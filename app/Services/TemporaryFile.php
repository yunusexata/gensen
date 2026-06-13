<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class TemporaryFile
{
    public static function fromAttachment($attachment): string
    {
        $disk = $attachment->disk ?? 'private';

        $storage = Storage::disk($disk);

        if (!$storage->exists($attachment->path)) {
            throw new Exception("File missing: {$attachment->path}");
        }

        /*
        |--------------------------------------------------------------------------
        | Create isolated temp directory
        |--------------------------------------------------------------------------
        */
        $tmpDir = storage_path(
            'app/tmp/' . now()->format('Ymd') . '/' . Str::random(12) . "/"
        );

        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }

        /*
        |--------------------------------------------------------------------------
        | Unique filename (NO collision)
        |--------------------------------------------------------------------------
        */
        $extension = pathinfo($attachment->path, PATHINFO_EXTENSION);

        $tmpPath = $tmpDir . '/' . Str::uuid() . '.' . $extension;

        /*
        |--------------------------------------------------------------------------
        | STREAM COPY (Supabase / S3 SAFE)
        |--------------------------------------------------------------------------
        */
        $readStream = $storage->readStream($attachment->path);

        if ($readStream === false) {
            throw new Exception("Failed to read remote file");
        }

        $writeStream = fopen($tmpPath, 'wb');

        stream_copy_to_stream($readStream, $writeStream);

        fclose($readStream);
        fclose($writeStream);

        // logger([
        //     'tmp_file_created' => $tmpPath
        // ]);

        return $tmpPath;
    }

    public static function cleanup(string $path): void
    {
        $dir = dirname($path);

        if (!is_dir($dir)) {
            return;
        }

        foreach (glob($dir . '/*') as $file) {
            @unlink($file);
        }

        @rmdir($dir);
    }
}
