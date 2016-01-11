<?php

namespace App\Listeners;

use App\Events\ConfirmationTokenCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionCreatedConfirmationEmail
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
     * @param  ConfirmationTokenCreated  $event
     * @return void
     */
    public function handle(ConfirmationTokenCreated $event)
    {
        $email = $event->confirmationToken->user->email;
        $token = $event->confirmationToken->token;

        Mail::send('emails.confirmation_subscription', ['confirmation_token' => $token],
            function ($message) use ($email) {
                $message->from('me@jeremydagorn.com', 'Laravel');

                $message->to($email);
            }
        );
    }
}
