<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResourceCollection;
use App\Models\Submission;

class GetAllSubmissionsController extends Controller
{
    public function __invoke()
    {
        return new SubmissionResourceCollection(Submission::all());
    }
}
