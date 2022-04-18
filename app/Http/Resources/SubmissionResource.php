<?php

namespace App\Http\Resources;

use App\Models\DoctorInformation;
use App\Models\PatientInformation;
use App\Models\Submission;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Submission
 */
class SubmissionResource extends JsonResource
{
    public function toArray($request): array
    {
        $patient = PatientInformation::find($this->patient_id);
        $doctor = $this->doctor_id;
        if ($doctor) {
            $doctor = DoctorInformation::find($this->doctor_id);
            $doctor = new DoctorInformationResource($doctor);
        }

        return [
            'id' => $this->id,
            'patient' => new PatientInformationResource($patient),
            'doctor' => $doctor,
            'symptoms' => $this->symptoms,
            'observations' => $this->observations,
            'diagnosis' => $this->diagnosis,
            'speciality' => $this->speciality,
        ];
    }
}
