
<div class="position-relative">
    <div wire:loading wire:target="submitChange, clickFile">
        <div class="position-absolute w-100 h-100 z-[9999999999]">
            <div class="w-100 h-100" style="background-color: grey; opacity:0.2"></div>
        </div>
        <span class="position-absolute shadow bg-white p-[20px] rounded z-[9999999999] text-[50pt]"
            style="top: 50%;left: 50%;transform: translate(-50%, -50%);">
            Loading <i class="fa-solid fa-wand-magic-sparkles text-purple animate-wand" style="font-size:50px;"></i>
        </span>
    </div>
    <div class="row">
        <div class="col-md-4 flex flex-col gap-2">
            <label class="font-label text-xs font-medium text-on-surface-variant" for="nama_bank_penerima">Nama lengkap</label>
            <input disabled class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="nama_lengkap" wire:model="nama_lengkap" name="first_name" placeholder="Nama lengkap" type="text"/>
        </div>
        <div class="col-md-4 flex flex-col gap-2">
            <label class="font-label text-xs font-medium text-on-surface-variant" for="tanggal_lahir">Tanggal lahir</label>
            <input disabled class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="tanggal_lahir" wire:model="tanggal_lahir" name="tanggal_lahir" type="date"/>
        </div>
        <div class="col-md-4 flex flex-col gap-2">
            <label class="font-label text-xs font-medium text-on-surface-variant" for="tanggal_lahir">No Wa</label>
            <input disabled class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="nomor_whatsapp" wire:model="nomor_whatsapp" name="nomor_whatsapp" type="text"/>
        </div>
    </div>
    <div class="flex-md-row rounded border md:p-10">
        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6" wire:ignore>
            <li class="nav-item mx-auto mb-md-2 md:w-[22%]" role="presentation">
                <a class="nav-link m-0 btn btn-flex btn-success text-dark btn-active-light-success active:text-black active w-full" data-bs-toggle="tab" href="#kt_vtab_pane_1" aria-selected="true" role="tab">
                    <div class="d-flex w-full flex-column align-items-center">
                        <span class="text-center fs-4 fw-bold">Edit Page</span>
                        <span class="text-center fs-7">Edit dan sesuaikan file lampiran</span>
                    </div>
                </a>
            </li>
            
            <li class="nav-item mx-auto mb-md-2 md:w-[22%]" role="presentation">
                <a class="nav-link m-0 btn btn-flex btn-warning text-dark btn-active-light-warning w-full" data-bs-toggle="tab" href="#kt_vtab_pane_2" aria-selected="false" role="tab">
                    <div class="d-flex w-full flex-column align-items-center">
                        <span class="text-center fs-4 fw-bold">Import Page</span>
                        <span class="text-center fs-7">Import lampiran Berkas</span>
                    </div>
                </a>
            </li>
            
            <li class="nav-item mx-auto mb-md-2 md:w-[22%]" role="presentation">
                <a class="nav-link m-0 btn btn-flex btn-success text-dark btn-active-light-success w-full" data-bs-toggle="tab" href="#kt_vtab_pane_3" aria-selected="false" role="tab">
                    <div class="d-flex w-full flex-column align-items-center">
                        <span class="text-center fs-4 fw-bold">Validation Page</span>
                        <span class="text-center fs-7">Valildasi Berkas</span>
                    </div>
                </a>
            </li>
            <li class="nav-item mx-auto mb-md-2 md:w-[22%]" role="presentation">
                <a class="nav-link m-0 btn btn-flex btn-primary text-dark btn-active-light-primary w-full active:text-black" data-bs-toggle="tab" href="#kt_vtab_pane_4" aria-selected="false" role="tab">
                    <div class="d-flex w-full flex-column align-items-center">
                        <span class="text-center fs-4 fw-bold">Download Page</span>
                        <span class="text-center fs-7">Download dan lihat hasil lampiran</span>
                    </div>
                </a>
            </li>
        </ul>
        <!-- Sticky Global Action Area -->
         <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-outline-variant py-md">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-md">
               <div class="flex flex-col">
                  <div class="flex items-center gap-sm">
                     <h1 class="font-h1 text-h2 text-on-surface">Document Management</h1>
                     <span class="bg-primary-container text-on-primary-container px-sm py-xs rounded text-label-caps uppercase tracking-wider">Workspace</span>
                  </div>
               </div>
               <div class="flex items-center gap-md">
                  <button type="button" wire:click="submitChange" class="bg-primary-container hover:bg-primary-fixed-dim text-on-primary-fixed-variant px-xl py-sm rounded-xl font-semibold shadow-sm transition-all active:scale-95 flex items-center gap-sm">
                  <span class="material-symbols-outlined text-[20px]">save</span>
                  Save And Merge Documents
                  </button>
               </div>
               {{-- <div class="flex items-center gap-md">
                  <button type="button" wire:click="submitMergeJob" class="bg-success-container hover:bg-success-fixed-dim text-on-success-fixed-variant px-xl py-sm rounded-xl font-semibold shadow-sm transition-all active:scale-95 flex items-center gap-sm">
                  <span class="material-symbols-outlined text-[20px]">photo_auto_merge</span>
                  Merge Documents
                  </button>
               </div> --}}
            </div>
         </header>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show" id="kt_vtab_pane_1" role="tabpanel" wire:ignore.self>
                
                <main class="flex-1 flex flex-col md:flex-row bg-background overflow-hidden">
                    <!-- Center: Image Previewer -->
                    <section class="flex-1 p-6 md:p-12 flex flex-col h-full md:w-200">
                        <!-- Main Preview Stage -->
                        <div class="flex-1 bg-surface-container-lowest rounded-xl ambient-shadow p-8 flex flex-col relative overflow-hidden group">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                <h2 class="text-2xl font-extrabold tracking-tight text-on-surface" id="preview_type">{{$editedData['type']}}</h2>
                                </div>
                                <button class="primary-gradient text-on-primary px-6 py-2.5 rounded-md text-sm font-bold flex items-center gap-2 hover:opacity-90 active:scale-95 transition-all">
                                <span class="material-symbols-outlined text-[18px]">download</span>
                                Export Image
                                </button>
                            </div>
                            <div wire:ignore
                                class="flex-1 relative rounded-xl bg-surface-container flex items-center justify-center">

                                <img
                                    id="preview"
                                    class="w-full object-cover"
                                    src="{{ asset(config('template.logo_panel'))  }}"
                                />
                            </div>
                            <!-- Bottom Controls -->
                            <div class="mt-8 flex justify-center md:gap-12">
                                <button class="flex flex-col items-center gap-2 group/btn" id="rotateLeft90">
                                    <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">rotate_left</span>
                                    </div>
                                    <span class="text-xs font-bold text-on-surface-variant">Rotate Left 90</span>
                                </button>
                                <button class="flex flex-col items-center gap-2 group/btn" id="rotateRight90">
                                    <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">rotate_right</span>
                                    </div>
                                    <span class="text-xs font-bold text-on-surface-variant">Rotate Right 90</span>
                                </button>
                                <button class="flex flex-col items-center gap-2 group/btn" id="rotateLeft">
                                    <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">rotate_left</span>
                                    </div>
                                    <span class="text-xs font-bold text-on-surface-variant">Rotate Left</span>
                                </button>
                                <button class="flex flex-col items-center gap-2 group/btn" id="rotateRight">
                                    <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">rotate_right</span>
                                    </div>
                                    <span class="text-xs font-bold text-on-surface-variant">Rotate Right</span>
                                </button>
                                <button class="flex flex-col items-center gap-2 group/btn" id="cropBtn">
                                    <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center group-hover/btn:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined text-on-surface-variant group-hover/btn:text-primary">save</span>
                                    </div>
                                    <span class="text-xs font-bold text-on-surface-variant">Save</span>
                                </button>
                            </div>
                        </div>
                    </section>
                    <!-- Right: Select Image List -->
                    <aside class="md:w-[400px] p-6 md:py-12 md:pr-12 flex flex-col h-full bg-background md:bg-transparent">
                        <div class="mb-6">
                            <h3 class="text-lg font-extrabold tracking-tight">Select Image</h3> 
                        </div>
                        <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar row d-flex justify-content-between">
                           
                            {{-- Zaryoy Card Depan --}}
                            <div class="col-md-6 mt-5">
                                <h3 class="fw-bold">Zaryou Card Depan</h3>
                                
                                @if ($zairyou_card_front_old['url'])
                                    @if (!$zairyou_card_front_old['isPdf'] && $zairyou_card_front_old['isImage'])
                                        <!-- Thumbnail Item 2 -->
                                        <div class="relative group cursor-pointer active:scale-95 transition-all">
                                            <div class="row d-flex justify-content-between flex-nowrap w-100 pr-5">
                                                    <div class="col-auto"> 
                                                    {{-- <span class="py-0 my-0 text-[10px] font-bold text-on-surface-variant">{{$zairyou_card_front_old['filename']}}</span> --}}
                                                    {!!$zairyou_card_front_old['printStatus']!!}
                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors' 
                                                        wire:click="showDialogDeleteFile('{{$zairyou_card_front_old['id']}}', '{{ App\Enums\Gensen\GensenAttachmentType::ZAIRYOU_CARD_FRONT }}')">
                                                        <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                                                    </button>
                                                    
                                                </div>
                                            </div>
                                            <div class="{{ ($zairyou_card_front_old['id'] == $editedData['id']) ? 'border-2 border-primary ring-4 ring-primary/10' : ''}} mt-2 w-full rounded-xl bg-surface-container-low hover:grayscale-0 transition-all" >
                                                <img class="w-full object-cover"  
                                                wire:click="clickFile('{{$zairyou_card_front_old['id']}}', 'zairyou_card_front_old', '{{$zairyou_card_front_old['type']?->label()}}')"
                                                src="{{ $zairyou_card_front_old['url'] }}"/>
                                            </div>
                                        </div>
                                    @elseif($zairyou_card_front_old['isPdf'] && !$zairyou_card_front_old['isImage'])
                                        <embed src="{{ $zairyou_card_front_old['url'] }}" type="application/pdf" width="100%" style="min-height: 400px;" class="mb-2">
                
                                    @else
                                        <div class="border rounded p-4 text-center bg-light mb-2">
                                            <i class="bi bi-file-earmark fs-1"></i>
                                            <div class="mt-2">
                                                {{$zairyou_card_front_old['filename']}}
                                            </div>
                                        </div>
                                    @endif
                                @else
                                <section class="mt-5">
                                    <div
                                        x-data="{
                                            isDragging: false,
                                            handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                    const dataTransfer = new DataTransfer();
                                                    dataTransfer.items.add(file);
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
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="handleDrop($event)"
                                        :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                        class="form-group mt-5"
                                    >
                                        <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                            <input class="hidden validate-upload-file" id="zairyou_card_front" name="zairyou_card_front" type="file"
                                            
                                            x-ref="input"
                                            {{-- wire:model="zairyou_card_front" --}}
                                            @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible"/>
                                            <label class="cursor-pointer flex flex-col items-center gap-3" for="zairyou_card_front">
                                                <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                <p class="font-body text-on-surface-variant"><span class="text-primary font-semibold">CARI FILE</span></p>
                                                <p class="text-xs text-outline font-medium">Format: JPG/ PNG (Max 10MB)</p>
                                            </label>
                                        </div>
                                        <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                            @if ($zairyou_card_front)
                                                @php
                                                    $ext = $zairyou_card_front->getClientOriginalExtension();
                                                    if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                        $url = $zairyou_card_front->temporaryUrl();
                                                        // $url = route('preview.temp.image', $zairyou_card_front->getFileName());
                                                        $filename = $zairyou_card_front->getClientOriginalName();
                                                    }elseif(in_array($ext, ['pdf'])){
                                                        $url = route('preview.temp.pdf', $zairyou_card_front->getFileName());
                                                        $filename = $zairyou_card_front->getClientOriginalName();
                                                    }else{
                                                        $filename = $zairyou_card_front->getClientOriginalName();
                                                    }
                                                    $ext = strtolower($ext);
                                                    
                                                @endphp
                                                @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                        
                                                    <img src="{{ $url }}" class="img-fluid rounded img-thumbnail">
                                                @elseif(in_array($ext, ['pdf']))
                                                    <embed src="{{ $url }}" type="application/pdf" width="100%">
                                                        {{-- <iframe
                                                            src="{{ $url }}#toolbar=0"
                                                            width="100%"
                                                            style="border:none">
                                                        </iframe> --}}
                                                @else
                                                    <div class="border rounded p-4 text-center bg-light">
                                                        <i class="bi bi-file-earmark fs-1"></i>
                                                        <div class="mt-2">
                                                            {{$filename}}
                                                        </div>
                                                    </div>

                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </section>
                                
                                @endif
                            </div>
                            {{-- Zairyou Card Belakang --}}
                            <div class="col-md-6">
                                <h3 class="fw-bold">Zairyou Card Belakang</h3>
                                @if ($zairyou_card_back_old['url'])
                                    @if (!$zairyou_card_back_old['isPdf'] && $zairyou_card_back_old['isImage'])
                                        <!-- Thumbnail Item 2 -->
                                        <div class="relative group cursor-pointer active:scale-95 transition-all">
                                            <div class="row d-flex justify-content-between flex-nowrap w-100 pr-5">
                                                    <div class="col-auto"> 
                                                    {{-- <span class="py-0 my-0 text-[10px] font-bold text-on-surface-variant">{{$zairyou_card_back_old['filename']}}</span> --}}
                                                    {!!$zairyou_card_back_old['printStatus']!!}
                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors' 
                                                        wire:click="showDialogDeleteFile('{{$zairyou_card_back_old['id']}}', '{{ App\Enums\Gensen\GensenAttachmentType::ZAIRYOU_CARD_BACK }}')">
                                                        <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                                                    </button>
                                                    
                                                </div>
                                            </div>
                                            <div class="{{ ($zairyou_card_back_old['id'] == $editedData['id']) ? 'border-2 border-primary ring-4 ring-primary/10' : ''}} mt-2 w-full rounded-xl bg-surface-container-low hover:grayscale-0 transition-all" >
                                                <img class="w-full object-cover"  
                                                wire:click="clickFile('{{$zairyou_card_back_old['id']}}', 'zairyou_card_back_old', '{{$zairyou_card_back_old['type']?->label()}}')"
                                                src="{{ $zairyou_card_back_old['url'] }}"/>
                                            </div>
                                        </div>
                                    @elseif($zairyou_card_back_old['isPdf'] && !$zairyou_card_back_old['isImage'])
                                        <embed src="{{ $zairyou_card_back_old['url'] }}" type="application/pdf" width="100%" style="min-height: 400px;" class="mb-2">
                                            {{-- <iframe
                                                src="{{ $zairyou_card_back_old['url'] }}#toolbar=0"
                                                width="100%"
                                                style="border:none">
                                            </iframe> --}}
                                    @else
                                        <div class="border rounded p-4 text-center bg-light mb-2">
                                            <i class="bi bi-file-earmark fs-1"></i>
                                            <div class="mt-2">
                                                {{$zairyou_card_back_old['filename']}}
                                            </div>
                                        </div>
                                    @endif
                                @else
                                <section class="mt-5">
                                    <div
                                        x-data="{
                                            isDragging: false,
                                            handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                    const dataTransfer = new DataTransfer();
                                                    dataTransfer.items.add(file);
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
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="handleDrop($event)"
                                        :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                        class="form-group mt-5"
                                    >
                                        <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                            <input class="hidden validate-upload-file" id="zairyou_card_back" name="zairyou_card_back" type="file"
                                            
                                            x-ref="input"
                                            {{-- wire:model="zairyou_card_back" --}}
                                            @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible"/>
                                            <label class="cursor-pointer flex flex-col items-center gap-3" for="zairyou_card_back">
                                                <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                <p class="font-body text-on-surface-variant"><span class="text-primary font-semibold">CARI FILE</span></p>
                                                <p class="text-xs text-outline font-medium">Format: JPG/ PNG (Max 10MB)</p>
                                            </label>
                                        </div>
                                        <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                            @if ($zairyou_card_back)
                                                @php
                                                    $ext = $zairyou_card_back->getClientOriginalExtension();
                                                    if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                        // $url = $zairyou_card_back->temporaryUrl();
                                                        $url = $zairyou_card_back->temporaryUrl();
                                                        // $url = route('preview.temp.image', $zairyou_card_back->getFileName());
                                                    }elseif(in_array($ext, ['pdf'])){
                                                        $url = route('preview.temp.pdf', $zairyou_card_back->getFileName());
                                                        $filename = $zairyou_card_back->getClientOriginalName();
                                                    }else{
                                                        $filename = $zairyou_card_back->getClientOriginalName();
                                                    }
                                                    $ext = strtolower($ext);
                                                    
                                                @endphp
                                                @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                        
                                                    <img src="{{ $url }}" class="img-fluid rounded img-thumbnail">
                                                @elseif(in_array($ext, ['pdf']))
                                                    <embed src="{{ $url }}" type="application/pdf" width="100%">
                                                        {{-- <iframe
                                                            src="{{ $url }}#toolbar=0"
                                                            width="100%"
                                                            style="border:none">
                                                        </iframe> --}}
                                                @else
                                                    <div class="border rounded p-4 text-center bg-light">
                                                        <i class="bi bi-file-earmark fs-1"></i>
                                                        <div class="mt-2">
                                                            {{$filename}}
                                                        </div>
                                                    </div>

                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </section>
                                @endif
                            </div>
                            {{-- My Number Depan --}}
                            <div class="col-md-6">
                                <h3 class="fw-bold">My Number Depan</h3>
                                @if ($my_number_front_old['url'])
                                    @if (!$my_number_front_old['isPdf'] && $my_number_front_old['isImage'])
                                        <!-- Thumbnail Item 2 -->
                                        <div class="relative group cursor-pointer active:scale-95 transition-all">
                                            <div class="row d-flex justify-content-between flex-nowrap w-100 pr-5">
                                                    <div class="col-auto"> 
                                                    {{-- <span class="py-0 my-0 text-[10px] font-bold text-on-surface-variant">{{$my_number_front_old['filename']}}</span> --}}
                                                    {!!$my_number_front_old['printStatus']!!}
                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors' 
                                                        wire:click="showDialogDeleteFile('{{$my_number_front_old['id']}}', '{{ App\Enums\Gensen\GensenAttachmentType::MY_NUMBER_FRONT }}')">
                                                        <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                                                    </button>
                                                    
                                                </div>
                                            </div>
                                            <div class="{{ ($my_number_front_old['id'] == $editedData['id']) ? 'border-2 border-primary ring-4 ring-primary/10' : ''}} mt-2 w-full rounded-xl bg-surface-container-low hover:grayscale-0 transition-all" >
                                                <img class="w-full object-cover"  
                                                wire:click="clickFile('{{$my_number_front_old['id']}}', 'my_number_front_old', '{{$my_number_front_old['type']?->label()}}')"
                                                src="{{ $my_number_front_old['url'] }}"/>
                                            </div>
                                        </div>
                                    @elseif($my_number_front_old['isPdf'] && !$my_number_front_old['isImage'])
                                        <embed src="{{ $my_number_front_old['url'] }}" type="application/pdf" width="100%" style="min-height: 400px;" class="mb-2">
                                            {{-- <iframe
                                                src="{{ $my_number_front_old['url'] }}#toolbar=0"
                                                width="100%"
                                                style="border:none">
                                            </iframe> --}}
                                    @else
                                        <div class="border rounded p-4 text-center bg-light mb-2">
                                            <i class="bi bi-file-earmark fs-1"></i>
                                            <div class="mt-2">
                                                {{$my_number_front_old['filename']}}
                                            </div>
                                        </div>
                                    @endif
                                @else
                                <section class="mt-5">
                                    <div
                                        x-data="{
                                            isDragging: false,
                                            handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                    const dataTransfer = new DataTransfer();
                                                    dataTransfer.items.add(file);
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
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="handleDrop($event)"
                                        :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                        class="form-group mt-5"
                                    >
                                        <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                            <input class="hidden validate-upload-file" id="my_number_front" name="my_number_front" type="file"
                                            
                                            x-ref="input"
                                            {{-- wire:model="my_number_front" --}}
                                            @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible"/>
                                            <label class="cursor-pointer flex flex-col items-center gap-3" for="my_number_front">
                                                <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                <p class="font-body text-on-surface-variant"><span class="text-primary font-semibold">CARI FILE</span></p>
                                                <p class="text-xs text-outline font-medium">Format: JPG/ PNG (Max 10MB)</p>
                                            </label>
                                        </div>
                                        <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                            @if ($my_number_front)
                                                @php
                                                    $ext = $my_number_front->getClientOriginalExtension();
                                                    if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                        $url = $my_number_front->temporaryUrl();
                                                        // $url = route('preview.temp.image', $my_number_front->getFileName());
    //                                                     $fullPath = $my_number_front->getRealPath();
    // $relativePath = Str::after($fullPath, 'livewire-tmp/');

    // $url = route('preview.temp.file', $relativePath);
    $filename = $my_number_front->getClientOriginalName();
                                                    }elseif(in_array($ext, ['pdf'])){
                                                        $url = route('preview.temp.pdf', $my_number_front->getFileName());
                                                        $filename = $my_number_front->getClientOriginalName();
                                                    }else{
                                                        $filename = $my_number_front->getClientOriginalName();
                                                    }
                                                    $ext = strtolower($ext);
                                                    
                                                @endphp
                                                {{-- {{ $my_number_front->temporaryUrl() }} --}}
                                                @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                                    <img src="{{ $url }}" class="img-fluid rounded img-thumbnail">
                                                @elseif(in_array($ext, ['pdf']))
                                                    <embed src="{{ $url }}" type="application/pdf" width="100%">
                                                        {{-- <iframe
                                                            src="{{ $url }}#toolbar=0"
                                                            width="100%"
                                                            style="border:none">
                                                        </iframe> --}}
                                                @else
                                                    <div class="border rounded p-4 text-center bg-light">
                                                        <i class="bi bi-file-earmark fs-1"></i>
                                                        <div class="mt-2">
                                                            {{$filename}}
                                                        </div>
                                                    </div>

                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </section>
                                @endif
                            </div>
                            {{-- My Number Back --}}
                            <div class="col-md-6">
                                <h3 class="fw-bold">My Number Belakang</h3>
                                @if ($my_number_back_old['url'])
                                    @if (!$my_number_back_old['isPdf'] && $my_number_back_old['isImage'])
                                        <!-- Thumbnail Item 2 -->
                                        <div class="relative group cursor-pointer active:scale-95 transition-all">
                                            <div class="row d-flex justify-content-between flex-nowrap w-100 pr-5">
                                                    <div class="col-auto"> 
                                                    {{-- <span class="py-0 my-0 text-[10px] font-bold text-on-surface-variant">{{$my_number_back_old['filename']}}</span> --}}
                                                    {!!$my_number_back_old['printStatus']!!}
                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors' 
                                                        wire:click="showDialogDeleteFile('{{$my_number_back_old['id']}}', '{{ App\Enums\Gensen\GensenAttachmentType::MY_NUMBER_BACK }}')">
                                                        <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                                                    </button>
                                                    
                                                </div>
                                            </div>
                                            <div class="{{ ($my_number_back_old['id'] == $editedData['id']) ? 'border-2 border-primary ring-4 ring-primary/10' : ''}} mt-2 w-full rounded-xl bg-surface-container-low hover:grayscale-0 transition-all" >
                                                <img class="w-full object-cover"  
                                                wire:click="clickFile('{{$my_number_back_old['id']}}', 'my_number_back_old', '{{$my_number_back_old['type']?->label()}}')"
                                                src="{{ $my_number_back_old['url'] }}"/>
                                            </div>
                                        </div>
                                    @elseif($my_number_back_old['isPdf'] && !$my_number_back_old['isImage'])
                                        <embed src="{{ $my_number_back_old['url'] }}" type="application/pdf" width="100%" style="min-height: 400px;" class="mb-2">
                                            {{-- <iframe
                                                src="{{ $my_number_back_old['url'] }}#toolbar=0"
                                                width="100%"
                                                style="border:none">
                                            </iframe> --}}
                                    @else
                                        <div class="border rounded p-4 text-center bg-light mb-2">
                                            <i class="bi bi-file-earmark fs-1"></i>
                                            <div class="mt-2">
                                                {{$my_number_front_old['filename']}}
                                            </div>
                                        </div>
                                    @endif
                                @else
                                <section class="mt-5">
                                    <div
                                        x-data="{
                                            isDragging: false,
                                            handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                    const dataTransfer = new DataTransfer();
                                                    dataTransfer.items.add(file);
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
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="handleDrop($event)"
                                        :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                        class="form-group mt-5"
                                    >
                                        <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                            <input class="hidden validate-upload-file" id="my_number_back" name="my_number_back" type="file"
                                            
                                            x-ref="input"
                                            {{-- wire:model="my_number_back" --}}
                                            @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible"/>
                                            <label class="cursor-pointer flex flex-col items-center gap-3" for="my_number_back">
                                                <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                <p class="font-body text-on-surface-variant"><span class="text-primary font-semibold">CARI FILE</span></p>
                                                <p class="text-xs text-outline font-medium">Format: JPG/ PNG (Max 10MB)</p>
                                            </label>
                                        </div>
                                        <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                            @if ($my_number_back)
                                                @php
                                                    $ext = $my_number_back->getClientOriginalExtension();
                                                    if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                        // $url = $my_number_back->temporaryUrl();
                                                        $url = $my_number_back->temporaryUrl();
                                                        // $url = route('preview.temp.image', $my_number_back->getFileName());
                                                        $filename = $my_number_back->getClientOriginalName();
                                                    }elseif(in_array($ext, ['pdf'])){
                                                        $url = route('preview.temp.pdf', $my_number_back->getFileName());
                                                        $filename = $my_number_back->getClientOriginalName();
                                                    }else{
                                                        $filename = $my_number_back->getClientOriginalName();
                                                    }
                                                    $ext = strtolower($ext);
                                                    
                                                @endphp
                                                @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                        
                                                    <img src="{{ $url }}" class="img-fluid rounded img-thumbnail">
                                                @elseif(in_array($ext, ['pdf']))
                                                    <embed src="{{ $url }}" type="application/pdf" width="100%">
                                                        {{-- <iframe
                                                            src="{{ $url }}#toolbar=0"
                                                            width="100%"
                                                            style="border:none">
                                                        </iframe> --}}
                                                @else
                                                    <div class="border rounded p-4 text-center bg-light">
                                                        <i class="bi bi-file-earmark fs-1"></i>
                                                        <div class="mt-2">
                                                            {{$filename}}
                                                        </div>
                                                    </div>

                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </section>
                                @endif
                            </div>
                            {{-- Rekening Indonesia --}}
                            <h3 class="fw-bold">Rekening Indonesia</h3>
                            @if ($rekening_indonesia_old['url'])
                                @if (!$rekening_indonesia_old['isPdf'] && $rekening_indonesia_old['isImage'])
                                    <!-- Thumbnail Item 2 -->
                                    <div class="relative group cursor-pointer active:scale-95 transition-all">
                                        <div class="row d-flex justify-content-between flex-nowrap w-100 pr-5">
                                                <div class="col-auto"> 
                                                {{-- <span class="py-0 my-0 text-[10px] font-bold text-on-surface-variant">{{$rekening_indonesia_old['filename']}}</span> --}}
                                                {!!$rekening_indonesia_old['printStatus']!!}
                                            </div>
                                            <div class="col-auto d-flex align-items-center">
                                                <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors' 
                                                    wire:click="showDialogDeleteFile('{{$rekening_indonesia_old['id']}}', '{{ App\Enums\Gensen\GensenAttachmentType::REKENING_INDONESIA }}')">
                                                    <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                                                </button>
                                                
                                            </div>
                                        </div>
                                        <div class="{{ ($rekening_indonesia_old['id'] == $editedData['id']) ? 'border-2 border-primary ring-4 ring-primary/10' : ''}} mt-2 w-full rounded-xl bg-surface-container-low hover:grayscale-0 transition-all" >
                                            <img class="w-full object-cover"  
                                            wire:click="clickFile('{{$rekening_indonesia_old['id']}}', 'rekening_indonesia_old', '{{$rekening_indonesia_old['type']?->label()}}')"
                                            src="{{ $rekening_indonesia_old['url'] }}"/>
                                        </div>
                                    </div>
                                @elseif($rekening_indonesia_old['isPdf'] && !$rekening_indonesia_old['isImage'])
                                    <embed src="{{ $rekening_indonesia_old['url'] }}" type="application/pdf" width="100%" style="min-height: 400px;" class="mb-2">
                                        {{-- <iframe
                                            src="{{ $rekening_indonesia_old['url'] }}#toolbar=0"
                                            width="100%"
                                            style="border:none">
                                        </iframe> --}}
                                @else
                                    <div class="border rounded p-4 text-center bg-light mb-2">
                                        <i class="bi bi-file-earmark fs-1"></i>
                                        <div class="mt-2">
                                            {{$rekening_indonesia_old['filename']}}
                                        </div>
                                    </div>
                                @endif
                            @else
                                <section class="mt-5">
                                    <div
                                        x-data="{
                                            isDragging: false,
                                            handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                    const dataTransfer = new DataTransfer();
                                                    dataTransfer.items.add(file);
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
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="handleDrop($event)"
                                        :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                        class="form-group mt-5"
                                    >
                                        <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                            <input class="hidden validate-upload-file" id="rekening_indonesia" name="rekening_indonesia" type="file"
                                            
                                            x-ref="input"
                                            {{-- wire:model="rekening_indonesia" --}}
                                            @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible"/>
                                            <label class="cursor-pointer flex flex-col items-center gap-3" for="rekening_indonesia">
                                                <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                <p class="font-body text-on-surface-variant"><span class="text-primary font-semibold">CARI FILE</span></p>
                                                <p class="text-xs text-outline font-medium">Format: JPG/ PNG (Max 10MB)</p>
                                            </label>
                                        </div>
                                        <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                            @if ($rekening_indonesia)
                                                @php
                                                    $ext = $rekening_indonesia->getClientOriginalExtension();
                                                    if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                        $url = $rekening_indonesia->temporaryUrl();
                                                        
                                                        // $url = route('preview.temp.image', $rekening_indonesia->getFileName());
                                                        $filename = $rekening_indonesia->getClientOriginalName();
                                                    }elseif(in_array($ext, ['pdf'])){
                                                        $url = route('preview.temp.pdf', $rekening_indonesia->getFileName());
                                                        $filename = $rekening_indonesia->getClientOriginalName();
                                                    }else{
                                                        $filename = $rekening_indonesia->getClientOriginalName();
                                                    }
                                                    $ext = strtolower($ext);
                                                    
                                                @endphp
                                                @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                        
                                                    <img src="{{ $url }}" class="img-fluid rounded img-thumbnail">
                                                @elseif(in_array($ext, ['pdf']))
                                                    <embed src="{{ $url }}" type="application/pdf" width="100%">
                                                        {{-- <iframe
                                                            src="{{ $url }}#toolbar=0"
                                                            width="100%"
                                                            style="border:none">
                                                        </iframe> --}}
                                                @else
                                                    <div class="border rounded p-4 text-center bg-light">
                                                        <i class="bi bi-file-earmark fs-1"></i>
                                                        <div class="mt-2">
                                                            {{$filename}}
                                                        </div>
                                                    </div>

                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </section>
                            @endif

                        </div>
                        {{-- <button type="button" class="mt-6 p-4 rounded-xl bg-primary-fixed-dim rounded hover:opacity-90 transition-transform duration-300 hover:scale-105" wire:click="submitChange">
                            <div class="flex items-center gap-3 justify-center">
                                <span class="material-symbols-outlined text-white">save</span>
                                <span class="text-[25px] font-bold text-on-tertiary">Submit Change</span>
                            </div>
                        </button> --}}
                    </aside>
                </main>
            </div>
            <div class="tab-pane fade" id="kt_vtab_pane_2" role="tabpanel" wire:ignore.self>
                <!-- Main Workspace Container -->
                <main class="min-h-screen pb-xl rounded-lg">
                    
                    <!-- Document Grid -->
                    <div class="mx-auto px-margin mt-xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-xl">
                        <!-- Card: Kertas Gensen -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm flex flex-col gap-md group hover:border-primary-container transition-colors">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="font-h2 text-body-lg text-on-surface">Kertas Gensen</h2>
                                </div>
                            </div>
                            <!-- Upload Zone -->
                            <div
                                x-data="{
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
                                    return;
                                    // Optional: you can limit or validate here
                                    }
                                }"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                class="form-group">
                                    <label for="kertas_gensen" class="border-2 border-dashed border-outline-variant hover:border-primary hover:bg-primary-fixed/10 transition-all cursor-pointer rounded-lg p-md flex flex-col items-center justify-center gap-sm text-center">
                                        <span class="material-symbols-outlined text-primary text-3xl">upload_file</span>
                                        <div class="text-body-sm">
                                            <span class="text-primary font-semibold">Click to upload</span> or drag and drop
                                        </div>
                                    </label>
                                    <input class="hidden validate-upload-file" id="kertas_gensen" name="kertas_gensen"
                                    type="file"
                                    multiple
                                    x-ref="input"
                                    wire:model="kertas_gensen"
                                    @change="handleFiles"
                                    accept="application/pdf, image/jpeg, image/png"
                                    class="position-absolute invisible" />
                            </div>
                            <!-- File Previews -->
                            <div class="grid grid-cols-2 gap-sm">
                                @if ($kertas_gensen)
                                    @foreach ($kertas_gensen as $index => $item)
                                        @php
                                            $ext = $item->getClientOriginalExtension();
                                            if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                $url = $item->temporaryUrl();
                                                
                                                // $url = route('preview.temp.image', $item->getFileName());
                                                $filename = $item->getClientOriginalName();
                                            }elseif(in_array($ext, ['pdf'])){
                                                $url = route('preview.temp.pdf', $item->getFileName());
                                                $filename = $item->getClientOriginalName();
                                            }else{
                                                $filename = $item->getClientOriginalName();
                                            }
                                            $ext = strtolower($ext);
                                        @endphp
                                        {{-- {!! $kertas_gensen_note[$index] !!} --}}
                                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                            {{-- IMAGE --}}
                                            <img wire:key="kertas_gensen_new_{{ $index }}" class="w-full h-full object-cover" data-alt="Professional scan of a tax document on a clean desk background with soft office lighting" 
                                            src="{{$url}}"/>
                                        @elseif(in_array($ext, ['pdf']))
                                            {{-- IFRAME PDF --}}
                                            <a wire:key="kertas_gensen_new_{{ $index }}"
                                                class="relative thumbnail-aspect bg-surface-container rounded-lg overflow-hidden group/thumb"
                                            >
                                                <iframe
                                                    src="{{ $url }}"
                                                    type="application/pdf"
                                                    width="100%"
                                                    height="200"
                                                    class="pointer-events-none"
                                                ></iframe>

                                            </a> 
                                        @else
                                            {{-- <div class="border rounded p-4 text-center bg-light">
                                                <i class="bi bi-file-earmark fs-1"></i>
                                                <div class="mt-2">
                                                    {{$filename}}
                                                </div>
                                            </div> --}}
                                        @endif
                                    @endforeach
                                @endif
                                @if (!empty($kertas_gensen_old && $kertas_gensen_old['groups']))
                                    @foreach ($kertas_gensen_old['groups'][0]['files'] as $index => $item)
                                        {{-- {!! $kertas_gensen_old_note[$index] !!} --}}
                                        @if($item['isImage'] ?? 0)
                                            <div class="relative group/thumb" wire:key="kertas_gensen_old_{{ $item['id'] }}">
                                                <!-- Preview -->
                                                <a wire:ignore
                                                    data-fslightbox="{{ $item['id'] }}"
                                                    href="{{ $item['url'] }}"
                                                    class="block thumbnail-aspect bg-surface-container rounded-lg overflow-hidden"
                                                >
                                                    <img
                                                        src="{{ $item['url'] }}"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </a>

                                                <!-- Actions -->
                                                <div class="absolute top-1 right-1 z-10">
                                                    <!-- Tag A (Download) -->
                                                  

                                                    <!-- Tag Button (Delete) -->
                                                    <button 
                                                        type="button"
                                                        wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::KERTAS_GENSEN }}')"
                                                        class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                    >
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>

                                            </div>
                                        @elseif($item['isPdf'])
                                            
                                            <div class="relative group/thumb" wire:key="kertas_gensen_old_{{ $item['id'] }}">
                                                {{-- IFRAME PDF Preview --}}
                                                <a wire:ignore data-fslightbox="{{$item['id']}}" data-type="iframe" href="#{{$item['id']}}"
                                                class="block thumbnail-aspect bg-surface-container rounded-lg overflow-scroll">    
                                                    <embed src="{{ $item['url'] }}" type="application/pdf" width="100%" style="min-height: 200px;" class="pointer-events-none">
                                                </a>       
                                                <!-- Actions -->
                                                <div class="absolute top-1 right-1 z-10">
                                                    <!-- Tag A (Download) -->
                                                
                                                    <!-- Tag Button (Delete) -->
                                                    <button 
                                                        type="button"
                                                        wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::KERTAS_GENSEN }}')"
                                                        class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                    >
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>
                                                {{-- Iframe Full Preview --}}
                                                <div style="position:absolute; left:-9999px; top:-9999px;">
                                                    <iframe
                                                        src="{{$item['url']}}"
                                                        id="{{$item['id']}}"
                                                        width="1920"
                                                        height="1080"
                                                        frameborder="0"
                                                    ></iframe>
                                                </div>
                                            </div>
                                        @else
                                            <div class="border rounded p-4 text-center bg-light" wire:key="kertas_gensen_old_{{ $index }}">
                                                <i class="bi bi-file-earmark fs-1"></i>
                                                <div class="mt-2">
                                                    {{$item['url']}}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- Card: Rekap Pengiriman Uang -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm flex flex-col gap-md group hover:border-primary-container transition-colors">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="font-h2 text-body-lg text-on-surface">Rekap Pengiriman</h2>
                                </div>
                            </div>
                                @if ($rekap_pengiriman_uang)
                                    @foreach ($rekap_pengiriman_uang as $rekap_index => $rekap)
                                        <div
                                                x-data="{
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
                                                @dragover.prevent="isDragging = true"
                                                @dragleave.prevent="isDragging = false"
                                                @drop.prevent="handleDrop($event)"
                                                :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                                class="form-group mt-5">
                                            <div class="border-2 border-dashed border-outline-variant/30 py-1 rounded-xl text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                                <input class="hidden validate-upload-file" id="rekap_pengiriman_uang.{{$rekap_index}}.file" name="rekap_pengiriman_uang.{{$rekap_index}}.file"
                                                    type="file"
                                                    multiple
                                                    x-ref="input"
                                                    wire:model="rekap_pengiriman_uang.{{$rekap_index}}.file"
                                                    @change="handleFiles"
                                                    accept="application/pdf"
                                                    class="position-absolute invisible" />
                                                <select class="form-select w-75 m-auto text-center" wire:model.live="rekap_pengiriman_uang.{{$rekap_index}}.remittance_type">
                                                    @foreach (App\Enums\Gensen\GensenAttachmentRemittanceType::options() as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="rekap_pengiriman_uang.{{$rekap_index}}.file" class="{{($rekap['remittance_type']) ? '' : 'd-none'}} border-2 border-dashed border-outline-variant hover:border-primary hover:bg-primary-fixed/10 transition-all cursor-pointer rounded-lg p-md flex flex-col items-center justify-center gap-sm text-center">
                                                    <span class="material-symbols-outlined text-primary text-3xl">upload_file</span>
                                                    <div class="text-body-sm">
                                                        <span class="text-primary font-semibold">Click to upload</span> or drag and drop
                                                    </div>
                                                </label>
                                                <div class="grid grid-cols-2 gap-sm">
                                                    @foreach ($rekap['file'] as $file_index => $item)
                                                        @php
                                                            $ext = $item->getClientOriginalExtension();
                                                            if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                            $url = $item->temporaryUrl();
                                                            
                                                        // $url = route('preview.temp.image', $item->getFileName());
                                                        $filename = $item->getClientOriginalName();
                                                            }elseif(in_array($ext, ['pdf'])){
                                                            $url = route('preview.temp.pdf', $item->getFileName());
                                                            $filename = $item->getClientOriginalName();
                                                            }else{
                                                            $filename = $item->getClientOriginalName();
                                                            }
                                                            $ext = strtolower($ext);
                                                        @endphp
                                                        @if(in_array($ext, ['pdf']))
                                                            <a wire:key="rekap_pengiriman_new_{{ $filename }}"
                                                                class="relative thumbnail-aspect bg-surface-container rounded-lg overflow-hidden group/thumb"
                                                            >
                                                                <iframe
                                                                    src="{{ $url }}"
                                                                    type="application/pdf"
                                                                    width="100%"
                                                                    height="200"
                                                                    class="pointer-events-none"
                                                                ></iframe>

                                                            </a> 
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <button type="button" wire:click="addRekapPengirimanUang" class="border-2 border-dashed border-outline-variant hover:border-primary hover:bg-primary-fixed/10 transition-all cursor-pointer rounded-lg p-md flex flex-col items-center justify-center gap-sm text-center">
                                    <span class="material-symbols-outlined text-primary text-3xl">add_circle</span>
                                    <div class="text-body-sm">Add files</div>
                                </button>
                                @if ($rekap_pengiriman_uang_old)
                                    <div class="grid grid-cols-2 gap-sm">
                                        @foreach ($rekap_pengiriman_uang_old['groups'] as $group_index => $group)
                                            {{-- <h3 class="ms-[10px] text-center">{{$rekap_pengiriman_uang_old['groups'][$group_index]['provider']}}</h3> --}}
                                            @if (!empty($group['files']))
                                            @foreach ($group['files'] as $rekap_index => $item)
                                                @if($item['isPdf'])
                                                    <div class="relative group/thumb" wire:key="rekap_pengirian_old_{{ $item['id'] }}" 
                                                        x-init="if(window.refreshFsLightbox) refreshFsLightbox()">
                                                        {{-- IFRAME PDF Preview --}}
                                                        <a data-fslightbox="rekap_pengiriman_{{$item['id']}}" data-type="iframe" href="#{{$item['id']}}"
                                                        class="block thumbnail-aspect bg-surface-container rounded-lg overflow-scroll">    
                                                            <embed src="{{ $item['url'] }}" type="application/pdf" width="100%" style="min-height: 200px;" class="pointer-events-none">
                                                        </a>       
                                                        <!-- Actions -->
                                                        <div class="absolute top-1 right-1 z-10">
                                                            <!-- Tag A (Download) -->
                                                         
                                                            <!-- Tag Button (Delete) -->
                                                            <button 
                                                                type="button"
                                                                wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::REKAP_PENGIRIMAN_UANG }}')"
                                                                class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                            >
                                                                <span class="material-symbols-outlined text-xl">delete</span>
                                                            </button>
                                                        </div>
                                                        {{-- Iframe Full Preview --}}
                                                        <div style="position:absolute; left:-9999px; top:-9999px;">
                                                            <iframe
                                                                src="{{$item['url']}}"
                                                                id="{{$item['id']}}"
                                                                width="1920"
                                                                height="1080"
                                                                frameborder="0"
                                                            ></iframe>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="border rounded p-4 text-center bg-light"  wire:key="rekap_pengirian_old_{{ $item['id'] }}">
                                                        <i class="bi bi-file-earmark fs-1"></i>
                                                        <div class="mt-2">
                                                            {{$item['url']}}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            
                            {{-- <div class="flex items-center justify-center h-40 bg-surface-container-low rounded-lg border border-outline-variant border-dashed">
                                <p class="text-body-sm text-secondary italic">No documents uploaded</p>
                            </div> --}}
                        </div>
                        <!-- Card: Kartu Keluarga -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm flex flex-col gap-md group hover:border-primary-container transition-colors">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="font-h2 text-body-lg text-on-surface">Kartu Keluarga</h2>
                                </div>
                            </div>
                            <!-- Upload Zone -->
                            <div
                                x-data="{
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
                                    return;
                                    // Optional: you can limit or validate here
                                    }
                                }"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                class="form-group">
                                    <label for="kartu_keluarga" class="border-2 border-dashed border-outline-variant hover:border-primary hover:bg-primary-fixed/10 transition-all cursor-pointer rounded-lg p-md flex flex-col items-center justify-center gap-sm text-center">
                                        <span class="material-symbols-outlined text-primary text-3xl">upload_file</span>
                                        <div class="text-body-sm">
                                            <span class="text-primary font-semibold">Click to upload</span> or drag and drop
                                        </div>
                                    </label>
                                    <input class="hidden validate-upload-file" id="kartu_keluarga" name="kartu_keluarga"
                                    type="file"
                                    multiple
                                    x-ref="input"
                                    wire:model="kartu_keluarga"
                                    @change="handleFiles"
                                    accept="application/pdf, image/jpeg, image/png"
                                    class="position-absolute invisible" />
                            </div>
                            <!-- File Previews -->
                            <div class="grid grid-cols-2 gap-sm">
                                @if ($kartu_keluarga)
                                    @foreach ($kartu_keluarga as $index => $item)
                                        @php
                                            $ext = $item->getClientOriginalExtension();
                                            if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                $url = $item->temporaryUrl();
                                                
                                                        // $url = route('preview.temp.image', $item->getFileName());
                                                $filename = $item->getClientOriginalName();
                                            }elseif(in_array($ext, ['pdf'])){
                                                $url = route('preview.temp.pdf', $item->getFileName());
                                                $filename = $item->getClientOriginalName();
                                            }else{
                                                $filename = $item->getClientOriginalName();
                                            }
                                            $ext = strtolower($ext);
                                        @endphp
                                        {{-- {!! $kartu_keluarga_note[$index] !!} --}}
                                        @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                            {{-- IMAGE --}}
                                            <!-- Preview -->
                                            <div class="relative group/thumb" wire:key="kartu_keluarga_new_{{ $filename }}">
                                                <a
                                                    data-fslightbox="kartu_keluarga_{{ rand() }}"
                                                    href="{{ $url }}"
                                                    class="block thumbnail-aspect bg-surface-container rounded-lg overflow-hidden"
                                                >
                                                    <img
                                                        src="{{ $url }}"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </a>
                                            </div>
                                        @elseif(in_array($ext, ['pdf']))
                                            {{-- IFRAME PDF --}}
                                            <a  wire:key="kartu_keluarga_new_{{ $filename }}"
                                                class="relative thumbnail-aspect bg-surface-container rounded-lg overflow-hidden group/thumb"
                                            >
                                                <iframe
                                                    src="{{ $url }}"
                                                    type="application/pdf"
                                                    width="100%"
                                                    height="200"
                                                    class="pointer-events-none"
                                                ></iframe>

                                            </a> 
                                        @else
                                            {{-- <div class="border rounded p-4 text-center bg-light">
                                                <i class="bi bi-file-earmark fs-1"></i>
                                                <div class="mt-2">
                                                    {{$filename}}
                                                </div>
                                            </div> --}}
                                        @endif
                                    @endforeach
                                @endif
                                @if (!empty($kartu_keluarga_old && $kartu_keluarga_old['groups']))
                                    @foreach ($kartu_keluarga_old['groups'][0]['files'] as $index => $item)
                                        {{-- {!! $kartu_keluarga_old_note[$index] !!} --}}
                                        @if($item['isImage'] ?? 0)
                                            <div class="relative group/thumb"  wire:key="kartu_keluarga_old_{{ $item['id'] }}">
                                                <!-- Preview -->
                                                <a
                                                    data-fslightbox="kartu_keluarga_old_{{ $item['id'] }}"
                                                    href="{{ $item['url'] }}"
                                                    class="block thumbnail-aspect bg-surface-container rounded-lg overflow-hidden"
                                                >
                                                    <img
                                                        src="{{ $item['url'] }}"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </a>

                                                <!-- Actions -->
                                                <div class="absolute top-1 right-1 z-10">
                                                    <!-- Tag A (Download) -->
                                                   

                                                    <!-- Tag Button (Delete) -->
                                                    <button 
                                                        type="button"
                                                        wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::KARTU_KELUARGA }}')"
                                                        class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                    >
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>

                                            </div>
                                        @elseif($item['isPdf'])
                                            
                                            <div class="relative group/thumb"  wire:key="kartu_keluarga_old_{{ $item['id'] }}">
                                                {{-- IFRAME PDF Preview --}}
                                                <a data-fslightbox="kartu_keluarga_old_{{$item['id']}}" data-type="iframe" href="#{{$item['id']}}"
                                                class="block thumbnail-aspect bg-surface-container rounded-lg overflow-scroll">    
                                                    <embed src="{{ $item['url'] }}" type="application/pdf" width="100%" style="min-height: 200px;" class="pointer-events-none">
                                                </a>       
                                                <!-- Actions -->
                                                <div class="absolute top-1 right-1 z-10">
                                                    <!-- Tag A (Download) -->
                                                   

                                                    <!-- Tag Button (Delete) -->
                                                    <button 
                                                        type="button"
                                                        wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::KARTU_KELUARGA }}')"
                                                        class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                    >
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>
                                                {{-- Iframe Full Preview --}}
                                                <div style="position:absolute; left:-9999px; top:-9999px;">
                                                    <iframe
                                                        src="{{$item['url']}}"
                                                        id="{{$item['id']}}"
                                                        width="1920"
                                                        height="1080"
                                                        frameborder="0"
                                                    ></iframe>
                                                </div>
                                            </div>
                                        @else
                                            <div class="border rounded p-4 text-center bg-light" wire:key="kartu_keluarga_old_{{ $item['id'] }}">
                                                <i class="bi bi-file-earmark fs-1"></i>
                                                <div class="mt-2">
                                                    {{$item['url']}}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- Card: Zairyou Card (Front/Back) -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm flex flex-col gap-md group hover:border-primary-container transition-colors">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="font-h2 text-body-lg text-on-surface">Zairyou Card</h2>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-sm">
                                <div class="flex flex-col gap-xs">
                                    <span class="text-label-caps text-[10px] text-secondary">FRONT SIDE</span>
                                    @if ($zairyou_card_front_old['id'])
                                        @if($zairyou_card_front_old['isImage'])
                                            <div wire:key="zairyou_card_front_{{ $zairyou_card_front_old['id'] }}" class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                                <!-- Actions -->
                                                <div class="absolute top-1 right-1 z-10">
                                                   <!-- Tag A (Download) -->
                                                  

                                                    <!-- Tag Button (Delete) -->
                                                    <button 
                                                        type="button"
                                                        wire:click.stop="showDialogDeleteFile('{{ $zairyou_card_front_old['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::ZAIRYOU_CARD_FRONT }}')"
                                                        class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                    >
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$zairyou_card_front_old['url']}}"/>
                                            </div>
                                        @endif
                                    @elseif ($zairyou_card_front)
                                        @php
                                            $ext = $zairyou_card_front->getClientOriginalExtension();
                                            if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                            $filename = $zairyou_card_front->getClientOriginalName();
                                            $url = $zairyou_card_front->temporaryUrl();
                                            
                                                        // $url = route('preview.temp.image', $zairyou_card_front->getFileName());
                                            }elseif(in_array($ext, ['pdf'])){
                                            $url = route('preview.temp.pdf', $zairyou_card_front->getFileName());
                                            $filename = $zairyou_card_front->getClientOriginalName();
                                            }else{
                                            $filename = $zairyou_card_front->getClientOriginalName();
                                            }
                                            $ext = strtolower($ext);
                                        @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png']))
                                            <div wire:key="zairyou_card_front_{{ $filename }}" class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">    
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$url}}"/>
                                            </div>
                                        @endif
                                    @else
                                        <div
                                            x-data="{
                                                isDragging: false,
                                                handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                const dataTransfer = new DataTransfer();
                                                dataTransfer.items.add(file);
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
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false"
                                            @drop.prevent="handleDrop($event)"
                                            :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                            class="form-group">
                                                <label for="zairyou_card_front" class="aspect-video cursor-pointer bg-surface-container-low rounded-lg border border-dashed border-outline-variant flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-secondary">add_photo_alternate</span>
                                                </label>
                                                {{-- <label for="zairyou_card_front" class="border-2 border-dashed border-outline-variant hover:border-primary hover:bg-primary-fixed/10 transition-all cursor-pointer rounded-lg p-md flex flex-col items-center justify-center gap-sm text-center">
                                                    
                                                </label> --}}
                                            <input class="hidden validate-upload-file" id="zairyou_card_front.1" name="zairyou_card_front"
                                                type="file"
                                                x-ref="input"
                                                {{-- wire:model="zairyou_card_front" --}}
                                                @change="handleFiles"
                                                accept="application/pdf, image/jpeg, image/png"
                                                class="position-absolute invisible" />
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col gap-xs">
                                    <span class="text-label-caps text-[10px] text-secondary">BACK SIDE</span>
                                    @if ($zairyou_card_back_old['id'])
                                        @if($zairyou_card_back_old['isImage'])
                                            <div wire:key="zairyou_card_back_{{ $zairyou_card_back_old['id'] }}" class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                                <!-- Actions -->
                                                <div class="absolute top-1 right-1 z-10">
                                                    <!-- Tag A (Download) -->
                                                 

                                                    <!-- Tag Button (Delete) -->
                                                    <button 
                                                        type="button"
                                                        wire:click.stop="showDialogDeleteFile('{{ $zairyou_card_back_old['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::ZAIRYOU_CARD_BACK }}')"
                                                        class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                    >
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$zairyou_card_back_old['url']}}"/>
                                            </div>
                                        @endif
                                    @elseif ($zairyou_card_back)
                                        @php
                                            $ext = $zairyou_card_back->getClientOriginalExtension();
                                            if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                            $filename = $zairyou_card_back->getClientOriginalName();
                                            $url = $zairyou_card_back->temporaryUrl();
                                            
                                                        // $url = route('preview.temp.image', $zairyou_card_back->getFileName());
                                            }elseif(in_array($ext, ['pdf'])){
                                            $url = route('preview.temp.pdf', $zairyou_card_back->getFileName());
                                            $filename = $zairyou_card_back->getClientOriginalName();
                                            }else{
                                            $filename = $zairyou_card_back->getClientOriginalName();
                                            }
                                            $ext = strtolower($ext);
                                        @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png']))
                                            <div wire:key="zairyou_card_back_{{ $filename }}" class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">    
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$url}}"/>
                                            </div>
                                        @endif
                                    @else
                                        <div
                                            x-data="{
                                                isDragging: false,
                                                handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                const dataTransfer = new DataTransfer();
                                                dataTransfer.items.add(file);
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
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false"
                                            @drop.prevent="handleDrop($event)"
                                            :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                            class="form-group">
                                                <label for="zairyou_card_back" class="aspect-video cursor-pointer bg-surface-container-low rounded-lg border border-dashed border-outline-variant flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-secondary">add_photo_alternate</span>
                                                </label>
                                                {{-- <label for="zairyou_card_back" class="border-2 border-dashed border-outline-variant hover:border-primary hover:bg-primary-fixed/10 transition-all cursor-pointer rounded-lg p-md flex flex-col items-center justify-center gap-sm text-center">
                                                    
                                                </label> --}}
                                            <input class="hidden validate-upload-file" id="zairyou_card_back.1" name="zairyou_card_back"
                                                type="file"
                                                x-ref="input"
                                                {{-- wire:model="zairyou_card_back" --}}
                                                @change="handleFiles"
                                                accept="application/pdf, image/jpeg, image/png"
                                                class="position-absolute invisible" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Card: My Number (Front/Back) -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm flex flex-col gap-md group hover:border-primary-container transition-colors">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="font-h2 text-body-lg text-on-surface">My Number</h2>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-sm">
                                <div class="flex flex-col gap-xs">
                                    <span class="text-label-caps text-[10px] text-secondary">FRONT SIDE</span>
                                    @if ($my_number_front_old['id'])
                                        @if($my_number_front_old['isImage'])
                                            <div wire:key="my_number_front_{{ $my_number_front_old['id'] }}" class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                                <!-- Actions -->
                                                <div class="absolute top-1 right-1 z-10">
                                                    <!-- Tag A (Download) -->
                                                  

                                                    <!-- Tag Button (Delete) -->
                                                    <button 
                                                        type="button"
                                                        wire:click.stop="showDialogDeleteFile('{{ $my_number_front_old['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::MY_NUMBER_FRONT }}')"
                                                        class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                    >
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$my_number_front_old['url']}}"/>
                                            </div>
                                        @endif
                                    @elseif ($my_number_front)
                                        @php
                                            $ext = $my_number_front->getClientOriginalExtension();
                                            if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                            $filename = $my_number_front->getClientOriginalName();
                                            $url = $my_number_front->temporaryUrl();
                                            
                                                        // $url = route('preview.temp.image', $my_number_front->getFileName());
    //                                                     $fullPath = $my_number_front->getRealPath();
    // $relativePath = Str::after($fullPath, 'livewire-tmp/');

    // $url = route('preview.temp.file', $relativePath);
                                            }elseif(in_array($ext, ['pdf'])){
                                            $url = route('preview.temp.pdf', $my_number_front->getFileName());
                                            $filename = $my_number_front->getClientOriginalName();
                                            }else{
                                            $filename = $my_number_front->getClientOriginalName();
                                            }
                                            $ext = strtolower($ext);
                                        @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png']))
                                            <div wire:key="my_number_front_{{ $filename }}" class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">    
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$url}}"/>
                                            </div>
                                        @endif
                                    @else
                                        <div
                                            x-data="{
                                                isDragging: false,
                                                handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                const dataTransfer = new DataTransfer();
                                                dataTransfer.items.add(file);
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
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false"
                                            @drop.prevent="handleDrop($event)"
                                            :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                            class="form-group">
                                                <label for="my_number_front" class="aspect-video cursor-pointer bg-surface-container-low rounded-lg border border-dashed border-outline-variant flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-secondary">add_photo_alternate</span>
                                                </label>
                                                {{-- <label for="my_number_front" class="border-2 border-dashed border-outline-variant hover:border-primary hover:bg-primary-fixed/10 transition-all cursor-pointer rounded-lg p-md flex flex-col items-center justify-center gap-sm text-center">
                                                    
                                                </label> --}}
                                            <input class="hidden validate-upload-file" id="my_number_front.1" name="my_number_front"
                                                type="file"
                                                x-ref="input"
                                                {{-- wire:model="my_number_front" --}}
                                                @change="handleFiles"
                                                accept="application/pdf, image/jpeg, image/png"
                                                class="position-absolute invisible" />
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col gap-xs">
                                    <span class="text-label-caps text-[10px] text-secondary">BACK SIDE</span>
                                    @if ($my_number_back_old['id'])
                                        @if($my_number_back_old['isImage'])
                                            <div wire:key="my_number_back_{{ $my_number_back_old['id'] }}" class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                                <!-- Actions -->
                                                <div class="absolute top-1 right-1 z-10">
                                                    <!-- Tag A (Download) -->
                                                 

                                                    <!-- Tag Button (Delete) -->
                                                    <button 
                                                        type="button"
                                                        wire:click.stop="showDialogDeleteFile('{{ $my_number_back_old['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::MY_NUMBER_BACK }}')"
                                                        class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                    >
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$my_number_back_old['url']}}"/>
                                            </div>
                                        @endif
                                    @elseif ($my_number_back)
                                        @php
                                            $ext = $my_number_back->getClientOriginalExtension();
                                            if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                            $filename = $my_number_back->getClientOriginalName();
                                            $url = $my_number_back->temporaryUrl();
                                            
                                                        // $url = route('preview.temp.image', $my_number_back->getFileName());
                                            }elseif(in_array($ext, ['pdf'])){
                                            $url = route('preview.temp.pdf', $my_number_back->getFileName());
                                            $filename = $my_number_back->getClientOriginalName();
                                            }else{
                                            $filename = $my_number_back->getClientOriginalName();
                                            }
                                            $ext = strtolower($ext);
                                        @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png']))
                                            <div wire:key="my_number_back_{{ $filename }}" class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">    
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$url}}"/>
                                            </div>
                                        @endif
                                    @else
                                        <div
                                            x-data="{
                                                isDragging: false,
                                                handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                const dataTransfer = new DataTransfer();
                                                dataTransfer.items.add(file);
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
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false"
                                            @drop.prevent="handleDrop($event)"
                                            :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                            class="form-group">
                                                <label for="my_number_back" class="aspect-video cursor-pointer bg-surface-container-low rounded-lg border border-dashed border-outline-variant flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-secondary">add_photo_alternate</span>
                                                </label>
                                                {{-- <label for="my_number_back" class="border-2 border-dashed border-outline-variant hover:border-primary hover:bg-primary-fixed/10 transition-all cursor-pointer rounded-lg p-md flex flex-col items-center justify-center gap-sm text-center">
                                                    
                                                </label> --}}
                                            <input class="hidden validate-upload-file" id="my_number_back.1" name="my_number_back"
                                                type="file"
                                                x-ref="input"
                                                {{-- wire:model="my_number_back" --}}
                                                @change="handleFiles"
                                                accept="application/pdf, image/jpeg, image/png"
                                                class="position-absolute invisible" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Card: Rekening Indonesia -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm flex flex-col gap-md group hover:border-primary-container transition-colors">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="font-h2 text-body-lg text-on-surface">Rekening Indonesia</h2>
                                </div>
                            </div>
                            
                                    @if ($rekening_indonesia_old['id'])
                                        @if($rekening_indonesia_old['isImage'])
                                            <div wire:key="rekening_indonesia_{{ $rekening_indonesia_old['id'] }}" class="relative thumbnail-aspect bg-surface-container rounded-lg overflow-hidden group/thumb max-w-[160px] mx-auto">
                                                <!-- Actions -->
                                                <div class="absolute top-1 right-1 z-10">
                                                    <!-- Tag A (Download) -->
                                                   
                                                    <!-- Tag Button (Delete) -->
                                                    <button 
                                                        type="button"
                                                        wire:click.stop="showDialogDeleteFile('{{ $rekening_indonesia_old['id'] }}', '{{ App\Enums\Gensen\GensenAttachmentType::REKENING_INDONESIA }}')"
                                                        class="inline-flex items-center justify-center p-1 bg-white/80 hover:bg-error/10 text-error rounded h-8 w-8 transition-colors"
                                                    >
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$rekening_indonesia_old['url']}}"/>
                                            </div>
                                        @endif
                                    @elseif ($rekening_indonesia)
                                        @php
                                            $ext = $rekening_indonesia->getClientOriginalExtension();
                                            if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                            $filename = $rekening_indonesia->getClientOriginalName();
                                            $url = $rekening_indonesia->temporaryUrl();
                                            
                                                        // $url = route('preview.temp.image', $rekening_indonesia->getFileName());
                                            }elseif(in_array($ext, ['pdf'])){
                                            $url = route('preview.temp.pdf', $rekening_indonesia->getFileName());
                                            $filename = $rekening_indonesia->getClientOriginalName();
                                            }else{
                                            $filename = $rekening_indonesia->getClientOriginalName();
                                            }
                                            $ext = strtolower($ext);
                                        @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png']))
                                        {{-- <div class="relative thumbnail-aspect bg-surface-container rounded-lg overflow-hidden group/thumb max-w-[160px] mx-auto">
                                            <div class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">    
                                                <img class="w-full h-full object-cover" data-alt="" src="{{$url}}"/>
                                            </div>
                                        </div> --}}
                                        <div wire:key="rekening_indonesia_{{ $filename }}" class="relative thumbnail-aspect bg-surface-container rounded-lg overflow-hidden group/thumb max-w-[160px] mx-auto">
                                            <img class="w-full h-full object-cover" data-alt="" src="{{$url}}"/>
                                            
                                        </div>
                                        @endif
                                    @else
                                    <div
                                            x-data="{
                                                isDragging: false,
                                                handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                const dataTransfer = new DataTransfer();
                                                dataTransfer.items.add(file);
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
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false"
                                            @drop.prevent="handleDrop($event)"
                                            :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                            class="form-group">
                                                <label for="rekening_indonesia" class="aspect-video cursor-pointer bg-surface-container-low rounded-lg border border-dashed border-outline-variant flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-secondary">add_photo_alternate</span>
                                                </label>
                                                {{-- <label for="rekening_indonesia" class="border-2 border-dashed border-outline-variant hover:border-primary hover:bg-primary-fixed/10 transition-all cursor-pointer rounded-lg p-md flex flex-col items-center justify-center gap-sm text-center">
                                                    
                                                </label> --}}
                                            <input class="hidden validate-upload-file" id="rekening_indonesia.1" name="rekening_indonesia"
                                                type="file"
                                                x-ref="input"
                                                {{-- wire:model="rekening_indonesia" --}}
                                                @change="handleFiles"
                                                accept="image/jpeg, image/png"
                                                class="position-absolute invisible" />
                                        </div>
                                        {{-- <div class="relative thumbnail-aspect bg-surface-container rounded-lg overflow-hidden group/thumb d-flex border-2 border-blue-300 md:w-1/2 h-full mx-auto">
                                            <div
                                                x-data="{
                                                isDragging: false,
                                                handleDrop(event) {
                                                const file = event.dataTransfer.files[0]; // Only take the first file
                                                if (file) {
                                                const dataTransfer = new DataTransfer();
                                                dataTransfer.items.add(file);
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
                                                @dragover.prevent="isDragging = true"
                                                @dragleave.prevent="isDragging = false"
                                                @drop.prevent="handleDrop($event)"
                                                :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                                class="form-group">
                                                    <label for="rekening_indonesia" class="w-full h-full aspect-video cursor-pointer bg-surface-container-low rounded-lg border border-dashed border-outline-variant flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-secondary">add_photo_alternate</span>
                                                    </label>
                                                <input class="hidden validate-upload-file" id="rekening_indonesia" name="rekening_indonesia"
                                                    type="file"
                                                    x-ref="input"
                                                    wire:model="rekening_indonesia"
                                                    @change="handleFiles"
                                                    accept="application/pdf, image/jpeg, image/png"
                                                    class="position-absolute invisible" />
                                            </div>
                                        </div> --}}
                                    @endif
                                    
                                
                        </div>
                        </div>
                    </div>
                    <!-- Sticky Footer Note (Floating Action Style) -->
                    <!-- <div class="fixed bottom-lg left-1/2 -translate-x-1/2 z-40 bg-on-surface text-white px-xl py-md rounded-2xl shadow-xl flex items-center gap-md">
                        <span class="material-symbols-outlined text-primary-container">info</span>
                        <p class="text-body-sm font-medium">All uploads are encrypted and secure. Supported: PDF, JPG, PNG (Max 10MB)</p>
                        <button class="ml-xl bg-white/10 hover:bg-white/20 p-xs rounded-full"><span class="material-symbols-outlined">close</span></button>
                    </div> -->
                </main>
                
            </div>
            <div class="tab-pane fade" id="kt_vtab_pane_3" role="tabpanel" wire:ignore.self>
                <!-- Main Content Area: Split Pane Layout -->
                @if ($onload)
                    <main class="w-full max-w-container-max mx-auto flex flex-row border overflow-hidden p-0">
                        <!-- Left Column: Validation Form (approx 40% based on guidance, though prompt asked for 30%. Defaulting to system guidance of 40% for right pane but prompt asked left. I will use 35/65 split to balance) -->
                        <section class="w-[35%] p-5 flex flex-col h-full bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm">
                            <div class="row">
                                <button type="button" class="btn btn-primary w-full" wire:click="addGensenFormDetail">Tambah Gensen</button>
                            </div>
                            <div class="row my-3 d-flex">
                                @foreach ($tahun_gensen_details as $index_tahun_gensen => $tahun_gensen_detail)
                                    <div class="my-2 d-flex justify-content-between w-full" wire:key="tahun_gensen_details_{{ $tahun_gensen_detail['id'] ? $tahun_gensen_detail['id'] : $tahun_gensen_detail['key'] }}">
                                        <div class="col-md-2">
                                            <input
                                                    class="form-control"
                                                    wire:model="tahun_gensen_details.{{ $index_tahun_gensen }}.tahun_gensen"
                                                    type="text"
                                                    placeholder="Reiwa"
                                                />
                                        </div>
                                        <div class="col">
                                            <input
                                                    class="form-control"
                                                    wire:model="tahun_gensen_details.{{ $index_tahun_gensen }}.nominal_gensen"
                                                    type="text"
                                                    placeholder="Nominal Gensen"
                                                />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="bg-surface-container px-lg py-md border-b border-outline-variant flex justify-between items-center">
                            <h2 class="text-headline-md font-headline-md text-on-surface">Data Extraction Results</h2>
                            <span class="bg-secondary-container text-on-primary-fixed-variant fw-bold px-2 py-1 rounded-full text-label-sm font-label-sm">CONFIDENCE {{ $remittance_extraction_confidence }}</span>
                            </div>
                            <div class="flex-1 overflow-y-auto p-lg flex flex-col gap-lg">
                            
                            <!-- Group 2: Financials -->
                            <div class="space-y-4">
                                <h3 class="text-label-bold font-label-bold text-on-surface-variant uppercase border-b border-outline-variant pb-2 mt-4">Remittance Details</h3>
                                
                                @if ($remittance_extraction_groups && !$gensen_has_pending_ai_jobs)
                                    @foreach ($remittance_extraction_groups as $index_remittance_extraction => $remittance)
                                        <div class="flex items-start gap-md p-sm hover:bg-surface-container-lowest rounded-lg border border-transparent hover:border-outline-variant transition-colors group">
                                            <input wire:model.live="remittance_extraction_groups.{{ $index_remittance_extraction }}.is_validate" class="mt-1 h-4 w-4 rounded border-outline text-primary focus:ring-primary-container bg-surface cursor-pointer" type="checkbox"/>
                                            <div class="flex-1">
                                                <label class="text-label-sm font-label-sm text-on-surface-variant block mb-1">{{$remittance['receiver_name']}} - {{$remittance['transaction_year']}}</label>
                                                <div class="row">
                                                    <input
                                                        class="form-control"
                                                        wire:model.defer="remittance_extraction_groups.{{ $index_remittance_extraction }}.receiver_relationship"
                                                        type="text"
                                                        placeholder="Hubungan"
                                                    />
                                                </div>
                                                <div class="row">
                                                    <button type="button" data-bs-toggle="collapse" href="#collapse_remittance_groups_{{ $remittance['id'] }}" role="button" aria-expanded="false" aria-controls="#collapse_remittance_groups_{{ $remittance['id'] }}" 
                                                        class="w-full text-body-md font-body-md text-on-surface bg-surface p-2 border border-outline-variant rounded flex justify-between items-center opacity-70 m-0">
                                                        <span class="font-data-mono text-data-mono">@currency($remittance['total_amount']) - {{$remittance['currency']}}</span>
                                                        @if ($remittance['total_amount'] >= 380000)
                                                            <span class="material-symbols-outlined text-outline text-[16px]">check_circle</span>
                                                        @endif
                                                    </button >
                                                </div>
                                                <div id="collapse_remittance_groups_{{ $remittance['id'] }}" class="collapse" aria-labelledby="headingOne" wire:ignore>
                                                    <div class="card-body py-0">
                                                        <ul class="list-group list-group-flush">
                                                            @foreach ($remittance['amount_details'] as $index_detail => $item)
                                                                <li wire:key="remittance_detail_{{ $remittance['id'] }}_{{ $index_detail }}" class="list-group-item text-dark">@currency($item)</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @elseif($gensen_has_pending_ai_jobs)
                                    <div class="">
                                        <div class="btn text-white w-100" style="background-color: #5d2fc2; "> 
                                            <span>
                                            Sedang Memproses <i class="fa-solid fa-wand-magic-sparkles text-white animate-wand"></i>
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="">
                                        <div class="btn text-white w-100" style="background-color: #e5a54b; "> 
                                            <span>
                                            Data belum diproses
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <h1 class="text-label-bold font-label-bold text-on-surface-variant text-[20pt] uppercase border-b border-outline-variant pb-2 mt-4 text-right">Total : @currency($remittance_validate_total)</h1>
                            </div>
                            </div>
                            <!-- Action Bar -->
                            <div class="p-md border-t border-outline-variant bg-surface-container-lowest flex justify-end gap-sm row d-flex flex-nowrap justify-content-evenly">
                                @if (!empty($rekap_pengiriman_uang_old['groups']))
                                    <div class="col-4">
                                        <button wire:click="submitRemittanceExtractionJob" type="button" class="px-6 py-2 bg-primary text-on-dark rounded-lg text-body-md font-body-md font-semibold hover:bg-on-secondary-container transition-colors shadow-sm">
                                        AI extract
                                        </button>
                                    </div>
                                @endif
                            <div class="col-4">
                                <button wire:click="getRemittanceExtraction" type="button" class="px-6 py-2 bg-warning text-on-dark rounded-lg text-body-md font-body-md font-semibold hover:bg-on-secondary-container transition-colors shadow-sm">
                                Refresh Data
                                </button>
                            </div>
                            <div class="col-4">
                                <button wire:click="confirmRemittanceValidation" type="button" class="px-6 py-2 bg-success text-on-dark rounded-lg text-body-md font-body-md font-semibold hover:bg-on-secondary-container transition-colors shadow-sm">
                                Confirm Data
                                </button>
                            </div>
                            </div>
                        </section>
                        <!-- Right Column: Document Preview (approx 65%) -->
                        <section class="w-[65%] flex flex-col h-full bg-[#1E293B] rounded-xl overflow-hidden shadow-inner relative group m-0">
                            <!-- Overlay Header -->
                            <div class="absolute top-0 left-0 w-full p-md bg-gradient-to-b from-black/60 to-transparent z-10 flex justify-between items-start pointer-events-none">
                                <h2 class="text-headline-md text-white drop-shadow-md">Document Preview: Kartu Keluarga</h2>
                            
                            </div>
                            <!-- Document Canvas -->
                            <div
                                class="h-[500px] overflow-scroll p-xl mt-3 relative flex flex-col gap-4"
                            >

                            @if(!empty($kertas_gensen_old['groups'][0]['files'] ?? []))

                            {{-- @for ($i = 0; $i < 2; $i++) --}}
                                
                            @foreach ($kertas_gensen_old['groups'][0]['files'] as $item)

                                @if ($item['isImage'])
                                    <img
                                        wire:ignore
                                        src="{{ $item['url'] }}"
                                        x-data="{
                                            rotate: false,
                                            init() {
                                                const img = new Image();

                                                img.onload = () => {
                                                    this.rotate = img.height > img.width;
                                                };

                                                img.src = this.$el.src;
                                            }
                                        }"
                                        x-init="init()"
                                        class="shadow-2xl bg-white border border-white rounded transition-all duration-300"
                                    />
                                @else
                                    <embed
                                        src="{{ $item['url'] }}"
                                        type="application/pdf"
                                        class="w-full"
                                        style="min-height: 450px;"
                                    >

                                @endif

                            @endforeach
                            {{-- @endfor --}}

                            @endif
                            @if(!empty($kartu_keluarga_old['groups'][0]['files'] ?? []))

                            {{-- @for ($i = 0; $i < 2; $i++) --}}
                                
                            @foreach ($kartu_keluarga_old['groups'][0]['files'] as $item)

                                @if ($item['isImage'])
                                    <img
                                        wire:ignore
                                        src="{{ $item['url'] }}"
                                        x-data="{
                                            rotate: false,
                                            init() {
                                                const img = new Image();

                                                img.onload = () => {
                                                    this.rotate = img.height > img.width;
                                                };

                                                img.src = this.$el.src;
                                            }
                                        }"
                                        x-init="init()"
                                        :class="rotate
                                            ? '-rotate-90 max-h-[42vw] mx-auto object-contain'
                                            : 'w-full object-contain'
                                        "
                                        class="shadow-2xl bg-white border border-white rounded transition-all duration-300"
                                    />
                                @else
                                    <embed
                                        src="{{ $item['url'] }}"
                                        type="application/pdf"
                                        class="w-full"
                                        style="min-height: 450px;"
                                    >

                                @endif

                            @endforeach
                            {{-- @endfor --}}

                            @endif

                            </div>
                        </section>
                    </main>
                @endif
             
            </div>
            <div class="tab-pane fade" id="kt_vtab_pane_4" role="tabpanel" wire:ignore.self>
                <!-- Main Content Area -->
                @if ($onload)
                    <main class="h-screen flex overflow-hidden">
                        <!-- File List Panel -->
                        <div class="w-80 border-r border-outline-variant/10 bg-surface-container-low flex flex-col">
                            
                            <div class="flex-1 overflow-y-auto p-4 space-y-3 file-scroll-mask"  
                                @if(!$seluruh_berkas_old['isJobProcessDone']
                                    || !$persyaratan_pengurusan_gensen_old['isJobProcessDone'])
                                    wire:poll.5s="refreshData"
                                @endif>
                                <h3>Seluruh Berkas</h3>
                                @if ($seluruh_berkas_old['isJobProcess'] && $seluruh_berkas_old['isJobProcess']->status == App\Enums\Gensen\JobStatus::DONE)
                                    @if ($seluruh_berkas_old['id'] == $showData['id'])
                                        <div class="bg-surface-container-lowest p-3 rounded-xl shadow-[0px_8px_32px_rgba(25,28,30,0.06)] border-l-4 border-primary group cursor-pointer transition-all duration-200"
                                        wire:click="showFile('{{$seluruh_berkas_old['id']}}', '{{$seluruh_berkas_old['url']}}', '{{$seluruh_berkas_old['type']}}', '{{$seluruh_berkas_old['nama_file']}}', '{{$seluruh_berkas_old['created_at']}}')">
                                            <div class="flex gap-3">
                                                <div class="h-10 w-10 bg-primary/5 rounded-lg flex items-center justify-center text-primary">
                                                    <span class="material-symbols-outlined">picture_as_pdf</span>
                                                </div>
                                    @else
                                        <div class="p-3 rounded-xl hover:bg-surface-container-lowest transition-all duration-200 group cursor-pointer" 
                                        wire:click="showFile('{{$seluruh_berkas_old['id']}}', '{{$seluruh_berkas_old['url']}}', '{{$seluruh_berkas_old['type']}}', '{{$seluruh_berkas_old['nama_file']}}', '{{$seluruh_berkas_old['created_at']}}')">
                                        <div class="flex gap-3">
                                            <div class="h-10 w-10 bg-secondary/5 rounded-lg flex items-center justify-center text-secondary-container">
                                                <span class="material-symbols-outlined">description</span>
                                            </div>
                                    @endif
                                            <div class="flex-1 overflow-hidden">
                                                <h6 class="text-[10px] text-on-surface">{{$seluruh_berkas_old['nama_file']}}</h6>
                                                <div class="flex items-center justify-between mt-1">
                                                    <span class="text-[10px] text-outline font-medium">{{ formatFileSize($seluruh_berkas_old['size']) }} • {{ Carbon\Carbon::parse($seluruh_berkas_old['created_at'])->format('M j, Y') }}</span>
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($seluruh_berkas_old['isJobProcess'] && ($seluruh_berkas_old['isJobProcess']->status == App\Enums\Gensen\JobStatus::PENDING || $seluruh_berkas_old['isJobProcess']->status == App\Enums\Gensen\JobStatus::PROCESSING))
                                <div class="">
                                    <div class="btn text-white w-100" style="background-color: #5d2fc2; "> 
                                        <span>
                                        Sedang Memproses <i class="fa-solid fa-wand-magic-sparkles text-white animate-wand"></i>
                                        </span>
                                    </div>
                                </div>
                                @endif
                                <h3>Persyaratan Pengurusan Gensen</h3>
                                @if ($persyaratan_pengurusan_gensen_old['isJobProcess'] && $persyaratan_pengurusan_gensen_old['isJobProcess']->status == App\Enums\Gensen\JobStatus::DONE)
                                    @if ($persyaratan_pengurusan_gensen_old['id'] == $showData['id'])
                                        <div class="bg-surface-container-lowest p-3 rounded-xl shadow-[0px_8px_32px_rgba(25,28,30,0.06)] border-l-4 border-primary group cursor-pointer transition-all duration-200"
                                        wire:click="showFile('{{$persyaratan_pengurusan_gensen_old['id']}}', '{{$persyaratan_pengurusan_gensen_old['url']}}', '{{$persyaratan_pengurusan_gensen_old['type']}}', '{{$persyaratan_pengurusan_gensen_old['filename']}}', '{{$persyaratan_pengurusan_gensen_old['created_at']}}')">
                                            <div class="flex gap-3">
                                                <div class="h-10 w-10 bg-primary/5 rounded-lg flex items-center justify-center text-primary">
                                                    <span class="material-symbols-outlined">picture_as_pdf</span>
                                                </div>
                                    @else
                                        <div class="p-3 rounded-xl hover:bg-surface-container-lowest transition-all duration-200 group cursor-pointer" 
                                        wire:click="showFile('{{$persyaratan_pengurusan_gensen_old['id']}}', '{{$persyaratan_pengurusan_gensen_old['url']}}', '{{$persyaratan_pengurusan_gensen_old['type']}}', '{{$persyaratan_pengurusan_gensen_old['filename']}}', '{{$persyaratan_pengurusan_gensen_old['created_at']}}')">
                                        <div class="flex gap-3">
                                            <div class="h-10 w-10 bg-secondary/5 rounded-lg flex items-center justify-center text-secondary-container">
                                                <span class="material-symbols-outlined">description</span>
                                            </div>
                                    @endif
                                            <div class="flex-1 overflow-hidden">
                                                <h6 class="text-[10px] text-on-surface">{{$persyaratan_pengurusan_gensen_old['filename']}}</h6>
                                                <div class="flex items-center justify-between mt-1">
                                                    <span class="text-[10px] text-outline font-medium">{{ formatFileSize($persyaratan_pengurusan_gensen_old['size']) }} • {{ Carbon\Carbon::parse($persyaratan_pengurusan_gensen_old['created_at'])->format('M j, Y') }}</span>
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($seluruh_berkas_old['isJobProcess'] && ($seluruh_berkas_old['isJobProcess']->status == App\Enums\Gensen\JobStatus::PENDING || $seluruh_berkas_old['isJobProcess']->status == App\Enums\Gensen\JobStatus::PROCESSING))
                                    
                                    <div class="">
                                        <div class="btn text-white w-100" style="background-color: #5d2fc2; "> 
                                            <span>
                                            Sedang Memproses <i class="fa-solid fa-wand-magic-sparkles text-white animate-wand"></i>
                                            </span>
                                        </div>
                                    </div>
                                
                                @endif
                                <h3>Kertas Gensen</h3>

                                @if (!empty($kertas_gensen_old && $kertas_gensen_old['groups']))
                                    @foreach ($kertas_gensen_old['groups'][0]['files'] as $item)

                                        <div
                                            wire:key="kertas_gensen_{{ $item['id'] }}"
                                            wire:click="showFile(
                                                '{{ $item['id'] }}',
                                                '{{ $item['url'] }}',
                                                '{{ $item['type'] }}',
                                                '{{ $item['filename'] }}',
                                                '{{ $item['created_at'] }}',
                                                '{{ $item['isImage'] ?? 0 }}'
                                            )"
                                            class="
                                                p-3 rounded-xl transition-all duration-200 group cursor-pointer
                                                {{ $item['id'] == $showData['id']
                                                    ? 'bg-surface-container-lowest shadow-[0px_8px_32px_rgba(25,28,30,0.06)] border-l-4 border-primary'
                                                    : 'hover:bg-surface-container-lowest'
                                                }}
                                            "
                                        >

                                            <div class="flex gap-3">

                                                <div class="
                                                    h-10 w-10 rounded-lg flex items-center justify-center
                                                    {{ $item['id'] == $showData['id']
                                                        ? 'bg-primary/5 text-primary'
                                                        : 'bg-secondary/5 text-secondary-container'
                                                    }}
                                                ">
                                                    <span class="material-symbols-outlined">
                                                        {{ $item['id'] == $showData['id']
                                                            ? 'picture_as_pdf'
                                                            : 'description'
                                                        }}
                                                    </span>
                                                </div>

                                                <div class="flex-1 overflow-hidden">
                                                    <h6 class="text-[10px] text-on-surface">
                                                        {{ $item['filename'] }}
                                                    </h6>

                                                    <div class="flex items-center justify-between mt-1">
                                                        <span class="text-[10px] text-outline font-medium">
                                                            {{ formatFileSize($item['size']) }}
                                                            •
                                                            {{ Carbon\Carbon::parse($item['created_at'])->format('M j, Y') }}
                                                        </span>

                                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    @endforeach
                                @endif
                                <h3>Rekap Pengiriman Uang</h3>

                                @if(!empty($rekap_pengiriman_uang_old['groups'] ?? []))

                                    @foreach ($rekap_pengiriman_uang_old['groups'] as $group_index => $group)

                                        <h3 class="ms-[10px]">
                                            {{ $group['provider'] }}
                                        </h3>

                                        @foreach ($group['files'] ?? [] as $item)

                                            <div
                                                wire:key="rekap_{{ $item['id'] }}"
                                                wire:click="showFile(
                                                    '{{ $item['id'] }}',
                                                    '{{ $item['url'] }}',
                                                    '{{ $item['type'] }}',
                                                    '{{ $item['filename'] }}',
                                                    '{{ $item['created_at'] }}',
                                                    '0'
                                                )"
                                                class="
                                                    p-3 rounded-xl transition-all duration-200 group cursor-pointer
                                                    {{ $item['id'] == $showData['id']
                                                        ? 'bg-surface-container-lowest shadow-[0px_8px_32px_rgba(25,28,30,0.06)] border-l-4 border-primary'
                                                        : 'hover:bg-surface-container-lowest'
                                                    }}
                                                "
                                            >

                                                <div class="flex gap-3">

                                                    <div class="
                                                        h-10 w-10 rounded-lg flex items-center justify-center
                                                        {{ $item['id'] == $showData['id']
                                                            ? 'bg-primary/5 text-primary'
                                                            : 'bg-secondary/5 text-secondary-container'
                                                        }}
                                                    ">
                                                        <span class="material-symbols-outlined">
                                                            {{ $item['id'] == $showData['id']
                                                                ? 'picture_as_pdf'
                                                                : 'description'
                                                            }}
                                                        </span>
                                                    </div>

                                                    <div class="flex-1 overflow-hidden">
                                                        <h6 class="text-[10px] text-on-surface">
                                                            {{ $item['filename'] }}
                                                        </h6>

                                                        <div class="flex items-center justify-between mt-1">
                                                            <span class="text-[10px] text-outline font-medium">
                                                                {{ formatFileSize($item['size']) }}
                                                                •
                                                                {{ Carbon\Carbon::parse($item['created_at'])->format('M j, Y') }}
                                                            </span>

                                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        @endforeach

                                    @endforeach

                                @endif
                                <h3>Kartu Keluarga</h3>

                                @if(!empty($kartu_keluarga_old['groups'][0]['files'] ?? []))

                                    @foreach ($kartu_keluarga_old['groups'][0]['files'] as $item)

                                        <div
                                            wire:key="kk_{{ $item['id'] }}"
                                            wire:click="showFile(
                                                '{{ $item['id'] }}',
                                                '{{ $item['url'] }}',
                                                '{{ $item['type'] }}',
                                                '{{ $item['filename'] }}',
                                                '{{ $item['created_at'] }}',
                                                '{{ $item['isImage'] ?? 0 }}'
                                            )"
                                            class="
                                                p-3 rounded-xl transition-all duration-200 group cursor-pointer
                                                {{ $item['id'] == $showData['id']
                                                    ? 'bg-surface-container-lowest shadow-[0px_8px_32px_rgba(25,28,30,0.06)] border-l-4 border-primary'
                                                    : 'hover:bg-surface-container-lowest'
                                                }}
                                            "
                                        >

                                            <div class="flex gap-3">

                                                <div class="
                                                    h-10 w-10 rounded-lg flex items-center justify-center
                                                    {{ $item['id'] == $showData['id']
                                                        ? 'bg-primary/5 text-primary'
                                                        : 'bg-secondary/5 text-secondary-container'
                                                    }}
                                                ">
                                                    <span class="material-symbols-outlined">
                                                        {{ $item['id'] == $showData['id']
                                                            ? 'picture_as_pdf'
                                                            : 'description'
                                                        }}
                                                    </span>
                                                </div>

                                                <div class="flex-1 overflow-hidden">
                                                    <h6 class="text-[10px] text-on-surface">
                                                        {{ $item['filename'] }}
                                                    </h6>

                                                    <div class="flex items-center justify-between mt-1">
                                                        <span class="text-[10px] text-outline font-medium">
                                                            {{ formatFileSize($item['size']) }}
                                                            •
                                                            {{ Carbon\Carbon::parse($item['created_at'])->format('M j, Y') }}
                                                        </span>

                                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                @endif
                            </div>
                        </div>
                        <!-- Preview Area -->
                        <div class="flex-1 bg-surface-container relative flex flex-col p-6">
                            @if ($showData['id'])
                                <!-- Header/Metadata -->
                                <div class="flex items-start justify-between mb-6">
                                <div>
                                    <h1 class="text-3xl font-extrabold tracking-tight text-primary font-headline">{{$showData['file_name']}}</h1>
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase tracking-wider">{{$showData['type']}}</span>
                                        <span class="text-xs text-outline font-medium">• Dibuat {{Carbon\Carbon::parse($showData['created_at'])->diffForHumans()}}</span>
                                    </div>
                                </div>
                                </div>
                                <!-- PDF Preview Container -->
                                <div class="flex-1 bg-surface-container-lowest rounded-xl relative shadow-[0px_8px_32px_rgba(25,28,30,0.04)] overflow-hidden flex flex-col">
                                    <!-- PDF Viewer Toolbar -->
                                    <div class="glass-toolbar border-b border-outline-variant/10 px-4 py-3 flex items-center justify-between z-10">
                                        
                                    </div>
                                    <!-- Document Content Simulation -->
                                    @if ($showData['isImage'])
                                        <img src="{{$showData['url']}}" class="img-fluid rounded img-thumbnail">
                                    @else
                                        <embed src="{{$showData['url']}}" type="application/pdf" width="100%" height="100%">
                                    @endif
                                </div>
                            @else
                                <img id="preview" class="w-full object-cover" data-alt="majestic snow-capped mountain peaks reflecting in a crystal clear alpine lake during morning blue hour" 
                                    src="{{asset(config('template.logo_panel'))}}"/>
                            @endif
                        </div>
                    </main>
                @endif
             
            </div>
        </div>
    </div>
    
    <div class="loading-screen" id="loadingScreen">
        <div class="loader"></div>
        <div class="loading-text" id="loadingText">Mengompresi gambar... (15.71 MB)</div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
            </svg>
        </span>
    </div>
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
        /* Loading Screen */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
        .loading-screen.show {
            display: flex;
        }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading-text {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }

        .file-preview.show {
            display: block;
        }
        .file-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .file-name {
            font-weight: 500;
            color: #333;
        }
        .file-size {
            color: #666;
            font-size: 0.9em;
        }
    </style>

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
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/fslightbox/index.js"></script>
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
                $wire.$set('onload', true);
                $wire.getOnload();
                
                document.getElementById('cropBtn')
                .addEventListener('click', () => {

                    if(!cropper) return;

                    const canvas = cropper.getCroppedCanvas({
                        maxWidth:1500,
                        maxHeight:1500,
                    });

                    canvas.toBlob(async (blob) => {
                        if (!blob) return;

                        const file = new File([blob], 'cropped.jpg', { type: 'image/jpeg' });
                        const type = $wire.editedData['type']; 

                        try {
                            // ✅ Native, official JavaScript UUID generation (Matches Laravel's Str::uuid())
                            const uuid = crypto.randomUUID();
                            // const storedName = `${uuid}.jpg`;

                            const formId = $wire.objId;

                            const target = await @this.getUploadTargetPath(type);

                            // const path = `gensen/${formId}/${type}/${storedName}`;
                            
                            uploadFileToSupabase(file, target.path);

                            // Pass metadata to Livewire
                            const fileMetadata = {
                                stored_name: target.stored_name,
                                file_size: file.size,
                                extension: 'jpg',
                                mime_type: 'image/jpeg',
                                original_name: 'cropped.jpg'
                            };

                            // @this.call('storeDirectMeta', fileMetadata);

                        } catch (error) {
                            console.error('Upload cycle error:', error);
                        }
                    }, 'image/jpeg', 1);
                    // canvas.toBlob(blob => {

                    //     const file = new File(
                    //         [blob],
                    //         'cropped.jpg',
                    //         { type:'image/jpeg' }
                    //     );
                    //     @this.upload(
                    //         'photo',
                    //         file,
                    //         () => {
                    //             console.log('uploaded');
                    //             // ✅ NOW file exists
                    //             @this.call('store');
                    //         },

                    //         () => console.log('error'),

                    //         (progress) => console.log(progress.detail.progress)
                    //     );

                    // }, 'image/jpeg', 1);
                });
                
                async function uploadFileToSupabase(file, path) {
                    console.log('path');
                    console.log(path);
                    const { data, error } = await window.supabase.storage.from('gensen-exata').upload(path, file)
                    if (error) {
                        console.log('upload error');
                        // Handle error
                    } else {
                        console.log('upload berhasil');
                        // Handle success
                    }
                }
                setTimeout(() => {
                    // updateSubstepDescription();
                    // showUploadedFilesSummary();
                    initializeFileInputs();
                    // initializeFormSubmits();
                }, 200); 
                Livewire.on('handleCropper', (data) => {
                setTimeout(() => {
                const image = document.getElementById('preview');
                const preview_type = document.getElementById('preview_type');

                    if (cropper) {
                        cropper.destroy();
                    }

                    url = data[0].url;
                    // console.log(['url',url]);
                    image.src = url;
                    // preview_type.innerHTML = url;

                    // image.onload = () => {
                        cropper = new Cropper(image, {
                        viewMode:0,
                        autoCropArea:1,
                        // responsive:true
                        });
                    // };
                    // cropper = new Cropper(image,{
                    //     viewMode:0,
                    //     autoCropArea:1,
                    //     responsive:true
                    // });
                },50);
            });
            Livewire.on('handleGetData',async (data) => {
                console.log('Fetching data asynchronously...');

                try {
                    // This runs asynchronously without blocking the browser UI thread
                    const result = await @this.call('getData'); 
                    
                    console.log('Data fetched successfully!', result);
                } catch (error) {
                    console.error('Failed to fetch data:', error);
                }
            });
                Livewire.on('initializeFileInputs', (data) => {
                    setTimeout(() => {
                        // updateSubstepDescription();
                        // showUploadedFilesSummary();
                        initializeFileInputs();
                        // initializeFormSubmits();
                    }, 200); 
                });
                window.Echo.channel('export-remittance-extranction')
                    .subscribed(() => console.log('SUBSCRIBED'))
                    .listen('.export.remittance-extraction.finished', (e) => {
                        console.log('EVENT MASUK:', e);
                        Livewire.dispatch('remittance-extraction-updated',{gensen_form_id: e.gensen_form_id});
                });
                window.Echo.channel('export-merge-attachment-status')
                    .subscribed(() => console.log('SUBSCRIBED'))
                    .listen('.export.merge-attachment-status.updated', (e) => {
                        console.log('EVENT MASUK:', e);
                        Livewire.dispatch('merge-attachment-updated',{gensen_form_id: e.gensen_form_id});
                });
            });
            {{-- Compress File Upload --}}
            const MAX_FILE_SIZE = 20 * 1024 * 1024; // 50MB in bytes (before compression)
            const TARGET_FILE_SIZE = 2 * 1024 * 1024; // Target 2MB after compression
            const MAX_UPLOAD_SIZE = 5 * 1024 * 1024; // Maximum 3MB after compression
            const formId = '7035';
            let currentSubstep = 1;
            let previewResult = '';
            let uploadIndex = 0;
            let uploadMulti = false;
            const uploadedFiles = [];
            const substepCompleted = {"1":0,"2":0,"3":0,"4":0};

            // File labels for display
            const fileLabels = {
                'file_1': 'Paspor Identitas diri',
                'file_2': 'Paspor Stempel Imigrasi',
                'file_3': 'Buku nenkin biru / kuning',
                'file_4': 'Buku Rekening / E-statement',
                'file_5': 'Juminhyou / tensetsu todoke',
                'file_6': 'Form Pengganti buku nenkin',
                'file_7': 'Zairyou card - Depan',
                'file_8': 'My Number - Depan',
                'file_9': 'Ichijikin / Form Lumpsum',
                'file_10': 'Zairyou card - Belakang',
                'file_11': 'My Number - Belakang',
                'ktp_file': 'KTP (Kartu Tanda Penduduk)'
            };

            const substepDescriptions = {
                1: 'Upload dokumen identitas dan imigrasi (Paspor, Stempel, Buku Nenkin)',
                2: 'Upload dokumen keuangan dan residensi (Rekening, Juminhyou, Form Nenkin)',
                3: 'Upload kartu identitas (Zairyou Card & My Number)',
                4: 'Upload dokumen lainnya (Ichijikin & KTP)'
            };

            // Store processed files for upload
            const processedFiles = {};

            // HEIC conversion queue to prevent race conditions
            let heicConversionQueue = Promise.resolve();
            const previewObjectUrls = {}; // Track object URLs for cleanup
            let isProcessingFile = false; // Flag to block concurrent uploads

            // Show/Hide loading screen with custom text
            function showLoadingScreen(text) {
                document.getElementById('loadingText').textContent = text;
                document.getElementById('loadingScreen').classList.add('show');
            }

            function hideLoadingScreen() {
                document.getElementById('loadingScreen').classList.remove('show');
            }

            // Disable/Enable all file inputs during processing
            function setFileInputsDisabled(disabled, excludeId = null) {
                document.querySelectorAll('input[type="file"]').forEach(input => {
                    if (input.id !== excludeId) {
                        input.disabled = disabled;
                        if (disabled) {
                            input.style.opacity = '0.5';
                            input.style.cursor = 'not-allowed';
                        } else {
                            input.style.opacity = '1';
                            input.style.cursor = 'pointer';
                        }
                    }
                });
                // Also disable/enable buttons during processing
                document.querySelectorAll('.btn').forEach(btn => {
                    btn.disabled = disabled;
                });
            }

            // Image Compression Function
            async function compressImage(file, fileKey, targetSizeBytes = TARGET_FILE_SIZE, maxSizeBytes = MAX_UPLOAD_SIZE) {
                console.log('start compress');
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = new Image();

                        img.onload = function() {
                            let width = img.width;
                            let height = img.height;
                            let quality = 0.9;

                            // Calculate initial scaling if image is too large
                            const maxDimension = 4096; // Maximum dimension for compatibility
                            if (width > maxDimension || height > maxDimension) {
                                if (width > height) {
                                    height = (height / width) * maxDimension;
                                    width = maxDimension;
                                } else {
                                    width = (width / height) * maxDimension;
                                    height = maxDimension;
                                }
                            }

                            // Aggressive scaling for very large files
                            const fileSizeMB = file.size / (1024 * 1024);
                            if (fileSizeMB > 10) {
                                // Scale down significantly for files over 10MB
                                const scaleFactor = Math.sqrt(10 / fileSizeMB);
                                width = Math.floor(width * scaleFactor);
                                height = Math.floor(height * scaleFactor);
                            } else if (fileSizeMB > 5) {
                                // Moderate scaling for files over 5MB
                                const scaleFactor = Math.sqrt(5 / fileSizeMB);
                                width = Math.floor(width * scaleFactor);
                                height = Math.floor(height * scaleFactor);
                            }

                            // Function to try compression
                            const tryCompress = (w, h, q) => {
                                const canvas = document.createElement('canvas');
                                canvas.width = w;
                                canvas.height = h;

                                const ctx = canvas.getContext('2d');
                                // Use better image smoothing
                                ctx.imageSmoothingEnabled = true;
                                ctx.imageSmoothingQuality = 'high';
                                ctx.drawImage(img, 0, 0, w, h);

                                return new Promise((resolveBlob) => {
                                    canvas.toBlob(
                                        (blob) => resolveBlob(blob),
                                        'image/jpeg',
                                        q
                                    );
                                });
                            };

                            // Iterative compression
                            const compress = async () => {
                                let blob = await tryCompress(width, height, quality);
                                let attempts = 0;
                                const maxAttempts = 10;

                                // First, try adjusting quality
                                while (blob.size > maxSizeBytes && quality > 0.1 && attempts < maxAttempts) {
                                    quality -= 0.1;
                                    blob = await tryCompress(width, height, quality);
                                    attempts++;
                                }

                                // If still too large, reduce dimensions
                                attempts = 0;
                                while (blob.size > maxSizeBytes && attempts < maxAttempts) {
                                    width = Math.floor(width * 0.9);
                                    height = Math.floor(height * 0.9);

                                    // Try with reduced dimensions
                                    blob = await tryCompress(width, height, quality);
                                    attempts++;

                                    // If we got below target, try to improve quality slightly
                                    if (blob.size < targetSizeBytes && quality < 0.9) {
                                        const testQuality = Math.min(0.9, quality + 0.1);
                                        const testBlob = await tryCompress(width, height, testQuality);
                                        if (testBlob.size <= maxSizeBytes) {
                                            blob = testBlob;
                                            quality = testQuality;
                                        }
                                    }
                                }

                                // Create a new File object from the blob
                                const compressedFile = new File(
                                    [blob],
                                    file.name.replace(/\.[^/.]+$/, '.jpg'), // Change extension to jpg
                                    {
                                        type: 'image/jpeg',
                                        lastModified: Date.now()
                                    }
                                );
                                console.log('disini');
                                let upload_name = uploadMulti ? `${fileKey}.${uploadIndex}` : `${fileKey}`;
                                console.log(upload_name);
                                @this.upload(
                                    upload_name,
                                    // `photo.${uploadIndex}`,
                                    compressedFile,

                                    () => {
                                        console.log('uploaded');
                                    },

                                    () => console.log('error'),

                                    (progress) => console.log([
                                        'progress',
                                        progress.detail.progress])
                                );
                                resolve({
                                    file: compressedFile,
                                    originalSize: file.size,
                                    compressedSize: blob.size,
                                    compressionRatio: ((1 - blob.size / file.size) * 100).toFixed(1)
                                });
                            };

                            compress().catch(reject);
                        };

                        img.onerror = function() {
                            reject(new Error('Failed to load image'));
                        };

                        img.src = e.target.result;
                    };

                    reader.onerror = function() {
                        reject(new Error('Failed to read file'));
                    };

                    reader.readAsDataURL(file);
                });
            }

            // File input change handlers
            function initializeFileInputs() {
                document.querySelectorAll('input[type="file"]').forEach(input => {
                    input.addEventListener('change', async function(e) {
                        // Prevent the generic public.php handler from running
                        e.stopImmediatePropagation();
                        const id = e.target.id;

                        const fileKey = id.split('.')[0];
                        
                        // Handle special case for ktp_file
                        const previewId = fileKey === 'ktp_file' ? 'preview_ktp_file' : 'preview_' + fileKey ;
                        const preview = document.getElementById(previewId);

                        const excludeUpload = ['kertas_gensen', 'kartu_keluarga', 'rekap_pengiriman_uang'];
                        previewResult = '';
                        uploadIndex = 0;
                        if(excludeUpload.includes(fileKey)){
                            const files = e.target.files;
                            uploadMulti = true;
                            // if (files.length) {
                            //     await processUploadQueue(files, fileKey, preview);
                            // }
                        }else{
                            uploadMulti = false;
                            const file = e.target.files[0];
                            handleUploadedFile(file, fileKey, preview);
                        }

                        // preview.innerHTML = previewResult;

                        // ✅ NOW file exists
                        setTimeout(() => {
                            @this.call('cobaStore');
                        }, 3000);

                    });
                });
            }
            async function processUploadQueue(files, fileKey, preview) {
                for (const file of files) {
                    console.log('queue upload:', file.name);

                    await handleUploadedFile(file, fileKey, preview);
                }

                console.log('All uploads finished');
            }

            async function handleUploadedFile(file, fileKey, preview){
                console.log('handle upload');
                if (file) {
                    // Block if another file is being processed
                    if (isProcessingFile) {
                        alert('Mohon tunggu proses file sebelumnya selesai.');
                        
                        return;
                    }

                    // Check file size before compression
                    if (file.size > MAX_FILE_SIZE) {
                        alert(`File "${file.name}" terlalu besar! Maksimal 50MB per file.\n\nUkuran file: ${(file.size / 1024 / 1024).toFixed(2)} MB`);
                        
                        preview.classList.remove('show');
                        return;
                    }

                    // Check file type
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/heic', 'image/heif'];
                    // Also check file extension for HEIC files (some browsers don't recognize the MIME type)
                    const fileName = file.name.toLowerCase();
                    const isValidExtension = fileName.endsWith('.jpg') || fileName.endsWith('.jpeg') ||
                                            fileName.endsWith('.png') || fileName.endsWith('.heic') ||
                                            fileName.endsWith('.heif');

                    if (!validTypes.includes(file.type) && !isValidExtension) {
                        alert(`File "${file.name}" format tidak didukung!\n\nHanya JPG, PNG, dan HEIC yang diperbolehkan.`);
                        e.target.value = '';
                        preview.classList.remove('show');
                        return;
                    }

                    // Set processing flag and disable other inputs
                    isProcessingFile = true;
                    setFileInputsDisabled(true, fileKey);

                    // Clear previous preview
                    // preview.innerHTML = '';
                    // preview.classList.add('show');

                    // Show processing message
                    const originalSizeMB = (file.size / 1024 / 1024).toFixed(2);
                    const isHeic = fileName.endsWith('.heic') || fileName.endsWith('.heif') ||
                                    file.type === 'image/heic' || file.type === 'image/heif';

                    // Show full screen loading
                    const loadingMessage = isHeic
                        ? `Mengonversi dan mengompresi gambar... (${originalSizeMB} MB)`
                        : `Mengompresi gambar... (${originalSizeMB} MB)`;
                    showLoadingScreen(loadingMessage);

                    previewText = `
                        <div class="file-info">
                            <span class="file-name">⏳ ${isHeic ? 'Mengonversi dan mengompresi gambar...' : 'Mengompresi gambar...'} (${originalSizeMB} MB)</span>
                            <span class="file-size" style="color: #007bff;">Harap tunggu...</span>
                        </div>
                    `;
                    // preview.innerHTML = previewText;
                    // console.log(previewText);

                    try {
                        // Convert HEIC to JPEG if needed
                        let processedFile = file;
                        if (isHeic) {
                            try {
                                // Queue HEIC conversions to prevent race conditions in libheif
                                processedFile = await new Promise((resolve, reject) => {
                                    heicConversionQueue = heicConversionQueue.then(async () => {
                                        try {
                                            // Small delay to ensure previous conversion is fully cleaned up
                                            await new Promise(r => setTimeout(r, 100));

                                            const convertedBlob = await heic2any({
                                                blob: file,
                                                toType: 'image/jpeg',
                                                quality: 0.9
                                            });
                                            // Convert blob to file
                                            const converted = new File(
                                                [convertedBlob],
                                                file.name.replace(/\.(heic|heif)$/i, '.jpg'),
                                                { type: 'image/jpeg', lastModified: Date.now() }
                                            );
                                            resolve(converted);
                                        } catch (err) {
                                            reject(err);
                                        }
                                    }).catch(err => {
                                        // Ensure queue continues even if one conversion fails
                                        console.log('reject queue')
                                        reject(err);
                                    });
                                });
                            } catch (conversionError) {
                                console.error('HEIC conversion error:', conversionError);
                                let errorMsg = `Gagal mengonversi file HEIC "${file.name}".`;

                                if (conversionError.code === 'ERR_LIBHEIF') {
                                    errorMsg += '\n\nFile HEIC mungkin rusak atau dalam format yang tidak didukung.';
                                } else {
                                    errorMsg += `\n\nError: ${conversionError.message}`;
                                }

                                errorMsg += '\n\nSilakan coba:\n1. Gunakan file HEIC lain\n2. Konversi ke JPG/PNG terlebih dahulu\n3. Ambil foto ulang jika memungkinkan';

                                alert(errorMsg);
                                e.target.value = '';
                                preview.classList.remove('show');
                                // Re-enable inputs after HEIC conversion error
                                isProcessingFile = false;
                                setFileInputsDisabled(false);
                                hideLoadingScreen();
                                return;
                            }
                        }

                        // Compress the image
                        const compressionResult = await compressImage(processedFile, fileKey);
                        const compressedFile = compressionResult.file;

                        // Check if compressed file is still too large
                        if (compressedFile.size > MAX_UPLOAD_SIZE) {
                            alert(`Gagal mengompresi file "${file.name}" ke ukuran yang sesuai.\n\nUkuran asli: ${(file.size / 1024 / 1024).toFixed(2)} MB\nSetelah kompresi: ${(compressedFile.size / 1024 / 1024).toFixed(2)} MB\n\nSilakan gunakan gambar dengan ukuran lebih kecil.`);
                            e.target.value = '';
                            preview.classList.remove('show');
                            // Re-enable inputs after compression size error
                            isProcessingFile = false;
                            setFileInputsDisabled(false);
                            hideLoadingScreen();
                            return;
                        }

                        // Show compression success
                        showFilePreviewWithCompression(compressedFile, compressionResult, preview, fileKey);
                        processedFiles[fileKey] = compressedFile;

                        // Re-enable inputs after successful processing
                        isProcessingFile = false;
                        setFileInputsDisabled(false);
                        hideLoadingScreen();

                    } catch (error) {
                        console.error('Compression error:', error);
                        alert(`Gagal mengompresi file "${file.name}".\n\nError: ${error.message}\n\nSilakan coba file lain.`);
                        e.target.value = '';
                        preview.classList.remove('show');
                        // Re-enable inputs after compression error
                        isProcessingFile = false;
                        setFileInputsDisabled(false);
                        hideLoadingScreen();
                    }
                } else {
                    preview.classList.remove('show');
                    delete processedFiles[fileKey];
                    // Clean up object URL when file is cleared
                    const previewId = preview.id;
                    if (previewObjectUrls[previewId]) {
                        try {
                            URL.revokeObjectURL(previewObjectUrls[previewId]);
                        } catch (e) {
                            // Ignore revoke errors
                        }
                        delete previewObjectUrls[previewId];
                    }
                }
            }

            // Form submit handlers
            function initializeFormSubmits() {
                for (let i = 1; i <= 4; i++) {
                    const form = document.getElementById('substep-form-' + i);
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            submitSubstep(i);
                        });
                    }
                }
            }

            // Submit substep
            async function submitSubstep(substep) {
                const form = document.getElementById('substep-form-' + substep);
                const formData = new FormData();

                // Add processed files (including cropped files) to formData
                const inputs = form.querySelectorAll('input[type="file"]');
                inputs.forEach(input => {
                    const fileKey = input.id;
                    if (processedFiles[fileKey]) {
                        formData.append(input.name, processedFiles[fileKey]);
                    }
                });

                // Show loading screen
                showLoadingScreen('Sedang mengupload dokumen. Harap tunggu...');

                try {
                    const response = await uploadWithRetry(
                        'https://nenkin.web.id/form-online/customer-form/' + formId + '/upload_substep/' + substep,
                        formData,
                        3
                    );

                    const result = await response.json();

                    hideLoadingScreen();

                    if (response.ok && result.success) {
                        if (result.is_final) {
                            // Final substep - redirect to success
                            alert('Upload berhasil! Semua dokumen telah diterima.\n\nAnda akan diarahkan ke halaman konfirmasi...');
                            setTimeout(() => {
                                window.location.href = result.redirect_url;
                            }, 1500);
                        } else {
                            // Move to next substep
                            currentSubstep = result.next_substep;
                            markSubstepCompleted(substep);
                            showSubstep(result.next_substep);

                            // Update uploaded files record
                            result.files_uploaded.forEach(fileKey => {
                                uploadedFiles[fileKey] = true;
                            });
                            showUploadedFilesSummary();
                        }
                    } else {
                        alert('Upload gagal: ' + (result.error || 'Server error') + '\n\nSilakan coba lagi.');
                    }
                } catch (error) {
                    hideLoadingScreen();
                    console.error('Error:', error);
                    alert('Terjadi kesalahan jaringan.\n\nSilakan periksa koneksi internet dan coba lagi.');
                }
            }

            // Skip substep
            function skipSubstep(substep) {
                if (substep === 4) {
                    // Final substep - must submit (can be empty)
                    submitSubstep(substep);
                } else {
                    currentSubstep = substep + 1;
                    showSubstep(currentSubstep);
                }
            }

            // Show specific substep
            function showSubstep(substep) {
                // Hide all forms
                document.querySelectorAll('.substep-form').forEach(form => {
                    form.classList.remove('active');
                });

                // Show target form
                const targetForm = document.getElementById('substep-form-' + substep);
                if (targetForm) {
                    targetForm.classList.add('active');
                }

                // Update indicators
                updateSubstepIndicators(substep);
                updateSubstepDescription();

                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // Update substep indicators
            function updateSubstepIndicators(substep) {
                document.querySelectorAll('.substep-dot').forEach(dot => {
                    const dotSubstep = parseInt(dot.getAttribute('data-substep'));
                    dot.classList.remove('active', 'completed');

                    if (substepCompleted[dotSubstep]) {
                        dot.classList.add('completed');
                        dot.textContent = '';
                    } else if (dotSubstep === substep) {
                        dot.classList.add('active');
                        dot.textContent = dotSubstep;
                    } else {
                        dot.textContent = dotSubstep;
                    }
                });

                // Update progress bar
                const progress = ((substep - 1) / 4) * 100;
                document.getElementById('upload-progress-bar').style.width = progress + '%';

                // Update substep number
                document.getElementById('current-substep-number').textContent = substep;
            }

            // Mark substep as completed
            function markSubstepCompleted(substep) {
                substepCompleted[substep] = 1;
                const dot = document.querySelector('.substep-dot[data-substep="' + substep + '"]');
                if (dot) {
                    dot.classList.remove('active');
                    dot.classList.add('completed');
                    dot.textContent = '';
                }
            }

            // Update substep description
            function updateSubstepDescription() {
                document.getElementById('substep-description').textContent = substepDescriptions[currentSubstep] || '';
            }

            // Show uploaded files summary
            function showUploadedFilesSummary() {
                const summaryDiv = document.getElementById('uploaded-summary');
                const uploadedList = [];

                for (const [key, value] of Object.entries(uploadedFiles)) {
                    if (value) {
                        uploadedList.push(fileLabels[key]);
                    }
                }

                if (uploadedList.length > 0) {
                    let html = '<div class="uploaded-files-summary"><h5>Dokumen yang Sudah Diupload:</h5>';
                    uploadedList.forEach(label => {
                        html += '<div class="uploaded-file-item">' + label + '</div>';
                    });
                    html += '</div>';
                    summaryDiv.innerHTML = html;
                    summaryDiv.style.display = 'block';
                } else {
                    summaryDiv.style.display = 'none';
                }
            }

            // Show file preview with compression details
            function showFilePreviewWithCompression(file, compressionResult, previewElement, fileKey) {
                const fileSizeKB = (file.size / 1024).toFixed(2);
                const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
                const originalSizeMB = (compressionResult.originalSize / 1024 / 1024).toFixed(2);
                const sizeColor = fileSizeMB > 2 ? '#ffc107' : '#28a745';

                let compressionInfo = '';
                if (compressionResult.originalSize !== compressionResult.compressedSize) {
                    compressionInfo = `
                        <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #ccc; font-size: 0.85em; color: #666;">
                            <div>✓ Dikompresi dari ${originalSizeMB} MB (${compressionResult.compressionRatio}% lebih kecil)</div>
                        </div>
                    `;
                }

                // Get preview ID from element
                // const previewId = previewElement.id;

                // // Revoke previous URL if exists to prevent memory leak
                // if (previewObjectUrls[previewId]) {
                //     try {
                //         // URL.revokeObjectURL(previewObjectUrls[previewId]);
                //     } catch (e) {
                //         // Ignore revoke errors
                //     }
                // }

                // Create image preview URL
                // const imageUrl = URL.createObjectURL(file);
                // previewObjectUrls[previewId] = imageUrl;

                previewResult = `
                    <div class="row">
                        <div class="file-info">
                            <span class="file-name">✓ ${file.name}</span>
                            <span class="file-size" style="color: ${sizeColor};">${fileSizeKB} KB</span>
                        </div>
                    </div>
                    ${compressionInfo}
                    
                `;

                // let upload_name = uploadMulti ? `${fileKey}_note.${uploadIndex}` : `${fileKey}_note`;
                // console.log(upload_name);
                // @this.set(upload_name, previewResult);
                uploadIndex++;
                // <div class="row">
                //         <div style="margin-top: 10px; text-align: center;" class="row d-flex jusify-content-center">
                //             <img src="${imageUrl}" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 2px solid #e0e0e0; object-fit: contain;">
                //         </div>
                //     </div>
                // $('#'+previewElement.id).append(previewText);
                // previewElement.classList.add('show');
            }

            // Upload with retry (exponential backoff)
            async function uploadWithRetry(url, formData, maxRetries = 3) {
                for (let i = 0; i < maxRetries; i++) {
                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            body: formData
                        });
                        return response;
                    } catch (error) {
                        if (i === maxRetries - 1) throw error;
                        await sleep(Math.pow(2, i) * 1000); // 1s, 2s, 4s
                    }
                }
            }

            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            
        </script>
    @endscript
    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.addEventListener('change', function (e) {

                if (!e.target.classList.contains('validate-upload-file')) return;

                const input = e.target;
                const file = input.files[0];

                if (!file) return;

                const maxSize = 2 * 1024 * 1024; // 2MB

                if (file.size > maxSize) {
                    Livewire.dispatch('{{ Alert::EVENT_INFO }}', [
                        '{{ Alert::ICON_ERROR }}',
                        'Gagal',
                        'Ukuran file maksimal 2MB'
                    ]);

                    // ❗ STOP LIVEWIRE
                    input.value = '';

                    // important → trigger empty change
                    input.dispatchEvent(new Event('change'));

                    return false;
                }

            }, true); // ✅ CAPTURE MODE (VERY IMPORTANT)

        });
    </script> --}}
    <script>
        // document.addEventListener('DOMContentLoaded', () => {

            // document.addEventListener('change', function (e) {

            //     if (!e.target.classList.contains('validate-upload-file')) return;

            //     const input = e.target;
            //     const files = Array.from(input.files);

            //     if (!files.length) return;

            //     const maxSize = 2 * 1024 * 1024; // 2MB

            //     const validFiles = [];
            //     let hasError = false;

            //     files.forEach(file => {
            //         if (file.size > maxSize) {
            //             hasError = true;
            //         } else {
            //             validFiles.push(file);
            //         }
            //     });

            //     // ❌ if any file invalid
            //     if (hasError) {

            //         Livewire.dispatch('{{ Alert::EVENT_INFO }}', [
            //             '{{ Alert::ICON_ERROR }}',
            //             'Gagal',
            //             'Ukuran file maksimal 2MB'
            //         ]);

            //         // rebuild file list (only valid files)
            //         const dataTransfer = new DataTransfer();

            //         validFiles.forEach(file => {
            //             dataTransfer.items.add(file);
            //         });

            //         input.files = dataTransfer.files;

            //         // VERY IMPORTANT → re-trigger change
            //         input.dispatchEvent(new Event('change', { bubbles: true }));

            //         return false;
            //     }

            // }, true); // CAPTURE MODE

        // });
    </script>
@endpush