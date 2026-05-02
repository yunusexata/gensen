<div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        wire:ignore.self>
        <div class="modal-dialog modal-xl" style="overflow: scroll">
            <div class="modal-content" style="overflow: scroll">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkModalLabel">Edit Point of Recommendation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body import_modal">
                            <!--begin::Stepper-->
                            <div class="stepper stepper-pills" id="kt_stepper_example_clickable" wire:ignore.self>
                                <!--begin::Nav-->
                                <div class="stepper-nav flex-center flex-wrap mb-10" wire:ignore>
                                    <!--begin::Step 1-->
                                    <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                        <!--begin::Wrapper-->
                                        <div class="stepper-wrapper d-flex align-items-center border border-primary rounded p-3 border-dashed">
                                            <!--begin::Icon-->
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">1</span>
                                            </div>
                                            <!--end::Icon-->

                                            <!--begin::Label-->
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">
                                                    Step 1
                                                </h3>

                                                <div class="stepper-desc fw-bold">
                                                    Informasi Personal
                                                </div>
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Wrapper-->

                                        <!--begin::Line-->
                                        <div class="stepper-line h-40px"></div>
                                        <!--end::Line-->
                                    </div>
                                    <!--end::Step 1-->
                                    <!--begin::Step 4-->
                                    <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                        <!--begin::Wrapper-->
                                        <div class="stepper-wrapper d-flex align-items-center border border-primary rounded p-3 border-dashed">
                                            <!--begin::Icon-->
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">2</span>
                                            </div>
                                            <!--begin::Icon-->

                                            <!--begin::Label-->
                                            <div class="stepper-label">
                                                <h3 class="stepper-title">
                                                    Step 2
                                                </h3>

                                                <div class="stepper-desc fw-bold">
                                                    Upload Berkas
                                                </div>
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Step 4-->
                                </div>
                                <!--end::Nav-->

                                <!--begin::Form-->
                                <form class="form w-lg-500px mx-auto" wire:submit.prevent="store" novalidate="novalidate" id="kt_stepper_example_basic_form">
                                    <!--begin::Group-->
                                    <div class="mb-5">
                                        <!--begin::Step 1-->
                                        <div class="flex-column current" data-kt-stepper-element="content" wire:ignore.self>
                                            <!-- Section: Personal Information -->
                                            <section>
                                                <div class="flex items-center gap-3 mb-5">
                                                    <span class="material-symbols-outlined text-primary" data-icon="person">person</span>
                                                    <h2 class="font-headline font-bold text-2xl">Informasi Personal</h2>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="nama_bank_penerima">Nama lengkap</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="nama_lengkap" wire:model="nama_lengkap" name="first_name" placeholder="Nama lengkap" type="text"/>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="tanggal_lahir">Tanggal lahir</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="tanggal_lahir" wire:model="tanggal_lahir" name="tanggal_lahir" type="date"/>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="tanggal_kepulangan">Tanggal kepulangan</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="tanggal_kepulangan" wire:model="tanggal_kepulangan" name="tanggal_kepulangan" type="date"/>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="nama_facebook">Nama Facebook</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="nama_facebook" wire:model="nama_facebook" name="nama_facebook" type="text" placeholder="Nama Facebook"/>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="nomor_whatsapp">Nomor Whatsapp</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="nomor_whatsapp" wire:model="nomor_whatsapp" name="nomor_whatsapp" type="text" placeholder="Nama Facebook"/>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="email">Alamat E-mail</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="email" wire:model="email" name="email" placeholder="jane.smith@example.com" type="email"/>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="nama_lpk">Nama LPK/SOPT</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="nama_lpk" wire:model="nama_lpk" name="nama_lpk" type="text" placeholder="Nama LPK/SO/PT"/>
                                                    </div>
                                                    <div class="flex justify-evenly gap-4 w-full">

                                                        <!-- Tahun Gensen -->
                                                        <div class="flex flex-col flex-1 gap-2">
                                                            <label class="font-label text-xs font-medium text-on-surface-variant" for="tahun_gensen">
                                                                Tahun Gensen (Reiwa)
                                                            </label>

                                                            <input
                                                                class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full"
                                                                id="tahun_gensen"
                                                                wire:model="tahun_gensen"
                                                                name="tahun_gensen"
                                                                type="number"
                                                                placeholder="7"
                                                            />
                                                        </div>

                                                        <!-- Tahun Transfer -->
                                                        <div class="flex flex-col flex-1 gap-2">
                                                            <label class="font-label text-xs font-medium text-on-surface-variant" for="tahun_transfer">
                                                                Tahun Transfer
                                                            </label>

                                                            <input
                                                                class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full"
                                                                id="tahun_transfer"
                                                                wire:model="tahun_transfer"
                                                                name="tahun_transfer"
                                                                type="number"
                                                                placeholder="{{ \Carbon\Carbon::now()->format('Y'); }}"
                                                            />
                                                        </div>

                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Section: Address -->
                                            <section class="mt-5">
                                                <div class="flex items-center gap-3 mb-5">
                                                    <span class="material-symbols-outlined text-primary" data-icon="location_on">location_on</span>
                                                    <h2 class="font-headline font-bold text-2xl">Alamat</h2>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-12 gap-x-8 gap-y-6">
                                                    <div class="flex flex-col gap-2 md:col-span-12">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="alamat_jepang">Alamat Jepang</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="alamat_jepang" wire:model="alamat_jepang" name="alamat_jepang" placeholder="shizuoka-ken hamamatsu-shi nakayama tokiwa building" type="text"/>
                                                    </div>
                                                    {{-- <div class="flex flex-col gap-2 md:col-span-5">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="city">City</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="city" name="city" placeholder="San Francisco" type="text"/>
                                                    </div>
                                                    <div class="flex flex-col gap-2 md:col-span-3">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="state">State / Province</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="state" name="state" placeholder="CA" type="text"/>
                                                    </div> --}}
                                                    <div class="flex flex-col gap-2 md:col-span-4">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="kode_pos_jepang">Kode Pos Jepang</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="kode_pos_jepang" wire:model="kode_pos_jepang" name="kode_pos_jepang" placeholder="Kode Pos Jepang" type="text"/>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Section: Account Balance -->
                                            <section class="mt-5">
                                                <div class="flex items-center gap-3 mb-5">
                                                    <span class="material-symbols-outlined text-primary" data-icon="account_balance">account_balance</span>
                                                    <h2 class="font-headline font-bold text-2xl">Akun Bank</h2>
                                                </div>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="nama_bank_penerima">Nama Bank Penerima</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="nama_bank_penerima" wire:model="nama_bank_penerima" name="first_name" placeholder="Nama Bank Penerima" type="text"/>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="no_rekening_penerima">No Rek Penerima</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="no_rekening_penerima" wire:model="no_rekening_penerima" name="first_name" placeholder="Nama Bank Penerima" type="text"/>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <label class="font-label text-xs font-medium text-on-surface-variant" for="nama_penerima">Nama Penerima</label>
                                                        <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/50 w-full" id="nama_penerima" wire:model="nama_penerima" name="first_name" placeholder="Nama Bank Penerima" type="text"/>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                        <!--begin::Step 1-->

                                        <!--begin::Step 1-->
                                        <div class="flex-column" data-kt-stepper-element="content" wire:ignore.self>
                                            <!-- Section: File Upload -->
                                            {{-- GENSEN --}}
                                            <section class="mt-5">
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
                                                    class="form-group mt-5"
                                                >
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                                                        <h2 class="font-headline font-bold text-2xl">KERTAS GENSEN</h2>
                                                    </div>
                                                    <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                                        <input class="hidden validate-upload-file" id="kertas_gensen" name="kertas_gensen" 
                                                        type="file"
                                                        multiple
                                                        x-ref="input"
                                                        wire:model="kertas_gensen"
                                                        @change="handleFiles"
                                                        accept="image/jpeg, image/png, application/pdf"
                                                        class="position-absolute invisible"/>
                                                        <label class="cursor-pointer flex flex-col items-center gap-3" for="kertas_gensen">
                                                            <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                                                            <p class="text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                                                        </label>
                                                    </div>
                                                    <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                                        @if ($kertas_gensen)
                                                            @foreach ($kertas_gensen as $item)
                                                                @php
                                                                    $ext = $item->getClientOriginalExtension();
                                                                    if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                                        $url = $item->temporaryUrl();
                                                                    }elseif(in_array($ext, ['pdf'])){
                                                                        $url = route('preview.temp.pdf', $item->getFileName());
                                                                        $filename = $item->getClientOriginalName();
                                                                    }else{
                                                                        $filename = $item->getClientOriginalName();
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
                                                            @endforeach
                                                        @endif
                                                        @if ($kertas_gensen_old && $kertas_gensen_old['groups']->isNotEmpty())
                                                            @foreach ($kertas_gensen_old['groups']->first()['files'] as $item)
                                                                @if (!$item['isPdf'] && $item['isImage'])
                                                                    <img src="{{ $item['url'] }}" class="img-fluid rounded img-thumbnail mb-2">
                                                                @elseif($item['isPdf'] && !$item['isImage'])
                                                                    <embed src="{{ $item['url'] }}" type="application/pdf" width="100%" style="min-height: 400px;" class="mb-2">
                                                                        {{-- <iframe
                                                                            src="{{ $item['url'] }}#toolbar=0"
                                                                            width="100%"
                                                                            style="border:none">
                                                                        </iframe> --}}
                                                                @else
                                                                    <div class="border rounded p-4 text-center bg-light mb-2">
                                                                        <i class="bi bi-file-earmark fs-1"></i>
                                                                        <div class="mt-2">
                                                                            {{$item['filename']}}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </section>
                                            {{-- Rekap Pengiriman Uang --}}
                                            <section class="mt-5">
                                                <div class="row mt-5">
                                                    <div class="flex items-center gap-3">
                                                        <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                                                        <h2 class="font-headline font-bold text-2xl">REKAP PENGIRIMAN UANG</h2>
                                                    </div>
                                                    <div class="row">
                                                        <h5 class="font-headline font-bold text-2xl text-center">Contoh Remittance</h5>
                                                    </div>
                                                </div>
                                                {{-- REMITTANCE EXAMPLE --}}
                                                <div class="row justify-content-evenly">

                                                    <div class="col-md-3 d-flex">
                                                        <div class="card-flex text-center">

                                                            <div class="image-box">
                                                                <img src="{{ Storage::url('remittance_example/Remittance_DCOM.jpg') }}"
                                                                    class="img-thumbnail example-img">
                                                            </div>

                                                            <h3 class="fw-bold mt-auto">DCOM</h3>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 d-flex">
                                                        <div class="card-flex text-center">
                                                            <div class="image-box">
                                                                <img src="{{ Storage::url('remittance_example/Remittance_KYODAI.jpg') }}"
                                                                    class="img-thumbnail example-img">
                                                            </div>
                                                            <h3 class="fw-bold mt-auto">KYODAI</h3>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 d-flex">
                                                        <div class="card-flex text-center">
                                                            <div class="image-box">
                                                                <img src="{{ Storage::url('remittance_example/Remittance_RIA_KYODAI.jpg') }}"
                                                                    class="img-thumbnail example-img">
                                                            </div>
                                                            <h3 class="fw-bold mt-auto">RIA KYODAI</h3>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 d-flex">
                                                        <div class="card-flex text-center">
                                                            <div class="image-box">
                                                                <img src="{{ Storage::url('remittance_example/Remittance_SMILES.jpg') }}"
                                                                    class="img-thumbnail example-img">
                                                            </div>
                                                            <h3 class="fw-bold mt-auto">SMILES</h3>
                                                        </div>
                                                    </div>

                                                </div>
                                                @if ($rekap_pengiriman_uang)
                                                    @foreach ($rekap_pengiriman_uang as $rekap_index => $rekap)
                                                        
                                                        <div
                                                            wire:key="rekap_pengiriman_uang_{{$rekap_index}}"
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
                                                            class="form-group"
                                                        >
                                                            <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                                                <input class="hidden validate-upload-file" id="rekap_pengiriman_uang.{{$rekap_index}}.file" name="rekap_pengiriman_uang.{{$rekap_index}}.file" 
                                                                type="file"
                                                                multiple
                                                                x-ref="input"
                                                                wire:model="rekap_pengiriman_uang.{{$rekap_index}}.file"
                                                                @change="handleFiles"
                                                                accept="image/jpeg, image/png, application/pdf"
                                                                class="position-absolute invisible"/>
                                                                
                                                                <select class="form-select w-75 m-auto text-center" wire:model.live="rekap_pengiriman_uang.{{$rekap_index}}.type">
                                                                    <option value="">-- Pilih Remittance --</option>
                                                                    @foreach (App\Models\GensenForm\GensenForm::REMITTANCE_CHOICE as $type)
                                                                        <option value="{{$type}}">{{$type}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($rekap['type'])
                                                                    <label class="cursor-pointer w-75 flex flex-col items-center gap-2 border-2 border-dashed border-blue-100 rounded-lg p-2 rounded" for="rekap_pengiriman_uang.{{$rekap_index}}.file">
                                                                        <span class=" my-0 material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                                        <p class=" my-0 font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class=" my-0 text-primary font-semibold">CARI FILE</span></p>
                                                                        <p class=" my-0 text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                                                                    </label>
                                                                @endif

                                                                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                                                    
                                                                    @foreach ($rekap['file'] as $file_index => $item)
                                                                        @php
                                                                            $ext = $item->getClientOriginalExtension();
                                                                            if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                                                $url = $item->temporaryUrl();
                                                                            }elseif(in_array($ext, ['pdf'])){
                                                                                $url = route('preview.temp.pdf', $item->getFileName());
                                                                                $filename = $item->getClientOriginalName();
                                                                            }else{
                                                                                $filename = $item->getClientOriginalName();
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
                                                                    @endforeach
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @if ($rekap_pengiriman_uang_old)
                                                
                                                    @foreach ($rekap_pengiriman_uang_old['groups'] as $item)
                                                        <h3 class="fw-bold">Remittance {{$item['provider']}}</h3>
                                                        @foreach ($item['files'] as $rekap)
                                                            @if (!$rekap['isPdf'] && $rekap['isImage'])
                                                                <img src="{{ $rekap['url'] }}" class="img-fluid rounded img-thumbnail mb-2">
                                                            @elseif($rekap['isPdf'] && !$rekap['isImage'])
                                                                <embed src="{{ $rekap['url'] }}" type="application/pdf" width="100%" style="min-height: 400px;" class="mb-2">
                                                                    {{-- <iframe
                                                                        src="{{ $rekap['url'] }}#toolbar=0"
                                                                        width="100%"
                                                                        style="border:none">
                                                                    </iframe> --}}
                                                            @else
                                                                <div class="border rounded p-4 text-center bg-light mb-2">
                                                                    <i class="bi bi-file-earmark fs-1"></i>
                                                                    <div class="mt-2">
                                                                        {{$rekap['filename']}}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endif

                                                <div class="row mb-2">
                                                    <button type="button" class="btn btn-success w-100 mx-auto" wire:click="addRekapPengirimanUang"><i class='fa fa-plus'></i> Tambah File <i class='fa fa-plus'></i></button>
                                                </div>
                                            </section>
                                            {{-- Kartu Keluarga --}}
                                            <section class="mt-5">
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
                                                    class="form-group mt-5"
                                                >
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                                                        <h2 class="font-headline font-bold text-2xl">KARTU KELUARGA</h2>
                                                    </div>
                                                    <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                                        <input class="hidden validate-upload-file" id="kartu_keluarga" name="kartu_keluarga" 
                                                        type="file"
                                                        multiple
                                                        x-ref="input"
                                                        wire:model="kartu_keluarga"
                                                        @change="handleFiles"
                                                        accept="image/jpeg, image/png, application/pdf"
                                                        class="position-absolute invisible"/>
                                                        <label class="cursor-pointer flex flex-col items-center gap-3" for="kartu_keluarga">
                                                            <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                                                            <p class="text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                                                        </label>
                                                    </div>
                                                    <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                                        @if ($kartu_keluarga)
                                                            @foreach ($kartu_keluarga as $item)
                                                                @php
                                                                    $ext = $item->getClientOriginalExtension();
                                                                    if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                                        $url = $item->temporaryUrl();
                                                                    }elseif(in_array($ext, ['pdf'])){
                                                                        $url = route('preview.temp.pdf', $item->getFileName());
                                                                        $filename = $item->getClientOriginalName();
                                                                    }else{
                                                                        $filename = $item->getClientOriginalName();
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
                                                            @endforeach
                                                        @endif
                                                        @if ($kartu_keluarga_old && $kartu_keluarga_old['groups']->isNotEmpty()))
                                                            @foreach ($kartu_keluarga_old['groups']->first()['files'] as $item)
                                                                @if (!$item['isPdf'] && $item['isImage'])
                                                                    <img src="{{ $item['url'] }}" class="img-fluid rounded img-thumbnail mb-2">
                                                                @elseif($item['isPdf'] && !$item['isImage'])
                                                                    <embed src="{{ $item['url'] }}" type="application/pdf" width="100%" style="min-height: 400px;" class="mb-2">
                                                                        {{-- <iframe
                                                                            src="{{ $item['url'] }}#toolbar=0"
                                                                            width="100%"
                                                                            style="border:none">
                                                                        </iframe> --}}
                                                                @else
                                                                    <div class="border rounded p-4 text-center bg-light mb-2">
                                                                        <i class="bi bi-file-earmark fs-1"></i>
                                                                        <div class="mt-2">
                                                                            {{$item['filename']}}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </section>
                                            {{-- Zairyou Card Depan--}}
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
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                                                        <h2 class="font-headline font-bold text-2xl">ZAIRYOU CARD (Depan)</h2>
                                                    </div>
                                                    <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                                        <input class="hidden validate-upload-file" id="zairyou_card_front" name="zairyou_card_front" type="file"
                                                        
                                                        x-ref="input"
                                                        wire:model="zairyou_card_front"
                                                        @change="handleFiles"
                                                        accept="image/jpeg, image/png, application/pdf"
                                                        class="position-absolute invisible"/>
                                                        <label class="cursor-pointer flex flex-col items-center gap-3" for="zairyou_card_front">
                                                            <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                                                            <p class="text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                                                        </label>
                                                    </div>
                                                    <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                                        @if ($zairyou_card_front)
                                                            @php
                                                                $ext = $zairyou_card_front->getClientOriginalExtension();
                                                                if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                                    $url = $zairyou_card_front->temporaryUrl();
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

                                                        @if ($zairyou_card_front_old)
                                                            @if (!$zairyou_card_front_old['isPdf'] && $zairyou_card_front_old['isImage'])
                                                                <img src="{{ $zairyou_card_front_old['url'] }}" class="img-fluid rounded img-thumbnail mb-2">
                                                            @elseif($zairyou_card_front_old['isPdf'] && !$zairyou_card_front_old['isImage'])
                                                                <embed src="{{ $zairyou_card_front_old['url'] }}" type="application/pdf" width="100%" style="min-height: 400px;" class="mb-2">
                                                                    {{-- <iframe
                                                                        src="{{ $zairyou_card_front_old['url'] }}#toolbar=0"
                                                                        width="100%"
                                                                        style="border:none">
                                                                    </iframe> --}}
                                                            @else
                                                                <div class="border rounded p-4 text-center bg-light mb-2">
                                                                    <i class="bi bi-file-earmark fs-1"></i>
                                                                    <div class="mt-2">
                                                                        {{$zairyou_card_front_old['filename']}}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </section>
                                            {{-- Zairyou Card Belakang --}}
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
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                                                        <h2 class="font-headline font-bold text-2xl">ZAIRYOU CARD (Belakang)</h2>
                                                    </div>
                                                    <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                                        <input class="hidden validate-upload-file" id="zairyou_card_back" name="zairyou_card_back" type="file"
                                                        
                                                        x-ref="input"
                                                        wire:model="zairyou_card_back"
                                                        @change="handleFiles"
                                                        accept="image/jpeg, image/png, application/pdf"
                                                        class="position-absolute invisible"/>
                                                        <label class="cursor-pointer flex flex-col items-center gap-3" for="zairyou_card_back">
                                                            <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                                                            <p class="text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                                                        </label>
                                                    </div>
                                                    <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                                        @if ($zairyou_card_back)
                                                            @php
                                                                $ext = $zairyou_card_back->getClientOriginalExtension();
                                                                if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                                    $url = $zairyou_card_back->temporaryUrl();
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

                                                        @if ($zairyou_card_back_old)
                                                            @if (!$zairyou_card_back_old['isPdf'] && $zairyou_card_back_old['isImage'])
                                                                <img src="{{ $zairyou_card_back_old['url'] }}" class="img-fluid rounded img-thumbnail mb-2">
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
                                                        @endif
                                                    </div>
                                                </div>
                                            </section>
                                            {{-- My Number Depan --}}
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
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                                                        <h2 class="font-headline font-bold text-2xl">MY NUMBER (Depan)</h2>
                                                    </div>
                                                    <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                                        <input class="hidden validate-upload-file" id="my_number_front" name="my_number_front" type="file"
                                                        
                                                        x-ref="input"
                                                        wire:model="my_number_front"
                                                        @change="handleFiles"
                                                        accept="image/jpeg, image/png, application/pdf"
                                                        class="position-absolute invisible"/>
                                                        <label class="cursor-pointer flex flex-col items-center gap-3" for="my_number_front">
                                                            <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                                                            <p class="text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                                                        </label>
                                                    </div>
                                                    <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                                        @if ($my_number_front)
                                                            @php
                                                                $ext = $my_number_front->getClientOriginalExtension();
                                                                if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                                    $url = $my_number_front->temporaryUrl();
                                                                }elseif(in_array($ext, ['pdf'])){
                                                                    $url = route('preview.temp.pdf', $my_number_front->getFileName());
                                                                    $filename = $my_number_front->getClientOriginalName();
                                                                }else{
                                                                    $filename = $my_number_front->getClientOriginalName();
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

                                                        @if ($my_number_front_old)
                                                            @if (!$my_number_front_old['isPdf'] && $my_number_front_old['isImage'])
                                                                <img src="{{ $my_number_front_old['url'] }}" class="img-fluid rounded img-thumbnail mb-2">
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
                                                        @endif
                                                    </div>
                                                </div>
                                            </section>
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
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                                                        <h2 class="font-headline font-bold text-2xl">MY NUMBER (Belakang)</h2>
                                                    </div>
                                                    <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                                        <input class="hidden validate-upload-file" id="my_number_back" name="my_number_back" type="file"
                                                        
                                                        x-ref="input"
                                                        wire:model="my_number_back"
                                                        @change="handleFiles"
                                                        accept="image/jpeg, image/png, application/pdf"
                                                        class="position-absolute invisible"/>
                                                        <label class="cursor-pointer flex flex-col items-center gap-3" for="my_number_back">
                                                            <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                                                            <p class="text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                                                        </label>
                                                    </div>
                                                    <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                                        @if ($my_number_back)
                                                            @php
                                                                $ext = $my_number_back->getClientOriginalExtension();
                                                                if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                                    $url = $my_number_back->temporaryUrl();
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

                                                        @if ($my_number_back_old)
                                                            @if (!$my_number_back_old['isPdf'] && $my_number_back_old['isImage'])
                                                                <img src="{{ $my_number_back_old['url'] }}" class="img-fluid rounded img-thumbnail mb-2">
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
                                                                        {{$my_number_back_old['filename']}}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </section>
                                            {{-- Rekening Indonesia --}}
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
                                                    <div class="flex items-center gap-3 mb-5">
                                                        <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                                                        <h2 class="font-headline font-bold text-2xl">REKENING INDONESIA</h2>
                                                    </div>
                                                    <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                                        <input class="hidden validate-upload-file" id="rekening_indonesia" name="rekening_indonesia" type="file"
                                                        
                                                        x-ref="input"
                                                        wire:model="rekening_indonesia"
                                                        @change="handleFiles"
                                                        accept="image/jpeg, image/png, application/pdf"
                                                        class="position-absolute invisible"/>
                                                        <label class="cursor-pointer flex flex-col items-center gap-3" for="rekening_indonesia">
                                                            <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                                                            <p class="text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                                                        </label>
                                                    </div>
                                                    <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                                        @if ($rekening_indonesia)
                                                            @php
                                                                $ext = $rekening_indonesia->getClientOriginalExtension();
                                                                if(in_array($ext, ['jpg','jpeg','png','gif','webp'])){
                                                                    $url = $rekening_indonesia->temporaryUrl();
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

                                                        @if ($rekening_indonesia_old)
                                                            @if (!$rekening_indonesia_old['isPdf'] && $rekening_indonesia_old['isImage'])
                                                                <img src="{{ $rekening_indonesia_old['url'] }}" class="img-fluid rounded img-thumbnail mb-2">
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
                                                        @endif
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                        <!--begin::Step 1-->
                                    </div>
                                    <!--end::Group-->

                                    <!--begin::Actions-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Wrapper-->
                                        <div class="me-2">
                                            <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                                Back
                                            </button>
                                        </div>
                                        <!--end::Wrapper-->

                                        <!--begin::Wrapper-->
                                        <div>
                                            <!-- Submit Button Area -->
                                            <div data-kt-stepper-action="submit" class="border-t border-outline-variant/15 flex flex-col md:flex-row items-center justify-between gap-6">
                                                <button class="w-full md:w-auto bg-gradient-to-r rounded from-primary to-primary-container text-white px-10 py-4 rounded-xl font-headline font-bold text-lg hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 shadow-md" type="submit">
                                                    Submit Application
                                                </button>
                                            </div>

                                            <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                                Continue
                                            </button>
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Stepper-->
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('css')
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" />
         <style>
         .material-symbols-outlined {
         font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
         }
         .form-input-focus:focus {
         outline: none;
         border-color: #00629e;
         box-shadow: 0 0 0 4px rgba(207, 229, 255, 0.5);
         }
      </style>
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&amp;family=Work+Sans:wght@600;700;800&amp;display=swap" rel="stylesheet"/>
      <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
      
    @endpush

    @push('js')
        <script>
            document.addEventListener('livewire:init', () => {

            setTimeout(() => {
                initStepper();
            }, 200); 

        });
        function initStepper(){
            // Stepper lement
            var element = document.querySelector("#kt_stepper_example_clickable");
    
            // Initialize Stepper
            var stepper = new KTStepper(element);
    
            // Handle navigation click
            stepper.on("kt.stepper.click", function (stepper) {
                stepper.goTo(stepper.getClickedStepIndex()); // go to clicked step
            });
    
            // Handle next step
            stepper.on("kt.stepper.next", function (stepper) {
                stepper.goNext(); // go next step
            });
    
            // Handle previous step
            stepper.on("kt.stepper.previous", function (stepper) {
                stepper.goPrevious(); // go previous step
            });
        }
        </script>
    @endpush