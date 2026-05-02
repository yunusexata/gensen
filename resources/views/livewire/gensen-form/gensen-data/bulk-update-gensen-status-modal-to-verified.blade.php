    {{-- Import Pipeline Modal --}}
    <div class="modal" id="bulkUpdateGensenStatusModalToVerified" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        wire:ignore.self>
        <div class="modal-dialog modal-fullscreen custom-zoom" style="overflow: scroll">
            <div class="modal-content" style="overflow: scroll">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkUpdateGensenStatusModalToVerifiedLabel">Import List Data Verified</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closebulkUpdateGensenStatusModalToVerified"></button>
                </div>
                <form wire:submit.prevent="storeImportBulkStatus">
                    <div class="modal-body import_modal">
                        <div class="form-group mb-2">
                            <label>File Import Excel</label>
                            <input type="file" wire:model="inputFileBulkStatus" class="form-control" id="inputFileBulkStatus"
                                accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            @error('input_file')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            @if($previewBulkStatusRows)
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="imported-bulk-status" data-bs-toggle="tab" data-bs-target="#imported-bulk-status-pane" type="button" role="tab" aria-controls="imported-bulk-status-pane" aria-selected="true">Imported</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="invalid-bulk-status" data-bs-toggle="tab" data-bs-target="#invalid-bulk-status-pane" type="button" role="tab" aria-controls="invalid-bulk-status-pane" aria-selected="false">Invalid ({{count($errorBulkStatusRows)}})</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="imported-bulk-status-pane" role="tabpanel" aria-labelledby="imported" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID Customer</th>
                                                    <th>Nama</th>
                                                    <th>Tanggal Lengkap</th>
                                                    <th>Tanggal Verified</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach($previewBulkStatusRows as $i => $row)
                                                    @if (!$row['error'])
                                                        <tr>
                                                        {{-- <tr class="{{ count($row['error']) ? '--kt-gray-100' : '' }}"> --}}
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $row['data']['id_customer'] }}</td>
                                                                <td>{{ $row['data']['nama_lengkap'] }}</td>
                                                                <td>{{ $row['data']['tanggal_lengkap'] }}</td>
                                                                <td>{{ $row['data']['tanggal_verified'] }}</td>
                                                                
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="invalid-bulk-status-pane" role="tabpanel" aria-labelledby="invalid" tabindex="0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID Customer</th>
                                                    <th>Nama</th>
                                                    <th>Tanggal Lengkap</th>
                                                    <th>Tanggal Verified</th>
                                                    <th>Pesan Error System</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no_error = 1;
                                                @endphp
                                                @foreach($previewBulkStatusRows as $i => $row)
                                                    @if ($row['error'])
                                                        <tr>
                                                        {{-- <tr class="{{ count($row['error']) ? '--kt-gray-100' : '' }}"> --}}
                                                                <td>{{ $no_error++ }}</td>
                                                                <td>{{ $row['data']['id_customer'] }}</td>
                                                                <td>{{ $row['data']['nama_lengkap'] }}</td>
                                                                <td>{{ $row['data']['tanggal_lengkap'] }}</td>
                                                                <td>{{ $row['data']['tanggal_verified'] }}</td>
                                                            <td>
                                                                @foreach($row['error'] as $field => $msg)
                                                                    <div>{{ json_encode($msg) }}</div>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closebulkUpdateGensenStatusModalToVerified">Tutup</button>
                        
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target='inputFileBulkStatus'>Simpan</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            Livewire.on('onSuccessImportBulkStatusDataToVerified', () => {
            $('#bulkUpdateGensenStatusModalToVerified').modal('hide');
            $('#inputFileBulkStatus').val(null);
        })
        </script>
    @endpush