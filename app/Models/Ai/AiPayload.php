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

        'request_payload',
        'response_payload',
    ]
)]
#[Guarded(['id'])]
class AiPayload extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;
}
