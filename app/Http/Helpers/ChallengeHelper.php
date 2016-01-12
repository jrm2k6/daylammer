<?php namespace App\Http\Helpers;

use Carbon\Carbon;

class ChallengeHelper {
    public static function getNextEmailApproximateDate($frequency)
    {
        if ($frequency == 'weekly') {
            return Carbon::now()->next(Carbon::SATURDAY);
        }

        $todayWeekday = Carbon::now()->dayOfWeek;

        if ($todayWeekday <= 2) {
            return Carbon::now()->next(Carbon::WEDNESDAY);
        } else if ($todayWeekday <= 5) {
            return Carbon::now()->next(Carbon::FRIDAY);
        } else {
            return Carbon::now()->next(Carbon::MONDAY);
        }
    }
}
