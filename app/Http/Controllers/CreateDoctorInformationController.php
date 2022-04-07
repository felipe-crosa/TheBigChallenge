<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDoctorInformationRequest;
use App\Http\Resources\DoctorInformationResource;
use Illuminate\Support\Facades\Auth;

class CreateDoctorInformationController extends Controller
{
    public function __invoke(CreateDoctorInformationRequest $request): DoctorInformationResource
    {
        $doctorInformation = Auth::user()->doctorInformation()->create($request->validated());

        return (new DoctorInformationResource($doctorInformation))
            ->additional([
                'status' => 200,
                'message' => 'Information created successfully',
            ]);
    }
}
