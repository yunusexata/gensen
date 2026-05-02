<?php

namespace App\Livewire\GensenForm\GensenData;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Helpers\Alert;
use App\Helpers\ExportHelper;
use App\Helpers\PermissionHelper;
use App\Models\Exata\Exata;
use App\Models\GensenForm\GensenForm;
use App\Models\User;
use App\Repositories\Account\UserRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use App\Traits\Livewire\WithDatatable;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class Datatable extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $gensenFormLinkId;

    protected $paginationTheme = 'bootstrap';

    public $targetDeleteId;

    public $pageName = "";
    public $lengthOptions = [10, 25, 50, 100];
    public $length = 25;
    public $search;
    public $sortBy = '';
    public $sortDirection = 'asc';
    public $keyword_filter = true;
    public $show_filter = true;

    public $showLoadingIndicator = true;
    public $loadingIndicatorTarget = "";

    public $isCanUpdate;
    public $isCanDelete;
    public $openRow = null;

    // public $editedRows = [];
    public ?string $editingRowId = null;
    public array $editingData = [];

    // FILTER
    public $filter_pic;
    public $filter_status;
    public $filter_tanggal_input_dari;
    public $filter_tanggal_input_sampai;
    public $filter_tanggal_kepulangan_dari;
    public $filter_tanggal_kepulangan_sampai;


    public function onMount()
    {
        $authUser = UserRepository::authenticatedUser();

        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_DATA, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_DATA, PermissionHelper::TYPE_DELETE));
    }

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        GensenFormRepository::delete(Crypt::decrypt($this->targetDeleteId));
        Alert::success($this, 'Berhasil', 'Data berhasil dihapus');
    }

    #[On('export')]
    public function export($type)
    {
        $fileName = "Data Gensen " . Carbon::now()->format('Y-m-d H:i:s');
        return ExportHelper::export(
            $type,
            $fileName,
            $this->datatableGetProcessedQuery()->get()->toArray(),
            'app.gensen-form.gensen-data.export',
            [
                'title' => 'Data Gensen',
                'type' => $type,
            ],
            [
                'size' => 'legal',
                'orientation' => 'landscape',
            ]
        );
    }

    #[On('export_ready_verified')]
    public function export_ready_verified($type)
    {
        $fileName = "Data Gensen Ready Verified " . Carbon::now()->format('Y-m-d H:i:s');
        return ExportHelper::export(
            $type,
            $fileName,
            $this->datatableGetProcessedQuery()
                ->whereNotNull('tanggal_lengkap')
                ->whereNull('tanggal_verified')
                ->get()->toArray(),
            'app.gensen-form.gensen-data.export_ready_verified',
            [
                'title' => 'Data Gensen Ready Verified',
                'type' => $type,
            ],
            [
                'size' => 'legal',
                'orientation' => 'landscape',
            ]
        );
    }

    #[On('on-delete-dialog-cancel')]
    public function onDialogDeleteCancel()
    {
        $this->targetDeleteId = null;
    }

    #[On('showDeleteDialog')]
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
                        $editHtml =  "<div class='col-auto mb-2'>
                            <button 
                                class='btn btn-primary btn-sm'
                                data-bs-toggle='modal'
                                data-bs-target='#editModal'
                                type='button'
                                x-data
                                @click=\"\$dispatch('edit-data', { id: '" . $id . "' })\"
                            >
                                <i class='ki-duotone ki-notepad-edit fs-3'>
                                    <span class='path1'></span>
                                    <span class='path2'></span>
                                </i>
                                Ubah
                            </button>
                        </div>";
                    }

                    $destroyHtml = "";
                    if ($this->isCanDelete) {
                        $destroyHtml = "<div class='col-auto'>
                            <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors' wire:click=\"showDeleteDialog('$id')\">
                                <span class='material-symbols-outlined text-lg' data-icon='delete'>delete</span>
                            </button>
                        </div>";
                    }

                    $html = "<div class='row p-0 m-0'>
                        
                        $destroyHtml 
                    </div>";

                    return $html;
                },
            ],
            [
                'searchable' => false,
                'sortable' => false,
                'name' => 'Progres Berkas',
                'render' => function ($item) {
                    // dd($item->isAttachmentCompleted());
                    $uploadedTypes = $item->attachments
                        ->where('status', '!=', GensenAttachmenStatus::STATUS_REJECTED)
                        ->pluck('type')
                        ->map(fn($t) => $t->value)
                        ->toArray();
                    $statuses = [];

                    foreach (GensenAttachmentType::cases() as $index => $type) {

                        $completed = in_array($type->value, $uploadedTypes);

                        $statuses[] = [
                            'name' => $type->label(),
                            'status' => $completed,
                            // 'color' => '#F1416C',
                            'color' => 'surface-container-high',
                            'nomor_urut' => $index + 1,
                        ];
                    }
                    $html = '<div class="d-flex flex-nowrap gap-1 mb-2">';

                    foreach ($statuses as $proses) {

                        $color = $proses['status']
                            // ? '#50CD89'
                            ? 'primary'
                            : $proses['color'];

                        $html .= '
        <span class="w-6 h-6 flex items-center justify-center rounded-full bg-' . $color . ' text-on-' . $color . ' text-[10px] font-bold"
        data-bs-toggle="tooltip"
            title="' . $proses['name'] . '">' . $proses['nomor_urut'] . '</span>';
                    }

                    $html .= '</div>';

                    return $html;
                }
            ],
            [
                'key' => 'status',
                'name' => 'Status',
                'render' => function ($item) {
                    return "<p class='btn btn-sm py-1 mb-0' style='background-color:" . $item->statusColor() . "'>" . $item->status . "</p>";
                }
            ],
            [
                'key' => 'is_should_filled',
                'name' => 'Pengisian Form',
                'render' => function ($item) {
                    return "<p class='btn btn-sm py-1 mb-0 btn-" . ($item->is_should_filled ? 'success' : 'danger') . "'>" . ($item->is_should_filled ? 'Sudah' : 'Belum') . "</p>";
                }
            ],
            [
                'key' => 'is_submitted',
                'name' => 'Submit Form',
                'render' => function ($item) {
                    return "<p class='btn btn-sm py-1 mb-0 btn-" . ($item->is_submitted ? 'success' : 'danger') . "'>" . ($item->is_submitted ? 'Sudah' : 'Belum') . "</p>";
                }
            ],
            [
                'key' => 'id_customer',
                'name' => 'Id Customer',
            ],
            [
                'key' => 'nama_lengkap',
                'name' => 'Nama Lengkap',
            ],
            [
                'key' => 'tanggal_lahir',
                'name' => 'Tanggal Lahir',
            ],
            [
                'key' => 'email',
                'name' => 'Email',
            ],
            [
                'key' => 'tanggal_lengkap',
                'name' => 'Tanggal Lengkap',
                'render' => function ($item) {
                    return $item->tanggal_lengkap ? Carbon::parse($item->tanggal_lengkap)->format('Y-m-d') : '-';
                }
            ],
            [
                'key' => 'tanggal_verified',
                'name' => 'Tanggal Verified',
                'render' => function ($item) {
                    return $item->tanggal_verified ? Carbon::parse($item->tanggal_verified)->format('Y-m-d') : '-';
                }
            ],
            [
                'key' => 'no_input_jepang',
                'name' => 'No Input Jepang',
            ],
            [
                'key' => 'tanggal_cair',
                'name' => 'Tanggal Cair',
                'render' => function ($item) {
                    return $item->tanggal_cair ? Carbon::parse($item->tanggal_cair)->format('Y-m-d') : '-';
                }
            ],
            [
                'key' => 'nominal_cair',
                'name' => 'Nominal Cair',
                'render' => function ($item) {
                    return $item->nominal_cair ? number_format($item->nominal_cair, 0, ',', '.') : '-';
                }
            ],
            [
                'key' => 'keterangan_mondai',
                'name' => 'Keterangan Mondai',
            ],
            [
                'key' => 'created_at',
                'name' => 'Tanggal Input',
                'render' => function ($item) {
                    return $item->created_at->format('Y-m-d');
                }
            ],
            [
                'key' => 'tanggal_kepulangan',
                'name' => 'Tanggal Kepulangan',
            ],
            [
                'key' => 'no_rekening_penerima',
                'name' => 'No Rekening Penerima',
            ],
            [
                'key' => 'nama_bank_penerima',
                'name' => 'Nama Bank Penerima',
            ],
            [
                'key' => 'tahun_gensen',
                'name' => 'Tahun Gensen',
            ],
            [
                'key' => 'tahun_transfer',
                'name' => 'Tahun Transfer',
            ],
            [
                'key' => 'nama_penerima',
                'name' => 'Nama Penerima',
            ],
            [
                'key' => 'hubungan_penerima',
                'name' => 'Hubungan Penerima',
            ],
            [
                'key' => 'pic_code',
                'name' => 'Kode PIC',
            ],
            [
                'key' => 'nominal_gensen',
                'name' => 'Nominal Gensen',
                'render' => function ($item) {
                    return $item->nominal_gensen ? number_format($item->nominal_gensen, 0, ',', '.') : '-';
                }
            ],
            [
                'key' => 'jumlah_kirim_uang',
                'name' => 'Jumlah Kirim Uang',
                'render' => function ($item) {
                    return $item->jumlah_kirim_uang ? number_format($item->jumlah_kirim_uang, 0, ',', '.') : '-';
                }
            ],
            [
                'key' => 'nama_instagram',
                'name' => 'Nama Instagram',
            ],
            [
                'key' => 'nama_tiktok',
                'name' => 'Nama Tiktok',
            ],
            [
                'key' => 'nomor_whatsapp',
                'name' => 'Nomor Whatsapp',
            ],
            [
                'key' => 'nomor_whatsapp_darurat',
                'name' => 'Nomor Whatsapp Darurat',
            ],
            [
                'key' => 'alamat_jepang',
                'name' => 'Alamat Jepang',
            ],
            [
                'key' => 'kode_pos_jepang',
                'name' => 'Kode POS Jepang',
            ],
            [
                'key' => 'nama_lpk',
                'name' => 'Nama LPK/SO/PT',
            ],
            [
                'searchable' => false,
                'key' => 'remarks_type',
                'name' => 'Asal Pembuatan',
                'render' => function ($item) {
                    return $item->remarks_type == User::class ? 'Manual PIC' : 'Link Pengisian Clien';
                }
            ],
        ];
    }

    public function getQuery(): Builder
    {
        return GensenFormRepository::datatable(
            $this->gensenFormLinkId ? Crypt::decrypt($this->gensenFormLinkId) : null,
            $this->filter_status,
            $this->filter_pic,
            $this->filter_tanggal_input_dari ?
                [
                    Carbon::parse($this->filter_tanggal_input_dari)->startOfDay(),
                    Carbon::parse($this->filter_tanggal_input_sampai)->endOfDay(),
                ] : null,
            $this->filter_tanggal_kepulangan_dari ?
                [
                    Carbon::parse($this->filter_tanggal_kepulangan_dari)->startOfDay(),
                    Carbon::parse($this->filter_tanggal_kepulangan_sampai)->endOfDay(),
                ] : null,
        );
    }

    public function getView(): string
    {
        return 'livewire.gensen-form.gensen-data.datatable';
    }

    // FLOW FUNCTION
    public function saveEditedRow()
    {
        try {
            DB::transaction(function () {});
            $validatedData = [
                'nama_lengkap' => $this->editingData['nama_lengkap'],
                'tanggal_lahir' => $this->editingData['tanggal_lahir'],
                'tanggal_kepulangan' => $this->editingData['tanggal_kepulangan'],
                'nama_instagram' => $this->editingData['nama_instagram'],
                'nama_tiktok' => $this->editingData['nama_tiktok'],
                'nomor_whatsapp' => $this->editingData['nomor_whatsapp'],
                'nomor_whatsapp_darurat' => $this->editingData['nomor_whatsapp_darurat'],
                'email' => $this->editingData['email'],
                'alamat_jepang' => $this->editingData['alamat_jepang'],
                'kode_pos_jepang' => $this->editingData['kode_pos_jepang'],
                'nama_lpk' => $this->editingData['nama_lpk'],
                'status' => $this->editingData['status'],

                // REK PENERIMA
                'no_rekening_penerima' => $this->editingData['no_rekening_penerima'],
                'nama_bank_penerima' => $this->editingData['nama_bank_penerima'],
                'nama_penerima' => $this->editingData['nama_penerima'],
                'hubungan_penerima' => $this->editingData['hubungan_penerima'],

                // 'status' => $this->editingData['status'],
                'tahun_gensen' => $this->editingData['tahun_gensen'],
                'tahun_transfer' => $this->editingData['tahun_transfer'],
            ];
            GensenFormRepository::update(simple_decrypt($this->editingRowId), $validatedData);

            DB::commit();
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
        } catch (Exception $e) {
            DB::rollBack();
            Alert::fail($this, "Gagal", $e->getMessage());
        }
    }

    // TRAITS 

    public function mount()
    {
        $this->onMount();

        $columns = $this->getColumns();
        if ('' == $this->sortBy && count($columns) > 0) {
            foreach ($columns as $col) {
                if (!isset($col['sortable']) || $col['sortable']) {
                    $this->sortBy = $col['key'];
                    break;
                }
            }
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('datatable-add-filter')]
    public function datatableAddFilter($filter)
    {
        foreach ($filter as $key => $value) {
            $this->$key = $value;
        }
    }

    #[On('datatable-refresh')]
    public function datatableRefresh() {}

    public function datatablePaginate($query)
    {
        if ($this->pageName) {
            return $query->paginate($this->length, pageName: $this->pageName);
        } else {
            return $query->paginate($this->length);
        }
    }

    public function datatableSort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = 'asc' === $this->sortDirection
                ? 'desc'
                : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
    }

    public function datatableGetProcessedQuery()
    {
        $columns = $this->getColumns();
        $query = $this->getQuery();
        $search = $this->search;
        $sortBy = $this->sortBy;
        $sortDirection = $this->sortDirection;

        $query->when($search, function ($query) use ($search, $columns) {
            $query->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    if (
                        isset($col['key'])
                        && (!isset($col['searchable']) || (isset($col['searchable']) && $col['searchable']))
                    ) {
                        $query->orWhere($col['key'], 'LIKE', "%$search%");
                    }
                }
            });
        });

        $query->when($sortBy, function ($query) use ($sortBy, $sortDirection) {
            $query->orderBy($sortBy, $sortDirection);
        });

        return $query;
    }

    public function datatableGetData()
    {
        return $this->datatablePaginate($this->datatableGetProcessedQuery());
    }
    public function editRow($id)
    {
        $row = GensenForm::findOrFail(simple_decrypt($id));

        $this->editingRowId = $id;

        $this->editingData = [
            'id' => Crypt::encrypt($row['id']),
            'nama_lengkap' => $row['nama_lengkap'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'tanggal_kepulangan' => $row['tanggal_kepulangan'],
            'nama_instagram' => $row['nama_instagram'],
            'nama_tiktok' => $row['nama_tiktok'],
            'nomor_whatsapp' => $row['nomor_whatsapp'],
            'nomor_whatsapp_darurat' => $row['nomor_whatsapp_darurat'],
            'email' => $row['email'],
            'alamat_jepang' => $row['alamat_jepang'],
            'kode_pos_jepang' => $row['kode_pos_jepang'],
            'nama_lpk' => $row['nama_lpk'],
            'status' => $row['status'],

            // REK PENERIMA
            'no_rekening_penerima' => $row['no_rekening_penerima'],
            'nama_bank_penerima' => $row['nama_bank_penerima'],
            'nama_penerima' => $row['nama_penerima'],
            'hubungan_penerima' => $row['hubungan_penerima'],

            // 'status' => $row['status'],
            'tahun_gensen' => $row['tahun_gensen'],
            'tahun_transfer' => $row['tahun_transfer'],
        ];
    }


    public function hydrateEditedRows($data)
    {
        consoleLog($this, 'hidrate');
        foreach ($data as $row) {
            if (!isset($this->editedRows[$row['id']])) {
            }
        }
    }

    public function render()
    {
        $data = $this->datatableGetData();

        // $this->hydrateEditedRows($data);

        return view($this->getView(), [
            'data' => $data,
            'columns' => $this->getColumns(),
        ]);
    }
}
