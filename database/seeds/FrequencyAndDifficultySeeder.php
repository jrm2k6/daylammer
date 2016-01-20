<?php

use App\Models\Difficulty;
use App\Models\Frequency;
use Illuminate\Database\Seeder;

class FrequencyAndDifficultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Frequency::create(['short_name' => 'new-challenge', 'name' => 'Every challenge']);
        Frequency::create(['short_name' => 'weekly', 'name' => 'Weekly']);

        Difficulty::create(['short_name' => 'easy', 'name' => 'Easy']);
        Difficulty::create(['short_name' => 'moderate', 'name' => 'Moderate']);
        Difficulty::create(['short_name' => 'hard', 'name' => 'Hard']);

    }
}
