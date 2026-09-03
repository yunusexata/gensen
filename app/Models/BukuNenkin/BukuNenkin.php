<?php

namespace App\Models\BukuNenkin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class BukuNenkin extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'alamat_jepang',
        'tanggal_kepulangan',
    ];

    protected $guarded = ['id'];

    public function companies()
    {
        return $this->hasMany(BukuNenkinCompany::class, 'buku_nenkin_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
