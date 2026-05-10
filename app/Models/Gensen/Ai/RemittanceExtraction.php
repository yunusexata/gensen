<?php

namespace App\Models\Gensen\Ai;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Jobs\ExportGensenJob;
use App\Jobs\MergePersyaratanPengurusanGensen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class RemittanceExtraction extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'ai_job_id',

        'subject_id',
        'subject_type',
        'confidence_score',
        'confidence_note',
        'total_transfer',
        'ai_total_transfer',
    ];

    protected $guarded = ['id'];

    protected static function onBoot()
    {
        self::updated(function ($model) {
            $model->subject->update(['jumlah_kirim_uang' => $model->total_transfer]);
        });
    }
    public function syncSubjectTotal()
    {
        $subject = $this->subject;

        if ($subject) {
            // Calculate the sum of all VALIDATED groups for this subject
            // We look through all extractions belonging to this subject
            $newTotal = $this->remittanceExtractionGroups->where('is_validate', true)
                ->sum('total_amount');
            logger([
                'new_total',
                $newTotal
            ]);

            $this->update(['total_transfer' => $newTotal]);
        }
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function remittanceExtractionGroups()
    {
        return $this->hasMany(RemittanceExtractionGroup::class, 'remittance_extraction_id', 'id');
    }
}
