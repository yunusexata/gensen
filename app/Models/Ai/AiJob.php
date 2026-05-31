<?php

namespace App\Models\Ai;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Events\RemittanceExtractionFinished;
use App\Jobs\ConvertPdfToImagesJob;
use App\Jobs\GensenExtractJob\ExtractionDocumentJob;
use App\Jobs\IchijikinExtraction\CropIchijikinJob;
use App\Jobs\IchijikinExtraction\ExtractionIchijikinJob;
use App\Jobs\IchijikinExtraction\SplitIchijikinJob;
use App\Models\Ai\AiPayload;
use App\Models\Ai\AiResult;
use App\Models\Ai\AiUsage;
use App\Models\Gensen\Ai\RemittanceExtraction;
use App\Models\Gensen\Ai\RemittanceExtractionGroup;
use App\Models\GensenForm\GensenFormAttachment;
use App\Repositories\Gensen\Ai\RemittanceExtractionGroupRepository;
use App\Repositories\Gensen\Ai\RemittanceExtractionRepository;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

#[Fillable(
    [
        'subject_type',
        'subject_id',

        'provider',
        'model',
        'job_type',

        'status', // pending, processing, success, failed

        'payload',

        'input_tokens',
        'output_tokens',
        'total_tokens',

        'estimated_cost',

        'started_at',
        'finished_at',

        'error_message',
    ]
)]
#[Guarded(['id'])]
class AiJob extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    const JOB_TYPE_REMITTANCE_EXTRACTION = 'remittance_extraction';
    const JOB_TYPE_ICHIJIKIN_EXTRACTION = 'ichijikin_extraction';

    protected $casts = [
        'payload' => 'array',
        'status' => JobStatus::class,
    ];
    public function usage()
    {
        return $this->hasOne(AiUsage::class);
    }

    public function result()
    {
        return $this->hasOne(AiResult::class);
    }

    public function payload()
    {
        return $this->hasOne(AiPayload::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }


    protected static function onBoot()
    {
        self::creating(function ($model) {
            $model->status = JobStatus::PENDING;
        });
        self::created(function ($model) {
            logger('ai job created');
            if ($model->job_type === self::JOB_TYPE_REMITTANCE_EXTRACTION) {
                RemittanceExtraction::where('subject_type', $model->subject_type)
                    ->where('subject_id', $model->subject_id)
                    ->where('ai_job_id', '!=', $model->id)
                    ->each(function ($remittance) {
                        $remittance->remittanceExtractionGroups()->delete();
                        $remittance->delete();
                    });
                GensenFormAttachment::where('gensen_form_id', $model->subject_id)
                    ->where('status', GensenAttachmenStatus::STATUS_CONVERTED)
                    ->where('type', GensenAttachmentType::REKAP_PENGIRIMAN_UANG)
                    ->each(function ($remittance) {
                        $remittance->delete();
                    });

                ConvertPdfToImagesJob::dispatch(
                    self::class,
                    $model
                )->onQueue('pdf');
            }
            if ($model->job_type === self::JOB_TYPE_ICHIJIKIN_EXTRACTION) {
                CropIchijikinJob::dispatch($model)->onQueue('crop');
            }
        });
        self::updated(function ($model) {});
    }
}
