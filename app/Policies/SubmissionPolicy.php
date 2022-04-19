<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Submission $submission): bool
    {
        return $user->id == $submission->patient_id;
    }
}
