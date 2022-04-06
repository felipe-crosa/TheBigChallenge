<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDoctorInformationRequest;
use App\Http\Resources\DoctorInformationResource;
use App\Models\DoctorInformation;
use Illuminate\Support\Facades\Auth;

class UpdateDoctorInformationController extends Controller
{
    public function __invoke(UpdateDoctorInformationRequest $request)
    {
        $doctor = DoctorInformation::where('user_id', Auth::id())->first();
        $doctor->update($request->validated());

        return (new DoctorInformationResource($doctor))->additional([
            'status'=>200,
            'message'=> 'Information updated successfully',
        ]);
    }
}
