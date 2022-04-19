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
        return [
            'id' => $this->id,
            'patient' => ($this->patient_id) ? new PatientInformationResource($this->patient) : $this->patient_id,
            'doctor' => ($this->doctor_id) ? new DoctorInformationResource($this->doctor) : $this->doctor_id,
            'symptoms' => $this->symptoms,
            'observations' => $this->observations,
            'diagnosis' => $this->diagnosis,
            'speciality' => $this->speciality,
        ];
    }
}
