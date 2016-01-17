<?php namespace App\Http\Helpers;

use App\Models\DifficultyUser;

class SubscriptionHelper
{
    public static function saveDifficultiesForUser($difficulties, $userId)
    {
        $difficulties = collect($difficulties);
        $difficulties = $difficulties->filter(function($item) {
           return $item != null;
        });

        if ($difficulties->has('difficulty_all') ||
            ($difficulties->only(['difficulty_easy', 'difficulty_moderate', 'difficulty_hard'])->count() == 3)) {
            DifficultyUser::create(['user_id' => $userId, 'difficulty' => 'all']);
        } else {
            if ($difficulties->has('difficulty_hard')) {
                DifficultyUser::create(['user_id' => $userId, 'difficulty' => 'hard']);
            }

            if ($difficulties->has('difficulty_moderate')) {
                DifficultyUser::create(['user_id' => $userId, 'difficulty' => 'moderate']);
            }

            if ($difficulties->has('difficulty_easy')) {
                DifficultyUser::create(['user_id' => $userId, 'difficulty' => 'easy']);
            }
        }
    }
}