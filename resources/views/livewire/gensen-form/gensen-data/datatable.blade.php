<div>
    <div class="row">
        {{-- <div class="col-auto">
            <button
                class="btn btn-success btn-sm"
                x-data
                @click="$dispatch('export', { type: '{{ App\Helpers\ExportHelper::TYPE_EXCEL }}' })">
                <i class="fa fa-file-excel"></i>
                Download
            </button>
        </div>
        <div class="col-auto">
            <button
                class="btn btn-success btn-sm"
                x-data
                @click="$dispatch('export_ready_verified', { type: '{{ App\Helpers\ExportHelper::TYPE_EXCEL }}' })">
                <i class="fa fa-file-excel"></i>
                Download Siap verifikasi
            </button>
        </div> --}}
        {{-- <div class="col-auto" wire:ignore>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bulkUpdateGensenStatusModalToLengkap">
                <i class="fa fa-upload"></i>
                Import
            </button>
        </div>
        <div class="col-auto" wire:ignore>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#bulkUpdateGensenStatusModalToVerified">
                <i class="fa fa-upload"></i>
                Import
            </button>
        </div> --}}
    </div>
    <div class="row mt-3">
        <div class="col-auto mb-0">
            <label>Status</label><br>
            <select wire:model.live="filter_status" class="form-select">
                <option value="">-- ISI --</option>
                @foreach (App\Models\GensenForm\GensenForm::STATUS_CHOICE as $key => $name)
                    <option value="{{$name}}">{{$name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto mb-0">
            <label>PIC</label><br>
            <select wire:model.live="filter_pic" class="form-select">
                <option value="">-- SEMUA --</option>
                @foreach (App\Models\GensenForm\GensenForm::PIC_CHOICE as $key => $name)
                    <option value="{{$name}}">{{$name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto mb-0 row">
            <div class="col-auto mb-0"  style="scale: 1;">
                <label class="form-label mb-0">Tanggal Input Dari</label>
                <input type="date" class="form-control" wire:model.live="filter_tanggal_input_dari"  />
            </div>
            <div class="col-auto mb-0"  style="scale: 1;">
                <label class="form-label mb-0">Tanggal Input Sampai</label>
                <input type="date" class="form-control" wire:model.live="filter_tanggal_input_sampai"  />
            </div>
        </div>
        <div class="col-auto mb-0 row">
            <div class="col-auto mb-0"  style="scale: 1;">
                <label class="form-label mb-0">Tanggal Kepulangan Dari</label>
                <input type="date" class="form-control" wire:model.live="filter_tanggal_kepulangan_dari"  />
            </div>
            <div class="col-auto mb-0"  style="scale: 1;">
                <label class="form-label mb-0">Tanggal Kepulangan Sampai</label>
                <input type="date" class="form-control" wire:model.live="filter_tanggal_kepulangan_sampai"  />
            </div>
        </div>
    </div>
    <div class="d-flex flex-nowrap gap-1 mb-2 d-none">
        <span class="w-6 h-6 flex items-center justify-center rounded-full text-[10px] font-bold"
        data-bs-toggle="tooltip"
            title="">
        </span>
    </div>
    <div class="row justify-content-between mb-3 mt-3">
        <div class="col-auto mb-2 {{ !isset($show_filter) || $show_filter == true ? '' : 'd-none' }}">
            <label>Show</label>
            <select wire:model.live.change="length" class="form-select">
                @foreach ($lengthOptions as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6 mb-2 {{ !isset($keyword_filter) || $keyword_filter == true ? '' : 'd-none' }}">
            <label>Kata Kunci</label>
            <input wire:model.live.debounce.500ms="search" type="text" class="form-control">
        </div>
    </div>

    <div class="position-relative">
        <div wire:loading>
            <div class="position-absolute w-100 h-100">
                <div class="w-100 h-100" style="background-color: grey; opacity:0.2"></div>
            </div>
            <h5 class="position-absolute shadow bg-white p-2 rounded"
                style="top: 50%;left: 50%;transform: translate(-50%, -50%);">Loading...</h5>
        </div>
       

        {{-- <div class="table-responsive max-h-[80vh] overflow-y-auto">
            <table class="table table-bordered text-nowrap text-left border-collapse min-w-full">
                <thead class="sticky top-0 bg-white z-10">
                    <tr class="bg-surface-container-low/50"> --}}
        <div class="table-responsive" style="max-height:80vh; overflow:auto;" id="tableWrapper">
            <table class="table-default table table-row-bordered table-bordered" style="max-height:80vh;">
                <thead class="sticky-top bg-white">
                    <tr class="bg-surface-container-low/50">
                        @foreach ($columns as $index => $col)
                            <th class="px-4 py-3 text-[11px] font-label font-bold tracking-widest text-on-surface-variant text-nowrap text-center" wire:key='datatable_header_{{ $index }}'>
                                @if (!isset($col['sortable']) || $col['sortable'])
                                    @php $isSortAscending = $col['key'] == $sortBy && $sortDirection == 'asc'@endphp
                                    <button type="button" class='btn p-0 m-0'
                                        wire:click="datatableSort('{{ $col['key'] }}')">
                                        <div class="fw-bold align-items-center d-flex">
                                            <div class='pe-2'>
                                                {{ $col['name'] }}
                                            </div>
                                            <div class="d-flex flex-column">
                                                <i
                                                    class="ki-duotone ki-up fs-4 m-0 p-0
                                {{ $isSortAscending ? 'text-dark' : 'text-secondary' }}"></i>
                                                <i
                                                    class="ki-duotone ki-down fs-4 m-0 p-0
                                {{ $isSortAscending ? 'text-secondary' : 'text-dark' }}"></i>
                                            </div>
                                        </div>
                                    </button>
                                @else
                                    <div class="fs-6 p-2">
                                        {{ $col['name'] }}
                                    </div>
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-variant/20">
                    {{-- @for ($i = 0; $i < 15; $i++) --}}
                        
                        @foreach ($data as $index => $item)
                            <tr wire:key='datatable_row_{{ $item['id'] }}'
                                class="hover:bg-surface-container-low transition-colors group">
                                @foreach ($columns as $col)
                                    @php
                                        $cell_style = '';
                                        if (isset($col['style'])) {
                                            $cell_style = is_callable($col['style'])
                                                ? call_user_func($col['style'], $item, $loop->parent->iteration )
                                                : $col['style'];
                                            $cell_style = "{$cell_class}";
                                        }

                                        $cell_class = '';
                                        if (isset($col['class'])) {
                                            $cell_class = is_callable($col['class'])
                                                ? call_user_func($col['class'], $item, $loop->parent->iteration )
                                                : $col['class'];
                                            $cell_class = "{$cell_class}";
                                        }
                                    @endphp

                                    @if (isset($col['render']) && is_callable($col['render']))
                                        <td class="px-4 py-2 {!! $cell_class !!}" style="{!! $cell_style !!}">
                                            {!! call_user_func($col['render'], $item, $loop->parent->iteration ) !!}
                                        </td>
                                    @elseif (isset($col['key']))
                                        <td class="px-4 py-2 {!! $cell_class !!}" style="{!! $cell_style !!}">
                                            {{ $item->{$col['key']} }}
                                        </td>
                                    @endif
                                
                                @endforeach
                            </tr>

                            <tr wire:key="data-collapse-{{$item['id']}}"
                            class="hover:bg-surface-container-low transition-colors group">
                                <td colspan="10" class="p-0 border-0">

                                    <div id="collapse-{{ $item['id'] }}" class="collapse" wire:ignore.self>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap w-100 m-0 p-0">
                                                <tbody>
                                                    @if ($editingRowId && $editingRowId == $item['id'])
                                                        
                                                        {{-- First Row --}}
                                                        <tr>
                                                            @if (Auth::user()->hasRole(App\Models\User::ROLE_SUPER_ADMIN))
                                                                <td>
                                                                    <label for="">status</label>
                                                                    <div class="d-flex align-items-center">
                                                                        <select class="form-control" wire:model.defer="editingData.status">
                                                                            <option value="">-- ISI --</option>
                                                                            @foreach (App\Models\GensenForm\GensenForm::STATUS_CHOICE as $status)
                                                                                <option value="{{$status}}">{{$status}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <label for="">Tanggal Lengkap</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="date"
                                                                        class="form-control"

                                                                        wire:model.defer="editingData.tanggal_lengkap"

                                                                        @cannot(
                                                                            PermissionHelper::transform(
                                                                                PermissionHelper::UPDATE_GENSEN_TANGGAL_LENGKAP,
                                                                                PermissionHelper::TYPE_UPDATE
                                                                            )
                                                                        )
                                                                            readonly
                                                                        @endcannot
                                                                    > 
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Tanggal Verified</label>
                                                                <div class="d-flex align-items-center">
                                                                   <input
                                                                        type="date"
                                                                        class="form-control"

                                                                        wire:model.defer="editingData.tanggal_verified"

                                                                        @cannot(
                                                                            PermissionHelper::transform(
                                                                                PermissionHelper::UPDATE_GENSEN_TANGGAL_VERIFIED,
                                                                                PermissionHelper::TYPE_UPDATE
                                                                            )
                                                                        )
                                                                            readonly
                                                                        @endcannot
                                                                    > 
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Tanggal Pengajuan</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="date"
                                                                        class="form-control"

                                                                        wire:model.defer="editingData.tanggal_pengajuan"

                                                                        @cannot(
                                                                            PermissionHelper::transform(
                                                                                PermissionHelper::UPDATE_GENSEN_TANGGAL_PENGAJUAN,
                                                                                PermissionHelper::TYPE_UPDATE
                                                                            )
                                                                        )
                                                                            readonly
                                                                        @endcannot
                                                                    > 
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">No Input Jepang</label>
                                                                <div class="d-flex align-items-center col-auto">
                                                                    <input
                                                                        type="date"
                                                                        class="form-control"

                                                                        wire:model.defer="editingData.no_input_jepang"

                                                                        @cannot(
                                                                            PermissionHelper::transform(
                                                                                PermissionHelper::UPDATE_GENSEN_NO_INPUT_JEPANG,
                                                                                PermissionHelper::TYPE_UPDATE
                                                                            )
                                                                        )
                                                                            readonly
                                                                        @endcannot
                                                                    > 
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Instagram</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.nama_instagram"
                                                                        @else
                                                                        value="{{ $editingData['nama_instagram'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Tiktok</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.nama_tiktok"
                                                                        @else
                                                                        value="{{ $editingData['nama_tiktok'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Nomor Whatsapp</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.nomor_whatsapp"
                                                                        @else
                                                                        value="{{ $editingData['nomor_whatsapp'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Nomor Whatsapp Darurat</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.nomor_whatsapp_darurat"
                                                                        @else
                                                                        value="{{ $editingData['nomor_whatsapp_darurat'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Email</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control w-[200px]" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.email"
                                                                        @else
                                                                        value="{{ $editingData['email'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        {{-- Second Row --}}
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="row d-flex flex-nowrap gap-2 justify-content-center">
                                                                    
                                                                    @if ($this->isCanCreate)
                                                                        <div class='col-auto m-0 p-0'>
                                                                            <button type='button' class='btn btn-sm btn-warning' wire:click="showCopyDialog('{{ $editingData['id'] }}')">
                                                                               <span class='material-symbols-outlined text-sm' data-icon='save_as'>save_as</span> Copy
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    @if ($this->isCanUpdate)
                                                                        <div class="col-auto m-0 p-0">
                                                                            <a href="{{route('gensen_data.attachment', ['id' => $editingData['id']])}}"
                                                                                class="btn btn-primary btn-sm m-0">
                                                                                <i class="ki-duotone ki-cube-2 text-sm">
                                                                                <span class="path1"></span>
                                                                                <span class="path2"></span>
                                                                                <span class="path3"></span>
                                                                                <span class="path4"></span>
                                                                                <span class="path5"></span>
                                                                                </i>
                                                                                Lampiran
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    @if ($this->isCanUpdate)
                                                                        <div class="col-auto m-0 p-0">
                                                                            <button onclick="copyToClipboard('{{route('gensen_form.upload_attachment', ['id' => $editingData['id']])}}')"
                                                                                type="button" class="btn btn-info btn-sm m-0">
                                                                                <i class="ki-duotone ki-fasten text-sm">
                                                                                    <span class="path1"></span>
                                                                                    <span class="path2"></span>
                                                                                </i>
                                                                                Link upload
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                </div>
                                                                <div class="row d-flex flex-nowrap gap-2 justify-content-center mt-2">
                                                                    @if ($this->isCanUpdate)
                                                                        <div class="col-auto m-0 p-0">
                                                                            <button type="button" class="btn btn-success btn-sm m-0" wire:click="saveEditedRow">
                                                                            <i class="ki-duotone ki-check text-sm">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                            <span class="path5"></span>
                                                                            </i>
                                                                            Simpan
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                    @if ($this->isCanDelete)
                                                                        <div class='col-auto m-0 p-0'>
                                                                            <button type='button' class='btn btn-sm btn-danger' wire:click="showDeleteDialog('{{$editingData['id']}}')">
                                                                                <span class='material-symbols-outlined text-sm' data-icon='delete'>delete</span> Hapus
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label>Nama Lengkap</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.nama_lengkap"
                                                                        @else
                                                                        value="{{ $editingData['nama_lengkap'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Tanggal Lahir</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="date" class="form-control" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.tanggal_lahir"
                                                                        @else
                                                                        value="{{ $editingData['tanggal_lahir'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">No Rekening Penerima</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control w-[200px]" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.no_rekening_penerima"
                                                                        @else
                                                                        value="{{ $editingData['no_rekening_penerima'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Nama Bank Penerima</label>
                                                                <div class="d-flex align-items-center">
                                                                    <select
                                                                        id="nama_bank_penerima"
                                                                        
                                                                        wire:model.defer="editingData.nama_bank_penerima"
                                                                        @if (!$this->isCanUpdate)
                                                                        readonly
                                                                        disabled
                                                                        @disabled(true)
                                                                        @endif
                                                                        name="nama_bank_penerima"
                                                                        class="form-control"
                                                                    >
                                                                        <option value="">-- ISI --</option>
                                                                        @foreach (App\Enums\Gensen\GensenBank::options() as $item)
                                                                            <option value="{{$item}}">{{$item}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Nama Penerima</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control w-[200px]" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.nama_penerima"
                                                                        @else
                                                                        value="{{ $editingData['nama_penerima'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">Hubungan Penerima</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" 
                                                                        @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.hubungan_penerima"
                                                                        @else
                                                                        value="{{ $editingData['hubungan_penerima'] }}"
                                                                        readonly
                                                                        @endif
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td colspan="5">

                                                                <label for="">Keterangan</label>
                                                                <div class="d-flex align-items-center">
                                                                    <textarea class="form-control w-[400px]" cols="30" rows="5"
                                                                    placeholder="Keterangan"
                                                                    @if ($this->isCanUpdate)
                                                                        wire:model.defer="editingData.keterangan"
                                                                    @else
                                                                        value="{{ $editingData['keterangan'] }}"
                                                                        readonly
                                                                    @endif
                                                                    ></textarea>
                                                                    
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </td>
                                <td colspan="100"></td>
                            </tr>
                            
                        @endforeach
                        @if ($data->hasMorePages())
                                <tr>
                                    <td colspan="999">
                                        <div
                                            x-data
                                            x-intersect.margin.300px="$wire.loadMore()"
                                            class="py-6 text-center"
                                        >
                                            Loading more...
                                        </div>
                                    </td>
                                </tr>
                            @endif
                    {{-- @endfor --}}
                </tbody>
            </table>
            {{-- <div class="position-relative">
                <div class="position-absolute">
                    @if ($hasMore)
                        <div
                            x-data
                            x-intersect.full="$wire.loadMore()"
                            class="py-6 text-center border border-danger w-[60vw]"
                        >
                            Loading more...
                        </div>
                    @endif
                </div>
            </div> --}}


        </div>
        <div class="row d-flex justify-content-between mt-5">
            <!-- LEFT BUTTON -->
            <div class="col-auto position-relative">
                <button id="scrollLeft"
                    class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary start-0 shadow">
                    ←
                </button>
            </div>
            <!-- RIGHT BUTTON -->
            <div class="col-auto position-relative">
                <button id="scrollRight"
                    class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary end-0 shadow">
                    →
                </button>
            </div>
        </div>
    </div>
</div>


@push('css')
    <style>
        td:has(.form-control) {
            /* width: 100px; */
        }
        .collapse:not(table) {
            visibility: visible !important;
        }
        .card-body {
            overflow: visible !important;
        }
    </style>
@endpush

@include('js.imask')

@push('js')
    <script>
    const wrapper = document.getElementById('tableWrapper');

    document.getElementById('scrollLeft')
        .addEventListener('click', () => {
            wrapper.scrollTo({
                left: 0,
                behavior: 'smooth'
            });
        });

    document.getElementById('scrollRight')
        .addEventListener('click', () => {
            wrapper.scrollTo({
                left: wrapper.scrollWidth,
                behavior: 'smooth'
            });
        });
    </script>
@endpush