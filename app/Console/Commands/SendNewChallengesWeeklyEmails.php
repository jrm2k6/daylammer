<?php

namespace App\Console\Commands;

use App\Jobs\SendChallengesEmail;
use App\Models\Thread;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use League\CommonMark\CommonMarkConverter;

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
        $users = User::where(['frequency' => 'weekly', 'confirmed' => true, 'unsubscribed' => false])->get();
        $threads = Thread::all();
        $currentWeekIndex = Carbon::now()->weekOfYear;
        $currentYear = Carbon::now()->year;

        $currentWeekChallenges = $threads->filter(function($thread) use ($currentWeekIndex, $currentYear) {
            return $thread->published_at->weekOfYear == $currentWeekIndex
                && $thread->published_at->year == $currentYear;
        });

        if ($currentWeekChallenges->count() == 0) {
            return;
        }

        $markdownConverter = new CommonMarkConverter();

        $currentWeekChallenges->map(function($challenge) use ($markdownConverter) {
            $challenge->markdown_content = $markdownConverter->convertToHtml($challenge->content);
            $challenge->markdown_content = str_replace('<pre>', '<pre style="white-space: pre-wrap;"', $challenge->markdown_content);
        });

        $users->each(function($user) use ($currentWeekChallenges) {
            $challengesForUser = $this->getChallengesForCurrentUser($user, $currentWeekChallenges);
            if ($challengesForUser->count() > 0) {
                $this->dispatch(new SendChallengesEmail($user, $challengesForUser, 'weekly'));
            }
        });
    }

    private function getChallengesForCurrentUser(User $user, $currentWeekChallenges)
    {
        $difficultiesUser = $user->difficulties;
        if ($difficultiesUser->count() > 0) {
            if ($difficultiesUser->first()->difficulty->short_name == 'all') {
                return $currentWeekChallenges;
            } else {
                $difficultiesUserShortName = $difficultiesUser->map(function($item) { return $item->difficulty->short_name; });
                $challenges = $currentWeekChallenges->filter(function($challenge) use ($difficultiesUserShortName) {
                    return collect($difficultiesUserShortName)->contains($challenge->difficulty);
                });

                return $challenges;
            }
        } else {
            return $currentWeekChallenges;
        }
    }
}
