<?php

namespace App\Models\GensenForm;

use App\Enums\Gensen\GensenFormDetailStatus;
use App\Enums\Gensen\JobStatus;
use App\Jobs\GensenFormDetailStatusJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class GensenFormDetailLog extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        // polymorphic relation
        'subject_id',
        'subject_type',

        // recipient
        'status',
        'keterangan',

        // lifecycle
        'job_status',

        // monitoring
        'attempts',
        'error_message',

        // timing
        'started_at',
        'finished_at',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'job_status' => JobStatus::class,
    ];

    protected static function onBoot()
    {
        self::created(function ($model) {
            GensenFormDetailStatusJob::dispatch($model)->onQueue('default');
        });
    }

    public function isDeletable()
    {
        return true;
    }

    public function isEditable()
    {
        return true;
    }

    public function subject()
    {
        return $this->morphTo();
    }

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
