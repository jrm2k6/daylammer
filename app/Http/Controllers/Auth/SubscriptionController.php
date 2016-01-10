<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Create a new subscription controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function createSubscription(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'frequency_hidden' => 'required|string|in:weekly,new-challenge'
        ], $this->messages());

        $user = User::create([
            'email' => $request->input('email'),
            'frequency' => $request->input('frequency_hidden')
        ]);

        $user->save();

        return view('subscription_success', ['email' => $user->email]);
    }

    private function messages()
    {
        return [
            'email.required' => 'You need to specify your email.',
            'email.email'  => 'Your email is invalid',
            'email.unique'  => 'Your email is already taken',
            'frequency_hidden.required' => 'You need to select when you want to get emails'
        ];
    }

}