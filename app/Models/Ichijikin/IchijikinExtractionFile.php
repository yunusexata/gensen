<?php

namespace App\Models\Ichijikin;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Jobs\ExportGensenJob;
use App\Jobs\IchijikinExtraction\CropIchijikinJob;
use App\Jobs\ImportGensenJob;
use App\Models\Ai\AiJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class IchijikinExtractionFile extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        'ichijikin_extraction_id',
        'ichijikin_extraction_detail_id',
        'file_stored_name',

        'disk',
        'path',
        'note',

        'extension',
        'mime_type',
        'file_size',

        // MERGE RESULT

        'merge_disk',
        'merge_path',
        'merge_note',

        'merge_extension',
        'merge_mime_type',
        'merge_file_size',
    ];

    protected $guarded = ['id'];

    const TYPE_SPEED = 'speed';
    const TYPE_NORMAL = 'normal';

    protected static function onBoot()
    {
        // self::creating(function ($model) {});
        self::created(function ($model) {
            $job = AiJob::create([
                'subject_type' => self::class,
                'subject_id'   => $model->id,
                'job_type'     => AiJob::JOB_TYPE_ICHIJIKIN_EXTRACTION,
                'status'       => 'pending',
                'provider'     => 'gemini-ai',
                'model'        => env('GEMINI_MODEL', 'gemini-3.1-flash-lite'),
            ]);
        });
    }

    public function result()
    {
        return $this->hasOne(IchijikinExtractionResult::class)
            ->latestOfMany('created_at');
    }

    public function aiJob()
    {
        return $this->belongsTo(AiJob::class, 'ichijikin_extraction_id', 'id');
    }

    public function ichijikinExtraction()
    {
        return $this->belongsTo(IchijikinExtraction::class, 'ichijikin_extraction_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
