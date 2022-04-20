<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResourceCollection;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class ListSubmissionsController extends Controller
{
    public function __invoke()
    {
        Auth::user()->can('viewAny', Submission::class);

        return new SubmissionResourceCollection(Submission::all());
    }
}
