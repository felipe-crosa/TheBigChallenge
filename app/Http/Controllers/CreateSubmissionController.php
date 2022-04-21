<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubmissionRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Submission;

class CreateSubmissionController
{
    public function __invoke(CreateSubmissionRequest $createRequest): SubmissionResource
    {
        $submission = Submission::create($createRequest->validated());

        return (new SubmissionResource($submission))->additional([
            'status' => 200,
            'message' => 'Submission created successfully',
        ]);
    }
}
