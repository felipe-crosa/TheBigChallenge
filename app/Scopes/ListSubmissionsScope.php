<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ListSubmissionsScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        if ($user->hasRole('patient')) {
            $builder->where('patient_id', $user->id);
        } elseif ($user->hasRole('doctor')) {
            $builder->whereNull('doctor_id')->orWhere('doctor_id', $user->id);
            $information = $user->doctorInformation;
            if ($information) {
                $builder->where('speciality', $information->speciality);
            }
        }
    }
}
