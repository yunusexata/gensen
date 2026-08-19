<div>

    <form wire:submit.prevent="store">
        
    <div wire:loading wire:target="images, store, file_ichijikin, storeExtract"
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
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-6 mb-3">
                <label>Nama Batch</label>
                <input placeholder="Nama Batch" type="text" value="{{$ichijikin_file->ichijikinExtraction->batch_name}}" class="form-control" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama File</label>
                <input placeholder="Nama Batch" type="text" value="{{$ichijikin_file->file_stored_name}}" class="form-control" readonly>
            </div>
        </div>
        <div class="row">
            <!-- Center: Image Previewer -->
            <section class="flex-1 p-6 md:p-12 flex flex-col h-full md:w-200">
                <!-- Main Preview Stage -->
                <div class="flex-1 bg-surface-container-lowest rounded-xl ambient-shadow p-8 flex flex-col relative overflow-hidden group">
                    <div
                        class="flex-1 relative rounded-xl bg-surface-container flex items-center justify-center w-75 mx-auto">
                        <img
                            class="w-50 object-cover"
                            src="{{ asset('storage/ichijikin/'.$ichijikin_file->ichijikinExtraction->batch_name. '/result/' . $nama_lengkap.'_'.$no_nenkin.'.jpg') }}?t={{ time() }}"
                        />
                    </div>
                    <div wire:ignore
                        class="flex-1 relative rounded-xl bg-surface-container flex items-center justify-center w-75 mx-auto">
                        <img
                            id="preview"
                            class="w-50 object-cover"
                            src="{{ asset('storage/' . $ichijikin_file->path) }}?t={{ time() }}"
                        />
                    </div>
                    <!-- Bottom Controls -->
                    <div class="mt-8 flex justify-center md:gap-12">
                        <button type="button" class="flex flex-col items-center gap-2 group/btn" id="rotateLeft90">
                            <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">rotate_left</span>
                            </div>
                            <span class="text-xs font-bold text-on-surface-variant">Rotate Left 90</span>
                        </button>
                        <button type="button" class="flex flex-col items-center gap-2 group/btn" id="rotateRight90">
                            <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">rotate_right</span>
                            </div>
                            <span class="text-xs font-bold text-on-surface-variant">Rotate Right 90</span>
                        </button>
                        <button type="button" class="flex flex-col items-center gap-2 group/btn" id="rotateLeft">
                            <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">rotate_left</span>
                            </div>
                            <span class="text-xs font-bold text-on-surface-variant">Rotate Left</span>
                        </button>
                        <button type="button" class="flex flex-col items-center gap-2 group/btn" id="rotateRight">
                            <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">rotate_right</span>
                            </div>
                            <span class="text-xs font-bold text-on-surface-variant">Rotate Right</span>
                        </button>
                        <button type="button" class="flex flex-col items-center gap-2 group/btn" id="cropBtn">
                            <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">save</span>
                            </div>
                            <span class="text-xs font-bold text-on-surface-variant">Save & Extract</span>
                        </button>
                    </div>
                </div>
            </section>
        </div>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-6 mb-3">
                <img src="{{ asset('storage/ichijikin/'.$ichijikin_file->ichijikinExtraction->batch_name. '/crop/'.$ichijikin_file->file_stored_name.'/nama_lengkap.png') }}?t={{ time() }}" alt="">
                <label>Nama Lengkap</label>
                <input placeholder="Nama Lengkap" type="text" wire:model.defer="nama_lengkap" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <img src="{{ asset('storage/ichijikin/'.$ichijikin_file->ichijikinExtraction->batch_name. '/crop/'.$ichijikin_file->file_stored_name.'/no_nenkin.png') }}?t={{ time() }}" alt="">
                <label>No Nenkin</label>
                <input placeholder="No Nenkin" type="text" wire:model.defer="no_nenkin" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <img src="{{ asset('storage/ichijikin/'.$ichijikin_file->ichijikinExtraction->batch_name. '/crop/'.$ichijikin_file->file_stored_name.'/lama_kerja.png') }}?t={{ time() }}" alt="">
                <label>Lama Kerja</label>
                <input placeholder="Lama Kerja" type="text" wire:model.defer="lama_kerja" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <img src="{{ asset('storage/ichijikin/'.$ichijikin_file->ichijikinExtraction->batch_name. '/crop/'.$ichijikin_file->file_stored_name.'/kokumin.png') }}?t={{ time() }}" alt="">
                <label>Kokumin</label>
                <input placeholder="Kokumin" type="text" wire:model.defer="kokumin" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <img src="{{ asset('storage/ichijikin/'.$ichijikin_file->ichijikinExtraction->batch_name. '/crop/'.$ichijikin_file->file_stored_name.'/nenkin_100.png') }}?t={{ time() }}" alt="">
                <label>Nenkin 100</label>
                <input placeholder="Nenkin 100" type="text" wire:model.defer="nenkin_100" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <img src="{{ asset('storage/ichijikin/'.$ichijikin_file->ichijikinExtraction->batch_name. '/crop/'.$ichijikin_file->file_stored_name.'/nenkin_80.png') }}?t={{ time() }}" alt="">
                <label>Nenkin 80</label>
                <input placeholder="Nenkin 80" type="text" wire:model.defer="nenkin_80" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <img src="{{ asset('storage/ichijikin/'.$ichijikin_file->ichijikinExtraction->batch_name. '/crop/'.$ichijikin_file->file_stored_name.'/nenkin_20.png') }}?t={{ time() }}" alt="">
                <label>Nenkin 20</label>
                <input placeholder="Nenkin 20" type="text" wire:model.defer="nenkin_20" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <img src="{{ asset('storage/ichijikin/'.$ichijikin_file->ichijikinExtraction->batch_name. '/crop/'.$ichijikin_file->file_stored_name.'/alamat.png') }}?t={{ time() }}" alt="">
                <label>Alamat</label>
                <textarea class="form-control" placeholder="Alamat" wire:model.defer="alamat">
                </textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label>Nilai</label>
                <input placeholder="Nilai" type="text" wire:model.defer="confidence_score" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Catatan</label>
                <input placeholder="Catatan" type="text" wire:model.defer="confidence_note" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Tipe</label>
                <select class="form-control" wire:model="type">
                    <option value="speed">speed</option>
                    <option value="normal">normal</option>
                </select>
            </div>
        </div>
        <div class="row">
            <button type="button" class="flex flex-col items-center gap-2 group/btn" wire:click="store">
                <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                    <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">save</span>
                </div>
                <span class="text-xs font-bold text-on-surface-variant">Save</span>
            </button>
        </div>

    </form>

</div>

@push('css')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" rel="stylesheet">
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

@push('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script>
        let cropper = null;
        const rotateDegree90 = 90;
        const rotateDegree = 5;

        const image = document.getElementById('preview');
        
        document.getElementById('rotateLeft90')
            .addEventListener('click', () => {
                console.log('click')
                if(cropper) cropper.rotate(-rotateDegree90);
        });

        document.getElementById('rotateRight90')
        .addEventListener('click', () => {
            if(cropper) cropper.rotate(rotateDegree90);
        });
        document.getElementById('rotateLeft')
            .addEventListener('click', () => {
                console.log('click')
                if(cropper) cropper.rotate(-rotateDegree);
        });

        document.getElementById('rotateRight')
        .addEventListener('click', () => {
            if(cropper) cropper.rotate(rotateDegree);
        });
        
    </script>
    @script
    
    <script>
        
        document.addEventListener('livewire:initialized', () => {
           
            document.getElementById('cropBtn')
            .addEventListener('click', () => {

                if(!cropper) return;

                const canvas = cropper.getCroppedCanvas({
                    maxWidth:1500,
                    maxHeight:1500,
                    fillColor: '#fff'
                });
                canvas.toBlob(blob => {

                    const file = new File(
                        [blob],
                        'cropped.jpg',
                        { type:'image/jpeg' }
                    );
                    @this.upload(
                        'photo',
                        file,
                        () => {
                            console.log('uploaded');
                            // ✅ NOW file exists
                            @this.call('storeExtract');
                        },

                        () => console.log('error'),

                        (progress) => console.log(progress.detail.progress)
                    );

                }, 'image/jpeg', 1);
            });

            const image = document.getElementById('preview');
            const preview_type = document.getElementById('preview_type');

                if (cropper) {
                    cropper.destroy();
                }

                url = image.src;
                image.src = url;
                cropper = new Cropper(image, {
                viewMode: 0,
                                autoCropArea:1,

                dragMode: 'move',
                movable: true,
                zoomable: true,
                scalable: true,

                cropBoxMovable: true,
                cropBoxResizable: true,

                background: false,
            });
        });
    </script>
    @endscript
@endpush