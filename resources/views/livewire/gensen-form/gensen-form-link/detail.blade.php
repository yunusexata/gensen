<div>

    <form wire:submit.prevent="store">
        
    <div wire:loading wire:target="images, store"
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
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Expired Pada</label>
                <input placeholder="Expired Pada" type="datetime-local" wire:model="expired_at" class="form-control" disabled>

                @error('expired_at')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input placeholder="Password" type="text" wire:model="password" class="form-control" disabled>

                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Jumlah Penggunaan</label>
                <input placeholder="max_usage" type="number" wire:model="max_usage" class="form-control">

                @error('max_usage')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama</label>
                <input placeholder="Nama" type="text" wire:model="name" class="form-control">

                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            @if ($user)
                <div class="col-md-6 mb-3">
                    <label>Pembuat</label>
                    <p class="form-control">{{$user['name']}}</p>

                </div>
                <div class="col-md-6 mb-3">
                    <label>Link</label>
                    <p class="form-control">{{$link}}</p>
                </div>
            @endif
        </div>
        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary mt-3">
            Save
        </button>
        @if ($objId)
            <button type="button" class='btn btn-success mt-3'
                onclick="copyToClipboard('{{$link}}')"
            >
            Copy Link
            </button>
            <div class="row mt-3">
                <livewire:gensen-form.gensen-data.datatable :gensenFormLinkId="$objId">
            </div>
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