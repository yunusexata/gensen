<div>
    <div class="row">
        <div class="col-auto">
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
        </div>
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
            <input wire:model.live.debounce.300ms="search" type="text" class="form-control">
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
        <div class="table-responsive" style="max-height:80vh; overflow:auto;">
            <table class="table table-row-bordered table-bordered" style="max-height:80vh;">
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
                                                ? call_user_func($col['style'], $item, $index)
                                                : $col['style'];
                                            $cell_style = "style='{$cell_class}'";
                                        }

                                        $cell_class = '';
                                        if (isset($col['class'])) {
                                            $cell_class = is_callable($col['class'])
                                                ? call_user_func($col['class'], $item, $index)
                                                : $col['class'];
                                            $cell_class = "class='{$cell_class}'";
                                        }
                                    @endphp

                                    @if (isset($col['render']) && is_callable($col['render']))
                                        <td class="px-4 py-2 {!! $cell_class !!}" style="{!! $cell_style !!}">
                                            {!! call_user_func($col['render'], $item) !!}
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
                                <td colspan="100" class="p-0 border-0">

                                    <div id="collapse-{{ $item['id'] }}" class="collapse" wire:ignore.self>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap w-100 m-0 p-0">
                                                <tbody>
                                                    @if ($editingRowId && $editingRowId == $item['id'])
                                                        <tr>
                                                            <td class="w-[350px] ">
                                                                <div class="row d-flex flex-nowrap gap-2 ">
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
                                                                </div>
                                                            </td>
                                                            <td class="w-[350px]">
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
                                                            <td class="w-[300px]">
                                                                <label>nama lengkap</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.nama_lengkap"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">tanggal lahir</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="date" class="form-control" wire:model.defer="editingData.tanggal_lahir"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">email</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="email" class="form-control" wire:model.defer="editingData.email"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">nominal gensen</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control currency" max="999999999999999" wire:model.defer="editingData.nominal_gensen"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">jumlah kirim uang</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control currency" max="999999999999999" wire:model.defer="editingData.jumlah_kirim_uang"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">tanggal lengkap</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="date" class="form-control" wire:model.defer="editingData.tanggal_lengkap"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">tanggal verified</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="date" class="form-control" wire:model.defer="editingData.tanggal_verified"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">no input Jepang</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.no_input_jepang"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">tanggal cair</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="date" class="form-control" wire:model.defer="editingData.tanggal_cair"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">nominal cair</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control currency" max="999999999999999" wire:model.defer="editingData.nominal_cair"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td class="">
                                                                <label class="truncate block" for="">Tanggal input</label>
                                                                <input
                                                                    type="text" 
                                                                    class="form-control w-[130px] py-3"  
                                                                    value="{{$editingData['created_at']}}"
                                                                    readonly
                                                                />
                                                            </td>
                                                            <td>
                                                                <label for="">tanggal kepulangan</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="date" class="form-control" wire:model.defer="editingData.tanggal_kepulangan"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">no rekening penerima</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control w-[200px]" wire:model.defer="editingData.no_rekening_penerima"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">nama bank penerima</label>
                                                                <div class="d-flex align-items-center">
                                                                    <select
                                                                        id="nama_bank_penerima"
                                                                        wire:model.defer="editingData.nama_bank_penerima"
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
                                                                <label for="">nama penerima</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control w-[200px]" wire:model.defer="editingData.nama_penerima"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">hubungan penerima</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.hubungan_penerima"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">tahun gensen</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="number" class="form-control" wire:model.defer="editingData.tahun_gensen"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">tahun transfer</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="number" class="form-control" wire:model.defer="editingData.tahun_transfer"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">kode PIC</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" value="{{$editingData['pic_code']}}" readonly
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">nama instagram</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.nama_instagram"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">nama tiktok</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.nama_tiktok"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">nomor whatsapp</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.nomor_whatsapp"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">nomor whatsapp darurat</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.nomor_whatsapp_darurat"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">alamat jepang</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.alamat_jepang"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">kode pos jepang</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.kode_pos_jepang"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">nama lpk/so/pt</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.nama_lpk"
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">asal pembuatan</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" value="{{$editingData['remarks_type']}}" readonly
                                                                    />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <label for="">keterangan mondai</label>
                                                                <div class="d-flex align-items-center">
                                                                    <input
                                                                        type="text" class="form-control" wire:model.defer="editingData.keterangan_mondai"
                                                                    />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    {{-- <tr>
                                                        <td colspan="100">
                                                            {{route('gensen_form.upload_attachment', ['id' => $editedRows[$item['id']]['id']])}}
                                                        </td>
                                                    </tr> --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    {{-- @endfor --}}
                </tbody>
            </table>
        </div>
        

    <div class="row justify-content-end mt-3">
        <div class="col">
            <em>Total Data: {{ $data->total() }}</em>
        </div>
        <div class="col-auto">
            {{ $data->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>


@push('css')
    <style>
        
        .collapse:not(table) {
            visibility: visible !important;
        }
        .card-body {
            overflow: visible !important;
        }
    </style>
@endpush

@include('js.imask')