<div>

    <form wire:submit.prevent="store">
        
    <div wire:loading wire:target="images, store, file_ichijikin"
     class="position-fixed top-0 start-0 w-100 h-100 
            bg-dark bg-opacity-50 
            justify-content-center align-items-center"
     style="z-index:9999;">

        <div class="bg-white p-4 rounded shadow">
            <p class="text-dark" style="font-size: 1.5rem; width: 100%; text-align: center;"> 
                <i class="text-dark animate-wand fas fa-wand-magic-sparkles text-dark"></i> &nbsp; Sedang Memproses
            </p>
        </div>
    </div>
        @if ($objId)

            <div class="row d-flex flex-col justify-content-center align-items-center">
                <div class="col-md-6 mb-3">
                    <label>Nama Batch</label>
                    <input placeholder="Nama Batch" type="text" value="{{$batch_name}}" class="form-control" readonly>
                </div>
                
                <div class="col-md-6">
                    <button
                        type="button"
                        class="btn btn-success btn-sm"
                        x-data
                        @click="$dispatch('export', { type: '{{ App\Helpers\ExportHelper::TYPE_EXCEL }}' })">
                        <i class="fa fa-file-excel"></i>
                        Download
                    </button>
                </div>
            </div>
            <div class="row">
                <livewire:ichijikin-extraction.datatable-batch-detail :objId="$objId" />
            </div>
        @else
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 mb-3">
                    <label>Email Label</label>
                    <input placeholder="Email Label" type="text" wire:model="label" class="form-control" required>

                    @error('label')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nama Bank</label>
                    <select class="form-control" wire:model="bank" required>
                        <option value="">Pilih Bank</option>
                        @foreach (App\Models\ResiGenerator\ResiGenerator::BANK_CHOICE as $value => $name)
                            <option value="{{ $value }}">{{$name}}</option>
                        @endforeach
                    </select>

                    @error('bank')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary mt-3">
                Save
            </button>
        @endif

    </form>

</div>

@push('css')
    <style>
        @keyframes pulse-wand {
            0%   { transform: scale(1);   opacity: 1; }
            50%  { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1);   opacity: 1; }
        }

        .animate-wand {
            animation: pulse-wand 1s infinite ease-in-out;
        }
    </style>
@endpush