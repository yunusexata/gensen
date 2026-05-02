<?php

namespace App\Livewire\Gensen\ExportImport;

use App\Helpers\Alert;
use App\Helpers\ExportHelper;
use App\Repositories\Gensen\GensenExportImportHistoryRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;
use Livewire\Component;

class Export extends Component
{
    public $exportStatus;
    public $filter_tanggal_input_dari;
    public $filter_tanggal_input_sampai;
    public $filter_pic;
    public function mount() {}

    #[On('setExportStatus')]
    public function setExportStatus($status)
    {
        $this->exportStatus = $status;
    }
    public function submitExport()
    {
        // $query = GensenFormRepository::export(
        //     $this->exportStatus,
        //     $this->filter_pic,
        //     $this->filter_tanggal_input_dari ?
        //         [
        //             Carbon::parse($this->filter_tanggal_input_dari)->startOfDay(),
        //             Carbon::parse($this->filter_tanggal_input_sampai)->endOfDay(),
        //         ] : null
        // );

        $filters = [
            'status' => $this->exportStatus,
            'pic_code' => $this->filter_pic,
            'tanggal_input' => $this->filter_tanggal_input_dari ?
                [
                    Carbon::parse($this->filter_tanggal_input_dari)->startOfDay(),
                    Carbon::parse($this->filter_tanggal_input_sampai)->endOfDay(),
                ] : null
        ];
        $history = GensenExportImportHistoryRepository::create([
            'role' => Auth::user()->roles->pluck('name')->first(),
            'created_by' => auth()->id(),
            'type' => 'export',
            'filters' => json_encode($filters, true)
        ]);

        $this->dispatch('datatable-refresh');
        $this->dispatch('onSuccessExportModal');
        $this->closeExportModal();

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
            'exportStatus',
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
