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
        self::creating(function ($model) {
            if (is_null($model->status)) {
                $model->status = JobStatus::PENDING;
            }
        });
        self::created(function ($model) {
            if ($model->type === 'export') {
                // if ($model->job_key != ExportImportJobKey::EXPORT_LIST_DATA_DALAM_PENGAJUAN) {
                ExportGensenJob::dispatch($model->id)->onQueue('excel');
                // }
            }
            if ($model->type === 'import') {
                ImportGensenJob::dispatch($model->id)->onQueue('excel');
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
