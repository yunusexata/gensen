<?php

namespace App\Services;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\GensenAttachmentType;
use App\Imports\ExcelImportBulkStatusGensen;
use App\Models\GensenForm\GensenForm;
use App\Models\User;
use App\Repositories\GensenForm\GensenFormDetailRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ImportService
{
    public function handle($job_key, ExcelImportBulkStatusGensen $import)
    {
        return match ($job_key) {
            ExportImportJobKey::IMPORT_LIST_DATA_LENGKAP => $this->importListDataLengkap($import),
            ExportImportJobKey::IMPORT_LIST_DATA_VERIFIED => $this->importListDataVerified($import),
            ExportImportJobKey::IMPORT_LIST_DATA_NO_INPUT_JAPAN => $this->importListDataNoInputJapan($import),
            ExportImportJobKey::IMPORT_LIST_DATA_DALAM_PENGAJUAN => $this->importListDataDalamPengajuan($import),
            ExportImportJobKey::IMPORT_LIST_DATA_GENSEN_CAIR => $this->importListDataDalamGensenCair($import),
            default => throw new \Exception("Role tidak dikenali"),
        };
    }

    // Validation Section
    private function validateListDataLengkap(array $row)
    {
        return Validator::make($row, [
            'id_customer' => 'required|exists:gensen_forms,id_customer',
            'nama_lengkap' => [
                'required',

                Rule::exists('gensen_forms')
                    ->where(function ($query) use ($row) {

                        $query
                            ->where(
                                'id_customer',
                                $row['id_customer']
                            )
                            ->where('nama_lengkap', 'ILIKE', trim($row['nama_lengkap']));
                    }),
            ],
            'tanggal_lengkap' => 'required',
        ], [
            'id_customer.required' => 'Id customer harus di isi',
            'id_customer.exists' => 'Id customer tidak terdaftar',
            'nama_lengkap.required' => 'Nama lengkap harus di isi',
            'nama_lengkap.exists' => 'Nama lengkap tidak terdaftar',
            'tanggal_lengkap.required' => 'Tanggal lengkap harus di isi',
        ]);
    }
    private function validateListDataVerified(array $row)
    {
        return Validator::make($row, [
            'id_customer' => 'required|exists:gensen_forms,id_customer',
            'nama_lengkap' => [
                'required',

                Rule::exists('gensen_forms')
                    ->where(function ($query) use ($row) {

                        $query
                            ->where(
                                'id_customer',
                                $row['id_customer']
                            )
                            ->where('nama_lengkap', 'ILIKE', trim($row['nama_lengkap']));
                    }),
            ],
            'tanggal_lengkap' => 'required',
            'tanggal_verified' => 'required',
        ], [
            'id_customer.required' => 'Id customer harus di isi',
            'id_customer.exists' => 'Id customer tidak terdaftar',
            'nama_lengkap.required' => 'Nama lengkap harus di isi',
            'nama_lengkap.exists' => 'Nama lengkap tidak terdaftar',
            'tanggal_lengkap.required' => 'Tanggal lengkap harus di isi',
            'tanggal_verified.required' => 'Tanggal verified harus di isi',
        ]);
    }
    private function validateListDataNoInputJapan(array $row)
    {
        return Validator::make($row, [
            'id_customer' => 'required|exists:gensen_forms,id_customer',
            'nama_lengkap' => [
                'required',

                Rule::exists('gensen_forms')
                    ->where(function ($query) use ($row) {

                        $query
                            ->where(
                                'id_customer',
                                $row['id_customer']
                            )
                            ->where('nama_lengkap', 'ILIKE', trim($row['nama_lengkap']));
                    }),
            ],
            'tanggal_lengkap' => 'required',
            'tanggal_verified' => 'required',
            'no_input_jepang' => 'required',
        ], [
            'id_customer.required' => 'Id customer harus di isi',
            'id_customer.exists' => 'Id customer tidak terdaftar',

            'nama_lengkap.required' => 'Nama lengkap harus di isi',
            'nama_lengkap.exists' => 'Nama lengkap tidak terdaftar',

            'tanggal_lengkap.required' => 'Tanggal lengkap harus di isi',

            'tanggal_verified.required' => 'Tanggal verified harus di isi',

            'no_input_jepang.required' => 'No input Jepang harus di isi',
        ]);
    }
    private function validateListDataDalamPengajuan(array $row)
    {
        return Validator::make($row, [
            'id_customer' => 'required|exists:gensen_forms,id_customer',
            'nama_lengkap' => [
                'required',

                Rule::exists('gensen_forms')
                    ->where(function ($query) use ($row) {

                        $query
                            ->where(
                                'id_customer',
                                $row['id_customer']
                            )
                            ->where('nama_lengkap', 'ILIKE', trim($row['nama_lengkap']));
                    }),
            ],
            'no_input_jepang' => 'required|exists:gensen_forms,no_input_jepang',
            'tanggal_pengajuan' => 'required',
        ], [
            'id_customer.required' => 'Id customer harus di isi',
            'id_customer.exists' => 'Id customer tidak terdaftar',
            'nama_lengkap.required' => 'Nama lengkap harus di isi',
            'nama_lengkap.exists' => 'Nama lengkap tidak terdaftar',
            'no_input_jepang.required' => 'No Input Jepang harus di isi',
            'no_input_jepang.exists' => 'No Input Jepang tidak terdaftar',
            'tanggal_pengajuan.required' => 'Tanggal Pengajuan harus di isi',
        ]);
    }
    private function validateListDataGensenCair(array $row)
    {
        return Validator::make($row, [
            // 'id_customer' => 'required|exists:gensen_forms,id_customer',
            'no_input_jepang' => 'required|exists:gensen_forms,no_input_jepang',
            'nama_lengkap' => [
                'required',

                Rule::exists('gensen_forms')
                    ->where(function ($query) use ($row) {

                        $query
                            ->where(
                                'id_customer',
                                $row['id_customer']
                            )
                            ->where('nama_lengkap', 'ILIKE', trim($row['nama_lengkap']));
                    }),
            ],
            'tanggal_pengajuan' => 'required',
            'tahun_gensen' => 'required',
            'tanggal_cair' => 'required',
            'nominal_cair' => 'required',
        ], [
            // 'id_customer.required' => 'Id customer harus di isi',
            // 'id_customer.exists' => 'Id customer tidak terdaftar',
            'no_input_jepang.required' => 'No Input Jepang harus di isi',
            'no_input_jepang.exists' => 'No Input Jepang tidak terdaftar',
            'nama_lengkap.required' => 'Nama Lengkap harus di isi',
            'nama_lengkap.exists' => 'Nama Lengkap tidak terdaftar',
            'tanggal_pengajuan.required' => 'Tanggal Pengajuan harus di isi',
            'tahun_gensen.required' => 'Tahun Gensen harus di isi',
            'tanggal_cair.required' => 'Tanggal Cair harus di isi',
            'nominal_cair.required' => 'Nominal Cair harus di isi',
        ]);
    }


    // Save Import Section
    private function importListDataLengkap($import): array
    {
        $successCount = 0;
        $errorRows = [];

        foreach ($import->rows as $index => $row) {
            $validator = $this->validateListDataLengkap($row->toArray());

            if ($validator->fails()) {

                $errorRows[] = [
                    'row' => $index + 1,
                    'errors' => $validator->errors()->toArray(),
                ];

                continue;
            }
            $validatedData = [];

            $validatedData = [
                'tanggal_lengkap' => $row['tanggal_lengkap'],
            ];

            $updated = GensenFormRepository::updateBy([
                ['id_customer', $row['id_customer']],
                // ['nama_lengkap', $row['nama_lengkap']],
                // ['tanggal_lengkap', '!=', null],
            ], $validatedData);

            if ($updated > 0) {
                $successCount++;
            }
        }
        return [
            'success_count' => $successCount,
            'errors' => $errorRows
        ];
    }
    private function importListDataVerified($import): array
    {
        $successCount = 0;
        $errorRows = [];

        foreach ($import->rows as $index => $row) {
            $validator = $this->validateListDataVerified($row->toArray());

            if ($validator->fails()) {

                $errorRows[] = [
                    'row' => $index + 1,
                    'errors' => $validator->errors()->toArray(),
                ];

                continue;
            }
            $validatedData = [];

            $validatedData = [
                'tanggal_verified' => $row['tanggal_verified'],
            ];

            $updated = GensenFormRepository::updateBy([
                ['id_customer', $row['id_customer']],
                // ['nama_lengkap', $row['nama_lengkap']],
                // ['tanggal_lengkap', '!=', null],
            ], $validatedData);

            if ($updated > 0) {
                $successCount++;
            }
        }
        return [
            'success_count' => $successCount,
            'errors' => $errorRows
        ];
    }
    private function importListDataNoInputJapan($import): array
    {
        $successCount = 0;
        $errorRows = [];

        foreach ($import->rows as $index => $row) {
            $validator = $this->validateListDataNoInputJapan($row->toArray());

            if ($validator->fails()) {

                $errorRows[] = [
                    'row' => $index + 1,
                    'errors' => $validator->errors()->toArray(),
                ];

                continue;
            }
            $validatedData = [];

            $status = Str::lower(
                trim($row['no_input_jepang'])
            );

            if ($status === 'cancel') {

                $validatedData = [
                    'status' => GensenForm::STATUS_CANCEL,
                    'keterangan' => $row['keterangan'],
                ];
            } elseif ($status === 'honnin') {

                $validatedData = [
                    'status' => GensenForm::STATUS_HONNIN,
                    'keterangan' => $row['keterangan'],
                ];
            } elseif ($status === 'mondai') {

                $validatedData = [
                    'status' => GensenForm::STATUS_MONDAI,
                    'keterangan' => $row['keterangan'],
                ];
            } else {

                $validatedData = [
                    'no_input_jepang' => $row['no_input_jepang'],
                ];
            }

            $updated = GensenFormRepository::updateBy([
                ['id_customer', $row['id_customer']],
                // ['nama_lengkap', $row['nama_lengkap']],
                // ['tanggal_lengkap', '!=', null],
                // ['tanggal_verified', '!=', null],
            ], $validatedData);

            if ($updated > 0) {
                $successCount++;
            }
        }
        return [
            'success_count' => $successCount,
            'errors' => $errorRows
        ];
    }
    private function importListDataDalamPengajuan($import): array
    {
        $successCount = 0;
        $errorRows = [];

        foreach ($import->rows as $index => $row) {
            $validator = $this->validateListDataDalamPengajuan($row->toArray());

            if ($validator->fails()) {

                $errorRows[] = [
                    'row' => $index + 1,
                    'errors' => $validator->errors()->toArray(),
                ];

                continue;
            }
            $validatedData = [];

            $validatedData = [
                'tanggal_pengajuan' => $row['tanggal_pengajuan'],
            ];

            $updated = GensenFormRepository::updateBy([
                ['id_customer', $row['id_customer']],
                // ['nama_lengkap', $row['nama_lengkap']],
                // ['tanggal_lengkap', '!=', null],
            ], $validatedData);

            if ($updated > 0) {
                $successCount++;
            }
        }
        return [
            'success_count' => $successCount,
            'errors' => $errorRows
        ];
    }
    private function importListDataDalamGensenCair($import): array
    {
        $successCount = 0;
        $errorRows = [];

        foreach ($import->rows as $index => $row) {
            $validator = $this->validateListDataGensenCair($row->toArray());

            if ($validator->fails()) {

                $errorRows[] = [
                    'row' => $index + 1,
                    'errors' => $validator->errors()->toArray(),
                ];

                continue;
            }
            $validatedData = [];

            $gensenForm = GensenFormRepository::findBy([
                ['no_input_jepang', $row['no_input_jepang']],
                // ['nama_lengkap', $row['nama_lengkap']],
            ]);
            preg_match('/^\d+/', trim($row['tahun_gensen']), $tahun_reiwa);
            $validatedData = [
                'tanggal_cair' => $row['tanggal_cair'],
                'nominal_cair' => $row['nominal_cair'],
            ];

            $updated = GensenFormDetailRepository::updateBy([
                // ['id_customer', $row['id_customer']],
                ['gensen_form_id', $gensenForm->id],
                ['tahun_gensen', $tahun_reiwa[0]],
            ], $validatedData);

            $gensenForm->onSubmitted();

            if ($updated > 0) {
                $successCount++;
            }
        }

        return [
            'success_count' => $successCount,
            'errors' => $errorRows
        ];
    }
}
