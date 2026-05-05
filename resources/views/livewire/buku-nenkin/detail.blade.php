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
                <label>Nama</label>
                <input placeholder="Nama" type="text" wire:model="nama" class="form-control">

                @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Lahir</label>
                <input placeholder="Tanggal Lahir" type="date" wire:model="tanggal_lahir" class="form-control">

                @error('tanggal_lahir')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Alamat Tinggal di Jepang</label>
                <input placeholder="Alamat Tinggal di Jepang" type="text" wire:model="alamat_jepang" class="form-control">

                @error('alamat_jepang')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Kepulangan</label>
                <input placeholder="Tanggal Kepulangan" type="date" wire:model="tanggal_kepulangan" class="form-control">

                @error('tanggal_kepulangan')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @foreach ($companies as $index => $company)
        <h2 class="fw-bold text-xl">Data Perusahaan {{$loop->iteration}}</h2>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Perusahaan</label>
                    <input placeholder="Nama Perusahaan" type="text" wire:model="companies.{{$index}}.nama_perusahaan" class="form-control">

                </div>
                <div class="col-md-6 mb-3">
                    <label>Alamat Perusahaan</label>
                    <input placeholder="Alamat Perusahaan" type="text" wire:model="companies.{{$index}}.alamat_perusahaan" class="form-control">

                </div>
                <div class="col-md-6 mb-3">
                    <label>Nomor Telepon</label>
                    <input placeholder="Nomor Telepon" type="text" wire:model="companies.{{$index}}.no_telp" class="form-control">

                </div>
                <div class="col-md-6 mb-3">
                    <label>Tanggal Kerja Awal</label>
                    <input placeholder="Tanggal Kerja Awal" type="date" wire:model="companies.{{$index}}.tanggal_kerja_awal" class="form-control">

                </div>
                <div class="col-md-6 mb-3">
                    <label>Tanggal Kerja Akhir</label>
                    <input placeholder="Tanggal Kerja Akhir" type="date" wire:model="companies.{{$index}}.tanggal_kerja_akhir" class="form-control">

                </div>
                <div class="col-md-6 mb-3">
                    <label>Jenis Nenkin</label>
                    <input placeholder="Jenis Nenkin" type="text" wire:model="companies.{{$index}}.jenis_nenkin" class="form-control">

                </div>
            </div>
        @endforeach
        <button type="button" wire:click="addCompany" wire:loading.attr="disabled" class="btn btn-success mt-3">
            Tambah Perusahaan
        </button>
        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary mt-3">
            Save
        </button>
        

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