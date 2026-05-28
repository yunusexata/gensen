<?php

namespace App\Repositories\GensenForm;

use App\Enums\Gensen\GensenAttachmentType;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormLink;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use App\Repositories\MasterDataRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GensenFormRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenForm::class;
    }

    public static function copy($gensen_form_id)
    {
        DB::beginTransaction();

        try {

            $gensen_form = self::find($gensen_form_id);

            /*
        |--------------------------------------------------------------------------
        | 1. CREATE NEW FORM
        |--------------------------------------------------------------------------
        */
            $newForm = GensenFormRepository::create([
                'nama_lengkap' => $gensen_form->nama_lengkap,
                'tanggal_lahir' => $gensen_form->tanggal_lahir,
                'tanggal_kepulangan' => $gensen_form->tanggal_kepulangan,
                'nama_instagram' => $gensen_form->nama_instagram,
                'nama_tiktok' => $gensen_form->nama_tiktok,
                'nomor_whatsapp' => $gensen_form->nomor_whatsapp,
                'nomor_whatsapp_darurat' => $gensen_form->nomor_whatsapp_darurat,
                'email' => $gensen_form->email,
                'alamat_jepang' => $gensen_form->alamat_jepang,
                'kode_pos_jepang' => $gensen_form->kode_pos_jepang,
                'nama_lpk' => $gensen_form->nama_lpk,

                'no_rekening_penerima' => $gensen_form->no_rekening_penerima,
                'nama_bank_penerima' => $gensen_form->nama_bank_penerima,
                'nama_penerima' => $gensen_form->nama_penerima,
                'hubungan_penerima' => $gensen_form->hubungan_penerima,

                // 'tahun_gensen' => $gensen_form->tahun_gensen,
                // 'tahun_transfer' => $gensen_form->tahun_transfer,

                'remarks_id' => $gensen_form->remarks_id,
                'remarks_type' => $gensen_form->remarks_type,
                'pic_code' => $gensen_form->pic_code,
                'no_input_jepang' => $gensen_form->no_input_jepang,

                'is_should_filled' => true,
                'is_submitted' => true,
            ]);

            /*
        |--------------------------------------------------------------------------
        | 2. COPY ATTACHMENTS
        |--------------------------------------------------------------------------
        */

            $attachments = $gensen_form->attachmentsCopy;

            foreach ($attachments as $attachment) {

                $disk = $attachment->disk;

                if (!Storage::disk($disk)->exists($attachment->path)) {
                    continue;
                }

                /*
            |--------------------------------------------------------------------------
            | Generate NEW FILE PATH
            |--------------------------------------------------------------------------
            */

                $extension = $attachment->extension;
                $newStoredName = Str::uuid() . '.' . $extension;

                $newPath = "gensen/{$newForm->id}/{$attachment->type->value}/{$newStoredName}";

                /*
                |--------------------------------------------------------------------------
                | Copy File (Driver Safe)
                |--------------------------------------------------------------------------
                */

                $sourceDisk = Storage::disk($disk);

                // stream prevents memory explosion + works for S3/Supabase/local
                $stream = $sourceDisk->readStream($attachment->path);

                if ($stream === false) {
                    continue;
                }

                Storage::disk($disk)->writeStream($newPath, $stream);

                if (is_resource($stream)) {
                    fclose($stream);
                }


                /*
            |--------------------------------------------------------------------------
            | Create New Attachment Row
            |--------------------------------------------------------------------------
            */

                GensenFormAttachmentRepository::create([
                    'gensen_form_id' => $newForm->id,
                    'type' => $attachment->type,
                    'original_name' => $attachment->original_name,
                    'stored_name' => $newStoredName,
                    'description' => $attachment->description,

                    'disk' => $disk,
                    'path' => $newPath,
                    'note' => $attachment->note,
                    'remittance_type' => $attachment->remittance_type,

                    'extension' => $attachment->extension,
                    'mime_type' => $attachment->mime_type,
                    'file_size' => $attachment->file_size,

                    'checksum' => $attachment->checksum,
                    'status' => $attachment->status,
                    'convert_image' => $attachment->convert_image,
                ]);
            }

            DB::commit();

            return $newForm;
        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public static function datatable(
        $gensenFormLinkId,
        $status,
        $pic,
        $tanggal_input = null,
        $tanggal_kepulangan = null,
    ) {

        $pic_code = $pic ? $pic : Auth::user()->pic_code;

        // return GensenForm::when($gensenFormLinkId, function ($q) use ($gensenFormLinkId) {
        //     $q->where('remarks_id', $gensenFormLinkId)
        //         ->where('remarks_type', GensenFormLink::class);
        // })
        $remittanceAgg = DB::table('remittance_extraction_groups as reg')
            ->join('remittance_extractions as re', function ($join) {
                $join->on('re.id', '=', 'reg.remittance_extraction_id')
                    ->where('re.subject_type', '=', GensenForm::class)
                    ->whereNull('re.deleted_at');
            })
            ->where('reg.is_validate', '=', true)
            ->whereNull('reg.deleted_at')
            ->selectRaw("
                re.subject_id,
                re.subject_type,

                STRING_AGG(
                    REPLACE(
                        TO_CHAR(reg.total_amount, 'FM999,999,999,999'),
                        ',',
                        '.'
                    ),
                    ';'
                    ORDER BY reg.transaction_year
                ) AS remittance_total_amounts,

                STRING_AGG(
                     COALESCE(reg.receiver_name, '') 
                     || ' - ' || 
                      COALESCE(reg.receiver_relationship, ''),
                    ';'
                    ORDER BY reg.transaction_year
                ) AS remittance_receiver_names,

                STRING_AGG(
                    reg.transaction_year::text,
                    ';'
                    ORDER BY reg.transaction_year
                ) AS remittance_receiver_years
            ")
            ->groupBy('re.subject_id', 're.subject_type');
        $gensenDetailAgg = DB::table('gensen_form_details as gfd')
            ->whereNull('gfd.deleted_at')
            ->selectRaw("
        gfd.gensen_form_id,

        STRING_AGG(
            gfd.tahun_gensen::text,
            ';'
            ORDER BY gfd.tahun_gensen
        ) AS tahun_gensen_details,

        STRING_AGG(
                COALESCE(gfd.tanggal_tarik_data, '') 
                || ' - ' || 
                COALESCE(gfd.label, ''),
            ';'
            ORDER BY gfd.tahun_gensen
        ) AS tarik_data_details,
            
        STRING_AGG(
            COALESCE(REPLACE(
                TO_CHAR(gfd.nominal_gensen, 'FM999,999,999,999'),
                ',',
                '.'
            ), ''),
            ';'
            ORDER BY gfd.tahun_gensen
        ) AS nominal_gensen_details
    ")
            ->groupBy('gfd.gensen_form_id');
        $gensenDetailCairAgg = DB::table('gensen_form_details as gfd')
            ->whereNull('gfd.deleted_at')
            ->whereNotNull('gfd.tanggal_cair')
            ->whereNotNull('nominal_cair')
            ->where('nominal_cair', '!=', 0)
            ->selectRaw("
        gfd.gensen_form_id,

        STRING_AGG(
            REPLACE(
                TO_CHAR(gfd.nominal_cair, 'FM999,999,999,999'),
                ',',
                '.'
            ),
            '<br>;'
            ORDER BY gfd.tahun_gensen
        ) AS nominal_cair_details,
        STRING_AGG(
            gfd.tahun_gensen::text || '-' || gfd.tanggal_cair::text,
            '<br>;'
            ORDER BY gfd.tahun_gensen
        ) AS tanggal_cair_details
    ")
            ->groupBy('gfd.gensen_form_id');
        return
            // dd(
            GensenForm::query()
            ->when($gensenFormLinkId, function ($q) use ($gensenFormLinkId) {
                $q->where('remarks_id', $gensenFormLinkId)
                    ->where('remarks_type', GensenFormLink::class);
            })
            ->leftJoinSub($remittanceAgg, 'remittances', function ($join) {
                $join->on('remittances.subject_id', '=', 'gensen_forms.id')
                    ->where('remittances.subject_type', '=', GensenForm::class);
            })
            ->leftJoinSub($gensenDetailAgg, 'gfd', function ($join) {
                $join->on('gfd.gensen_form_id', '=', 'gensen_forms.id');
            })
            ->leftJoinSub($gensenDetailCairAgg, 'gfd_cair', function ($join) {
                $join->on('gfd_cair.gensen_form_id', '=', 'gensen_forms.id');
            })
            ->select([
                'gensen_forms.*',
                'gfd.tahun_gensen_details',
                'gfd.nominal_gensen_details',
                'gfd_cair.tanggal_cair_details as tanggal_cair_details',
                'gfd_cair.nominal_cair_details as nominal_cair_details',
                'remittances.remittance_total_amounts',
                'remittances.remittance_receiver_names',
                'remittances.remittance_receiver_years',
            ])
            ->withExists([
                'attachments as has_kartu_keluarga' => function ($q) {
                    $q->where('type', GensenAttachmentType::KARTU_KELUARGA);
                },
                'attachments as has_my_number' => function ($q) {
                    $q->where('type', GensenAttachmentType::MY_NUMBER_FRONT);
                },
            ])
            ->when($pic_code, function ($q) use ($pic_code) {
                $q->where('pic_code', $pic_code);
            })
            ->when($tanggal_input, function ($query) use ($tanggal_input) {
                $query->whereBetween('created_at', $tanggal_input);
            })
            ->when($tanggal_kepulangan, function ($query) use ($tanggal_kepulangan) {
                $query->whereBetween('tanggal_kepulangan', $tanggal_kepulangan);
            })
            ->when($status && !in_array($status, [GensenForm::STATUS_SIAP_VERIFIKASI, GensenForm::STATUS_NO_INPUT_JEPANG]), function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($status == GensenForm::STATUS_SIAP_VERIFIKASI, function ($q) use ($status) {
                $q->whereNotNull('tanggal_lengkap')
                    ->whereNull('tanggal_verified');
            })
            ->when(
                $status == GensenForm::STATUS_NO_INPUT_JEPANG,
                function ($q) use ($status) {
                    $q->whereNotNull('tanggal_lengkap')
                        ->whereNotNull('tanggal_verified')
                        ->whereNotNull('no_input_jepang');
                }
                // ->get()
            );
    }
    public static function export(
        $status,
        $pic_code = null,
        $tanggal_input = null,
        $tanggal_kepulangan = null,
    ) {
        return GensenForm::withExists([
            'attachments as has_kartu_keluarga' => function ($q) {
                $q->where('type', GensenAttachmentType::KARTU_KELUARGA);
            },
            'attachments as has_my_number' => function ($q) {
                $q->where('type', GensenAttachmentType::MY_NUMBER_FRONT);
            },
        ])
            ->when($pic_code, function ($q) use ($pic_code) {
                $q->where('pic_code', $pic_code);
            })
            ->when($tanggal_input, function ($query) use ($tanggal_input) {
                $query->whereBetween('created_at', $tanggal_input);
            })
            ->when($tanggal_kepulangan, function ($query) use ($tanggal_kepulangan) {
                $query->whereBetween('tanggal_kepulangan', $tanggal_kepulangan);
            })
            ->when($status && !in_array($status, [GensenForm::STATUS_SIAP_VERIFIKASI, GensenForm::STATUS_NO_INPUT_JEPANG]), function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($status == GensenForm::STATUS_SIAP_VERIFIKASI, function ($q) use ($status) {
                $q->whereNotNull('tanggal_lengkap')
                    ->whereNull('tanggal_verified');
            });
    }
}
