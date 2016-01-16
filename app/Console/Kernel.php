<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\FetchLatestChallenges::class,
        Commands\SendNewChallengeEmails::class,
        Commands\SendNewChallengesWeeklyEmails::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('daylammer:latest')->dailyAt('10:00');

        $schedule->command('daylammer:new_challenge_email')->tuesdays()->at('10:00');

        $schedule->command('daylammer:new_challenge_email')->thursdays()->at('10:00');

        $schedule->command('daylammer:new_challenge_email')->saturdays()->at('10:00');

        $schedule->command('daylammer:weekly_email')->saturdays()->at('10:00');
    }
}
