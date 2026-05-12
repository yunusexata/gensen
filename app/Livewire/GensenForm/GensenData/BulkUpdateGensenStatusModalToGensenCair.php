<?php

namespace App\Livewire\GensenForm\GensenData;

use App\Enums\Gensen\ExportImportJobKey;
use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Imports\ExcelImportBulkStatusGensen;
use App\Models\GensenForm\GensenForm;
use App\Repositories\Exata\ExataRepository;
use App\Repositories\Gensen\GensenExportImportHistoryRepository;
use App\Repositories\GensenForm\GensenFormDetailRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

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
                // 'id_customer' => $row['id_customer'],
                'nama_lengkap' => $row['nama'],
                'no_input_jepang' => $row['no_input_jepang'],
                'tanggal_pengajuan' => $row['tanggal_pengajuan'],
                'tahun_gensen' => $row['tahun_gensen'],
                'tanggal_cair' => $row['tanggal_cair'],
                'nominal_cair' => $row['nominal_cair'],
            ];
            $validator = Validator::make($d, [
                // 'id_customer' => 'required|exists:gensen_forms,id_customer',
                'no_input_jepang' => 'required|exists:gensen_forms,no_input_jepang',
                'nama_lengkap' => [
                    'required',
                    Rule::exists('gensen_forms')
                        ->where(function ($query) use ($d) {
                            $query->where('nama_lengkap', $d['nama_lengkap'])
                                ->where('no_input_jepang', $d['no_input_jepang']);
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
                'nama_lengkap.required' => 'Nama lengkap harus di isi',
                'nama_lengkap.exists' => 'Nama lengkap tidak terdaftar',
                'tanggal_pengajuan.required' => 'Tanggal Pengajuan harus di isi',
                'tahun_gensen.required' => 'Tahun Gensen harus di isi',
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
                    $gensenForm = GensenFormRepository::findBy([
                        ['no_input_jepang', $value['data']['no_input_jepang']]
                    ]);
                    preg_match('/^\d+/', trim($value['data']['tahun_gensen']), $tahun_reiwa);
                    $updated = GensenFormDetailRepository::updateBy([
                        // ['id_customer', $value['data']['id_customer']],
                        ['gensen_form_id', $gensenForm->id],
                        ['nama_lengkap', $value['data']['nama_lengkap']],
                        ['tahun_gensen', $tahun_reiwa[0]],
                        ['no_input_jepang', $value['data']['no_input_jepang']],
                        ['tanggal_pengajuan', $value['data']['tanggal_pengajuan']],
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
                'job_key' => ExportImportJobKey::IMPORT_LIST_DATA_GENSEN_CAIR->value,
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
