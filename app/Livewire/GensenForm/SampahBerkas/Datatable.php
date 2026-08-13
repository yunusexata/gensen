<?php

namespace App\Livewire\GensenForm\SampahBerkas;

use App\Helpers\Alert;
use App\Helpers\PermissionHelper;
use App\Repositories\Account\UserRepository;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use App\Traits\Livewire\WithDatatable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;

class Datatable extends Component
{
    use WithDatatable;

    public $isCanUpdate;
    public $isCanDelete;

    public $targetRestoreId;
    public $targetDeleteId;

    public function onMount()
    {
        $authUser = UserRepository::authenticatedUser();
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_ATTACHMENT_TRASH, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_ATTACHMENT_TRASH, PermissionHelper::TYPE_DELETE));
    }

    // --- Restore Dialog & Action ---
    public function showRestoreDialog($id)
    {
        $this->targetRestoreId = $id;

        Alert::confirmation(
            $this,
            Alert::ICON_QUESTION,
            "Kembalikan Berkas",
            "Apakah Anda Yakin Ingin Mengembalikan Berkas Ini ?",
            "on-restore-dialog-confirm",
            "on-restore-dialog-cancel",
            "Kembalikan",
            "Batal",
        );
    }

    #[On('on-restore-dialog-confirm')]
    public function onDialogRestoreConfirm()
    {
        if (!$this->isCanUpdate || $this->targetRestoreId == null) {
            return;
        }

        GensenFormAttachmentRepository::restore($this->targetRestoreId);
        $this->targetRestoreId = null;

        Alert::success($this, 'Berhasil', 'Berkas berhasil dikembalikan');
    }

    #[On('on-restore-dialog-cancel')]
    public function onDialogRestoreCancel()
    {
        $this->targetRestoreId = null;
    }

    // --- Force Delete Dialog & Action ---
    public function showDeleteDialog($id)
    {
        $this->targetDeleteId = $id;

        Alert::confirmation(
            $this,
            Alert::ICON_WARNING,
            "Hapus Permanent",
            "Apakah Anda Yakin Ingin Menghapus Permanent Berkas Ini ? Tindakan ini tidak dapat dibatalkan.",
            "on-delete-dialog-confirm",
            "on-delete-dialog-cancel",
            "Hapus Permanent",
            "Batal",
        );
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        GensenFormAttachmentRepository::forceDelete($this->targetDeleteId);
        $this->targetDeleteId = null;

        Alert::information($this, 'Berkas berhasil dihapus permanent');
    }

    #[On('on-delete-dialog-cancel')]
    public function onDialogDeleteCancel()
    {
        $this->targetDeleteId = null;
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
                'name' => 'Aksi',
                'sortable' => false,
                'searchable' => false,
                'render' => function ($item) {
                    $restoreHtml = "";
                    if ($this->isCanUpdate) {
                        $restoreHtml = "<div class='col-auto me-1'>
                            <button type='button' class='p-1 hover:bg-success/10 text-success rounded transition-colors border-0 bg-transparent' wire:click=\"showRestoreDialog({$item->id})\" title='Kembalikan'>
                                <span class='material-symbols-outlined text-lg'>settings_backup_restore</span>
                            </button>
                        </div>";
                    }

                    $destroyHtml = "";
                    if ($this->isCanDelete) {
                        $destroyHtml = "<div class='col-auto'>
                            <button type='button' class='p-1 hover:bg-error/10 text-error rounded transition-colors border-0 bg-transparent' wire:click=\"showDeleteDialog({$item->id})\" title='Hapus Permanent'>
                                <span class='material-symbols-outlined text-lg'>delete_forever</span>
                            </button>
                        </div>";
                    }

                    return "<div class='row p-0 m-0 d-flex justify-content-start flex-nowrap'>
                        {$restoreHtml} {$destroyHtml}
                    </div>";
                },
            ],
            [
                'key' => 'original_name',
                'name' => 'Nama Berkas',
                'searchable' => false,
                'class' => 'text-nowrap',
            ],
            [
                'key' => 'type',
                'name' => 'Jenis Berkas',
                'searchable' => false,
                'class' => 'text-nowrap',
                'render' => function ($item) {
                    return $item->type?->label() ?? $item->type;
                }
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'Nama Customer',
                'class' => 'text-nowrap',
                'render' => function ($item) {
                    return $item->gensenForm?->nama_lengkap ?? '-';
                }
            ],
            [
                'key' => 'file_size',
                'name' => 'Ukuran File',
                'searchable' => false,
                'class' => 'text-nowrap',
                'render' => function ($item) {
                    $bytes = (int) $item->file_size;
                    if ($bytes >= 1048576) {
                        return number_format($bytes / 1048576, 2) . ' MB';
                    } elseif ($bytes >= 1024) {
                        return number_format($bytes / 1024, 2) . ' KB';
                    }
                    return $bytes . ' B';
                }
            ],
            [
                'key' => 'note',
                'name' => 'Catatan',
                'searchable' => false,
                'render' => function ($item) {
                    return $item->note ?? '-';
                }
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'Dihapus Oleh',
                'class' => 'text-nowrap',
                'render' => function ($item) {
                    return $item->deletedByUser?->name ?? '-';
                }
            ],
            [
                'key' => 'deleted_at',
                'name' => 'Tanggal Dihapus',
                'searchable' => false,
                'class' => 'text-nowrap',
                'render' => function ($item) {
                    return $item->deleted_at ? $item->deleted_at->format('Y-m-d H:i:s') : '-';
                }
            ],
            [
                'key' => 'disk',
                'name' => 'Lokasi Penyimpanan',
                'searchable' => false,
                'class' => 'text-nowrap',
                'render' => function ($item) {
                    return $item->disk;
                }
            ],
            [
                'key' => 'path',
                'name' => 'Lokasi File',
                'searchable' => false,
                'class' => 'text-nowrap',
                'render' => function ($item) {
                    return $item->path;
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return GensenFormAttachmentRepository::datatableTrash($this->search);
    }

    public function getView(): string
    {
        return 'livewire.gensen-form.sampah-berkas.datatable';
    }
}
