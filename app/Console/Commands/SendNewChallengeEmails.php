<?php

namespace App\Console\Commands;

use App\Jobs\SendChallengesEmail;
use App\Models\Thread;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

use League\CommonMark\CommonMarkConverter;

class SendNewChallengeEmails extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daylammer:new_challenge_email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email containing new challenge';

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
        $users = User::where(['frequency' => 'new-challenge', 'confirmed' => true])->get();
        $latestChallenge = Thread::all()->sortByDesc('published_at')->first();
        $latestChallenge->markdown_content = (new CommonMarkConverter())->convertToHtml($latestChallenge->content);
        $latestChallenge->markdown_content = str_replace('<pre>', '<pre style="white-space: pre-wrap;"', $latestChallenge->markdown_content);

        $latestChallengeDifficulty = $latestChallenge->difficulty;

        $users = $users->filter(function($user) use ($latestChallengeDifficulty) {
            return $user->hasDifficulty($latestChallengeDifficulty)
                || $user->hasDifficulty('all')
                || collect($user->difficulties)->count() == 0;
        });

        $users->each(function($user) use ($latestChallenge) {
            $this->dispatch(new SendChallengesEmail($user, collect([$latestChallenge]), 'new-challenge'));
        });

    }
}
