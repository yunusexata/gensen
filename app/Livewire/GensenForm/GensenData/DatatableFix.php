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
    public $targetCopyId;

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
    public $isCanCreate;
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

        $this->isCanCreate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_DATA, PermissionHelper::TYPE_CREATE));
        $this->isCanUpdate = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_DATA, PermissionHelper::TYPE_UPDATE));
        $this->isCanDelete = $authUser->hasPermissionTo(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_DATA, PermissionHelper::TYPE_DELETE));

        $this->sortBy = 'created_at';
        $this->sortDirection = 'DESC';
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

    #[On('on-delete-dialog-confirm')]
    public function onDialogDeleteConfirm()
    {
        if (!$this->isCanDelete || $this->targetDeleteId == null) {
            return;
        }

        GensenFormRepository::delete(Crypt::decrypt($this->targetDeleteId));
        Alert::success($this, 'Berhasil', 'Data berhasil dihapus');
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
            "Apakah Anda Yakin Ingin Duplikat Data Ini ?",
            "on-delete-dialog-confirm",
            "on-delete-dialog-cancel",
            "Hapus",
            "Batal",
        );
    }

    #[On('on-copy-dialog-confirm')]
    public function onDialogCopyConfirm()
    {
        if (!$this->isCanCreate || $this->targetCopyId == null) {
            return;
        }

        GensenFormRepository::copy(Crypt::decrypt($this->targetCopyId));
        Alert::success($this, 'Berhasil', 'Data berhasil diperbarui');
    }

    #[On('on-copy-dialog-cancel')]
    public function onDialogCopyCancel()
    {
        $this->targetCopyId = null;
    }

    #[On('showCopyDialog')]
    public function showCopyDialog($id)
    {
        $this->targetCopyId = $id;

        Alert::confirmation(
            $this,
            Alert::ICON_QUESTION,
            "Duplikat Data",
            "Apakah Anda Yakin Ingin Duplikat Data Ini ?",
            "on-copy-dialog-confirm",
            "on-copy-dialog-cancel",
            "Duplikat",
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
                'key' => 'id',
                'name' => 'No',
                'sortable' => true,
                'searchable' => false,
                'render' => function ($item, $index) {
                    $id = Crypt::encrypt($item->id);

                    $destroyHtml = "";
                    if ($this->isCanDelete) {
                        $destroyHtml = "<div class='col-auto'>
                            <button type='button' class='btn py-1 px-2 btn-sm btn-danger' wire:click=\"showDeleteDialog('$id')\">
                                Hapus
                            </button>
                        </div>";
                    }

                    $copyHtml = "";
                    if ($this->isCanCreate) {
                        $copyHtml = "<div class='col-auto'>
                            <button type='button' class='btn py-1 px-2 btn-sm btn-warning' wire:click=\"showCopyDialog('$id')\">
                                Copy
                            </button>
                        </div>";
                    }
                    // @click=\"\$dispatch('edit-data', { id: '" . $id . "' })\"
                    $editHtml = "";
                    if ($this->isCanUpdate) {
                        $editHtml = "<div class='col-auto' wire:key='datatable_row_main_" . $item['id'] . "'>
                            <button type='button' class='p-0 hover:bg-success/10 text-success rounded transition-colors'
                            
                                data-bs-toggle='collapse'
                                data-bs-target='#collapse-" . $item['id'] . "'
                                style='cursor: pointer;'
                                wire:click=\" editRow('" . simple_encrypt($item['id']) . "')\">
                                <span class='material-symbols-outlined text-lg' data-icon='edit_square'>edit_square</span>
                            </button>
                        </div>";
                    }

                    $html = "<div class='row p-0 m-0 d-flex d-inline flex-nowrap'>
                        
                        $destroyHtml 
                        $copyHtml 
                        $editHtml 
                        <h1>{$index}</h1>
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
            // [
            //     'key' => 'is_should_filled',
            //     'name' => 'Pengisian',
            //     'render' => function ($item) {
            //         return "<p class='btn btn-sm py-1 mb-0 btn-" . ($item->is_should_filled ? 'success' : 'danger') . "'>" . ($item->is_should_filled ? 'Sudah' : 'Belum') . "</p>";
            //     }
            // ],
            // [
            //     'key' => 'is_submitted',
            //     'name' => 'Submit',
            //     'render' => function ($item) {
            //         return "<p class='btn btn-sm py-1 mb-0 btn-" . ($item->is_submitted ? 'success' : 'danger') . "'>" . ($item->is_submitted ? 'Sudah' : 'Belum') . "</p>";
            //     }
            // ],
            [
                'key' => 'status',
                'name' => 'Status',
                'render' => function ($item) {
                    return "<p class='btn btn-sm py-1 mb-0' style='background-color:" . $item->statusColor() . "'>" . $item->status . "</p>";
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
                'key' => 'created_at',
                'name' => 'Tanggal Input',
                'render' => function ($item) {
                    return '<div class="text-nowrap">' . $item->created_at->format('Y-m-d H:i:s') . '</div>';
                }
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
                'key' => 'tanggal_pengajuan',
                'name' => 'Tanggal Pengajuan',
                'render' => function ($item) {
                    return $item->tanggal_pengajuan ? Carbon::parse($item->tanggal_pengajuan)->format('Y-m-d') : '-';
                }
            ],
            // [
            //     'key' => 'tanggal_cair',
            //     'name' => 'Tanggal Cair',
            //     'render' => function ($item) {
            //         return $item->tanggal_cair ? Carbon::parse($item->tanggal_cair)->format('Y-m-d') : '-';
            //     }
            // ],
            // [
            //     'key' => 'nominal_cair',
            //     'name' => 'Nominal Cair',
            //     'render' => function ($item) {
            //         return $item->nominal_cair ? number_format($item->nominal_cair, 0, ',', '.') : '-';
            //     }
            // ],
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
                'key' => 'nama_penerima',
                'name' => 'Nama Penerima',
            ],
            [
                'key' => 'hubungan_penerima',
                'name' => 'Hubungan Penerima',
            ],
            // [
            //     'key' => 'tahun_gensen',
            //     'name' => 'Tahun Gensen',
            // ],
            // [
            //     'key' => 'tahun_transfer',
            //     'name' => 'Tahun Transfer',
            // ],

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
                'key' => 'keterangan_mondai',
                'name' => 'Keterangan Mondai',
            ],
            [
                'searchable' => false,
                'key' => 'remarks_type',
                'name' => 'Asal Pembuatan',
                'render' => function ($item) {
                    return $item->remarks_type == User::class ? 'Manual PIC' : 'Link Pengisian Clien';
                }
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'Gensen',
                'render' => function ($item) {
                    $details = explode(';', $item->details);
                    $html = "";
                    foreach ($details as $index => $gensen) {
                        $html .= "<div class='text-nowrap'>{$gensen}</div>";
                    }
                    return $html;
                }
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'Tanggungan Keluarga',
                'render' => function ($item) {

                    $total_amounts = explode(';', $item->remittance_total_amounts);
                    $receiver_names = explode(';', $item->remittance_receiver_names);
                    $receiver_years = explode(';', $item->remittance_receiver_years);

                    $html = "";
                    foreach ($total_amounts as $index => $amount) {
                        $html .= "<div class='text-nowrap'> " . toReiwaYear($receiver_years[$index]) . " - " . $amount . " - {$receiver_names[$index]}</div>";
                    }
                    return $html;
                }
            ],
            [
                'sortable' => false,
                'searchable' => false,
                'name' => 'Gensen Cair',
                'render' => function ($item) {
                    $cair_details = explode(';', $item->cair_details);
                    $html = "";
                    foreach ($cair_details as $index => $gensen) {
                        $html .= "<div class='text-nowrap'>{$gensen}</div>";
                    }
                    return $html;
                }
            ],
            [
                'key' => 'pic_code',
                'name' => 'Kode PIC',
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
            consoleLog($this, $this->editingData['status']);
            $validatedData = [
                'status' => $this->editingData['status'],
                'nama_lengkap' => $this->editingData['nama_lengkap'],
                'tanggal_lahir' => $this->editingData['tanggal_lahir'],
                'email' => $this->editingData['email'],
                'tanggal_lengkap' => $this->editingData['tanggal_lengkap'] ? $this->editingData['tanggal_lengkap'] : null,
                'tanggal_verified' => $this->editingData['tanggal_verified'] ? $this->editingData['tanggal_verified'] : null,
                'no_input_jepang' => $this->editingData['no_input_jepang'],
                'tanggal_pengajuan' => $this->editingData['tanggal_pengajuan'] ? $this->editingData['tanggal_pengajuan'] : null,
                'tanggal_cair' => $this->editingData['tanggal_cair'] ? $this->editingData['tanggal_cair'] : null,
                'nominal_cair' => imaskToValue($this->editingData['nominal_cair']),
                'nominal_gensen' => imaskToValue($this->editingData['nominal_gensen']),
                // 'jumlah_kirim_uang' => imaskToValue($this->editingData['jumlah_kirim_uang']),
                'tanggal_kepulangan' => $this->editingData['tanggal_kepulangan'] ? $this->editingData['tanggal_kepulangan'] : null,
                // REK PENERIMA
                'no_rekening_penerima' => $this->editingData['no_rekening_penerima'],
                'nama_bank_penerima' => $this->editingData['nama_bank_penerima'],
                'nama_penerima' => $this->editingData['nama_penerima'],
                'hubungan_penerima' => $this->editingData['hubungan_penerima'],
                // 'status' => $this->editingData['status'],
                'tahun_gensen' => $this->editingData['tahun_gensen'],
                'tahun_transfer' => $this->editingData['tahun_transfer'],
                'nama_instagram' => $this->editingData['nama_instagram'],
                'nama_tiktok' => $this->editingData['nama_tiktok'],
                'nomor_whatsapp' => $this->editingData['nomor_whatsapp'],
                'nomor_whatsapp_darurat' => $this->editingData['nomor_whatsapp_darurat'],
                'alamat_jepang' => $this->editingData['alamat_jepang'],
                'kode_pos_jepang' => $this->editingData['kode_pos_jepang'],
                'nama_lpk' => $this->editingData['nama_lpk'],
                'keterangan_mondai' => $this->editingData['keterangan_mondai'],
            ];
            GensenFormRepository::update($this->editingRowId, $validatedData);

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
                        $query->orWhere($col['key'], 'ILIKE', "%$search%");
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

        $this->editingRowId = simple_decrypt($id);

        $this->editingData = [
            'id' => Crypt::encrypt($row['id']),
            'status' => $row['status'],
            'nama_lengkap' => $row['nama_lengkap'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'email' => $row['email'],
            'tanggal_lengkap' => $row['tanggal_lengkap'] ? Carbon::parse($row['tanggal_lengkap'])->format('Y-m-d') : null,
            'tanggal_verified' => $row['tanggal_verified'] ? Carbon::parse($row['tanggal_verified'])->format('Y-m-d') : null,
            'no_input_jepang' => $row['no_input_jepang'],
            'tanggal_pengajuan' => $row['tanggal_pengajuan'] ? Carbon::parse($row['tanggal_pengajuan'])->format('Y-m-d') : null,
            'tanggal_cair' => $row['tanggal_cair'] ? Carbon::parse($row['tanggal_cair'])->format('Y-m-d') : null,
            'nominal_cair' => valueToImask($row['nominal_cair']),
            'created_at' => $row['created_at'] ? Carbon::parse($row['created_at'])->format('Y-m-d') : null,
            'nominal_gensen' => valueToImask($row['nominal_gensen']),
            // 'jumlah_kirim_uang' => valueToImask($row['jumlah_kirim_uang']),
            'tanggal_kepulangan' => $row['tanggal_kepulangan'] ? Carbon::parse($row['tanggal_kepulangan'])->format('Y-m-d') : null,
            // REK PENERIMA
            'no_rekening_penerima' => $row['no_rekening_penerima'],
            'nama_bank_penerima' => $row['nama_bank_penerima'],
            'nama_penerima' => $row['nama_penerima'],
            'hubungan_penerima' => $row['hubungan_penerima'],
            // 'status' => $row['status'],
            'tahun_gensen' => $row['tahun_gensen'],
            'tahun_transfer' => $row['tahun_transfer'],
            'pic_code' => $row['pic_code'],
            'nama_instagram' => $row['nama_instagram'],
            'nama_tiktok' => $row['nama_tiktok'],
            'nomor_whatsapp' => $row['nomor_whatsapp'],
            'nomor_whatsapp_darurat' => $row['nomor_whatsapp_darurat'],
            'alamat_jepang' => $row['alamat_jepang'],
            'kode_pos_jepang' => $row['kode_pos_jepang'],
            'nama_lpk' => $row['nama_lpk'],
            'remarks_type' => $row['remarks_type'] == User::class ? 'Manual PIC' : 'Link Pengisian Clien',
            'keterangan_mondai' => $row['keterangan_mondai'],

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
