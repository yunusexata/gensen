<?php

namespace App\Models\GensenForm;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Helpers\NumberGenerator;
use App\Helpers\PermissionHelper;
use App\Models\Ai\AiJob;
use App\Models\Gensen\Ai\RemittanceExtraction;
use App\Repositories\Account\UserRepository;
use App\Repositories\GensenForm\PersyaratanGensenJobRepository;
use App\Repositories\GensenForm\SeluruhBerkasJobRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Muhammadyunus1072\TrackHistory\HasTrackHistory;

class GensenForm extends Model
{
    //  FIlter export
    //  Import excel (bulk update)
    //  poin of recommendation
    //  max 3
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        // Sistem
        'id_customer',
        'status',

        // ---------- //
        // Form Input //
        // ---------- //

        // Data Diri
        'nama_lengkap',
        'tanggal_lahir',
        'email',
        'tanggal_kepulangan',
        'nama_instagram',
        'nama_tiktok',
        'nomor_whatsapp',
        'nomor_whatsapp_darurat',
        'alamat_jepang',
        'kode_pos_jepang',
        'nama_lpk',

        // REK PENERIMA
        'no_rekening_penerima',
        'nama_bank_penerima',
        'nama_penerima',
        'hubungan_penerima',

        // Gensen
        'tahun_gensen',
        'tahun_transfer',

        // Relasi History
        'remarks_id',
        'remarks_type',
        'pic_code',

        // Validasi
        'is_should_filled',
        'is_submitted',

        // ----------- //
        // Flow Bisnis //
        // ----------- //

        // Step 1 - HS
        'tanggal_lengkap',

        // Step 2 - HS2
        'tanggal_verified',

        // Step 3 - Admin Jepang
        'no_input_jepang',

        // Step 4 - HS
        'nominal_gensen',
        'jumlah_kirim_uang',
        'nama_penerima_dan_hubungan',

        // Step 5 - Admin Jepang
        'tanggal_pengajuan',  // Tanggal Pengajuan Ke Kantor Pajak

        // Step 6 - Acc Exata
        'nominal_cair',
        'tanggal_cair',

        // MONDAI
        'keterangan_mondai',
    ];

    const PIC_AI = 'AI';
    const PIC_MT = 'MT';
    const PIC_SN = 'SN';

    const PIC_CHOICE = [
        self::PIC_AI => 'AI',
        self::PIC_MT => 'MT',
        self::PIC_SN => 'SN',
    ];

    const REMITTANCE_SMILES = 'SMILES';
    const REMITTANCE_KYODAI = 'KYODAI';
    const REMITTANCE_RIA_KYODAI = 'RIA KYODAI';

    const REMITTANCE_CHOICE = [
        self::REMITTANCE_SMILES => 'SMILES',
        self::REMITTANCE_KYODAI => 'KYODAI',
        self::REMITTANCE_RIA_KYODAI => 'RIA KYODAI',
    ];

    const STATUS_BELUM_LENGKAP = 'BELUM LENGKAP';
    const STATUS_SIAP_VERIFIKASI = 'SIAP VERIFIKASI'; // NOT INCLUDE IN FLOW / CUSTOM STATUS 
    const STATUS_LENGKAP = 'LENGKAP';
    const STATUS_VERIFIED = 'VERIFIED';
    const STATUS_NO_INPUT_JEPANG = 'NO INPUT JEPANG'; // NOT INCLUDE IN FLOW / CUSTOM STATUS 
    const STATUS_DALAM_PENGAJUAN = 'DALAM PENGAJUAN';
    const STATUS_GENSEN_CAIR = 'GENSEN CAIR';
    const STATUS_CANCEL = 'CANCEL';
    const STATUS_HONNIN = 'HONNIN';
    const STATUS_CHOICE = [

        self::STATUS_BELUM_LENGKAP => 'BELUM LENGKAP',
        self::STATUS_LENGKAP => 'LENGKAP',
        self::STATUS_SIAP_VERIFIKASI => 'SIAP VERIFIKASI',
        self::STATUS_VERIFIED => 'VERIFIED',
        self::STATUS_NO_INPUT_JEPANG => 'NO INPUT JEPANG',
        self::STATUS_DALAM_PENGAJUAN => 'DALAM PENGAJUAN',
        self::STATUS_GENSEN_CAIR => 'GENSEN CAIR',
        self::STATUS_CANCEL => 'CANCEL',
        self::STATUS_HONNIN => 'HONNIN',
    ];

    const ATTACHMENT_ORDER_BY = [
        GensenAttachmentType::KERTAS_GENSEN->value,
        GensenAttachmentType::ZAIRYOU_CARD_FRONT->value,
        GensenAttachmentType::ZAIRYOU_CARD_BACK->value,
        GensenAttachmentType::MY_NUMBER_FRONT->value,
        GensenAttachmentType::MY_NUMBER_BACK->value,
        GensenAttachmentType::REKENING_INDONESIA->value,
        GensenAttachmentType::REKAP_PENGIRIMAN_UANG->value,
        GensenAttachmentType::KARTU_KELUARGA->value,
    ];

    public function statusColor()
    {
        return match ($this->status) {
            self::STATUS_BELUM_LENGKAP => '#F9B2D7',
            self::STATUS_LENGKAP => '#5DEBD7',
            self::STATUS_VERIFIED => '#89D4FF',
            self::STATUS_DALAM_PENGAJUAN => '#4689e8',
            self::STATUS_GENSEN_CAIR => '#E5C95F',
            self::STATUS_CANCEL => '#FFF6F6',
            self::STATUS_HONNIN => '#D1855C',
            null => '#ffffff',
        };
    }

    protected $guarded = ['id'];

    public function isDeletable()
    {
        return true;
    }

    public function isEditable()
    {
        return true;
    }

    public function isCanDelete()
    {
        return $this->isDeletable() && UserRepository::authenticatedUser()->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_FORM, PermissionHelper::TYPE_DELETE));
    }

    protected static function onBoot()
    {
        self::creating(function ($model) {
            $model->id_customer = NumberGenerator::generate(self::class);
            $model->status = self::STATUS_BELUM_LENGKAP;
            // $model->created_by = rand(7, 9);
        });
        self::updating(function ($model) {
            if ($model->isDirty('tanggal_lengkap') && $model->tanggal_lengkap) {
                $model->status = self::STATUS_LENGKAP;
            }
            if ($model->isDirty('tanggal_verified') && $model->tanggal_verified) {
                $model->status = self::STATUS_VERIFIED;
            }
            if ($model->isDirty('tanggal_cair') && $model->tanggal_cair && $model->isDirty('nominal_cair') && $model->nominal_cair) {
                $model->status = self::STATUS_GENSEN_CAIR;
            }
            if ($model->isDirty('tanggal_pengajuan') && $model->tanggal_pengajuan) {
                $model->status = self::STATUS_DALAM_PENGAJUAN;
            }
            // if ($model->isDirty('no_input_jepang') && $model->no_input_jepang) {
            // $model->status = self::STATUS_GENSEN_CAIR;
            // }
        });
        self::created(function ($model) {
            if ($model->remarks_type === GensenFormLink::class) {
                $model->remarks->incrementUsedCount();
            }
        });
        self::updated(function ($model) {
            if ($model->status === self::STATUS_LENGKAP) {

                $aiJob = AiJob::create([

                    'provider' => 'gemini-ai',

                    'model' => env('GEMINI_MODEL', 'gemini-3.1-flash-lite'),

                    'job_type' => AiJob::JOB_TYPE_REMITTANCE_EXTRACTION,

                    'status' => 'pending',

                    'subject_type' => $model::class,

                    'subject_id' => $model->id,
                ]);
            }
        });
        self::deleted(function ($model) {
            if ($model->remarks_type === GensenFormLink::class) {
                $model->remarks->decrementUsedCount();
            }
        });
    }

    public function copyInfo($object, $data = false, $prefix = "")
    {
        if ($data) {
            // foreach ($data as $item) {
            //     $object[$prefix . "" . $item] = $this->$item;
            // }
        } else {

            // ---------- //
            // Form Input //
            // ---------- //

            // Data Diri
            $object[$prefix . 'nama_lengkap'] = $this->nama_lengkap;
            $object[$prefix . 'tanggal_lahir'] = $this->tanggal_lahir;
            $object[$prefix . 'email'] = $this->email;
            $object[$prefix . 'tanggal_kepulangan'] = $this->tanggal_kepulangan;
            $object[$prefix . 'nama_instagram'] = $this->nama_instagram;
            $object[$prefix . 'nama_tiktok'] = $this->nama_tiktok;
            $object[$prefix . 'nomor_whatsapp'] = $this->nomor_whatsapp;
            $object[$prefix . 'nomor_whatsapp_darurat'] = $this->nomor_whatsapp_darurat;
            $object[$prefix . 'alamat_jepang'] = $this->alamat_jepang;
            $object[$prefix . 'kode_pos_jepang'] = $this->kode_pos_jepang;
            $object[$prefix . 'nama_lpk'] = $this->nama_lpk;

            // REK PENERIMA
            $object[$prefix . 'no_rekening_penerima'] = $this->no_rekening_penerima;
            $object[$prefix . 'nama_bank_penerima'] = $this->nama_bank_penerima;
            $object[$prefix . 'nama_penerima'] = $this->nama_penerima;
            $object[$prefix . 'hubungan_penerima'] = $this->hubungan_penerima;

            // Relasi History
            $object[$prefix . 'remarks_id'] = $this->remarks_id;
            $object[$prefix . 'remarks_type'] = $this->remarks_type;
            $object[$prefix . 'pic_code'] = $this->pic_code;

            // Validasi
            $object[$prefix . 'is_should_filled'] = true;
            $object[$prefix . 'is_submitted'] = true;
        }

        return $object;
    }

    public function onSubmitted()
    {
        // AUTOMATIC UPDATE STATUS LENGKAP WHEN GensenAttachmentType::completeIdentity() == true
        // if (in_array($this->status, [
        //     self::STATUS_LENGKAP,
        //     self::STATUS_BELUM_LENGKAP,
        //     null,
        // ])) {
        //     $this->status = $this->isAttachmentReady(GensenAttachmentType::completeIdentity()) ? self::STATUS_LENGKAP : self::STATUS_BELUM_LENGKAP;
        // }
        $this->is_should_filled = $this->isShouldFilled();
        $this->save();
    }

    public function isAttachmentReady($requiredTypes = false): bool
    {
        $requiredTypes = $requiredTypes ? $requiredTypes : GensenAttachmentType::cases();
        $uploadedTypes = $this->attachments
            ->where('status', '!=', GensenAttachmenStatus::STATUS_REJECTED)
            ->whereNull('deleted_at')
            ->pluck('type')
            ->map(fn($t) => $t->value)
            ->toArray();
        foreach ($requiredTypes as $type) {
            if (!in_array($type->value, $uploadedTypes)) {
                return false;
            }
        }

        return true;
    }

    public function handleMergePersyaratanGensen()
    {
        if (
            // $this->isAttachmentReady(GensenAttachmentType::mergeIdentity())
            // && 
            (
                !$this->persyaratanGensenJob() || !$this->persyaratanGensenJob()
                    ->where('status', '=', JobStatus::PENDING)
                    ->exists()
            )
        ) {
            PersyaratanGensenJobRepository::create([
                'gensen_form_id' => $this->id,
                'status' => JobStatus::PENDING,
            ]);
        }
    }

    public function handleMergeSeluruhBerkas()
    {
        if (
            // $this->isAttachmentReady(GensenAttachmentType::mergeAllIdentity())
            // && 
            (
                !$this->seluruhBerkasJob() || !$this->seluruhBerkasJob()
                    ->where('status', '=', JobStatus::PENDING)
                    ->exists()
            )
        ) {
            SeluruhBerkasJobRepository::create([
                'gensen_form_id' => $this->id,
                'status' => JobStatus::PENDING,
            ]);
        }
    }

    const SHOULD_FILLED = [
        'nama_lengkap',
        'email',
        'tanggal_lahir',
        'nama_instagram',
        'nama_tiktok',
        'nomor_whatsapp',
        'nomor_whatsapp_darurat',
        'alamat_jepang',
        'kode_pos_jepang',

        // REK PENERIMA
        'no_rekening_penerima',
        'nama_bank_penerima',
        'nama_penerima',
    ];

    public function isShouldFilled(): bool
    {
        return collect(self::SHOULD_FILLED)
            ->every(fn($field) => filled($this->{$field}));
    }

    public function attachmentGroups($types)
    {
        $attachments = $this->attachments
            ->where('status', '!=', GensenAttachmenStatus::STATUS_CONVERTED)
            ->when($types, function ($q) use ($types) {
                $q->whereIn('type', $types);
            })
            ->groupBy(fn($a) => $a->type->value);

        return collect(GensenAttachmentType::cases())
            ->mapWithKeys(function ($type) use ($attachments) {

                $items = $attachments->get($type->value, collect());

                if (in_array($type, [
                    GensenAttachmentType::KARTU_KELUARGA,
                    GensenAttachmentType::KERTAS_GENSEN,
                    GensenAttachmentType::REKAP_PENGIRIMAN_UANG,
                ])) {

                    return [
                        $type->value => [
                            'type' => $type,
                            'label' => $type->label(),
                            'uploaded' => $items->isNotEmpty(),
                            'groups' => $items
                                ->groupBy('remittance_type')
                                ->map(function ($files, $provider) {
                                    return [
                                        'provider' => $provider,
                                        'files' => $files->map(fn($file) => [
                                            'id' => Crypt::encrypt($file->id),
                                            'filename' => $file->original_name,
                                            'remittance_type' => $file->remittance_type,
                                            'size' => $file->file_size,
                                            'note' => $file->note,
                                            'type' => $file->type,
                                            'created_at' => $file->created_at,
                                            'isPdf' => $file->isPdf(),
                                            'isImage' => $file->isImage(),
                                            'url' => $file->previewUrl(),
                                        ]),
                                    ];
                                })
                                ->values()
                                ->toArray(),
                        ]
                    ];
                }
                if (in_array($type, [
                    GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN,
                    GensenAttachmentType::SELURUH_BERKAS,
                ])) {

                    $attachment = $items->first();
                    return [
                        $type->value => [
                            'id' => $attachment?->id ? Crypt::encrypt($attachment->id) : null,
                            'type' => $type,
                            'label' => $type->label(),
                            'uploaded' => (bool) $attachment,
                            'attachment' => $attachment,
                            'filename' => $attachment?->original_name,
                            'isJobProcess' => $attachment?->isJobProcess(),
                            'isJobProcessDone' => $attachment?->isJobProcessDone(),
                            'status' => $attachment?->status,
                            'printStatus' => $attachment?->status?->print(),
                            'size' => $attachment?->file_size,
                            'note' => $attachment?->note,
                            'created_at' => $attachment?->created_at,
                            'isPdf' => $attachment?->isPdf(),
                            'isImage' => $attachment?->isImage(),
                            'url' => $attachment?->previewUrl(),
                        ]
                    ];
                }

                $attachment = $items->first();

                return [
                    $type->value => [
                        'id' => $attachment?->id ? Crypt::encrypt($attachment->id) : null,
                        'type' => $type,
                        'label' => $type->label(),
                        'uploaded' => (bool) $attachment,
                        'attachment' => $attachment,
                        'filename' => $attachment?->original_name,
                        'status' => $attachment?->status,
                        'printStatus' => $attachment?->status?->print(),
                        'size' => $attachment?->file_size,
                        'note' => $attachment?->note,
                        'created_at' => $attachment?->created_at,
                        'isPdf' => $attachment?->isPdf(),
                        'isImage' => $attachment?->isImage(),
                        'url' => $attachment?->previewUrl(),
                    ]
                ];
            });
    }

    // Mysql
    // public function attachments()
    // {
    //     return $this->hasMany(GensenFormAttachment::class, 'gensen_form_id', 'id')->orderByRaw(
    //         "FIELD(type, " . collect(self::ATTACHMENT_ORDER_BY)
    //             ->map(fn($v) => "'$v'")
    //             ->implode(',') . ")"
    //     );
    // }


    // PostgreSQL
    public function attachments()
    {
        $case = collect(self::ATTACHMENT_ORDER_BY)
            ->values()
            ->map(
                fn($value, $index) =>
                "WHEN '{$value}' THEN " . ($index + 1)
            )
            ->implode(' ');

        return $this->hasMany(GensenFormAttachment::class, 'gensen_form_id', 'id')
            ->orderByRaw("CASE type {$case} ELSE 999 END");
    }
    public function attachmentsToConvert()
    {
        return $this->hasMany(GensenFormAttachment::class, 'gensen_form_id', 'id')->whereIn('type', [
            GensenAttachmentType::KERTAS_GENSEN->value,
            GensenAttachmentType::KARTU_KELUARGA->value,
            GensenAttachmentType::REKAP_PENGIRIMAN_UANG->value,
        ])
            ->where(function ($q) {
                $q->whereNull('convert_image')
                    ->orWhere('convert_image', false);
            })
            ->where('status', '!=', GensenAttachmenStatus::STATUS_CONVERTED);
    }
    public function attachmentsConvertedRekapanPengirimanUang()
    {
        return $this->hasMany(GensenFormAttachment::class, 'gensen_form_id', 'id')->where('type', GensenAttachmentType::REKAP_PENGIRIMAN_UANG)
            ->where('status', GensenAttachmenStatus::STATUS_CONVERTED);
    }

    public function remarks()
    {
        return $this->morphTo();
    }

    public function getPicAttribute()
    {
        if (!$this->remarks) {
            return null;
        }

        if ($this->remarks instanceof GensenFormLink) {
            return $this->remarks->creator;
        }

        return $this->remarks;
    }

    public function persyaratanGensenJob()
    {
        return $this->hasOne(
            PersyaratanGensenJob::class,
            'gensen_form_id', // FK in jobs table
            'id'              // PK in gensen_forms
        );
    }

    public function seluruhBerkasJob()
    {
        return $this->hasOne(
            SeluruhBerkasJob::class,
            'gensen_form_id', // FK in jobs table
            'id'              // PK in gensen_forms
        );
    }

    public function remittanceExtraction()
    {
        return $this->hasOne(RemittanceExtraction::class, 'subject_id', 'id')->where('subject_type', self::class);
    }

    public function gensenFormDetails()
    {
        return $this->hasMany(GensenFormDetail::class, 'gensen_form_id', 'id');
    }
}
