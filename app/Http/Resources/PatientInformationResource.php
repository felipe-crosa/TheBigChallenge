<?php

namespace App\Http\Resources;

use App\Models\PatientInformation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PatientInformation
 */
class PatientInformationResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'height' => $this->height,
            'date_of_birth' => $this->date_of_birth,
            'weight' => $this->weight,
            'gender' => $this->gender,
            'allergies' => $this->allergies,
            'medical_conditions' => $this->medical_conditions,
            'user_id' => $this->user_id,
        ];
    }
}
