<?php

namespace App\Models\GensenForm;

use App\Enums\Gensen\JobStatus;
use App\Jobs\MergeSeluruhBerkas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class SeluruhBerkasJob extends Model
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
            MergeSeluruhBerkas::dispatch($model->id, $model->gensen_form_id)->onQueue('pdf');
        });
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
