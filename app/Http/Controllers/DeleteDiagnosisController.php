<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteDiagnosisRequest;
use App\Models\Submission;
use App\Services\CdnService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeleteDiagnosisController
{
    public function __invoke(DeleteDiagnosisRequest $request, Submission $submission, CdnService $cdnService)
    {
        $fileName = $request->validated()['diagnosisFileName'];
        $folder = config('filesystems.disks.do.folder');

        Storage::disk('do')->delete("{$folder}/{$fileName}");
        $cdnService->purge($fileName);


        $submission->diagnosis = null;
        $submission->save();

        return response()->json(['message' => 'File deleted'], 200);
    }
}
