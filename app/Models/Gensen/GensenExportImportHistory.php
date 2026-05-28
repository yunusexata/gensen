<?php

namespace App\Models\Gensen;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Jobs\ExportGensenJob;
use App\Jobs\ImportGensenJob;
use App\Jobs\MergePersyaratanPengurusanGensen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;
use Illuminate\Support\Facades\URL;

class GensenExportImportHistory extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        'role',
        'type',
        'job_key',
        'export_template',
        'status',

        'file_template_name',
        'disk_template',
        'file_template_path',

        'file_name',
        'disk',
        'file_path',
        'error_message',

        'filters',
        'amount',

        'started_at',
        'finished_at',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'status' => JobStatus::class,
        'job_key' => ExportImportJobKey::class,
    ];

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

    public function previewUrl(): string
    {
        return URL::temporarySignedRoute(
            'gensen.attachment.preview-export-import',
            now()->addMinutes(30),
            ['history_id' => $this->id]
        );
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
