<?php

namespace App\Models\Ichijikin;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Jobs\ExportGensenJob;
use App\Jobs\IchijikinExtraction\SplitIchijikinJob;
use App\Jobs\ImportGensenJob;
use App\Models\Ichijikin\IchijikinExtractionFile;
use App\Models\Ichijikin\IchijikinExtractionResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class IchijikinExtractionDetail extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'ichijikin_extraction_id',

        'stored_name',
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

    public function ichijikin()
    {
        return $this->belongsTo(IchijikinExtraction::class, 'ichijikin_extraction_id', 'id');
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
