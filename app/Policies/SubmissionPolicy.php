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

    public function view(User $user, Submission $submission): bool
    {
        $isAssigned = $submission->doctor_id != null;
        $canDoctorView = (! $isAssigned && $user->hasRole('doctor')) || ($submission->doctor_id == $user->id);
        $canPatientView = $user->id == $submission->patient_id;

        return $canDoctorView || $canPatientView;
    }
}
