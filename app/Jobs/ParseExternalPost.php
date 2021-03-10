<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Goutte as Goutte;

class ParseExternalPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postUrl;
    protected $postId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $postUrl)
    {
        $this->postUrl = $postUrl;
        $urlItems = array_filter(explode('/', $postUrl));
        $this->postId = (int) end($urlItems);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //validate post
        if (!$this->postId || strpos($this->postUrl, config('parser.parsed_url')) !== 0 ||
            Post::where('external_post_id', $this->postId)->exists()) return;
        //parse post
        $crawler = Goutte::request('GET', $this->postUrl);
        $title = $crawler->filter('.post__title-text')->text();
        $content = $crawler->filter('#post-content-body')->html();
        $dateText = $crawler->filter('.post__time')->first()->attr('data-time_published');
        $date = Carbon::createFromFormat('Y-m-d\TH:i\Z', $dateText);
        $post = Post::create([
            'external_post_id' => $this->postId,
            'content' => $content,
            'external_url' => $this->postUrl,
            'title' => $title,
            'published' => $date
        ]);
        //parse tags
        $tags = [];
        $crawler->filter('.post__tags')->first()->filter('.post__tag')->each(function ($node) use (&$tags) {
            $title = $node->text();
            $tags[] = Tag::firstOrCreate([
                'title' => $title
            ])->id;
        });
        $post->tags()->attach($tags);
    }
}
