<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class GetSubmissionController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse|SubmissionResource
    {
        try {
            $this->authorize('view', $submission);

            return (new SubmissionResource($submission))->additional([
                'status' => 200,
            ]);
        } catch (AuthorizationException $authorizationException) {
            return response()->json([
                'status' => '403',
                'message' => 'You dont have authorization to access this submission',
            ]);
        }
    }
}
