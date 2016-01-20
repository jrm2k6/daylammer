<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function home()
    {
        return view('create-password');
    }

    public function createPassword(Request $request)
    {
        $this->validate($request, [
           'email' => 'required|exists:users,email',
            'password' => 'confirmed|min:8'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user && $user->password != null) {
            return back()
                ->with('errors',
                    collect(['You already have a password attached to your email']));
        }

        /** @var User $user */
        $user->update(['password' => bcrypt($request->input('password'))]);
        return redirect('login');
    }
}
