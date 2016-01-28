<?php namespace App\Http\Helpers;

use App\Models\Difficulty;
use App\Models\DifficultyUser;

class SubscriptionHelper
{
    public static function saveDifficultiesForUser($difficulties, $userId)
    {
        $difficulties = collect($difficulties);
        $difficulties = $difficulties->filter(function($item) {
           return $item != null;
        });

        $difficultyAllId = Difficulty::where('short_name', 'all')->first()->id;
        $difficultyHardId = Difficulty::where('short_name', 'hard')->first()->id;
        $difficultyIntermediateId = Difficulty::where('short_name', 'intermediate')->first()->id;
        $difficultyEasyId = Difficulty::where('short_name', 'easy')->first()->id;

        if ($difficulties->has('difficulty_all') ||
            ($difficulties->only(['difficulty_easy', 'difficulty_intermediate', 'difficulty_hard'])->count() == 3)) {
            DifficultyUser::create(['user_id' => $userId, 'difficulty_id' => $difficultyAllId]);
        } else {
            if ($difficulties->has('difficulty_hard')) {
                DifficultyUser::create(['user_id' => $userId, 'difficulty_id' => $difficultyHardId]);
            }

            if ($difficulties->has('difficulty_intermediate')) {
                DifficultyUser::create(['user_id' => $userId, 'difficulty_id' => $difficultyIntermediateId]);
            }

            if ($difficulties->has('difficulty_easy')) {
                DifficultyUser::create(['user_id' => $userId, 'difficulty_id' => $difficultyEasyId]);
            }
        }
    }
}