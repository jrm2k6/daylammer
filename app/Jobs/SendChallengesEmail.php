<?php

namespace App\Jobs;

use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendChallengesEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.weekly', [],
            function ($message) {
                $message->from('me@jeremydagorn.com', 'Your weekly newsletter');

                $message->to('jeremy.dagorn@gmail.com');
            }
        );
    }
}
