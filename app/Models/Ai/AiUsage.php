<?php

namespace App\Models\Ai;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

#[Fillable(
    [

        'ai_job_id',

        'input_tokens',
        'output_tokens',
        'thinking_tokens',
        'cached_tokens',
        'total_tokens',

        'input_cost',
        'output_cost',
        'thinking_cost',
        'total_cost',

        'latency_ms',
        'currency'
    ]
)]
#[Guarded(['id'])]
class AiUsage extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deletor()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
}
