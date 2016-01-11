<?php

namespace App\Events;

use App\Events\Event;
use App\Models\ConfirmationToken;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConfirmationTokenCreated extends Event
{
    use SerializesModels;

    public $confirmationToken;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ConfirmationToken $token)
    {
        $this->confirmationToken = $token;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
