<?php

namespace App\Livewire\TemplatePosting;

use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Helpers\AppCrypt;
use App\Helpers\PermissionHelper;
use App\Jobs\ResiGenerator\GenerateResiZipJob;
use App\Models\ListPosting\TemplatePosting;
use App\Repositories\Account\UserRepository;
use App\Repositories\ListPosting\TemplatePostingRepository;
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
    public $isCanUpdateDetail;

    // Delete Dialog
    public $targetDeleteId;

    public function onMount()
    {
        $authUser = UserRepository::authenticatedUser();
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_RESI_GENERATOR, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_RESI_GENERATOR, PermissionHelper::TYPE_DELETE));

        $this->sortBy = 'created_at';
        $this->sortDirection = 'DESC';
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        TemplatePostingRepository::delete($this->targetDeleteId);
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

    public function generateZip($id)
    {

        $id = AppCrypt::decrypt($id);
        if (!$id) {
            abort(404, 'Link tidak valid atau telah dimanipulasi.');
        }
        GenerateResiZipJob::dispatch(TemplatePostingRepository::find($id))->onQueue('pdf');

        Alert::success(
            $this,
            'Berhasil',
            'Proses kompres sedang berjalan'
        );
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
                        $editUrl = route('template_posting.detail', $id);
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
                'key' => 'created_at',
                'name' => 'Tgl Dibuat'
            ],
            [
                'key' => 'name',
                'name' => 'Nama / Judul'
            ],
            [
                'key' => 'type',
                'name' => 'Jenis Template',
                'render' => function ($item) {
                    return TemplatePosting::TYPE_CHOICE[$item->type];
                }
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'Creator',
                'render' => function ($item) {
                    return $item->creator->name;
                }
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'File',
                'render' => function ($item) {
                    return '<img style="width:150px; height:auto; border:1px solid black; border-radius:5px" src="' . $item->previewUrl() . '" alt="">';
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return TemplatePostingRepository::datatable();
    }

    public function getView(): string
    {
        return 'livewire.template-posting.datatable';
    }
}
