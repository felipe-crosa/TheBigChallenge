<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSubmissionRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class UpdateSubmissionController
{
    public function __invoke(UpdateSubmissionRequest $request, Submission $submission) : SubmissionResource
    {
        if (Auth::user()->cannot('update', $submission)) {
            abort(403, 'You are not authorized to preform this action. The submission has already been asigned to a doctor');
        }
        $submission->update($request->validated());

        return new SubmissionResource($submission);
    }
}
