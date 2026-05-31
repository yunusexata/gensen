<?php

namespace App\Models\Ai;

use App\Enums\Gensen\JobStatus;
use App\Events\RemittanceExtractionFinished;
use App\Models\Gensen\Ai\RemittanceExtraction;
use App\Models\Gensen\Ai\RemittanceExtractionGroup;
use App\Models\Ichijikin\IchijikinExtractionResult;
use App\Repositories\IchijikinExtraction\IchijikinExtractionResultRepository;
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
            logger(['model result', $model->result_type]);
            if ($model->result_type == AiJob::JOB_TYPE_REMITTANCE_EXTRACTION) {
                $result = json_decode($model->result_json, true);
                logger(['model result all', $model]);
                logger(['model result', $result]);
                $remittance = RemittanceExtraction::create(
                    [
                        'subject_id' => $model->aiJob->subject_id,
                        'subject_type' => $model->aiJob->subject_type,
                        'ai_job_id' => $model->aiJob->id,
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

            if ($model->result_type == AiJob::JOB_TYPE_ICHIJIKIN_EXTRACTION) {
                logger('DAH SAMPE RESULT ICHIJIKIN');
                $result = json_decode($model->result_json, true);
                IchijikinExtractionResultRepository::create([
                    'ichijikin_extraction_id' => $model->aiJob->subject->ichijikin_extraction_id,
                    'ichijikin_extraction_file_id' => $model->aiJob->subject_id,

                    'nama_lengkap' => $result['nama_lengkap'],
                    'no_nenkin' => $result['no_nenkin'],
                    'lama_kerja' => $result['lama_kerja'],
                    'kokumin' => $result['kokumin'],
                    'nenkin_100' => $result['nenkin_100'],
                    'nenkin_80' => $result['nenkin_80'],
                    'nenkin_20' => $result['nenkin_20'],

                    'type' => IchijikinExtractionResult::TYPE_SPEED,

                    'error_message' => null,

                    // 'started_at' => $model->aiJob,
                    // 'finished_at' => $model->aiJob,
                    'confidence_score' => $result['confidence_score'],
                    // 'confidence_note' => isset($result['confidence_note']) ? $result['confidence_note'] : null,

                    // lifecycle state
                    'status' => JobStatus::DONE,

                ]);
            }
        });
    }

    public function aiJob()
    {
        return $this->belongsTo(AiJob::class, 'ai_job_id', 'id');
    }
}
