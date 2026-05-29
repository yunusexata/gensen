<?php

namespace App\Models\Ichijikin;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Jobs\ExportGensenJob;
use App\Jobs\ImportGensenJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;
use Illuminate\Support\Facades\URL;

class IchijikinExtractionResult extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        'ichijikin_extraction_file_id',

        'nama_lengkap',
        'no_nenkin',
        'lama_kerja',
        'nenkin_100',
        'nenkin_80',
        'nenkin_20',
        'type',

        'error_message',

        'started_at',
        'finished_at',
        'confidence_score',

        // lifecycle state
        'status',
    ];

    protected $guarded = ['id'];

    const TYPE_SPEED = 'speed';
    const TYPE_NORMAL = 'normal';

    protected $casts = [
        'status' => JobStatus::class,
    ];

    protected static function onBoot()
    {
        self::creating(function ($model) {});
        self::created(function ($model) {});
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
