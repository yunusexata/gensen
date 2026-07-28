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
                    <label>Nama / Judul</label>
                    <input placeholder="Nama / Judul" type="text" value="{{$label}}" class="form-control" readonly>
                </div>
                
                {{-- <div class="col-md-6">
                    <button
                        type="button"
                        class="btn btn-success btn-sm"
                        x-data
                        @click="$dispatch('export', { type: '{{ App\Helpers\ExportHelper::TYPE_EXCEL }}' })">
                        <i class="fa fa-file-excel"></i>
                        Download
                    </button>
                </div> --}}
            </div>
            <div class="row">
                <livewire:resi-generator.datatable-detail :objId="$objId" />
            </div>
        @else
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 mb-3">
                    <label>Nama / Judul</label>
                    <input placeholder="Nama / Judul" type="text" wire:model="name" class="form-control" required>

                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <div wire:key="file_template" x-data="{
                            isDragging: false,
                            handleDrop(event) {
                                {{-- Multi --}}
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
                                // Optional: you can limit or validate here
                            }
                        }"
                        @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                        @drop.prevent="handleDrop($event)"
                        :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                        class="form-group">
                        <div
                            class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                            @if (!$file_template)
                                
                                <input class="hidden validate-upload-file"
                                    id="file_template"
                                    name="file_template" type="file"
                                    x-ref="input"
                                    wire:model="file_template"
                                    @change="handleFiles" 
                                    class="position-absolute invisible" />

                                <label
                                    class="cursor-pointer w-full md:w-3/4 flex flex-col items-center gap-2 border-2 border-dashed border-blue-100 rounded-lg p-2 rounded"
                                    for="file_template">
                                    <span
                                        class=" my-0 material-symbols-outlined text-5xl text-primary-container"
                                        data-icon="description">description</span>
                                    <p class=" my-0 font-body text-on-surface-variant">Drag and drop file
                                        kamu disini, atau <span
                                            class=" my-0 text-primary font-semibold">CARI FILE</span></p>
                                </label>
                            @else

                                <div class="border rounded p-4 text-center bg-light">
                                    <i class="bi bi-file-earmark fs-1"></i>
                                    <div class="mt-2">
                                        {{$file_template->getClientOriginalName();}}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
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