<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubmissionRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class CreateSubmissionController
{
    public function __invoke(CreateSubmissionRequest $createRequest): SubmissionResource
    {
        Auth::user()->can('create', Submission::class);
        $submission = Submission::create($createRequest->validated());

        return (new SubmissionResource($submission))->additional([
            'status' => 200,
            'message' => 'Submission created successfully',
        ]);
    }
}
