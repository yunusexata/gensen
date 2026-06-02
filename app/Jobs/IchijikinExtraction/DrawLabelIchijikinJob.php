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

class DrawLabelIchijikinJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(
        public $model = null,

    ) {}

    public function handle(): void
    {
        try {

            logger(['Split Ichijikin Job']);

            $attachment = $this->model->ichijikinExtractionFile;
            $tmpPdfPath = basename($attachment->path);
            $local_path = $tmpPdfPath;
            $extension = strtolower(pathinfo($local_path, PATHINFO_EXTENSION));

            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                return;
            }
            logger('HANDLE DRAW LABEL DOCUMENT');
            app(IchijikinService::class)
                ->drawLabelImage(storage_path("app/public/$attachment->path"), "ichijikin/{$attachment->ichijikinExtraction->batch_name}/result", $this->model->nama_lengkap . "_" . $this->model->no_nenkin, $this->model->kokumin, $this->model->nenkin_100);
        } catch (\Throwable $th) {
            //throw $th;
        }
        // event(new ConvertPdfToIMageFinished($this->model->id, $this->model->type->value));
    }
}
