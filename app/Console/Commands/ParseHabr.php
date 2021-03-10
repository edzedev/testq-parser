<?php

namespace App\Console\Commands;

use App\Jobs\ParseExternalPost;
use Illuminate\Console\Command;
use \Goutte as Goutte;
use Illuminate\Support\Facades\Redis;

class ParseHabr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:habr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse website posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $baseUrl = config('parser.parsed_url');
        $savedLatestPostUrl = Redis::get('latestPostUrl');
        $latestPostUrl = '';
        for ($i = 1; $i <= 50; $i++) {
            $pageUrl = ($i === 1) ? $baseUrl : $baseUrl.'/page'.$i;
            // retrieve html for page
            $crawler = Goutte::request('GET', $pageUrl);
            $links = $crawler->filter('.post__title_link');
            if ($i === 1) {
                $latestPostUrl = $links->first()->attr('href');
            }
            foreach ($links as $link) {
                $url = $link->getAttribute('href');
                // stop parser if posts already parsed
                if ($savedLatestPostUrl && $savedLatestPostUrl === $url ) {
                    break 2;
                }

                ParseExternalPost::dispatch($url);
            }
        }
        Redis::set('latestPostUrl',$latestPostUrl);
    }
}
