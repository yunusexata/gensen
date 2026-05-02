<?php

namespace App\Livewire\GensenForm\GensenData;

use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Imports\ExcelImportBulkStatusGensen;
use App\Models\GensenForm\GensenForm;
use App\Repositories\Exata\ExataRepository;
use App\Repositories\Gensen\GensenExportImportHistoryRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class BulkUpdateGensenStatusModalToGensenCair extends Component
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
                'nama_lengkap' => $row['nama'],
                'no_input_jepang' => $row['no_input_jepang'],
                'tanggal_cair' => $row['tanggal_cair'],
                'nominal_cair' => $row['nominal_cair'],
            ];
            $validator = Validator::make($d, [
                'id_customer' => 'required|exists:gensen_forms,id_customer',
                'nama_lengkap' => 'required|exists:gensen_forms,nama_lengkap',
                'no_input_jepang' => 'required|exists:gensen_forms,no_input_jepang',
                'tanggal_cair' => 'required',
                'nominal_cair' => 'required',
            ], [
                'id_customer.required' => 'Id customer harus di isi',
                'id_customer.exists' => 'Id customer tidak terdaftar',
                'nama_lengkap.required' => 'Nama lengkap harus di isi',
                'nama_lengkap.exists' => 'Nama lengkap tidak terdaftar',
                'no_input_jepang.required' => 'No Input Jepang harus di isi',
                'no_input_jepang.exists' => 'No Input Jepang tidak terdaftar',
                'tanggal_cair.required' => 'Tanggal cair harus di isi',
                'nominal_cair.required' => 'Nominal cair harus di isi',
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
            $path = $this->inputFileBulkStatus->getRealPath();
            $successCount = 0;
            foreach ($this->previewBulkStatusRows as $key => $value) {
                if (!$value['error']) {
                    $updated = GensenFormRepository::updateBy([
                        ['id_customer', $value['data']['id_customer']],
                        ['nama_lengkap', $value['data']['nama_lengkap']],
                        ['no_input_jepang', $value['data']['no_input_jepang']],
                    ], [
                        'tanggal_cair' => $value['data']['tanggal_cair'],
                        'nominal_cair' => $value['data']['nominal_cair'],
                    ]);

                    if ($updated > 0) {
                        $successCount++;
                    }
                }
            }
            unlink($path);
            DB::commit();
            $history = GensenExportImportHistoryRepository::create([
                'role' => Auth::user()->roles->pluck('name')->first(),
                'created_by' => auth()->id(),
                'type' => 'import',
                'filters' => json_encode([], true),
                'status' => JobStatus::DONE,
                'amount' => $successCount
            ]);

            $this->dispatch('datatable-refresh');
            $this->dispatch('onSuccessImportBulkStatusDataToGensenCair');
            $this->dispatch('refresh-table');
            $this->closebulkUpdateGensenStatusModalToGensenCair();

            Alert::confirmation(
                $this,
                Alert::ICON_SUCCESS,
                "Berhasil",
                "Data Berhasil Diperbarui",
                "on-dialog-confirm",
                "on-dialog-cancel",
                "Oke",
                "Tutup",
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    public function closebulkUpdateGensenStatusModalToGensenCair()
    {
        $this->reset('inputFileBulkStatus');
        $this->previewBulkStatusRows = [];
        $this->errorBulkStatusRows = [];
    }

    public function render()
    {
        return view('livewire.gensen-form.gensen-data.bulk-update-gensen-status-modal-to-gensen-cair');
    }
}
