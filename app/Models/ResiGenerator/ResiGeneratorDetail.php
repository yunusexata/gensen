<?php

namespace App\Models\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Jobs\ResiGenerator\GenerateReceiptImageJob;
use App\Models\Ai\AiJob;
use App\Models\ResiGenerator\ResiGenerator;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class ResiGeneratorDetail extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        'resi_generator_id',

        'no',
        'jenis_pencairan',
        'nama',
        'nominal',
        'rekening',
        'bank',

        'is_matched',
        'resi_generator_email_id',
        'generated_image_disk',
        'generated_image_path',
        'confidence_score',

        'error_message',

        'started_at',
        'finished_at',

        // lifecycle state
        'status',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'status' => JobStatus::class,
    ];

    protected static function onBoot()
    {
        // self::creating(function ($model) {});
        self::created(function ($model) {
            // GenerateReceiptImageJob::dispatch($model)->onQueue('extract');
        });
    }

    public function resi()
    {
        return $this->belongsTo(ResiGenerator::class, 'resi_generator_id', 'id');
    }

    public function email()
    {
        return $this->belongsTo(ResiGeneratorEmail::class, 'resi_generator_email_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
