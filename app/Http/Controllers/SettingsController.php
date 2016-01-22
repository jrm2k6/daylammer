<?php namespace App\Http\Controllers;

use App\Models\Difficulty;
use App\Models\DifficultyUser;
use App\Models\Frequency;
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

        collect($request->input('difficulties'))->each(function($id) use ($user) {
            DifficultyUser::create([
                'user_id' => $user->id,
                'difficulty_id' => $id
            ]);
        });

        return response(['message' => 'Changes saved!'], 200);
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