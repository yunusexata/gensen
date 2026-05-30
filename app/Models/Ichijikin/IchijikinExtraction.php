<?php

namespace App\Models\Ichijikin;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Jobs\ExportGensenJob;
use App\Jobs\IchijikinExtraction\SplitIchijikinJob;
use App\Jobs\ImportGensenJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class IchijikinExtraction extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        'batch_name',
        'stored_name',
        'description',

        'disk',
        'path',
        'note',

        'extension',
        'mime_type',
        'file_size',

        'checksum',
    ];

    protected $guarded = ['id'];

    protected static function onBoot()
    {
        self::created(function ($model) {
            SplitIchijikinJob::dispatch($model)->onQueue('pdf');
        });
    }

    public function ichijikinExtractionFiles()
    {
        return $this->hasMany(IchijikinExtractionFile::class, 'ichijikin_extraction_id', 'id');
    }

    public function ichijikinExtractionResults()
    {
        return $this->hasMany(IchijikinExtractionResult::class, 'ichijikin_extraction_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
