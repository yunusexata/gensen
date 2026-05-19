<?php

namespace App\Livewire\Gensen\ExportImport;

use App\Enums\Gensen\JobStatus;
use App\Helpers\Alert;
use App\Helpers\PermissionHelper;
use App\Models\GensenForm\GensenForm;
use App\Repositories\Account\UserRepository;
use App\Repositories\Gensen\GensenExportImportHistoryRepository;
use App\Traits\Livewire\WithDatatable as LivewireWithDatatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\On;
use Livewire\Component;


class DatatableHistory extends Component
{
    use LivewireWithDatatable;

    public $isCanUpdate;
    public $isCanDelete;
    public $isCanUpdateBookingTime;
    public $isCanUpdateDetail;

    // Delete Dialog
    public $targetDeleteId;
    protected $listeners = ['status-updated' => 'updateStatus'];

    public $statuses = [];

    public function updateStatus($data)
    {
        consoleLog($this, [
            'data masuk',
            $data
        ]);
        if ($data['type'] === 'export' && $data['created_by'] == Auth::user()->id && $data['status'] === JobStatus::DONE->value) {
            $encryptedId = Crypt::encrypt($data['id']);
            $this->dispatch(
                'download-export',
                // url: $data['url']
                url: route('gensen_form_export_import.download', ['id' => $encryptedId])
            );
        }
        $this->statuses[$data['id']] = $data;
    }

    public function onMount()
    {
        $this->sortBy = 'created_at';
        $this->sortDirection = 'desc';
        $authUser = UserRepository::authenticatedUser();
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_USER, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_USER, PermissionHelper::TYPE_DELETE));
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        GensenExportImportHistoryRepository::delete(Crypt::decrypt($this->targetDeleteId));
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

                    $id = Crypt::encrypt($item->id);
                    $destroyHtml = "";
                    if ($this->isCanDelete) {
                        $destroyHtml = "<div class='col-auto mb-2'>
                            <button class='btn btn-danger btn-sm m-0' 
                                wire:click=\"showDeleteDialog('$id')\">
                                <i class='ki-duotone ki-trash fs-1'>
                                    <span class='path1'></span>
                                    <span class='path2'></span>
                                    <span class='path3'></span>
                                    <span class='path4'></span>
                                    <span class='path5'></span>
                                </i>
                                Hapus
                            </button>
                        </div>";
                    }

                    $html = "<div class='row'>
                        $destroyHtml 
                    </div>";

                    return $html;
                },
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'Pembuat',
                'render' => function ($item) {
                    return $item->creator ? $item->creator->name . " | " . $item->role : '-';
                }
            ],
            [
                'key' => 'job_key',
                'name' => 'Nama Task',
                'render' => function ($item) {
                    return $item->job_key->value;
                }
            ],
            [
                'key' => 'created_at',
                'name' => 'Tanggal Dibuat',
                'render' => function ($item) {
                    return $item->created_at->format('d M Y H:i');
                }
            ],
            [
                'key' => 'type',
                'name' => 'Tipe',
                'render' => function ($item) {
                    return "  <span 
        x-data 
        x-bind:class=\"{
            'badge badge-success': ('{$item->type}') === 'export',
            'badge badge-primary': ('{$item->type}') === 'import',
        }\"
        x-text=\"('{$item->type}')\"
    >
    </span>
";
                }
            ],
            [
                'key' => 'status',
                'name' => 'Status',
                'render' => function ($item) {
                    return "
    <span 
        x-data 
        x-bind:class=\"{
            'badge badge-warning': (\$wire.statuses[{$item->id}]?.status ?? '{$item->status->value}') === 'pending',
            'badge badge-info': (\$wire.statuses[{$item->id}]?.status ?? '{$item->status->value}') === 'processing',
            'badge badge-success': (\$wire.statuses[{$item->id}]?.status ?? '{$item->status->value}') === 'done',
            'badge badge-danger': (\$wire.statuses[{$item->id}]?.status ?? '{$item->status->value}') === 'failed',
            'badge badge-secondary': !['pending','processing','done','failed'].includes(\$wire.statuses[{$item->id}]?.status ?? '{$item->status->value}')
        }\"
        x-text=\"(\$wire.statuses[{$item->id}]?.status ?? '{$item->status->value}')\"
    >
    </span>
";
                }
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'Download',
                'render' => function ($item) {

                    $encryptedId = Crypt::encrypt($item->id);
                    $url = route('gensen_form_export_import.download', ['id' => $encryptedId]);
                    $download = "<a download='$item->filename' href='{$url}' class='btn btn-success btn-sm'>
                    Download
                </a>";
                    //                 $html = "
                    //     <div x-data>
                    //         <template x-if=\"\$wire.statuses[{$item->id}]?.status === 'done' && $item->type == 'export'\">
                    //             <a download='$item->filename' href='{$url}' class='btn btn-success btn-sm'>
                    //                 Download
                    //             </a>
                    //         </template>
                    //     </div>
                    // ";
                    $html = "";
                    if ($item->status === JobStatus::DONE) {
                        $html .= $download;
                    }
                    return $html;
                }
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'key' => 'amount',
                'name' => 'Jumlah Data',
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'key' => 'error_message',
                'name' => 'Pesan Error',
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return GensenExportImportHistoryRepository::datatable();
    }

    public function getView(): string
    {
        return 'livewire.gensen.export-import.datatable-history';
    }
}
