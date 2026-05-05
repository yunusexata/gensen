<?php

namespace App\Models\BukuNenkin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class BukuNenkinCompany extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'buku_nenkin_id',
        'nama_perusahaan',
        'alamat_perusahaan',
        'no_telp',
        'tanggal_kerja_awal',
        'tanggal_kerja_akhir',
        'jenis_nenkin',
    ];

    protected $guarded = ['id'];
}
