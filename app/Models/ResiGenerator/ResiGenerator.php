<?php

namespace App\Models\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Jobs\IchijikinExtraction\SplitIchijikinJob;
use App\Jobs\ResiGenerator\GetEmailJob;
use App\Jobs\ResiGenerator\ResiMatchingJob;
use App\Models\Ichijikin\IchijikinExtractionFile;
use App\Models\Ichijikin\IchijikinExtractionResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class ResiGenerator extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        'label',
        'bank',
        'amount',

        'source_file_name',
        'source_file_disk',
        'source_file_path',

        'get_email_error_message',

        'get_email_started_at',
        'get_email_finished_at',

        // lifecycle state
        'get_email_status',

        'matching_error_message',

        'matching_started_at',
        'matching_finished_at',

        // lifecycle state
        'matching_status',

        'zip_path',
        'zip_generated_at',
        'zip_status',
        'zip_error_message',
        'zip_started_at',
        'zip_finished_at',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'get_email_status' => JobStatus::class,
        'matching_status' => JobStatus::class,
        'zip_status' => JobStatus::class,
    ];

    const BANK_BCA = 'bca';
    const BANK_BNI = 'bni';
    const BANK_BRI = 'bri';
    const BANK_MANDIRI = 'mandiri';

    const BANK_CHOICE = [
        self::BANK_BCA => 'BCA',
        self::BANK_BNI => 'BNI',
        self::BANK_BRI => 'BRI',
        self::BANK_MANDIRI => 'MANDIRI',
    ];

    protected static function onBoot()
    {
        self::updated(function ($model) {
            logger([
                'Updated Resi Generator Models',
                'Detail Count = ' . $model->details->count(),
                'Model Amount = ' . $model->amount
            ]);
            if (
                $model->wasChanged('get_email_status')
                && $model->getOriginal('get_email_status') !== JobStatus::DONE
                && $model->get_email_status === JobStatus::DONE
            ) {
                logger('DONE & Match Count');

                ResiMatchingJob::dispatch($model)
                    ->onQueue('pdf');
            }
        });
    }

    public function details()
    {
        return $this->hasMany(ResiGeneratorDetail::class, 'resi_generator_id', 'id');
    }

    public function emails()
    {
        return $this->hasMany(ResiGeneratorEmail::class, 'resi_generator_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
