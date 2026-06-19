<?php

namespace App\Models\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Models\Ai\AiJob;
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
        'email_received_at',
        'email_subject',
        'email_body_raw',
        'email_parsed',
        'generated_image_path'
        
        'error_message',

        'started_at',
        'finished_at',

        // lifecycle state
        'status',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'status' => JobStatus::class,
        'email_parsed' => 'array',
    ];

    protected static function onBoot()
    {
        // self::creating(function ($model) {});
        self::created(function ($model) {});
    }

    public function resiGenerator()
    {
        return $this->belongsTo(resiGenerator::class, 'resi_generator_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
