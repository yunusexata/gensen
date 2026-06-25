    {{-- Import Pipeline Modal --}}
    <div class="modal fade" id="exportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        wire:ignore.self>
        <div class="modal-dialog modal-md" style="overflow: scroll">
            <div class="modal-content" style="overflow: scroll">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeExportModal"></button>
                </div>
                <form wire:submit.prevent="submitExport">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="form-label">Tanggal Dari</label>
                            <input type="date" class="form-control" wire:model="filter_tanggal_input_dari"  />
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Tanggal Sampai</label>
                            <input type="date" class="form-control" wire:model="filter_tanggal_input_sampai"  />
                        </div>
                        <div class="row mb-3">
                            <label>PIC</label><br>
                            <select wire:model="filter_pic" class="form-select">
                                <option value="">-- SEMUA --</option>
                                @foreach (App\Models\GensenForm\GensenForm::PIC_CHOICE as $key => $name)
                                    <option value="{{$name}}">{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeExportModal">Tutup</button>
                        
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target='submitExport'>Simpan</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            Livewire.on('onSuccessExportModal', () => {
            $('#exportModal').modal('hide');
        })
        </script>
    @endpush