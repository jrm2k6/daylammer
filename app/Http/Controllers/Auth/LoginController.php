<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function home()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ],[
            'email.required' => 'Email is required.',
            'email.email' => 'Email is not valid.',
            'email.exists' => 'Email is not valid.',
            'password.required' => 'Password is required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->intended('settings');
        }

        return redirect('login')->with('errors', collect(['Incorrect password']));
    }
}