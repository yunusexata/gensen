<?php

namespace App\Models\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Jobs\IchijikinExtraction\SplitIchijikinJob;
use App\Jobs\ResiGenerator\GetEmailJob;
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

        'error_message',

        'started_at',
        'finished_at',

        // lifecycle state
        'status',

        'zip_path',
        'zip_generated_at',
        'zip_status',
        'zip_error_message',
        'zip_started_at',
        'zip_finished_at',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'status' => JobStatus::class,
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
        self::created(function ($model) {
            GetEmailJob::dispatch($model)->onQueue('extract');
        });
    }

    public function details()
    {
        return $this->hasMany(ResiGeneratorDetail::class, 'resi_generator_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
