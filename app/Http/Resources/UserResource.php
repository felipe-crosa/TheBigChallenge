<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'patient_information' => new PatientInformationResource($this->whenLoaded('patientInformation')),
            'doctor_information' => new DoctorInformationResource($this->whenLoaded('doctorInformation')),
            'role' => $this->when(boolval($this->roles), $this->roles->pluck('name')),
            'filled_information' => $this->patientInformation()->count() > 0 || $this->doctorInformation()->count() > 0,
        ];
    }
}
