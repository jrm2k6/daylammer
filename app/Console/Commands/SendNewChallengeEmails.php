<?php

namespace App\Console\Commands;

use App\Jobs\SendChallengesEmail;
use App\Models\Thread;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

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
        $latest_challenge = Thread::all()->sortByDesc('published_at')->first();

        $users->each(function($user) use ($latest_challenge) {
            $this->dispatch(new SendChallengesEmail($user, [$latest_challenge]));
        });

    }
}
