<?php

namespace App\Models\Gensen;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Jobs\ExportGensenJob;
use App\Jobs\HistoryExportImport\GenerateZipJob;
use App\Jobs\ImportGensenJob;
use App\Jobs\MergePersyaratanPengurusanGensen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class GensenSeluruhBerkasZipJob extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'gensen_export_import_history_id',
        'status',
        'error_message',
        'zip_disk',
        'zip_path',
        'started_at',
        'finished_at',

    ];

    protected $guarded = ['id'];

    protected $casts = [
        'status' => JobStatus::class,
        'customer_ids' => 'array',
    ];

    protected static function onBoot()
    {
        self::creating(function ($model) {
            if (is_null($model->status)) {
                $model->status = JobStatus::PENDING;
            }
        });
        self::created(function ($model) {
            GenerateZipJob::dispatch($model->gensen_export_import_history_id)->onQueue('pdf');
        });
    }

    public function gensenExportImportHistory()
    {
        return $this->belongsTo(GensenExportImportHistory::class, 'gensen_export_import_history_id', 'id');
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
