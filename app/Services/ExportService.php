<?php

namespace App\Services;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\GensenAttachmentType;
use App\Models\GensenForm\GensenForm;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class ExportService
{
    public function handle($job_key, array $filters)
    {
        return match ($job_key) {
            ExportImportJobKey::EXPORT_LIST_DATA_BELUM_LENGKAP => $this->exportListDataBelumLengkap($filters),
            ExportImportJobKey::EXPORT_LIST_DATA_SIAP_VERIFIKASI => $this->exportListDataSiapVerifikasi($filters),
            ExportImportJobKey::EXPORT_LIST_DATA_VERIFIED => $this->exportListDataVerified($filters),
            ExportImportJobKey::EXPORT_LIST_DATA_NO_INPUT_JAPAN => $this->exportListDataNoInputJapan($filters),
            ExportImportJobKey::EXPORT_LIST_DATA_DALAM_PENGAJUAN => $this->exportListDataDalamPengajuan($filters),
            default => throw new \Exception("Role tidak dikenali"),
        };
    }

    private function query($filters)
    {
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

        return GensenForm::query()
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
            ->when(isset($filters['pic_code']) && $filters['pic_code'], function ($q) use ($filters) {
                $q->where('pic_code', $filters['pic_code']);
            })
            ->when(isset($filters['tanggal_input']) && $filters['tanggal_input'], function ($query) use ($filters) {
                $query->whereBetween('created_at', $filters['tanggal_input']);
            });
    }

    private function exportListDataBelumLengkap($filters)
    {
        return $this->query($filters)
            ->where('status', GensenForm::STATUS_BELUM_LENGKAP)
            ->whereNull('tanggal_lengkap')
            ->get();
    }

    private function exportListDataSiapVerifikasi($filters)
    {
        return $this->query($filters)
            ->where('status', GensenForm::STATUS_LENGKAP)
            ->whereNotNull('tanggal_lengkap')
            ->whereNull('tanggal_verified')
            ->get();
    }

    private function exportListDataVerified($filters)
    {
        return $this->query($filters)
            ->where('status', GensenForm::STATUS_VERIFIED)
            ->whereNotNull('tanggal_lengkap')
            ->whereNotNull('tanggal_verified')
            ->whereNull('no_input_jepang')
            ->get();
    }

    private function exportListDataNoInputJapan($filters)
    {
        return   $this->query($filters)
            ->where('status', GensenForm::STATUS_VERIFIED)
            ->whereNotNull('tanggal_lengkap')
            ->whereNotNull('tanggal_verified')
            ->whereNotNull('no_input_jepang')
            ->whereNull('tanggal_pengajuan')
            ->get();
    }

    private function exportListDataDalamPengajuan($filters)
    {
        return $this->query($filters)
            ->where('status', GensenForm::STATUS_DALAM_PENGAJUAN)
            ->whereNotNull('tanggal_lengkap')
            ->whereNotNull('tanggal_verified')
            ->whereNotNull('no_input_jepang')
            ->whereNotNull('tanggal_pengajuan')
            ->whereNull('tanggal_cair')
            ->whereNull('nominal_cair')
            ->get();
    }
}
