<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AssignSubmissionController
{
    public function __invoke(Submission $submission): JsonResponse
    {
        if (Auth::user()->cannot('assign', $submission)) {
            abort(403, 'You are not authorized');
        }

        $submission->update(['doctor_id' => Auth::id()]);

        return response()->json([
            'status' => 200,
            'message' => 'The submission has been assigned successfully',
        ]);
    }
}
