<?php

namespace App\Livewire\IchijikinExtraction;

use App\Helpers\Alert;
use App\Helpers\ExportHelper;
use App\Helpers\PermissionHelper;
use App\Repositories\Account\UserRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionFileRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionRepository;
use App\Traits\Livewire\WithDatatable;
use Carbon\Carbon;
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
                'name' => 'Action',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    $editHtml = "";

                    $id = Crypt::encrypt($item->id);
                    if ($this->isCanUpdate) {
                        $editUrl = route('ichijikin_extraction.edit', $id);
                        $editHtml = "<div class='col-auto'>
                            <a type='button' href='$editUrl' class='p-0 hover:bg-error/10 text-primary rounded transition-colors'>
                                <span class='material-symbols-outlined text-lg' data-icon='edit'>edit</span>
                            </a>
                        </div>";
                    }
                    $html = "<div class='row p-0 m-0 d-flex justify-content-start flex-nowrap'>
                        $editHtml 
                    </div>";

                    return $html;
                },
            ],
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

                    $url = asset('storage/ichijikin/' . $item->ichijikinExtraction->batch_name . '/crop/' . $item->file_stored_name . '/nama_lengkap.png');
                    return "$item->nama_lengkap<br><img src='" . $url . "' style='width: 250px; max-width: 250px; border:1px solid black; border-radius:5px;'>";
                }
            ],
            [
                'key' => 'no_nenkin',
                'name' => 'No Nenkin',
                'render' => function ($item) {

                    $url = asset('storage/ichijikin/' . $item->ichijikinExtraction->batch_name . '/crop/' . $item->file_stored_name . '/no_nenkin.png');
                    return "$item->no_nenkin<br><img src='" . $url . "' style='width:150px; height:auto; border:1px solid black; border-radius:5px;'>";
                }
            ],
            [
                'key' => 'lama_kerja',
                'name' => 'Lama Kerja',
                'render' => function ($item) {

                    $url = asset('storage/ichijikin/' . $item->ichijikinExtraction->batch_name . '/crop/' . $item->file_stored_name . '/lama_kerja.png');
                    return "$item->lama_kerja<br><img src='" . $url . "' style='width:150px; height:auto; border:1px solid black; border-radius:5px;'>";
                }
            ],
            [
                'key' => 'kokumin',
                'name' => 'Kokumin',
                'render' => function ($item) {

                    $url = asset('storage/ichijikin/' . $item->ichijikinExtraction->batch_name . '/crop/' . $item->file_stored_name . '/kokumin.png');
                    return "$item->kokumin<br><img src='" . $url . "' style='width:150px; height:auto; border:1px solid black; border-radius:5px;'>";
                }
            ],
            [
                'key' => 'nenkin_100',
                'name' => 'Nenkin 100',
                'render' => function ($item) {

                    $url = asset('storage/ichijikin/' . $item->ichijikinExtraction->batch_name . '/crop/' . $item->file_stored_name . '/nenkin_100.png');
                    return "$item->nenkin_100<br><img src='" . $url . "' style='width:150px; height:auto; border:1px solid black; border-radius:5px;'>";
                }
            ],
            [
                'key' => 'nenkin_80',
                'name' => 'Nenkin 80',
                'render' => function ($item) {

                    $url = asset('storage/ichijikin/' . $item->ichijikinExtraction->batch_name . '/crop/' . $item->file_stored_name . '/nenkin_80.png');
                    return "$item->nenkin_80<br><img src='" . $url . "' style='width:150px; height:auto; border:1px solid black; border-radius:5px;'>";
                }
            ],
            [
                'key' => 'nenkin_20',
                'name' => 'Nenkin 20',
                'render' => function ($item) {

                    $url = asset('storage/ichijikin/' . $item->ichijikinExtraction->batch_name . '/crop/' . $item->file_stored_name . '/nenkin_20.png');
                    return "$item->nenkin_20<br><img src='" . $url . "' style='width:150px; height:auto; border:1px solid black; border-radius:5px;'>";
                }
            ],
            [
                'key' => 'alamat',
                'name' => 'Alamat',
                'render' => function ($item) {

                    $url = asset('storage/ichijikin/' . $item->ichijikinExtraction->batch_name . '/crop/' . $item->file_stored_name . '/alamat.png');
                    return "$item->alamat<br><img src='" . $url . "' style='width:500px; height:auto; border:1px solid black; border-radius:5px;'>";
                }
            ],

            [
                'key' => 'type',
                'name' => 'Tipe',
                'render' => function ($item) {
                    return $item->type ?? 'Belum Di Proses';
                }
            ],
            [
                'key' => 'confidence_score',
                'name' => 'Nilai',
                'render' => function ($item) {
                    return $item->confidence_score ?? 'Belum Di Proses';
                }
            ],
            [
                'key' => 'confidence_note',
                'name' => 'Catatan',
                'render' => function ($item) {
                    return $item->confidence_note;
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
