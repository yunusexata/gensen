<?php

namespace App\Livewire\GensenForm\GensenData;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Imports\ExcelImportBulkStatusGensen;
use App\Repositories\Gensen\GensenExportImportHistoryRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class BulkUpdateGensenStatusModalToDalamPengajuan extends Component
{
    use WithFileUploads;

    public $inputFileBulkStatus;

    // Import Pipeline
    public $previewBulkStatusRows;
    public $errorBulkStatusRows = [];


    public function mount() {}
    // IMPORT PIPELINE
    public function updatedInputFileBulkStatus()
    {
        $import = new ExcelImportBulkStatusGensen();
        Excel::import($import, $this->inputFileBulkStatus);

        $this->previewBulkStatusRows = [];
        $this->errorBulkStatusRows = [];


        $d = [];
        foreach ($import->rows as $index => $row) {
            $d = [
                'id_customer' => $row['id_customer'],
                'nama_lengkap' => $row['nama_lengkap'],
                'no_input_jepang' => $row['no_input_jepang'],
                'tanggal_pengajuan' => $row['tanggal_pengajuan'],
            ];
            $validator = Validator::make($d, [
                'id_customer' => 'required|exists:gensen_forms,id_customer',
                'nama_lengkap' => 'required|exists:gensen_forms,nama_lengkap',
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

            $this->previewBulkStatusRows[] = [
                'data' => $d,
                'error' => $validator->errors()->toArray()
            ];

            if ($validator->fails()) {
                $this->errorBulkStatusRows[] = $index;
            }
        }
    }

    public function closeImportBulkStatusModal()
    {
        $this->reset('inputFileBulkStatus');
        $this->previewBulkStatusRows = [];
        $this->errorBulkStatusRows = [];
    }

    public function storeImportBulkStatus()
    {
        try {
            DB::beginTransaction();
            $disk = 'supabase';

            $extension = $this->inputFileBulkStatus
                ->extension();

            $fileName = ExportImportJobKey::IMPORT_LIST_DATA_DALAM_PENGAJUAN->value . '-' . now()->format('Ymd') . '.' . $extension;

            consoleLog($this, ['filename dalam pengajuan', $fileName]);

            // $filePath = $this->inputFileBulkStatus
            //     ->storeAs(
            //         'imports/gensen',
            //         $fileName,
            //         $disk
            //     );
            $filePath = Storage::disk('supabase')->putFileAs(
                'imports/gensen',
                $this->inputFileBulkStatus,
                $fileName,
                [
                    'visibility' => 'private',
                ]
            );

            $history = GensenExportImportHistoryRepository::create([
                'role' => Auth::user()->roles->pluck('name')->first(),
                'created_by' => auth()->id(),
                'job_key' => ExportImportJobKey::IMPORT_LIST_DATA_DALAM_PENGAJUAN->value,
                'type' => 'import',
                'filters' => json_encode([], true),
                'status' => JobStatus::PROCESSING,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'disk' => $disk,
                'start_at' => now(),
            ]);
            $path = $this->inputFileBulkStatus->getRealPath();
            unlink($path);

            $this->dispatch('datatable-refresh');
            $this->dispatch('onSuccessImportBulkStatusDataToDalamPengajuan');
            $this->dispatch('refresh-table');
            $this->closebulkUpdateGensenStatusModalToDalamPengajuan();

            Alert::information($this, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    public function closebulkUpdateGensenStatusModalToDalamPengajuan()
    {
        $this->reset('inputFileBulkStatus');
        $this->previewBulkStatusRows = [];
        $this->errorBulkStatusRows = [];
    }

    public function render()
    {
        return view('livewire.gensen-form.gensen-data.bulk-update-gensen-status-modal-to-dalam-pengajuan');
    }
}
