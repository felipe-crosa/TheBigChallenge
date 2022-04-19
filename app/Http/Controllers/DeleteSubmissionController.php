<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class DeleteSubmissionController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse
    {
        $response = [
            'status' => 200,
            'message' => 'The submission has been deleted',
        ];

        try {
            $this->authorize('delete', $submission);
            $submission->delete();
        } catch (AuthorizationException $authorizationException) {
            $response = [
                'status' => 403,
                'message' => 'You dont own this submission',
            ];
        } catch (\Exception $exception) {
            $response = [
                'status' => 409,
                'message' => 'Could not delete submission',
            ];
        }

        return response()->json($response);
    }
}
