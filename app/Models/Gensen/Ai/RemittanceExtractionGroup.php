<?php

namespace App\Models\Gensen\Ai;

use App\Models\User;
use App\Traits\Models\UppercaseAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class RemittanceExtractionGroup extends Model
{
    // php artisan reverb:start
    use HasFactory, SoftDeletes, HasTrackHistory, UppercaseAttributes;

    protected $fillable = [

        'remittance_extraction_id',
        'receiver_name',
        'transaction_year',

        // We use decimal(15,2) for financial accuracy rather than float/number
        'total_amount',
        'currency',
        'transfer_transaction_count',

        // THE AUDIT TRAIL: Store the individual amounts as a JSON array
        'amount_details',
        'is_validate',
        'receiver_relationship',
    ];

    protected array $uppercase = [
        'receiver_name',
        'receiver_relationship'
    ];

    protected $guarded = ['id'];

    protected static function onBoot()
    {
        static::deleted(function ($model) {
            $model->syncSubjectTotal();
        });
    }

    /**
     * Recalculates the sum from scratch to ensure mathematical integrity.
     */
    public function syncSubjectTotal()
    {
        // $subject = $this->remittanceExtraction->subject;

        // if ($subject) {
        // Calculate the sum of all VALIDATED groups for this subject
        // We look through all extractions belonging to this subject
        // $newTotal = $this->remittanceExtraction->whereHas('remittanceExtraction', function ($query) use ($subject) {
        //     $query->where('subject_id', $subject->id);
        // })
        //     ->where('is_validate', true)
        //     ->sum('total_amount');
        // logger([
        //     'new_total',
        //     $newTotal
        // ]);

        // $subject->update(['jumlah_kirim_uang' => $newTotal]);
        // }
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function remittanceExtraction()
    {
        return $this->belongsTo(RemittanceExtraction::class, 'remittance_extraction_id', 'id');
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
