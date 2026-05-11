<?php

namespace App\Repositories\GensenForm;

use App\Enums\Gensen\GensenAttachmentType;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormLink;
use App\Repositories\MasterDataRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GensenFormRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return GensenForm::class;
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
                    ->where('re.subject_type', '=', GensenForm::class);
            })
            ->where('reg.is_validate', '=', true)
            ->selectRaw("
                re.subject_id,
                re.subject_type,
                STRING_AGG(
                    reg.total_amount || '-' || reg.receiver_name,
                    '; '
                    ORDER BY reg.transaction_year
                ) AS remittance
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
                'remittances.remittance',
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
