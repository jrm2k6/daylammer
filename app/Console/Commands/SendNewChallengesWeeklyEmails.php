<?php

namespace App\Console\Commands;

use App\Jobs\SendChallengesEmail;
use App\Models\Thread;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Mail;

class SendNewChallengesWeeklyEmails extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daylammer:weekly_email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly email containing 3 challenges';

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
//        $users = User::where(['frequency' => 'weekly', 'confirmed' => true])->get();
//        $threads = Thread::all();
//        $currentWeekIndex = Carbon::now()->weekOfYear;
//        $currentYear = Carbon::now()->year;
//
//        $current_week_challenges = $threads->filter(function($thread) use ($currentWeekIndex, $currentYear) {
//            return $thread->published_at->weekOfYear == $currentWeekIndex
//                && $thread->published_at->year == $currentYear;
//        });
//
//        $users->each(function($user) use ($current_week_challenges) {
            $this->dispatch(new SendChallengesEmail());
//        });

    }
}
