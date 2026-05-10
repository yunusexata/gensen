<?php

namespace App\Models\Ai;

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
}
