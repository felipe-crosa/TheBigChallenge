<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientInformationPolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return boolval($user->patientInformation);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('patient');
    }

    public function update(User $user): bool
    {
        return boolval($user->patientInformation);
    }
}
