<?php

namespace App\Jobs\IchijikinExtraction;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Events\ConvertPdfToIMageFinished;
use App\Jobs\GensenExtractJob\ExtractionDocumentJob;
use App\Models\Ai\AiJob;
use App\Models\GensenForm\GensenForm;
use App\Models\Ichijikin\IchijikinExtractionFile;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionFileRepository;
use App\Services\Ichijikin\IchijikinService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Symfony\Component\Process\Process;

class CropIchijikinJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(
        public AiJob $model,

    ) {}

    public function handle(): void
    {
        try {

            logger(['Crop Ichijikin Job']);

            $attachment = $this->model->subject;

            if (!in_array($attachment->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                return;
            }
            logger('HANDLE CROP DOCUMENT');
            app(IchijikinService::class)
                ->handleCropDocument($this->model);
        } catch (\Throwable $th) {
            //throw $th;
        }
        // event(new ConvertPdfToIMageFinished($this->model->id, $this->model->type->value));
    }
}
