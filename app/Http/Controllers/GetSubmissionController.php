<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetSubmissionController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse|SubmissionResource
    {
        Auth::user()->can('view', $submission);

        return (new SubmissionResource($submission))->additional([
            'status' => 200,
        ]);
    }
}
