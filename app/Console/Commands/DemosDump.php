<?php

namespace App\Console\Commands;

use CraftCms\Cms\Entry\Elements\Entry;
use CraftCms\Cms\Support\Facades\Elements;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Writes the demo's content to seed.sql.
 *
 * Restore the seed, edit content or the content model, then run `php artisan demos:dump`.
 * The dump only holds what the demo needs, with its rows sorted, so its diff shows
 * what actually changed.
 */
class DemosDump extends Command
{
    protected $signature = 'demos:dump {path? : Where to write the dump (defaults to seed.sql in the project root)}';

    protected $description = 'Prune the database to what the demo needs, then dump it to seed.sql';

    /**
     * Tables whose rows are caches, logs, sessions, queues or tokens.
     * Their structure is still dumped.
     */
    public const array EXCLUDE_DATA = [
        'announcements', 'assetindexdata', 'assetindexingsessions', 'bulkopevents', 'cache', 'cache_locks',
        'deprecationerrors', 'elementactivity', 'elements_bulkops', 'failed_jobs', 'imagetransformindex',
        'job_batches', 'jobprogress', 'jobs', 'password_reset_tokens', 'phpsessions', 'resourcepaths',
        'routetokens', 'searchindexqueue', 'searchindexqueue_fields', 'session', 'sessions',
    ];

    public function handle(): int
    {
        $connection = DB::connection();

        if ($connection->getDriverName() !== 'pgsql') {
            $this->error('The demo seed is a PostgreSQL dump.');

            return self::FAILURE;
        }

        $this->prune();

        $path = $this->argument('path') ?? base_path('seed.sql');
        $this->info("Dumping the database to $path");
        $this->dump($connection->getConfig(), $path);

        return self::SUCCESS;
    }

    private function prune(): void
    {
        $this->call('craft:utils:prune-revisions', ['--max-revisions' => 1, '--no-interaction' => true]);

        $this->info('Deleting provisional drafts');
        foreach (Entry::find()->provisionalDrafts()->status(null)->site('*')->unique()->all() as $draft) {
            Elements::deleteElement($draft, hardDelete: true);
        }

        $this->call('craft:gc:run', ['--deleteAllTrashed' => true, '--no-interaction' => true]);

        // Garbage collection keeps trashed nested entries whose owner still exists.
        DB::table('elements')->whereNotNull('dateDeleted')->delete();
    }

    /**
     * @param  array<string, mixed>  $config
     */
    private function dump(array $config, string $path): void
    {
        $prefix = $config['prefix'] ?? '';
        $schema = $config['search_path'] ?? $config['schema'] ?? 'public';

        $command = [
            'pg_dump',
            '--host='.($config['host'] ?? '127.0.0.1'),
            '--port='.($config['port'] ?? '5432'),
            '--username='.$config['username'],
            '--no-owner',
            '--no-privileges',
            '--clean',
            '--if-exists',
        ];

        foreach (self::EXCLUDE_DATA as $table) {
            $command[] = "--exclude-table-data=$schema.$prefix$table";
        }

        $command[] = $config['database'];

        $errors = tempnam(sys_get_temp_dir(), 'demos-dump-');
        $process = proc_open($command, [1 => ['pipe', 'w'], 2 => ['file', $errors, 'w']], $pipes, null, [
            ...getenv(),
            'PGPASSWORD' => (string) $config['password'],
        ]);

        $tmp = "$path.tmp";
        $out = fopen($tmp, 'w');
        $rows = null;
        // Sequences of tables without dumped rows only count requests; they can start over.
        $excluded = implode('|', array_map(fn (string $table) => preg_quote($prefix.$table, '/'), self::EXCLUDE_DATA));

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
                    fwrite($out, $rows === [] ? '' : implode("\n", $rows)."\n");
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

            throw new RuntimeException("pg_dump failed: $message");
        }

        rename($tmp, $path);
    }
}
