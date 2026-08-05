<?php

namespace App\Livewire\ResiGenerator;

use App\Helpers\Alert;
use App\Helpers\AppCrypt;
use App\Helpers\ExportHelper;
use App\Helpers\NumberFormatter;
use App\Helpers\PermissionHelper;
use App\Repositories\Account\UserRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionFileRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionRepository;
use App\Repositories\ResiGenerator\ResiGeneratorDetailRepository;
use App\Traits\Livewire\WithDatatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;
use Livewire\Component;


class DatatableDetail extends Component
{
    use WithDatatable;

    public $objId;

    public $isCanUpdate;
    public $isCanDelete;
    public $isCanUpdateBookingTime;
    public $isCanUpdateDetail;

    // Delete Dialog
    public $targetDeleteId;

    public function onMount()
    {
        $authUser = UserRepository::authenticatedUser();
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_RESI_GENERATOR, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_RESI_GENERATOR, PermissionHelper::TYPE_DELETE));
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        // IchijikinExtractionFileRepository::delete($this->targetDeleteId);
        Alert::success($this, 'Berhasil', 'Data berhasil dihapus');
    }

    #[On('on-delete-dialog-cancel')]
    public function onDialogDeleteCancel()
    {
        $this->targetDeleteId = null;
    }

    public function showDeleteDialog($id)
    {
        $this->targetDeleteId = $id;

        Alert::confirmation(
            $this,
            Alert::ICON_QUESTION,
            "Hapus Data",
            "Apakah Anda Yakin Ingin Menghapus Data Ini ?",
            "on-delete-dialog-confirm",
            "on-delete-dialog-cancel",
            "Hapus",
            "Batal",
        );
    }

    #[On('refresh-table')]
    public function refreshTable()
    {
        $this->resetPage();
    }

    public function getColumns(): array
    {
        return [

            [
                'name' => 'Action',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    $editHtml = "";

                    $id = Crypt::encrypt($item->id);
                    // if ($this->isCanUpdate) {
                    //     $editUrl = route('ichijikin_extraction.edit', $id);
                    //     $editHtml = "<div class='col-auto'>
                    //         <a type='button' href='$editUrl' class='p-0 hover:bg-error/10 text-primary rounded transition-colors'>
                    //             <span class='material-symbols-outlined text-lg' data-icon='edit'>edit</span>
                    //         </a>
                    //     </div>";
                    // }
                    $destroyHtml = "";
                    if ($this->isCanDelete) {
                        $destroyHtml = "<div class='col-auto'>
                            <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors' wire:click=\"showDeleteDialog($item->id)\">
                                <span class='material-symbols-outlined text-lg' data-icon='delete'>delete</span>
                            </button>
                        </div>";
                    }
                    $html = "<div class='row p-0 m-0 d-flex justify-content-start flex-nowrap'>
                        $editHtml $destroyHtml
                    </div>";

                    return $html;
                },
            ],
            [
                'key' => 'nama',
                'name' => 'Nama (Excel)',
                'class' => 'bg-white',
                'render' => function ($item) {
                    return $item->nama;
                }
            ],
            [
                'key' => 'nama_penerima',
                'name' => 'Nama Penerima (Excel)',
                'class' => 'bg-white',
                'render' => function ($item) {
                    return $item->nama_penerima;
                }
            ],
            [
                'key' => 'formatted_penerima',
                'name' => 'Nama (Email)',
                'class' => 'bg-light',
                'render' => function ($item) {
                    return $item->formatted_penerima;
                }
            ],
            [
                'key' => 'nominal',
                'name' => 'Nominal (Excel)',
                'class' => 'text-right bg-white',
                'render' => function ($item) {
                    return NumberFormatter::format($item->nominal);
                }
            ],
            [
                'key' => 'formatted_nominal',
                'name' => 'Nominal (Email)',
                'class' => 'text-right bg-light',
                'render' => function ($item) {
                    return NumberFormatter::format($item->formatted_nominal);
                }
            ],
            [
                'key' => 'rekening',
                'name' => 'Rekening (Excel)',
                'class' => 'text-center bg-white',
                'render' => function ($item) {
                    return $item->rekening;
                }
            ],
            [
                'key' => 'formatted_rekening_tujuan',
                'name' => 'Rekening (Email)',
                'class' => 'text-center bg-light',
                'render' => function ($item) {
                    return $item->formatted_rekening_tujuan;
                }
            ],
            [
                'key' => 'confidence_score',
                'name' => 'Poin',
                'render' => function ($item) {
                    return $item->confidence_score;
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        $id = AppCrypt::decrypt($this->objId);
        if (!$id) {
            abort(404, 'Link tidak valid atau telah dimanipulasi.');
        }
        return ResiGeneratorDetailRepository::datatable($id);
    }

    public function getView(): string
    {
        return 'livewire.resi-generator.datatable-detail';
    }
}
