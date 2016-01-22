<?php namespace App\Http\Controllers;

use App\Models\Difficulty;
use App\Models\DifficultyUser;
use App\Models\Frequency;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function home()
    {
        $authUser = Auth::user();
        $frequencies = Frequency::all()->each(function($item) use ($authUser) {
           if ($item->short_name == $authUser->frequency) {
               $item->selected = true;
           }
        });

        $userDifficultyIds = collect($authUser->difficulties)->pluck('difficulty_id');
        $difficulties = Difficulty::all()->each(function($item) use ($userDifficultyIds) {
            if (is_int($userDifficultyIds->search($item->id))) {
                $item->selected = true;
            }
        });

        return view('settings')
            ->with('frequencies', $frequencies)
            ->with('difficulties', $difficulties);
    }

    public function updateDifficulties(Request $request)
    {
        $this->validate($request, [
            '*' => 'exists:difficulties,id'
        ]);

        $user = Auth::user();

        DifficultyUser::where('user_id', $user->id)->delete();

        $this->updateUserDifficulties($user, collect($request->input('difficulties')));

        return response(['message' => 'Changes saved!'], 200);
    }

    public function updateUserDifficulties(User $user, $difficulties) {
        $difficultiesId = Difficulty::where('short_name', '<>', 'all')->pluck('id');
        $difficultiesId = collect($difficultiesId);

        if ($difficultiesId->intersect($difficulties)->count() == $difficultiesId->count()) {
            // User is interested in all difficulties
            DifficultyUser::create([
                'user_id' => $user->id,
                'difficulty_id' => Difficulty::where('short_name', 'all')->first()->id
            ]);
        } else {
            $difficulties->each(function($id) use ($user) {
                DifficultyUser::create([
                    'user_id' => $user->id,
                    'difficulty_id' => $id
                ]);
            });
        }
    }

    public function updateFrequency(Request $request)
    {
        $this->validate($request, [
           'frequency' => 'required|string|in:weekly,new-challenge'
        ]);

        $user = Auth::user();
        $user->update(['frequency' => $request->input('frequency')]);

        return response(['message' => 'Changes saved!'], 200);
    }
}