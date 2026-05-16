<?php

namespace App\Models\GensenForm;

use App\Enums\Gensen\JobStatus;
use App\Jobs\MergePersyaratanPengurusanGensen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class PersyaratanGensenJob extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        'gensen_form_id',

        'error_message',

        'started_at',
        'finished_at',

        // lifecycle state
        'status',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'status' => JobStatus::class,
    ];

    protected static function onBoot()
    {
        self::creating(function ($model) {});
        self::created(function ($model) {
            MergePersyaratanPengurusanGensen::dispatch($model->id, $model->gensen_form_id)->onQueue('pdf');;
        });
    }
}
