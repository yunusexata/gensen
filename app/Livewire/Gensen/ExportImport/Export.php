<?php

namespace App\Livewire\Gensen\ExportImport;

use App\Enums\Gensen\ExportImportJobKey;
use App\Helpers\Alert;
use App\Repositories\Gensen\GensenExportImportHistoryRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Export extends Component
{
    public $export_job_key;
    public $filter_tanggal_input_dari;
    public $filter_tanggal_input_sampai;
    public $filter_pic;
    public function mount() {}

    #[On('setExportJobKey')]
    public function setExportJobKey($job_key)
    {
        $this->export_job_key = ExportImportJobKey::from($job_key);;
    }
    public function submitExport()
    {
        // $query = GensenFormRepository::export(
        //     $this->export_job_key,
        //     $this->filter_pic,
        //     $this->filter_tanggal_input_dari ?
        //         [
        //             Carbon::parse($this->filter_tanggal_input_dari)->startOfDay(),
        //             Carbon::parse($this->filter_tanggal_input_sampai)->endOfDay(),
        //         ] : null
        // );

        $filters = [
            // 'status' => GensenForm::STATUS_BELUM_LENGKAP,
            'job_key' => $this->export_job_key->value,
            'pic_code' => $this->filter_pic,
            'tanggal_input' => $this->filter_tanggal_input_dari ?
                [
                    Carbon::parse($this->filter_tanggal_input_dari)->startOfDay(),
                    Carbon::parse($this->filter_tanggal_input_sampai)->endOfDay(),
                ] : null
        ];
        $export_template = null;
        match ($this->export_job_key) {
            ExportImportJobKey::EXPORT_LIST_DATA_BELUM_LENGKAP =>
            $export_template = 'app.gensen.gensen-data.export-belum-lengkap',
            ExportImportJobKey::EXPORT_LIST_DATA_VERIFIED =>
            $export_template = 'app.gensen.gensen-data.export-japan-version',
            ExportImportJobKey::EXPORT_LIST_DATA_NO_INPUT_JAPAN =>
            $export_template = 'app.gensen.gensen-data.export-japan-version',
            default => $export_template = null,
        };
        $history = GensenExportImportHistoryRepository::create([
            'role' => Auth::user()->roles->pluck('name')->first(),
            'job_key' => $this->export_job_key,
            'created_by' => auth()->id(),
            'type' => 'export',
            'filters' => json_encode($filters, true),
            'export_template' => $export_template,
        ]);

        $this->dispatch('datatable-refresh');
        $this->dispatch('onSuccessExportModal');
        $this->closeExportModal();

        Alert::information($this, 'Data berhasil disimpan');
        // $fileName = "Data Gensen " . Carbon::now()->format('Y-m-d H:i:s');
        // return ExportHelper::export(
        //     ExportHelper::TYPE_EXCEL,
        //     $fileName,
        //     $query->get()->toArray(),
        //     'app.gensen-form.gensen-data.export',
        //     [
        //         'title' => 'Data Gensen',
        //         'type' => ExportHelper::TYPE_EXCEL,
        //     ],
        //     [
        //         'size' => 'legal',
        //         'orientation' => 'landscape',
        //     ]
        // );
    }

    public function closeExportModal()
    {
        $this->reset([
            'export_job_key',
            'filter_pic',
            'filter_tanggal_input_dari',
            'filter_tanggal_input_sampai',
        ]);
    }

    public function render()
    {
        return view('livewire.gensen.export-import.export');
    }
}
