<?php namespace App\Http\Controllers\Auth;

use App\Events\ResendConfirmationEmailEvent;
use App\Events\SubscriptionCreated;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ChallengeHelper;
use App\Models\ConfirmationToken;
use App\User;
use Carbon\Carbon;
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
        ], $this->createSubscriptionMessages());

        $user = User::create([
            'email' => $request->input('email'),
            'frequency' => $request->input('frequency_hidden')
        ]);

        $user->save();

        event(new SubscriptionCreated($user));

        return view('subscription_success', ['email' => $user->email]);
    }

    public function confirmSubscription(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|size:17|exists:confirmation_tokens,token'
        ], $this->confirmSubscriptionMessages());

        /** @var ConfirmationToken $token */
        $token = ConfirmationToken::where('token', $request->input('token'))->first();

        /** @var User $user */
        $user = $token->user;

        if (Carbon::now()->subWeeks(2) < $token->updated_at) {
            $user->setAsConfirmedUser();

            return view('subscription_confirmed', [
                'email' => $token->user->email,
                'date_next_email' => ChallengeHelper::getNextEmailApproximateDate($token->user->frequency)
            ]);
        } else {
            return view('subscription_token_expired', ['email' => $token->user->email]);
        }
    }

    public function resendConfirmation(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->input('email');
        event(new ResendConfirmationEmailEvent($email));

        return view('subscription_success', ['email' => $email]);
    }


    private function createSubscriptionMessages()
    {
        return [
            'email.required' => 'You need to specify your email.',
            'email.email'  => 'Your email is invalid',
            'email.unique'  => 'Your email is already taken',
            'frequency_hidden.required' => 'You need to select when you want to get emails'
        ];
    }

    private function confirmSubscriptionMessages()
    {
        return [
            'token.required' => 'No confirmation token found!'
        ];
    }

}