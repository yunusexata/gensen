<?php

namespace App\Services;

use App\Enums\Gensen\GensenAttachmentType;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use Illuminate\Support\Facades\Storage;

class GensenAttachmentService
{
    public function storeGenerated(
        int $gensenFormId,
        $path,
        GensenAttachmentType $type,
    ) {

        $disk = 'private';
        $fullPath = Storage::disk('private')->path($path);

        GensenFormAttachmentRepository::deleteBy([
            ['gensen_form_id', $gensenFormId],
            ['type', $type],
        ]);

        return GensenFormAttachmentRepository::create([
            'gensen_form_id' => $gensenFormId,

            'type' => $type,

            'disk' => $disk,
            'path' => $path,

            'original_name' => $type->label() . '.pdf',
            'stored_name' => basename($path),

            'extension' => pathinfo($fullPath, PATHINFO_EXTENSION),
            'mime_type' => mime_content_type($fullPath),
            'file_size' => filesize($fullPath),

            'checksum' => hash_file('sha256', $fullPath),
        ]);
    }
}
