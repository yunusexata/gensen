<?php

namespace App\Services;

use App\Enums\Gensen\GensenAttachmentType;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use Illuminate\Support\Facades\Storage;

class GensenAttachmentService
{
    public function storeGenerated(
        int $gensenFormId,
        $filePath,
        GensenAttachmentType $type,
    ) {


        $localDisk = 'private';
        $remoteDisk = 'supabase';

        $fullPath = Storage::disk($localDisk)->path($filePath);
        // $storedName = basename($filePath);
        GensenFormAttachmentRepository::deleteBy([
            ['gensen_form_id', $gensenFormId],
            ['type', $type],
        ]);

        Storage::disk($remoteDisk)->put(
            $filePath,
            fopen($fullPath, 'r')
        );
        GensenFormAttachmentRepository::create([
            'gensen_form_id' => $gensenFormId,

            'type' => $type,

            'disk' => $remoteDisk,
            'path' => $filePath,

            'original_name' => $type->label() . '.pdf',
            'stored_name' => basename($filePath),

            'extension' => pathinfo($fullPath, PATHINFO_EXTENSION),
            'mime_type' => mime_content_type($fullPath),
            'file_size' => filesize($fullPath),

            'checksum' => hash_file('sha256', $fullPath),
        ]);

        Storage::disk($localDisk)->delete($filePath);
        return;
    }
}
