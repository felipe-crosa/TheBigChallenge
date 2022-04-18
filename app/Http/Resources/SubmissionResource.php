<?php

namespace App\Http\Resources;

use App\Models\Submission;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Submission
 */
class SubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'symptoms' => $this->symptoms,
            'observations' => $this->observations,
            'diagnosis' => $this->diagnosis,
            'speciality' => $this->speciality,
        ];
    }
}
