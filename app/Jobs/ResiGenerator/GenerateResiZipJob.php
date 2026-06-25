<?php

namespace App\Jobs\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Models\Ichijikin\IchijikinExtraction;
use App\Models\ResiGenerator\ResiGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class GenerateResiZipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public ResiGenerator $resi
    ) {}

    public function handle(): void
    {

        try {
            $this->resi->update([
                'zip_status' => JobStatus::PROCESSING,
                'zip_started_at' => now(),
            ]);

            $folder = storage_path(
                "app/private/resi_generator/result/{$this->resi->label}"
            );

            if (!is_dir($folder)) {
                throw new \Exception("Folder not found: $folder");
            }

            $zipDir = storage_path("app/public/resi/zips_result");

            if (!is_dir($zipDir)) {
                mkdir($zipDir, 0755, true);
            }

            $zipFile = $zipDir . '/' . $this->resi->label . '.zip';

            if (file_exists($zipFile)) {
                unlink($zipFile);
            }

            $command = sprintf(
                '7z a -tzip -mx=3 "%s" "%s/*"',
                $zipFile,
                $folder
            );

            exec($command . ' 2>&1', $output, $result);

            if ($result !== 0) {
                throw new \Exception(
                    implode("\n", $output)
                );
            }

            $this->resi->update([
                'zip_path' => 'resi/zips_result/' . $this->resi->label . '.zip',
                'zip_generated_at' => now(),
                'zip_status' => JobStatus::DONE,
                'zip_finished_at' => now(),
            ]);
        } catch (\Throwable $e) {

            $this->resi->update([
                'zip_status' => JobStatus::FAILED,
                'zip_finished_at' => now(),
                'zip_error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(?Throwable $e): void
    {
        $this->resi->update([
            'zip_status' => JobStatus::FAILED,
            'zip_finished_at' => now(),
            'zip_error_message' => $e->getMessage(),
        ]);
    }
}
