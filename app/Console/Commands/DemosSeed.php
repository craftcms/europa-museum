<?php

namespace App\Console\Commands;

use CraftCms\Cms\Entry\Elements\Entry;
use CraftCms\Cms\Support\Facades\Elements;
use Illuminate\Console\Command;

/**
 * Makes the restored demo look current.
 */
class DemosSeed extends Command
{
    protected $signature = 'demos:seed';

    protected $description = 'Give the news articles post dates within the last two weeks';

    public function handle(): int
    {
        $this->info('Refreshing news');
        $faker = \Faker\Factory::create();

        foreach (Entry::find()->section('newsArticles')->all() as $entry) {
            $entry->postDate = $faker->dateTimeInInterval('now', '-2 weeks');
            Elements::saveElement($entry);
        }

        return self::SUCCESS;
    }
}
