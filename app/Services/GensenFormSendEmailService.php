<?php

namespace App\Services;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\GensenAttachmentType;
use App\Models\GensenForm\GensenForm;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class GensenFormSendEmailService
{
    public function handle($status)
    {
        return match ($status) {
            GensenForm::STATUS_LENGKAP => $this->templateStatusLengkap($filters),
            GensenForm::STATUS_VERIFIED => $this->exportListDataBelumLengkap($filters),
            GensenForm::STATUS_DALAM_PENGAJUAN => $this->exportListDataBelumLengkap($filters),
            GensenForm::STATUS_CANCEL => $this->exportListDataBelumLengkap($filters),
            GensenForm::STATUS_GENSEN_CAIR => $this->exportListDataBelumLengkap($filters),
            GensenForm::STATUS_HONNIN => $this->exportListDataBelumLengkap($filters),
            default => throw new \Exception("Role tidak dikenali"),
        };
    }

    private function query($filters)
    {
        $remittanceAgg = DB::table('remittance_extraction_groups as reg')
            ->join('remittance_extractions as re', function ($join) {
                $join->on('re.id', '=', 'reg.remittance_extraction_id')
                    ->whereNull('re.deleted_at');
            })
            ->where('reg.is_validate', true)
            ->whereNull('reg.deleted_at')
            ->selectRaw("
        re.subject_id,
        re.subject_type,
        reg.transaction_year,

        STRING_AGG(
            reg.total_amount::text,
            '; '
            ORDER BY reg.transaction_year
        ) AS remittance_total_amounts,

        STRING_AGG(
            reg.receiver_name || '-' || reg.receiver_relationship,
            '; '
            ORDER BY reg.transaction_year
        ) AS remittance_receiver_names
    ")
            ->groupBy(
                're.subject_id',
                're.subject_type',
                'reg.transaction_year'
            );

        // return GensenForm::query()
        //     ->leftJoinSub($remittanceAgg, 'remittances', function ($join) {
        //         $join->on('remittances.subject_id', '=', 'gensen_forms.id')
        //             ->where('remittances.subject_type', '=', GensenForm::class);
        //     })
        //     ->select([
        //         'gensen_forms.*',
        //         'remittances.remittance_total_amounts',
        //         'remittances.remittance_receiver_names',
        //     ])
        return GensenForm::query()
            ->join('gensen_form_details as gfd', function ($join) {
                $join->on('gfd.gensen_form_id', '=', 'gensen_forms.id')
                    ->whereNull('gfd.deleted_at');
            })

            ->leftJoinSub($remittanceAgg, 'remittances', function ($join) {
                $join->on('remittances.subject_id', '=', 'gensen_forms.id')
                    ->where('remittances.subject_type', '=', GensenForm::class)
                    ->on('remittances.transaction_year', '=', 'gfd.tahun_gensen');
            })

            ->select([
                'gensen_forms.*',
                'gfd.tahun_gensen as tahun_gensen_detail',
                'gfd.nominal_gensen as nominal_gensen_detail',
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
            ->when(isset($filters['pic_code']) && $filters['pic_code'], function ($q) use ($filters) {
                $q->where('gensen_forms.pic_code', $filters['pic_code']);
            })
            ->when(isset($filters['tanggal_input']) && $filters['tanggal_input'], function ($query) use ($filters) {
                $query->whereBetween('gensen_forms.created_at', $filters['tanggal_input']);
            });
    }
    private function templateStatusLengkap() {}
}
