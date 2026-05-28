<?php

namespace App\Livewire\Gensen\ExportImport;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Imports\ExcelImportBulkStatusGensen;
use App\Imports\ExcelImportTarikData;
use App\Repositories\Gensen\GensenExportImportHistoryRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ExportDalamPengajuanModal extends Component
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
        $import = new ExcelImportTarikData();
        Excel::import($import, $this->inputFileBulkStatus);

        $this->previewBulkStatusRows = [];
        $this->errorBulkStatusRows = [];

        $d = [];
        foreach ($import->rows as $index => $row) {
            $d = $row;
            $validator = Validator::make($d, [
                'no_input_jepang' => 'required|exists:gensen_forms,no_input_jepang',
                'nama_lengkap' => 'required|exists:gensen_forms,nama_lengkap',
                // 'tanggal_lengkap' => 'required',
                // 'tanggal_verified' => 'required',
                // 'no_input_jepang' => 'required',
                'tanggal_tarik_data' => 'required',
                'label' => 'required',
            ], [
                'no_input_jepang.required' => 'No Input Jepang harus di isi',
                'no_input_jepang.exists' => 'No Input Jepang tidak terdaftar',
                'nama_lengkap.required' => 'Nama lengkap harus di isi',
                'nama_lengkap.exists' => 'Nama lengkap tidak terdaftar',
                'tanggal_tarik_data.required' => 'Tanggal Tarik Data harus di isi',
                'label.required' => 'Label harus di isi',
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

    public function storeExportDalamPengajuan()
    {
        try {
            DB::beginTransaction();

            // $disk = 'env('DEFAULT_STORE_DISK', 'private');'
            $disk = 'private';

            $extension = $this->inputFileBulkStatus
                ->extension();

            $fileName = ExportImportJobKey::EXPORT_LIST_DATA_DALAM_PENGAJUAN->value . '-' . now()->format('Ymd') . '.' . $extension;

            // $filePath = $this->inputFileBulkStatus
            //     ->storeAs(
            //         '',
            //         $fileName,
            //         $disk
            //     );
            $filePath = Storage::disk($disk)->putFileAs(
                'exports/gensen/template_dalam_pengajuan',
                $this->inputFileBulkStatus,
                $fileName,
                [
                    'visibility' => 'private',
                ]
            );

            $history = GensenExportImportHistoryRepository::create([
                'role' => Auth::user()->roles->pluck('name')->first(),
                'created_by' => auth()->id(),
                'job_key' => ExportImportJobKey::EXPORT_LIST_DATA_DALAM_PENGAJUAN->value,
                'type' => 'export',
                'filters' => json_encode([], true),
                'status' => JobStatus::DONE,
                'file_template_name' => $fileName,
                'file_template_path' => $filePath,
                'disk_template' => $disk,
                'start_at' => now(),
            ]);
            $path = $this->inputFileBulkStatus->getRealPath();
            unlink($path);
            DB::commit();

            $this->dispatch('datatable-refresh');
            $this->dispatch('onSuccessExportDalamPengajuan');
            $this->dispatch('refresh-table');
            $this->closeExportDalamPengajuanModal();

            Alert::information($this, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    public function closeExportDalamPengajuanModal()
    {
        $this->reset('inputFileBulkStatus');
        $this->previewBulkStatusRows = [];
        $this->errorBulkStatusRows = [];
    }

    public function render()
    {
        return view('livewire.gensen.export-import.export-dalam-pengajuan-modal');
    }
}
