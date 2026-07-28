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

        <div class="row d-flex justify-content-center">
            
            {{-- SECTION PILIH TEMPLATE --}}
            <div class="col-md-8 mb-4">
                <label class="form-label fw-bold">Pilih Template Artboard</label>
                
                <div class="row g-3">
                    {{-- Lakukan looping data template dari database --}}
                    @foreach($templates as $template)
                    <div class="col-6 col-md-4 col-lg-3">
                        <label class="w-100 position-relative m-0">
                            {{-- Input radio disembunyikan, di-bind dengan Livewire --}}
                            <input type="radio" wire:model="template_posting_id" value="{{ $template->id }}" class="template-radio" required>
                            
                            <div class="card template-card h-100 rounded-3">
                                {{-- Badge indikator centang di pojok kanan atas --}}
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary selected-indicator shadow" style="z-index: 10; padding: 0.4rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                    </svg>
                                </span>

                                {{-- Gambar Template (sesuaikan path-nya dengan storage Anda) --}}
                                <img src="{{ $template->previewUrl() }}" class="card-img-top p-1 rounded-3" alt="{{ $template->name }}" style="height: 140px; object-fit: cover; object-position: top;">
                                
                                <div class="card-body text-center p-2">
                                    <p class="card-text small fw-semibold mb-0 text-truncate" title="{{ $template->name }}">{{ $template->name }}</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>

                @error('template_id')
                    <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- SECTION INPUT NAMA / JUDUL (Kode Anda sebelumnya) --}}
            <div class="col-md-8 mb-3">
                <label class="form-label fw-bold">Nama / Judul Task</label>
                <input placeholder="Contoh: Batch 1 Juli 2026" type="text" wire:model="name" class="form-control" required>
                @error('name')
                    <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- SECTION UPLOAD EXCEL (Kode Anda sebelumnya) --}}
            <div class="col-md-8 mb-3">
                <label class="form-label fw-bold">Upload Data Excel</label>
                <div wire:key="file_excel" x-data="{
                        isDragging: false,
                        handleDrop(event) {
                            const files = event.dataTransfer.files;
                    
                            if (files.length) {
                                const dataTransfer = new DataTransfer();
                    
                                [...files].forEach(file => {
                                    dataTransfer.items.add(file);
                                });
                    
                                $refs.input.files = dataTransfer.files;
                                $refs.input.dispatchEvent(new Event('change', { bubbles: true }));
                            }
                    
                            this.isDragging = false;
                        },
                        handleFiles(event) {
                            const file = event.target.files[0];
                        }
                    }"
                    @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                    @drop.prevent="handleDrop($event)"
                    :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                    class="form-group">
                    <div
                        class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors d-flex justify-content-center duration-300">
                        @if (!$file_excel)
                            
                            <input class="hidden validate-upload-file"
                                id="file_excel"
                                name="file_excel" type="file"
                                x-ref="input"
                                wire:model="file_excel"
                                @change="handleFiles" 
                                accept=".xlsx,.xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"
                                class="position-absolute invisible" style="display: none;" />

                            <label
                                class="cursor-pointer w-full md:w-3/4 flex flex-col items-center gap-2 border-2 border-dashed border-blue-100 rounded-lg p-2 rounded"
                                for="file_excel">
                                <span class="my-0 material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                <p class="my-0 font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary fw-semibold">CARI FILE</span></p>
                                <p class="my-0 text-xs text-muted font-medium">Format: Excel</p>
                            </label>
                        @else
                            <div class="border rounded p-4 text-center bg-light w-100">
                                <i class="bi bi-file-earmark-excel fs-1 text-success"></i>
                                <div class="mt-2 fw-semibold">
                                    {{$file_excel->getClientOriginalName()}}
                                </div>
                                {{-- Tombol hapus file (opsional) --}}
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2" wire:click="$set('file_excel', null)">Ganti File</button>
                            </div>
                        @endif
                    </div>
                </div>
                @error('file_excel')
                    <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary mt-3">
            Save
        </button>
    </form>
</div>

@push('css')
        <style>
    /* Custom CSS untuk Image Radio Card */
    .template-card {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        border: 2px solid transparent;
        overflow: visible;
    }
    
    .template-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }

    /* Sembunyikan radio button asli */
    .template-radio {
        display: none;
    }

    /* Styling saat radio button terpilih */
    .template-radio:checked + .template-card {
        border-color: #0d6efd; /* Warna biru primary Bootstrap */
        background-color: #f8fbff;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Tampilkan badge centang hanya saat terpilih */
    .template-radio:checked + .template-card .selected-indicator {
        opacity: 1;
        transform: scale(1);
    }

    /* Animasi badge centang */
    .selected-indicator {
        opacity: 0;
        transform: scale(0);
        transition: all 0.2s ease-in-out;
    }
</style>
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