<?php

namespace App\Services;

use App\Enums\Gensen\GensenAttachmentType;
use App\Models\GensenForm\GensenForm;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class ExportService
{
    public function handle(string $role, array $filters)
    {
        return match ($role) {
            User::ROLE_HS => $this->exportHS1($filters),
            User::ROLE_HS2 => $this->exportHS2($filters),
            User::ROLE_ADMIN_JAPAN => $this->exportAdminJapan($filters),
            User::ROLE_ACC_EXATA => $this->exportAccExata($filters),
            default => throw new \Exception("Role tidak dikenali"),
        };
    }

    private function exportHS1($filters)
    {
        return GensenForm::withExists([
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
            })
            ->when(isset($filters['tanggal_kepulangan']) && $filters['tanggal_kepulangan'], function ($query) use ($filters) {
                $query->whereBetween('tanggal_kepulangan', $filters['tanggal_kepulangan']);
            })
            ->when(isset($filters['status']) && $filters['status'] && $filters['status'] != GensenForm::STATUS_SIAP_VERIFIKASI, function ($q) use ($filters) {
                $q->where('status', $filters['status']);
            })
            ->when(isset($filters['status']) && $filters['status'] && $filters['status'] == GensenForm::STATUS_SIAP_VERIFIKASI, function ($q) {
                $q->whereNotNull('tanggal_lengkap')
                    ->whereNull('tanggal_verified');
            })
            ->get();
    }

    private function exportHS2($filters)
    {
        return GensenForm::withExists([
            'attachments as has_kartu_keluarga' => function ($q) {
                $q->where('type', GensenAttachmentType::KARTU_KELUARGA);
            },
            'attachments as has_my_number' => function ($q) {
                $q->where('type', GensenAttachmentType::MY_NUMBER_FRONT);
            },
        ])
            ->when(isset($filters['pic_code']) && !is_null($filters['pic_code']), function ($q) use ($filters) {
                $q->where('pic_code', $filters['pic_code']);
            })
            ->when(isset($filters['tanggal_input']) && $filters['tanggal_input'], function ($query) use ($filters) {
                $query->whereBetween('created_at', $filters['tanggal_input']);
            })
            ->when(isset($filters['tanggal_kepulangan']) && $filters['tanggal_kepulangan'], function ($query) use ($filters) {
                $query->whereBetween('tanggal_kepulangan', $filters['tanggal_kepulangan']);
            })
            ->when(isset($filters['status']) && $filters['status'] && $filters['status'] != GensenForm::STATUS_SIAP_VERIFIKASI, function ($q) use ($filters) {
                $q->where('status', $filters['status']);
            })
            ->when(isset($filters['status']) && $filters['status'] && $filters['status'] == GensenForm::STATUS_SIAP_VERIFIKASI, function ($q) {
                $q->whereNotNull('tanggal_lengkap')
                    ->whereNull('tanggal_verified');
            })
            ->get();
    }

    private function exportAdminJapan($filters)
    {
        return GensenForm::withExists([
            'attachments as has_kartu_keluarga' => function ($q) {
                $q->where('type', GensenAttachmentType::KARTU_KELUARGA);
            },
            'attachments as has_my_number' => function ($q) {
                $q->where('type', GensenAttachmentType::MY_NUMBER_FRONT);
            },
        ])
            ->when(isset($filters['pic_code']) && !is_null($filters['pic_code']), function ($q) use ($filters) {
                $q->where('pic_code', $filters['pic_code']);
            })
            ->when(isset($filters['tanggal_input']) && $filters['tanggal_input'], function ($query) use ($filters) {
                $query->whereBetween('created_at', $filters['tanggal_input']);
            })
            ->when(isset($filters['tanggal_kepulangan']) && $filters['tanggal_kepulangan'], function ($query) use ($filters) {
                $query->whereBetween('tanggal_kepulangan', $filters['tanggal_kepulangan']);
            })
            ->whereNotNull('tanggal_lengkap')
            ->whereNotNull('tanggal_verified')
            ->whereNull('no_input_jepang')
            ->get();
    }

    private function exportAccExata($filters)
    {
        return GensenForm::withExists([
            'attachments as has_kartu_keluarga' => function ($q) {
                $q->where('type', GensenAttachmentType::KARTU_KELUARGA);
            },
            'attachments as has_my_number' => function ($q) {
                $q->where('type', GensenAttachmentType::MY_NUMBER_FRONT);
            },
        ])
            ->when(isset($filters['pic_code']) && !is_null($filters['pic_code']), function ($q) use ($filters) {
                $q->where('pic_code', $filters['pic_code']);
            })
            ->when(isset($filters['tanggal_input']) && $filters['tanggal_input'], function ($query) use ($filters) {
                $query->whereBetween('created_at', $filters['tanggal_input']);
            })
            ->when(isset($filters['tanggal_kepulangan']) && $filters['tanggal_kepulangan'], function ($query) use ($filters) {
                $query->whereBetween('tanggal_kepulangan', $filters['tanggal_kepulangan']);
            })
            ->whereNotNull('tanggal_lengkap')
            ->whereNotNull('tanggal_verified')
            ->whereNotNull('no_input_jepang')
            ->whereNull('tanggal_cair')
            ->get();
    }
}
