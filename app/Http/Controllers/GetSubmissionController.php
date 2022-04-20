<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class GetSubmissionController
{
    public function __invoke(Submission $submission): SubmissionResource
    {
        Auth::user()->can('view', $submission);

        return (new SubmissionResource($submission))->additional([
            'status' => 200,
        ]);
    }
}
