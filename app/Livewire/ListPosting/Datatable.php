<?php

namespace App\Livewire\ListPosting;

use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Helpers\AppCrypt;
use App\Helpers\PermissionHelper;
use App\Jobs\ListPosting\ZipGeneratedImagesJob;
use App\Jobs\ResiGenerator\GenerateResiZipJob;
use App\Repositories\Account\UserRepository;
use App\Repositories\ListPosting\ListPostingRepository;
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
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        ListPostingRepository::delete($this->targetDeleteId);
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
        ZipGeneratedImagesJob::dispatch($id);
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
                        $editUrl = route('list_posting.detail', $id);
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
                    $downloadHtml = '';
                    if (
                        $item->zip_status === JobStatus::DONE && $item->zip_path &&
                        file_exists(storage_path('app/public/' . $item->zip_path))
                    ) {
                        $downloadUrl = route(
                            'list_posting.download',
                            $id
                        );

                        $downloadHtml = "
                        <div class='col-auto'>
                            <a
                                href='{$downloadUrl}'
                                class='p-0 hover:bg-success/10 text-success rounded transition-colors'
                            >
                                <span class='material-symbols-outlined text-lg'>
                                    download
                                </span>
                            </a>
                        </div>";
                    } elseif ($item->zip_status === JobStatus::PROCESSING) {
                        // If processing, show a disabled loading spinner/icon
                        $downloadHtml = "<div class='col-auto'>
                                    <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors' wire:click=\"generateZip($id)\">
                                        <span class='material-symbols-outlined text-lg text-warning animate-spin' title='Compiling ZIP...'>sync</span>
                                    </button>
                                </div>";
                    } else {
                        // If not started yet (or failed), show the trigger button to start the job
                        $downloadHtml = "
                            <div class='col-auto'>
                                <button
                                    type='button'
                                    wire:click=\"generateZip('{$id}')\"
                                    class='p-0 hover:bg-warning/10 text-warning rounded transition-colors'
                                >
                                    <span class='material-symbols-outlined text-lg'>
                                        folder_zip
                                    </span>
                                </button>
                            </div>";
                    }

                    $html = "<div class='row p-0 m-0 d-flex justify-content-start flex-nowrap'>
                        $editHtml $destroyHtml $downloadHtml
                    </div>";

                    return $html;
                },
            ],
            [
                'key' => 'name',
                'name' => 'Nama / Judul'
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return ListPostingRepository::datatable();
    }

    public function getView(): string
    {
        return 'livewire.list-posting.datatable';
    }
}
