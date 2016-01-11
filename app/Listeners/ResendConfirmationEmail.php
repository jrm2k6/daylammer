<?php

namespace App\Listeners;

use App\Events\ConfirmationTokenCreated;
use App\Events\ResendConfirmationEmailEvent;
use App\Models\ConfirmationToken;
use App\User;

class ResendConfirmationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ResendConfirmationEmailEvent  $event
     * @return void
     */
    public function handle(ResendConfirmationEmailEvent $event)
    {
        $user = User::where('email', $event->email)->first();

        if ($user) {
            $confirmationToken = $user->confirmationToken;

            $token = substr(md5(rand()), 0, 17);

            while (ConfirmationToken::where('token', $token)->first() != null) {
                $token = substr(md5(rand()), 0, 17);
            }

            $confirmationToken->update([
                'token' => $token
            ]);

            event(new ConfirmationTokenCreated($confirmationToken));
        }
    }
}
