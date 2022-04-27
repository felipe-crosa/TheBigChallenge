<?php

namespace App\Listeners;

use App\Events\SubmissionDiagnosed;
use App\Mail\DiagnosedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendDiagnosisNotification implements ShouldQueue
{
    public function handle(SubmissionDiagnosed $event): void
    {
        $user = User::find($event->submission->patient_id);
        $email = $user->email;
        Mail::to($email)->send(new DiagnosedMail($user));
    }
}
