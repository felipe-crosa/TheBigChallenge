<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DeleteSubmissionController
{
    public function __invoke(Submission $submission): JsonResponse
    {
        if (Auth::user()->cannot('delete', $submission)) {
            abort(403);
        }
        $submission->delete();

        return response()->json([
            'status' => 200,
            'message' => 'The submission has been deleted',
        ]);
    }
}
