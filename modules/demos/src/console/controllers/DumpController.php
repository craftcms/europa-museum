<?php

namespace modules\demos\console\controllers;

use Craft;
use craft\console\Controller;
use craft\db\Table;
use craft\elements\Entry;
use craft\helpers\Console;
use craft\helpers\Db;
use yii\console\ExitCode;

/**
 * Writes the demo's content to seed.sql.
 *
 * Restore the seed, edit content or the content model, then run `php craft demos/dump`.
 * The dump only holds what the demo needs, with its rows sorted, so its diff shows
 * what actually changed.
 */
class DumpController extends Controller
{
    /**
     * Tables whose rows are caches, logs, sessions or Freeform's seeded activity.
     * Their structure is still dumped.
     */
    public const EXCLUDE_DATA = [
        'announcements', 'assetindexdata', 'assetindexingsessions', 'bulkopevents', 'cache',
        'craftidtokens', 'deprecationerrors', 'elementactivity', 'elements_bulkops',
        'imagetransformindex', 'phpsessions', 'queue', 'resourcepaths', 'searchindexqueue',
        'searchindexqueue_fields', 'session', 'sessions', 'tokens',
        'freeform_feeds', 'freeform_feed_messages', 'freeform_notification_log', 'freeform_session_context',
    ];

    /**
     * Prunes the database to what the demo needs, then dumps it.
     *
     * This changes the database: it keeps only the latest revision of each element,
     * deletes provisional drafts, trashed elements and Freeform submissions
     * (`demos/seed` recreates those).
     *
     * @param string|null $path Where to write the dump (defaults to seed.sql in the project root)
     */
    public function actionIndex(?string $path = null): int
    {
        $db = Craft::$app->getDb();

        if (!$db->getIsPgsql()) {
            $this->stderr('The demo seed is a PostgreSQL dump.' . PHP_EOL, Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->prune();

        $path ??= Craft::getAlias('@root/seed.sql');
        $this->stdout("Dumping the database to $path ... ");
        $this->dump($path);
        $this->stdout('done' . PHP_EOL, Console::FG_GREEN);

        return ExitCode::OK;
    }

    private function prune(): void
    {
        Craft::$app->runAction('utils/prune-revisions', ['maxRevisions' => 1, 'interactive' => false]);

        $this->stdout('Deleting provisional drafts ... ');
        $drafts = Entry::find()->provisionalDrafts()->status(null)->site('*')->unique()->all();
        foreach ($drafts as $draft) {
            Craft::$app->getElements()->deleteElement($draft, true);
        }
        $this->stdout('done' . PHP_EOL, Console::FG_GREEN);

        Craft::$app->runAction('demos/seed/clean');
        Craft::$app->runAction('gc', ['deleteAllTrashed' => true, 'interactive' => false]);

        // Garbage collection keeps trashed nested entries whose owner still exists.
        Db::delete(Table::ELEMENTS, ['not', ['dateDeleted' => null]]);
    }

    private function dump(string $path): void
    {
        $db = Craft::$app->getDb();
        $dsn = Db::parseDsn($db->dsn);
        $schema = Craft::$app->getConfig()->getDb()->schema ?: 'public';

        $command = [
            'pg_dump',
            '--host=' . ($dsn['host'] ?? '127.0.0.1'),
            '--port=' . ($dsn['port'] ?? '5432'),
            '--username=' . $db->username,
            '--no-owner',
            '--no-privileges',
            '--clean',
            '--if-exists',
        ];

        foreach (self::EXCLUDE_DATA as $table) {
            $command[] = "--exclude-table-data=$schema.{$db->tablePrefix}$table";
        }

        $command[] = $dsn['dbname'];

        $errors = tempnam(sys_get_temp_dir(), 'demos-dump-');
        $process = proc_open($command, [1 => ['pipe', 'w'], 2 => ['file', $errors, 'w']], $pipes, null, [
            ...getenv(),
            'PGPASSWORD' => (string)$db->password,
        ]);

        $tmp = "$path.tmp";
        $out = fopen($tmp, 'w');
        $rows = null;
        // Sequences of tables without dumped rows only count requests; they can start over.
        $excluded = implode('|', array_map(fn(string $table) => preg_quote($db->tablePrefix . $table, '/'), self::EXCLUDE_DATA));

        while (($line = fgets($pipes[1])) !== false) {
            // Lines that change with the pg_dump version or on every run.
            if (
                preg_match('/^(\\\\(un)?restrict |-- Dumped (from|by) )/', $line) ||
                preg_match("/^SELECT pg_catalog\\.setval\\('[^.]+\\.($excluded)_id_seq'/", $line)
            ) {
                continue;
            }

            if ($rows !== null) {
                if ($line === "\\.\n") {
                    // Sort each table's rows, so dumps of the same content are identical.
                    sort($rows, SORT_STRING);
                    fwrite($out, $rows === [] ? '' : implode("\n", $rows) . "\n");
                    $rows = null;
                } else {
                    $rows[] = rtrim($line, "\n");
                    continue;
                }
            } elseif (str_starts_with($line, 'COPY ')) {
                $rows = [];
            }

            fwrite($out, $line);
        }

        fclose($out);
        fclose($pipes[1]);
        $status = proc_close($process);
        $message = trim(file_get_contents($errors));
        unlink($errors);

        if ($status !== 0) {
            unlink($tmp);
            throw new \RuntimeException("pg_dump failed: $message");
        }

        rename($tmp, $path);
    }
}
