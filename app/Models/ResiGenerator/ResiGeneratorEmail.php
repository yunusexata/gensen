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

class ResiGeneratorEmail extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'resi_generator_id',
        'email_received_at',
        'email_subject',
        'email_sender',
        'email_body_raw',
        'email_html',
        'email_parsed',

        'formatted_nominal',
        'formatted_rekening_tujuan',
        'formatted_penerima',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'email_parsed' => 'array',
    ];

    protected static function onBoot()
    {
        self::created(function ($model) {});
    }

    public function resi()
    {
        return $this->belongsTo(ResiGenerator::class, 'resi_generator_id', 'id');
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
