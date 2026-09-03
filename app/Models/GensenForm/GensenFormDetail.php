<?php

namespace App\Models\GensenForm;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class GensenFormDetail extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'gensen_form_id',
        'tahun_gensen',
        'nominal_gensen',


        // Step 4 - Acc Exata
        'tanggal_tarik_data',  // Tanggal Tarik Data
        'label',  // Label Tarik Data

        // Step 5 - HS2
        'nominal_cair',
        'tanggal_cair',
    ];

    protected $guarded = ['id'];

    public function isDeletable()
    {
        return true;
    }

    public function isEditable()
    {
        return true;
    }
    public function gensenForm()
    {
        return $this->belongsTo(GensenForm::class, 'gensen_form_id', 'id');
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
