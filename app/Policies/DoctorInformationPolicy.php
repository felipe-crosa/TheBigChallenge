<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorInformationPolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return boolval($user->doctorInformation);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('doctor');
    }

    public function update(User $user): bool
    {
        return boolval($user->doctorInformation);
    }
}
