<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteDiagnosisRequest;
use App\Models\Submission;
use App\Services\CdnService;
use Illuminate\Support\Facades\Storage;

class DeleteDiagnosisController
{
    public function __invoke(DeleteDiagnosisRequest $request, Submission $submission, CdnService $cdnService)
    {
        $fileName = $request->validated()['fileName'];
        $folder = config('filesystems.disks.do.folder');

        $submission->diagnosis = null;
        $submission->save();

        Storage::disk('do')->delete("{$folder}/{$fileName}");
        $cdnService->purge($fileName);

        return response()->json(['message' => 'File deleted'], 200);
    }
}