<?php

namespace App\Livewire\IchijikinExtraction;

use App\Helpers\Alert;
use App\Helpers\PermissionHelper;
use App\Repositories\Account\UserRepository;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use App\Traits\Livewire\WithDatatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;
use Livewire\Component;


class Datatable extends Component
{
    use WithDatatable;

    public $isCanUpdate;
    public $isCanDelete;
    public $isCanUpdateBookingTime;
    public $isCanUpdateDetail;

    // Delete Dialog
    public $targetDeleteId;

    public function onMount()
    {
        $authUser = UserRepository::authenticatedUser();
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_FORM_LINK, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_FORM_LINK, PermissionHelper::TYPE_DELETE));
        $this->sortBy = 'expired_at';
        $this->sortDirection = 'DESC';
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        GensenFormLinkRepository::delete($this->targetDeleteId);
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
                        $editUrl = route('gensen_form_link.edit', $id);
                        $editHtml = "<div class='col-auto'>
                            <a type='button' href='$editUrl' class='p-0 hover:bg-error/10 text-primary rounded transition-colors'>
                                <span class='material-symbols-outlined text-lg' data-icon='edit'>edit</span>
                            </a>
                        </div>";
                    }

                    $destroyHtml = "";
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
                'key' => 'expired_at',
                'name' => 'Expired Pada'
            ],
            [
                'key' => 'name',
                'name' => 'Nama'
            ],
            [
                'key' => 'password',
                'name' => 'Password'
            ],
            [
                'key' => 'status',
                'name' => 'Status'
            ],
            [
                'key' => 'max_usage',
                'name' => 'Maks Penggunaan'
            ],
            [
                'key' => 'used_count',
                'name' => 'Jumlah Terpakai'
            ],
            [
                'sortable' => false,
                'searcable' => false,
                'name' => 'Kode PIC',
                'render' => function ($item) {
                    return $item->pic_code;
                }
            ],

            [
                'sortable' => false,
                'searcable' => false,
                'name' => 'Link',
                'render' => function ($item) {
                    // $link = route('gensen_form_link.form', Crypt::encrypt($item->id));
                    // $link = route('gensen_form_link.create', $item->token);
                    $link = route('gensen_form.form', simple_encrypt($item->token));
                    $linkHtml = "
                        <div class='d-flex flex-nowrap justify-content-start gap-2 p-0 m-0'>
                            <div class='col-auto p-0 m-0'>
                                <button class='p-0 hover:bg-error/10 text-success rounded transition-colors'
                                    onclick=\"copyToClipboard('$link')\"
                                >
                                <span class='material-symbols-outlined text-lg' data-icon='edit'>Link</span>
                                </button>
                            </div>
                            <div class='col-auto p-0 m-0'>
                                <p
                                    class='form-control m-0 py-0'
                                    onclick=\"copyToClipboard('$link')\"
                                >" . $link . "</p>
                            </div>
                        </div>
                        
                        ";
                    return $linkHtml;
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return GensenFormLinkRepository::datatable();
    }

    public function getView(): string
    {
        return 'livewire.gensen-form.gensen-form-link.datatable';
    }
}
