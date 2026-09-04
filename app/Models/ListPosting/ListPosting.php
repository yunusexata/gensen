<?php

namespace App\Models\ListPosting;

use App\Enums\Gensen\JobStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class ListPosting extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'template_posting_id',
        'name',

        'zip_path',
        'zip_generated_at',
        'zip_status',
        'zip_error_message',
        'zip_started_at',
        'zip_finished_at',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'zip_status' => JobStatus::class,
    ];

    public function template()
    {
        return $this->belongsTo(TemplatePosting::class, 'template_posting_id', 'id');
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
