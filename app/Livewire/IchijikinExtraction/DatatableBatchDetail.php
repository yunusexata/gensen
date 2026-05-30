<?php

namespace App\Livewire\IchijikinExtraction;

use App\Helpers\Alert;
use App\Helpers\PermissionHelper;
use App\Repositories\Account\UserRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionFileRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionRepository;
use App\Traits\Livewire\WithDatatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;
use Livewire\Component;


class DatatableBatchDetail extends Component
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
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_ICHIJIKIN_EXTRACTION, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_ICHIJIKIN_EXTRACTION, PermissionHelper::TYPE_DELETE));
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        IchijikinExtractionFileRepository::delete($this->targetDeleteId);
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
                'key' => 'nama_lengkap',
                'name' => 'Nama Lengkap',
                'render' => function ($item) {
                    dd($item);
                    return $item->nama_lengkap ?? 'KOSONG';
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return IchijikinExtractionFileRepository::datatable($this->objId);
    }

    public function getView(): string
    {
        return 'livewire.ichijikin-extraction.datatable-batch-detail';
    }
}
