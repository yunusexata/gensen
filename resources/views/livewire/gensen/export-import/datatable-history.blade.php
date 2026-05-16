<div>
    <div class="row justify-content-between mb-3">
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

        <div class="table-responsive">
            <table class="table table-bordered text-nowrap w-100 h-100 w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/50">
                        @foreach ($columns as $index => $col)
                            <th class="px-4 py-3 text-[11px] font-label font-bold tracking-widest text-on-surface-variant" wire:key='datatable_header_{{ $index }}'>
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
                    @foreach ($data as $index => $item)
                        <tr wire:key='datatable_row_{{ $index }}'
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
                    @endforeach
                </tbody>
            </table>
        </div>
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
    </style>
@endpush

@push('js')
@endpush