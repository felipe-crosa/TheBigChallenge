<?php

namespace App\Http\Resources;

use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin Submission
 * @property-read string $status
 */
class SubmissionResource extends JsonResource
{
    public function toArray($request): array
    {
        $doctor = $this->doctor;
        if ($doctor) {
            $doctor->load('doctorInformation');
        }

        $patient = $this->patient;
        $age = 0;
        $gender = 'none';
        if ($patient) {
            $patient->load('patientInformation');
            if ($patient->patientInformation) {
                $gender = $patient->patientInformation->gender;
                $age = Carbon::parse($patient->patientInformation->date_of_birth)->age;
            }
        }

        return [
            'id' => $this->id,

            $this->mergeWhen((! $this->doctor_id) && $patient->patientInformation && Auth::user()->hasRole('doctor'), [
                'patient' => [
                    'gender' => $gender,
                    'age' => $age,
                ],
            ]),

            'patient' => $this->when(
                ($this->patient_id && (Auth::user()->hasRole('patient') || $this->doctor_id)),
                new UserResource($patient)
            ),
            'doctor' => $this->when(boolval($this->doctor_id), new UserResource($doctor)),
            'symptoms' => $this->symptoms,
            'observations' => $this->observations,
            'diagnosis' => $this->diagnosis,
            'speciality' => $this->speciality,
            'status' => $this->status,
        ];
    }
}
