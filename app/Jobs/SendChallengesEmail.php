<?php

namespace App\Jobs;

use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class SendChallengesEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $challenges;
    protected $subjectEmail;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Collection $challenges
     * @param string $type
     */
    public function __construct(User $user, $challenges, $type)
    {
        $this->user = $user;
        $this->challenges = $challenges;

        if ($type == 'weekly') {
            $this->subjectEmail = 'Daylammer - Your weekly challenges!';
        } else {
            $this->subjectEmail = 'Daylammer - Your new challenge!';
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.challenges', ['challenges' => $this->challenges, 'email' => $this->user->email],
            function ($message) {
                $message->from('me@jeremydagorn.com', $this->subjectEmail);

                $message->to($this->user->email);
            }
        );
    }
}
