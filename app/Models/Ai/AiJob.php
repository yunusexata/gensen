<?php

namespace App\Models\Ai;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Events\RemittanceExtractionFinished;
use App\Jobs\ConvertPdfToImagesJob;
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
                    $model
                )->onQueue('default');
            }
        });
        self::updated(function ($model) {
            if ($model->status == JobStatus::DONE) {
                if ($model->job_type === self::JOB_TYPE_REMITTANCE_EXTRACTION) {
                    $result = json_decode($model->result->result_json, true);
                    logger(['model result all', $model->result]);
                    logger(['model result', $result]);
                    $remittance = RemittanceExtraction::create(
                        [
                            'subject_id' => $model->subject_id,
                            'subject_type' => $model->subject_type,
                            'ai_job_id' => $model->id,
                            'confidence_score' => $result['confidence_score'],
                            'confidence_note' => isset($result['confidence_note']) ? $result['confidence_note'] : null,
                        ]
                    );
                    foreach ($result['groups'] as $data) {
                        RemittanceExtractionGroup::create(
                            [
                                'remittance_extraction_id' => $remittance->id,
                                'receiver_name' => $data['receiver_name'],
                                'transaction_year' => $data['transaction_year'],
                                'total_amount' => $data['total_amount'],
                                'amount_details' => json_encode($data['amount_details'], true),
                                'currency' => $data['currency'],
                                'is_validate' => false,
                                'transfer_transaction_count' => $data['transfer_transaction_count'],
                            ]
                        );
                    }
                }
                event(new RemittanceExtractionFinished($model->subject_id));
            }
        });
    }
}
