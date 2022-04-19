<?php

namespace App\Http\Resources;

use App\Models\Submission;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Submission
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
        if ($patient) {
            $patient->load('patientInformation');
        }

        return [
            'id' => $this->id,
            'patient' => $this->when(boolval($this->patient_id), new UserResource($patient)),
            'doctor' => $this->when(boolval($this->doctor_id), new UserResource($doctor)),
            'symptoms' => $this->symptoms,
            'observations' => $this->observations,
            'diagnosis' => $this->diagnosis,
            'speciality' => $this->speciality,
        ];
    }
}
