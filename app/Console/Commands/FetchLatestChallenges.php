<?php

namespace App\Console\Commands;

use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Console\Command;
use JD\Laradit\Facades\Laradit;
use JD\Laradit\Facades\LaraditAuth;

class FetchLatestChallenges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daylammer:latest {--backfill : Whether the job should fetch all threads from beginning}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest challenge from r/dailyprogrammer';

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
     * @return mixed
     */
    public function handle()
    {
        $shouldBackfill = $this->option('backfill');

        $authToken = LaraditAuth::getScriptAuthenticationManager()->getAccessToken();
        Laradit::setAuthToken($authToken);

        if ($shouldBackfill) {
            $hasResponse = true;
            $isInitial = true;
            $after = null;
            while ($hasResponse) {
                $res = $this->fetchLinks($isInitial, $after);
                $hasResponse = $res['has_response'];
                $after = $res['after'];
                $isInitial = false;
            }
        } else {
            $hot_links = Laradit::getListingsResource()->getNewLinks('dailyprogrammer', ['limit' => 1]);

            $hot_links = collect($hot_links['data']['children']);
            $hot_links = $hot_links->map(function($item) {
                $data = $item['data'];
                return $this->extractData($data);
            });

            $hot_links->each(function ($item) {
                $this->createThread($item);
            });
        }
    }

    public function extractData($data)
    {
        return [
            'title' => $data['title'],
            'published_at' => Carbon::createFromTimestamp($data['created']),
            'url' => $data['url'],
            'content' => $data['selftext'],
            'html_content' => $data['selftext_html']
        ];
    }

    public function fetchLinks($initialFetch, $after)
    {
        if (!$initialFetch && $after == null) {
            return ['has_response' => false, 'after' => null];
        }

        if ($initialFetch) {
            $links = Laradit::getListingsResource()->getNewLinks('dailyprogrammer');
        } else {
            $links = Laradit::getListingsResource()->getNewLinks('dailyprogrammer', ['after' => $after]);
        }

        $after = $links['data']['after'];
        $links = collect($links['data']['children']);
        $hasResponse = $links->count() > 0;

        $links = $links->map(function($item) {
            $data = $item['data'];
            return $this->extractData($data);
        });

        $links->each(function ($item) {
            $this->createThread($item);
        });

        return ['has_response' => $hasResponse, 'after' => $after];
    }

    public function createThread($data)
    {
        $res = preg_match('#^\[(?P<date>.*)\]\s(?P<challenge_index>\w+\s.*)\s*\[(?P<difficulty>\w+)\]\s*(?P<title>.*)\z#', $data['title'], $matches);
        if ($res) {
            $this->info($data['title'] . ' matches pattern');
            $title = trim($matches['challenge_index']).' - '.trim($matches['title']);
            $difficulty = strtolower($matches['difficulty']);
            $url = $data['url'];

            $thread_already_stored = Thread::where([
                'title' => $title,
                'difficulty' => $difficulty,
                'url' => $url
            ])->count() > 0;

            if (! $thread_already_stored) {
                Thread::create([
                    'title' => $title,
                    'difficulty' => $difficulty,
                    'url' => $data['url'],
                    'published_at' => $data['published_at'],
                    'content' => $data['content'],
                    'html_content' => $data['html_content']
                ]);
            }
        } else {
            $this->warn($data['title'] . ' failed to match pattern');
        }
    }
}
