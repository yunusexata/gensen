<?php

namespace App\Repositories\GensenForm;

use App\Enums\Gensen\GensenAttachmentType;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormLink;
use App\Repositories\MasterDataRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class GensenFormRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenForm::class;
    }

    public static function copy($gensen_form_id)
    {

        try {
            DB::transaction(function () use ($gensen_form_id) {
                $gensen_form = self::find($gensen_form_id);
                // Form Candidate
                $validateData = [
                    // Form J-Expert
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

                    // REK PENERIMA
                    'no_rekening_penerima' => $gensen_form->no_rekening_penerima,
                    'nama_bank_penerima' => $gensen_form->nama_bank_penerima,
                    'nama_penerima' => $gensen_form->nama_penerima,
                    'hubungan_penerima' => $gensen_form->hubungan_penerima,

                    'tahun_gensen' => $gensen_form->tahun_gensen,
                    'tahun_transfer' => $gensen_form->tahun_transfer,

                    'remarks_id' => $gensen_form->remarks_id,
                    'remarks_type' => $gensen_form->remarks_type,
                    'pic_code' => $gensen_form->pic_code,

                ];
                $gensenForm = GensenFormRepository::create($validateData);
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
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
                    reg.total_amount::text,
                    '; '
                    ORDER BY reg.transaction_year
                ) AS remittance_total_amounts,

                STRING_AGG(
                    reg.receiver_name,
                    '; '
                    ORDER BY reg.transaction_year
                ) AS remittance_receiver_names
            ")
            ->groupBy('re.subject_id', 're.subject_type');
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
            ->select([
                'gensen_forms.*',
                'remittances.remittance_total_amounts',
                'remittances.remittance_receiver_names',
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
