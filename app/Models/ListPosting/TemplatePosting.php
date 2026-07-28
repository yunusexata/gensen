<?php

namespace App\Models\ListPosting;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class TemplatePosting extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [

        'name',
        'path',
        'disk',
        'config',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'config' => 'array',
    ];

    public function previewUrl(): string
    {
        return match ($this->disk) {

            // =========================================
            // LOCAL PUBLIC
            // =========================================
            'public' => URL::temporarySignedRoute(
                'template_posting.preview',
                now()->addMinutes(30),
                [
                    'template' => $this->id,
                ]
            ),
            // =========================================
            // LOCAL PRIVATE
            // =========================================
            'private' => URL::temporarySignedRoute(
                'template_posting.preview',
                now()->addMinutes(30),
                [
                    'template' => $this->id,
                ]
            ),

            // =========================================
            // SUPABASE
            // =========================================
            'supabase' => 'https://pevrthazwqqzmxrthphg.supabase.co/storage/v1/object/public/gensen-exata/' . $this->path,
            default => throw new \Exception(
                "Unsupported disk [{$this->disk}]"
            ),
        };
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
