<?php

namespace App\Listeners;

use App\Events\ConfirmationTokenCreated;
use App\Events\SubscriptionCreated;
use App\Models\ConfirmationToken;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateSubscriptionCreatedConfirmationToken
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
     * @param  SubscriptionCreated  $event
     * @return void
     */
    public function handle(SubscriptionCreated $event)
    {
        $user = $event->user;

        $token = substr(md5(rand()), 0, 17);

        while (ConfirmationToken::where('token', $token)->first() != null) {
            $token = substr(md5(rand()), 0, 17);
        }

        $confirmationToken = ConfirmationToken::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        $confirmationToken->save();

        event(new ConfirmationTokenCreated($confirmationToken));
    }
}
