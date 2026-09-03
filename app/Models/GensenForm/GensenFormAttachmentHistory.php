<?php

namespace App\Models\GensenForm;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentRemittanceType;
use App\Enums\Gensen\GensenAttachmentType;
use App\Models\GensenForm\GensenFormAttachment;
use App\Models\GensenForm\GensenForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class GensenFormAttachmentHistory extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'gensen_form_id',
        'gensen_form_attachment_id',
        'type',
        'original_name',       // KK_andi.jpg
        'stored_name',         // uuid filename
        'description',

        'disk',                // local / s3
        'path',                // storage path
        'note',                // attachment note
        'remittance_type',                // attachment note

        'extension',           // jpg
        'mime_type',           // image/jpeg
        'file_size',           // bytes

        'checksum',
        'status',               // STORED ,REJECTED, EDITED
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'type' => GensenAttachmentType::class,
        'remittance_type' => GensenAttachmentRemittanceType::class,
        'status' => GensenAttachmenStatus::class,
    ];
    public function isDeletable()
    {
        return true;
    }

    public function isEditable()
    {
        return true;
    }
    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }
    public function previewUrl(): string
    {
        return URL::temporarySignedRoute(
            'gensen.attachment.preview',
            now()->addMinutes(30),
            ['attachment' => $this->id]
        );
    }

    public function url(): string
    {
        return $this->type->is(GensenAttachmentType::REKAP_PENGIRIMAN_UANG)
            ? generateUrl(
                "gensen/{$this->gensen_form_id}/{$this->type->value}",
                $this->path
            )
            : generateUrl(
                "gensen/{$this->gensen_form_id}/{$this->type->value}/{$this->note}",
                $this->path
            );
    }
    protected static function onBoot()
    {
        self::creating(function ($model) {
            if ($model->gensen_form_attachment_id) {
                $model = $model->gensenFormAttachment->saveInfo($model, false, '');
            }
        });
    }

    public function gensenForm()
    {
        return $this->belongsTo(GensenForm::class, 'gensen_form_id', 'id');
    }

    public function gensenFormAttachment()
    {
        return $this->belongsTo(GensenFormAttachment::class, 'gensen_form_attachment_id', 'id');
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
