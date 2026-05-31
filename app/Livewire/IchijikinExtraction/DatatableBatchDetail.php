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
                'key' => 'file_stored_name',
                'name' => 'Nama File',
                'render' => function ($item) {
                    return $item->file_stored_name;
                }
            ],
            [
                'key' => 'nama_lengkap',
                'name' => 'Nama Lengkap',
                'render' => function ($item) {
                    return $item->nama_lengkap ?? 'Belum Di Proses';
                }
            ],
            [
                'key' => 'no_nenkin',
                'name' => 'No Nenkin',
                'render' => function ($item) {
                    return $item->no_nenkin ?? 'Belum Di Proses';
                }
            ],
            [
                'key' => 'lama_kerja',
                'name' => 'Lama Kerja',
                'render' => function ($item) {
                    return $item->lama_kerja ? $item->lama_kerja . " Bulan" : 'Belum Di Proses';
                }
            ],
            [
                'key' => 'kokumin',
                'name' => 'Kokumin',
                'render' => function ($item) {
                    return is_null($item->kokumin) ? 'Belum Di Proses' : $item->kokumin;
                }
            ],
            [
                'key' => 'nenkin_100',
                'name' => 'Nenkin 100',
                'render' => function ($item) {
                    return $item->nenkin_100 ?? 'Belum Di Proses';
                }
            ],
            [
                'key' => 'nenkin_80',
                'name' => 'Nenkin 80',
                'render' => function ($item) {
                    return $item->nenkin_80 ?? 'Belum Di Proses';
                }
            ],
            [
                'key' => 'nenkin_20',
                'name' => 'Nenkin 20',
                'render' => function ($item) {
                    return $item->nenkin_20 ?? 'Belum Di Proses';
                }
            ],
            [
                'key' => 'type',
                'name' => 'Tipe',
                'render' => function ($item) {
                    return $item->type ?? 'Belum Di Proses';
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return IchijikinExtractionFileRepository::datatable(Crypt::decrypt($this->objId));
    }

    public function getView(): string
    {
        return 'livewire.ichijikin-extraction.datatable-batch-detail';
    }
}
