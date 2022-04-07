<?php

namespace App\Http\Resources;

use App\Models\DoctorInformation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin DoctorInformation
 */
class DoctorInformationResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'speciality' => $this->speciality,
            'institution' => $this->institution,
        ];
    }
}
