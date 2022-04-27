<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DOCdnService implements CdnService
{
    public function purge($fileName)
    {
        $folder = config('filesystems.disks.do.folder');
        Http::asJson()->delete(
            config('filesystems.disks.do.cdn_endpoint').'/cache',
            [
                'files' => ["{$folder}/{$fileName}"],
            ]
        );
    }
}
