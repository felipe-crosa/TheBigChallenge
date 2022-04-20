<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResourceCollection;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class ListSubmissionsController
{
    public function __invoke() : SubmissionResourceCollection
    {
        if (Auth::user()->cannot('viewAll', Submission::class)) {
            abort(403);
        }

        return new SubmissionResourceCollection(Submission::all());
    }
}
