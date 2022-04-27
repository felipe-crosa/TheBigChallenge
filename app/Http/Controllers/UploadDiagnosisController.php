<?php

namespace App\Http\Controllers;

use App\Events\SubmissionDiagnosed;
use App\Http\Requests\UploadDiagnosisRequest;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadDiagnosisController extends Controller
{
    public function __invoke(UploadDiagnosisRequest $request, Submission $submission)
    {
        $file = $request->file('diagnosisFile');
        $fileName = (string) Str::uuid();
        $folder = config('filesystems.disks.do.folder');
        Storage::put(
            "{$folder}/{$fileName}",
            file_get_contents($file)
        );
        $submission->diagnosis = $fileName;
        $submission->save();

        SubmissionDiagnosed::dispatch($submission);

        return response()->json([
            'message' => 'File uploaded',
            'fileName' => $fileName,

        ], 200);
    }
}
