<?php

namespace App\Models\Ai;

use App\Enums\Gensen\JobStatus;
use App\Events\RemittanceExtractionFinished;
use App\Models\Gensen\Ai\RemittanceExtraction;
use App\Models\Gensen\Ai\RemittanceExtractionGroup;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

#[Fillable(
    [
        'ai_job_id',

        'result_type',
        // gensen_extraction
        // remittance_extraction
        // validation_result

        'result_json',

        'confidence_score',
        'confidence_note',
    ]
)]
#[Guarded(['id'])]
class AiResult extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;
    protected $casts = [
        'result_json' => 'array',
    ];


    protected static function onBoot()
    {
        self::created(function ($model) {

            if ($model->job_type === AiJob::JOB_TYPE_REMITTANCE_EXTRACTION) {
                $result = json_decode($model->result_json, true);
                logger(['model result all', $model]);
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

                event(new RemittanceExtractionFinished($model->subject_id));
            };
        });
    }
}
