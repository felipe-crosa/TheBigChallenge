<?php

namespace App\Mail;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DiagnosedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): Mailable
    {
        return $this->markdown('emails.diagnosed', [
            'user' => $this->user,
//            'submission' => $this->submission,
        ]);
    }
}
