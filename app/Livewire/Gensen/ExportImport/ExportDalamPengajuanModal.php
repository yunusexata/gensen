<?php

namespace App\Livewire\Gensen\ExportImport;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Helpers\ExportHelper;
use App\Imports\ExcelImportBulkStatusGensen;
use App\Imports\ExcelImportTarikData;
use App\Repositories\Gensen\GensenExportImportHistoryRepository;
use App\Repositories\GensenForm\GensenFormDetailRepository;
use App\Repositories\GensenForm\GensenFormRepository;
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
                'error' => array_merge($validator->errors()->toArray(), $row['error'])
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
            $path = $this->inputFileBulkStatus->getRealPath();
            $successCount = 0;
            foreach ($this->previewBulkStatusRows as $key => $value) {
                if (!$value['error']) {
                    $updated = GensenFormDetailRepository::update($value['data']['gensen_form_detail_id'], [
                        'tanggal_tarik_data' => $value['data']['tanggal_tarik_data'],
                        'label' => $value['data']['label'],
                    ]);
                    $gensen_form = GensenFormRepository::findBy([
                        ['id_customer', $value['data']['id_customer']]
                    ]);

                    $gensen_form->onSubmitted();

                    if ($updated > 0) {
                        $successCount++;
                    }
                }
            }
            $disk = 'private';

            $extension = $this->inputFileBulkStatus
                ->extension();

            $fileName = ExportImportJobKey::EXPORT_LIST_DATA_DALAM_PENGAJUAN->value . '-' . now()->format('Ymd') . '.' . $extension;

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
                'export_template' => 'app.gensen.gensen-data.export-dalam-pengajuan',
                'file_template_name' => $fileName,
                'file_template_path' => $filePath,
                'disk_template' => $disk,
                'start_at' => now(),

            ]);
            $path = $this->inputFileBulkStatus->getRealPath();
            unlink($path);
            DB::commit();
            $fileName = "Data Gensen Dalam Pengajuan" . Carbon::now()->format('Y-m-d H:i:s');


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
