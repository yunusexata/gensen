<div class="">
    @if ($authorized)

        @if (!$isAdmin)
            <div class="row">
                <livewire:gensen-form.gensen-form.registered-list :token="$objId" />
            </div>
        @endif
        <!--begin::Stepper-->
        <div class="stepper stepper-pills kt-stepper" id="kt_stepper_example_clickable" wire:ignore.self>
            <!--begin::Nav-->
            <div class="stepper-nav flex-center flex-wrap mb-10 ">
                <!--begin::Step 1-->
                @if (!$isUploadAttachment)
                    <div class="stepper-item  w-full md:w-auto mx-8 my-4 current {{ $is_should_filled ? 'd-none' : '' }}"
                        data-kt-stepper-element="nav" data-kt-stepper-action="step" wire:ignore.self>

                        <!--begin::Wrapper-->
                        <div
                            class="stepper-wrapper w-full d-flex align-items-center border border-primary rounded p-3 border-dashed {{ !$is_should_filled ? '' : 'd-none' }}">
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
                @endif

                <!--end::Step 1-->
                <!--begin::Step 4-->
                <div class="stepper-item  w-full md:w-auto mx-8 my-4" data-kt-stepper-element="nav"
                    data-kt-stepper-action="step" wire:ignore.self>
                    <!--begin::Wrapper-->
                    <div
                        class="stepper-wrapper w-full d-flex align-items-center border border-primary rounded p-3 border-dashed">
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
            <form class="form w-lg-500px mx-auto" novalidate="novalidate" id="kt_stepper_example_basic_form">
                <!--begin::Group-->
                <div class="mb-5">
                    @if (!$isUploadAttachment)
                        <!--begin::Personal Information-->
                        <div class="flex-column current" data-kt-stepper-element="content" wire:ignore.self>
                            @if (!$is_should_filled)
                                <!-- Section: Personal Information -->
                                <section>
                                    <div class="flex items-center gap-3 mb-5">
                                        <span class="material-symbols-outlined text-primary"
                                            data-icon="person">person</span>
                                        <h2 class="font-headline font-bold text-2xl">Informasi Personal</h2>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                        <div class="flex flex-col gap-2">
                                            <label class="font-label text-xs font-medium text-on-surface-variant"
                                                for="nama_lengkap">Nama lengkap<span
                                                    class="text-red-500">*</span></label>
                                            <input
                                                class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('nama_lengkap') is-invalid border border-red-500 @enderror"
                                                id="nama_lengkap" wire:model="nama_lengkap" name="nama_lengkap"
                                                placeholder="exata indonesia" type="text" />

                                            @error('nama_lengkap')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label class="font-label text-xs font-medium text-on-surface-variant"
                                                for="email">Alamat E-mail<span class="text-red-500">*</span></label>
                                            <input
                                                class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('email') is-invalid border border-red-500 @enderror"
                                                id="email" wire:model="email" name="email"
                                                placeholder="exata@gmail.com" type="email" />

                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <label class="font-label text-xs font-medium text-on-surface-variant"
                                                for="tanggal_lahir">Tanggal lahir<span
                                                    class="text-red-500">*</span></label>
                                            <input
                                                class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('tanggal_lahir') is-invalid border border-red-500 @enderror"
                                                id="tanggal_lahir" wire:model.live="tanggal_lahir" name="tanggal_lahir"
                                                type="date" />

                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        @if ($gensenFormId)
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="tanggal_kepulangan">Tanggal kepulangan</label>
                                                <input
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('tanggal_kepulangan') is-invalid border border-red-500 @enderror"
                                                    id="tanggal_kepulangan" wire:model="tanggal_kepulangan"
                                                    name="tanggal_kepulangan" type="date" />

                                                @error('tanggal_kepulangan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="nama_instagram">Nama Instagram<span
                                                        class="text-red-500">*</span></label>
                                                <input
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('nama_instagram') is-invalid border border-red-500 @enderror"
                                                    id="nama_instagram" wire:model="nama_instagram"
                                                    name="nama_instagram" type="text" placeholder="exata" />

                                                @error('nama_instagram')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="nama_tiktok">Nama Tiktok<span
                                                        class="text-red-500">*</span></label>
                                                <input
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('nama_tiktok') is-invalid border border-red-500 @enderror"
                                                    id="nama_tiktok" wire:model="nama_tiktok" name="nama_tiktok"
                                                    type="text" placeholder="exata" />

                                                @error('nama_tiktok')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="nomor_whatsapp">Nomor Whatsapp<span
                                                        class="text-red-500">*</span></label>
                                                <input type="text"
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 @error('nomor_whatsapp') is-invalid border border-red-500 @enderror"
                                                    required name="nomor_whatsapp" placeholder="08123456789"
                                                    aria-label="nomor_whatsapp" aria-describedby="basic-addon1"
                                                    wire:model="nomor_whatsapp">
                                                @error('nomor_whatsapp')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <div class="form-text" id="basic-addon4">Contoh +628XXXXXXXXXX</div>
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="nomor_whatsapp_darurat">Nomor Whatsapp Darurat (hubungan)<span
                                                        class="text-red-500">*</span></label>
                                                <input type="text"
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 @error('nomor_whatsapp') is-invalid border border-red-500 @enderror"
                                                    required name="nomor_whatsapp_darurat"
                                                    placeholder="08123456789 (Kakak)"
                                                    aria-label="nomor_whatsapp_darurat"
                                                    aria-describedby="basic-addon1"
                                                    wire:model="nomor_whatsapp_darurat">
                                                @error('nomor_whatsapp_darurat')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <div class="form-text" id="basic-addon4">Contoh +628XXXXXXXXXX</div>
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="nama_lpk">Nama LPK/SO/PT</label>
                                                <input
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('nama_lpk') is-invalid border border-red-500 @enderror"
                                                    id="nama_lpk" wire:model="nama_lpk" name="nama_lpk"
                                                    type="text" placeholder="LPK Minori" />

                                                @error('nama_lpk')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                </section>

                                @if ($gensenFormId)
                                    <!-- Section: Gensen Details -->
                                    <section class="mt-5">
                                        <div class="flex items-center gap-3 mb-5">
                                            <span class="material-symbols-outlined text-primary"
                                                data-icon="location_on">contract_edit</span>
                                            <h2 class="font-headline font-bold text-2xl">Data Gensen</h2>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-x-8 gap-y-6">
                                            <div class="flex flex-col gap-2 md:col-span-12">

                                                @foreach ($gensen_form_details as $index_form_detail => $gensen_detail)
                                                    
                                                    <!-- Tahun Gensen -->
                                                    <label class="font-label text-xs font-medium text-on-surface-variant"
                                                        for="tahun_gensen">
                                                        Tahun Gensen (Reiwa)
                                                    </label>

                                                    <div class="row d-flex flex-nowrap justify-content-between gap-2" wire:key="gensen_form_detail_key_{{ $gensen_detail['key'] }}">
                                                        <div class="col">
                                                            <select wire:model="gensen_form_details.{{$index_form_detail}}.tahun_gensen"
                                                                name="gensen_form_details.{{$index_form_detail}}.tahun_gensen"
                                                                class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus w-full @error('gensen_form_details.{{$index_form_detail}}.tahun_gensen') is-invalid border border-red-500 @enderror">
                                                                <option value="">-- ISI --</option>
                                                                @foreach ($tahun_gensen_choice as $choice)
                                                                    <option value="{{ $choice['value'] }}">{{ $choice['label'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            @error('gensen_form_details.{{$index_form_detail}}.tahun_gensen')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-danger btn-md" wire:click="deleteGensenFormDetail('{{ $index_form_detail }}')">Hapus</button>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <button type="button" class="btn btn-success btm-md w-full" wire:click="addGensenFormDetail()">Tambah Data Gensen</button>

                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="kode_pos_jepang">Apakah gensen yang akan di urus saat ini melalui exata, sudah pernah di urus sendiri atau melalui konsultan lain?<span
                                                        class="text-red-500">*</span></label>
                                                <select id="is_previously_processed" wire:model.live="is_previously_processed"
                                                    name="is_previously_processed"
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus w-full @error('is_previously_processed') is-invalid border border-red-500 @enderror">
                                                    <option value="">-- ISI --</option>
                                                    <option value="sudah">Sudah
                                                    </option>
                                                    <option value="belum">Belum
                                                    </option>
                                                    
                                                </select>
                                                

                                                @error('is_previously_processed')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
 
                                            </div>

                                        </div>
                                    </section>
                                    <!-- Section: Address -->
                                    <section class="mt-5">
                                        <div class="flex items-center gap-3 mb-5">
                                            <span class="material-symbols-outlined text-primary"
                                                data-icon="location_on">location_on</span>
                                            <h2 class="font-headline font-bold text-2xl">Alamat</h2>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-x-8 gap-y-6">
                                            <div class="flex flex-col gap-2 md:col-span-12">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="alamat_jepang">Alamat Jepang<span
                                                        class="text-red-500">*</span></label>
                                                        <textarea class="form-control @error('alamat_jepang') is-invalid border border-red-500 @enderror" id="alamat_jepang" wire:model="alamat_jepang"
                                                    name="alamat_jepang" placeholder="Shizuoka-ken, Hamamatsu-shi, Chuo-ku, Tokiwacho 123-4, Leo pallace No.302" col="4"></textarea>

                                                @error('alamat_jepang')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            {{-- <div class="flex flex-col gap-2 md:col-span-5">
                                            <label class="font-label text-xs font-medium text-on-surface-variant" for="city">City</label>
                                            <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full" id="city" name="city" placeholder="San Francisco" type="text"/>
                                        </div>
                                        <div class="flex flex-col gap-2 md:col-span-3">
                                            <label class="font-label text-xs font-medium text-on-surface-variant" for="state">State / Province</label>
                                            <input class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full" id="state" name="state" placeholder="CA" type="text"/>
                                        </div> --}}
                                            <div class="flex flex-col gap-2 md:col-span-5">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="kode_pos_jepang">Kode Pos Jepang (Tanpa Strip)<span
                                                        class="text-red-500">*</span></label>
                                                <input
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('kode_pos_jepang') is-invalid border border-red-500 @enderror"
                                                    id="kode_pos_jepang" wire:model="kode_pos_jepang"
                                                    name="kode_pos_jepang" placeholder="1000001 (Tanpa Strip)"
                                                    type="text" />

                                                @error('kode_pos_jepang')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </section>
                                    <!-- Section: Account Balance -->
                                    <section class="mt-5">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-primary"
                                                data-icon="account_balance">account_balance</span>
                                            <h2 class="font-headline font-bold text-2xl">Data Bank Indonesia</h2>
                                        </div>
                                        <div class="flex justify-center items-center gap-3">
                                            <h5 class=" font-normal text-lg text-center">(Untuk pencairan uang gensen)</h5>
                                            
                                        </div>
                                        <div class="flex justify-center items-center gap-3 mb-5">
                                            <h5 class=" font-normal text-lg text-center">Boleh menggunakan rek keluarga jika tidak memiliki rek pribadi</h5>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="nama_bank_penerima">Nama Bank<span
                                                        class="text-red-500">*</span></label>
                                                <select id="nama_bank_penerima" wire:model="nama_bank_penerima"
                                                    name="nama_bank_penerima"
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus w-full @error('nama_bank_penerima') is-invalid border border-red-500 @enderror">
                                                    <option value="">-- ISI --</option>
                                                    @foreach (App\Enums\Gensen\GensenBank::options() as $item)
                                                        <option value="{{ $item }}">{{ $item }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('nama_bank_penerima')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="no_rekening_penerima">No Rekening<span
                                                        class="text-red-500">*</span></label>
                                                <input
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('no_rekening_penerima') is-invalid border border-red-500 @enderror"
                                                    id="no_rekening_penerima" wire:model="no_rekening_penerima"
                                                    name="first_name" placeholder="1234567890" type="text" />

                                                @error('no_rekening_penerima')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="nama_penerima">Nama Pemilik<span
                                                        class="text-red-500">*</span></label>
                                                <input
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('nama_penerima') is-invalid border border-red-500 @enderror"
                                                    id="nama_penerima" wire:model="nama_penerima" name="first_name"
                                                    placeholder="exata" type="text" />

                                                @error('nama_penerima')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <label class="font-label text-xs font-medium text-on-surface-variant"
                                                    for="hubungan_penerima">Hubungan</label>
                                                <input
                                                    class="bg-surface-container-low border-none rounded-lg p-3 font-body text-on-surface form-input-focus placeholder:text-outline-variant/80 w-full @error('hubungan_penerima') is-invalid border border-red-500 @enderror"
                                                    id="hubungan_penerima" wire:model="hubungan_penerima"
                                                    name="first_name" placeholder="Istri" type="text" />
                                                
                                                <div class="form-text" id="basic-addon4">Kosongkan jika menggunakan rek pribadi</div>

                                                @error('hubungan_penerima')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </section>
                                @endif
                            @endif
                        </div>
                    @endif
                    <!--begin::Personal Information-->

                    <!--begin::Example Attachment-->
                    {{-- <div class="flex-column {{ $isUploadAttachment ? 'current' : '' }}"
                        data-kt-stepper-element="content" wire:ignore.self>
                        <div class="row">
                            
                        </div>
                    </div> --}}
                    <!--begin::Example Attachment-->

                    <!--begin::Upload Attachment-->
                    <div class="flex-column {{ $isUploadAttachment ? 'current' : '' }}" data-kt-stepper-element="content" wire:ignore.self>
                        <!-- Section: File Upload -->
                        {{-- GENSEN --}}
                        {{-- @if (!isset($kertas_gensen_old['groups']) || !$kertas_gensen_old['groups']->isNotEmpty()) --}}
                        <section class="mt-5">
                            
                            <div x-data="{
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
                            }" @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                                :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                class="form-group mt-5">
                                <div class="flex items-center gap-3 mb-5">
                                    <span class="material-symbols-outlined text-primary"
                                        data-icon="cloud_upload">cloud_upload</span>
                                    <h2 class="font-headline font-bold text-2xl">KERTAS GENSEN</h2>
                                </div>
                                <div class="row">
                                
                                    <div class="col-md-10">
                                        <h3 class="text-center ">Contoh: KERTAS GENSEN</h3>
                                        <h3 class="text-center">(PDF, PNG, JPG)</h3>
                                        <img src="{{ asset('assets/media/PERSYARATAN GENSEN/KERTAS GENSEN.png') }}"
                                            alt="" class=" mb-3">
                                    </div>
                                </div>
                                <div
                                    class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                    <input class="hidden validate-upload-file" id="kertas_gensen"
                                        name="kertas_gensen" type="file" multiple x-ref="input"
                                        {{-- wire:model="kertas_gensen" --}} @change="handleFiles"
                                        accept="application/pdf, image/jpeg, image/png"
                                        class="position-absolute invisible" />
                                    <label class="cursor-pointer flex flex-col items-center gap-3"
                                        for="kertas_gensen">
                                        <span class="material-symbols-outlined text-5xl text-primary-container"
                                            data-icon="description">description</span>
                                        <p class="font-body text-on-surface-variant">Drag and drop file kamu disini,
                                            atau <span class="text-primary font-semibold">CARI FILE</span></p>
                                        <p class="text-xs text-outline font-medium">Format: PDF, JPG/PNG (Max 10MB)</p>
                                    </label>
                                </div>
                                <div
                                    class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0 file-preview">
                                    @if ($kertas_gensen)
                                        <h1>File baru</h1>
                                        @foreach ($kertas_gensen as $index => $item)
                                            @php
                                                $ext = $item->getClientOriginalExtension();
                                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                    $url = $item->temporaryUrl();
                                                } elseif (in_array($ext, ['pdf'])) {
                                                    $url = route('preview.temp.pdf', $item->getFileName());
                                                    $filename = $item->getClientOriginalName();
                                                } else {
                                                    $filename = $item->getClientOriginalName();
                                                }

                                                $ext = strtolower($ext);

                                            @endphp
                                            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <div class="row">
                                                    <div style="margin-top: 10px; text-align: center;"
                                                        class="row d-flex jusify-content-center">
                                                        <img src="{{ $url }}" alt="Preview"
                                                            style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 2px solid #e0e0e0; object-fit: contain;">
                                                    </div>
                                                </div>

                                                {!! $kertas_gensen_note[$index] !!}
                                                {{-- <img src="{{ $url }}" class="img-fluid rounded img-thumbnail"> --}}
                                            @elseif(in_array($ext, ['pdf']))
                                                <embed src="{{ $url }}" type="application/pdf"
                                                    width="100%" style="height: 60vh;">
                                                {{-- <iframe
                                                        src="{{ $url }}#toolbar=0"
                                                        width="100%"
                                                        style="border:none">
                                                    </iframe> --}}
                                            @else
                                                <div class="border rounded p-4 text-center bg-light">
                                                    <i class="bi bi-file-earmark fs-1"></i>
                                                    <div class="mt-2">
                                                        {{ $filename }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if (!empty($kertas_gensen_old['groups']))
                                        @foreach ($kertas_gensen_old['groups'][0]['files'] as $item)
                                            {{-- {!! $kertas_gensen_old_note[$index] !!} --}}
                                            @if ($item['isImage'])
                                                <div class="relative group/thumb">
                                                    <!-- Preview -->

                                                    <img src="{{ $item['url'] }}" class="w-100 h-full object-cover">

                                                    <!-- Actions -->
                                                    <div class="absolute top-1 right-1 z-10">
                                                        <button type="button"
                                                            wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', 'kertas_gensen_old')"
                                                            class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                            <span
                                                                class="material-symbols-outlined text-[20]">delete</span>
                                                        </button>
                                                    </div>

                                                </div>
                                            @elseif($item['isPdf'])
                                                <div class="relative group/thumb w-100">
                                                    {{-- IFRAME PDF Preview --}}

                                                    <embed src="{{ $item['url'] }}" type="application/pdf"
                                                        width="100%" style="min-height: 450px;">
                                                    <!-- Actions -->
                                                    <div class="absolute top-1 right-1 z-10">
                                                        <button type="button"
                                                            wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', 'kertas_gensen_old')"
                                                            class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                            <span
                                                                class="material-symbols-outlined text-[20]">delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="border rounded p-4 text-center bg-light">
                                                    <i class="bi bi-file-earmark fs-1"></i>
                                                    <div class="mt-2">
                                                        {{ $item['url'] }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        </section>
                        {{-- @endif --}}
                        {{-- Zairyou Card Depan --}}
                        {{-- @if (!$zairyou_card_front_old || !$zairyou_card_front_old['id']) --}}
                        <section class="mt-5">
                            
                            <div class="flex items-center gap-3 mb-5">
                                <span class="material-symbols-outlined text-primary"
                                    data-icon="cloud_upload">cloud_upload</span>
                                <h2 class="font-headline font-bold text-2xl">ZAIRYOU CARD (Depan)</h2>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-10">
                                    <h3 class="text-center my-0 ">Contoh: ZARYU CARD DEPAN</h3>
                                    <h3 class="text-center">(PNG, JPG)</h3>
                                    <img src="{{ asset('assets/media/PERSYARATAN GENSEN/ZARYU CARD DEPAN.png') }}"
                                        alt="" class="">
                                </div>
                            </div>
                            @if ($zairyou_card_front_old && $zairyou_card_front_old['id'])
                                @if ($zairyou_card_front_old['isImage'])
                                    <div
                                        class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                        <!-- Actions -->
                                        <div class="absolute top-1 right-1 z-10">
                                            <button type="button"
                                                wire:click.stop="showDialogDeleteFile('{{ $zairyou_card_front_old['id'] }}', 'zairyou_card_front_old')"
                                                class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                <span class="material-symbols-outlined text-[20]">delete</span>
                                            </button>
                                        </div>
                                        <img class="w-full h-full object-cover" data-alt=""
                                            src="{{ $zairyou_card_front_old['url'] }}" />
                                    </div>
                                @endif
                            @else
                                <div x-data="{
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
                                }" @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                                    :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                    class="form-group">
                                    <div
                                        class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                        <input class="hidden validate-upload-file" id="zairyou_card_front"
                                            name="zairyou_card_front" type="file" x-ref="input"
                                            {{-- wire:model="zairyou_card_front" --}} @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible" />
                                        <label class="cursor-pointer flex flex-col items-center gap-3"
                                            for="zairyou_card_front">
                                            <span class="material-symbols-outlined text-5xl text-primary-container"
                                                data-icon="description">description</span>
                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu
                                                disini, atau <span class="text-primary font-semibold">CARI FILE</span>
                                            </p>
                                            <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)
                                            </p>
                                        </label>
                                    </div>
                                </div>
                                @if ($zairyou_card_front)
                                    @php
                                        $ext = $zairyou_card_front->getClientOriginalExtension();
                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                            $url = $zairyou_card_front->temporaryUrl();
                                        } elseif (in_array($ext, ['pdf'])) {
                                            $url = route('preview.temp.pdf', $zairyou_card_front->getFileName());
                                            $filename = $zairyou_card_front->getClientOriginalName();
                                        } else {
                                            $filename = $zairyou_card_front->getClientOriginalName();
                                        }
                                        $ext = strtolower($ext);
                                    @endphp
                                    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                        <div
                                            class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                            <img class="w-full h-full object-cover" data-alt=""
                                                src="{{ $url }}" />
                                        </div>
                                    @endif
                                @endif
                            @endif

                        </section>
                        {{-- @endif --}}
                        {{-- Zairyou Card Belakang --}}
                        <section class="mt-5">

                            <div class="flex items-center gap-3 mb-5">
                                <span class="material-symbols-outlined text-primary"
                                    data-icon="cloud_upload">cloud_upload</span>
                                <h2 class="font-headline font-bold text-2xl">ZAIRYOU CARD (Belakang)</h2>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-10">
                                    <h3 class="text-center ">Contoh: ZARYU CARD BELAKANG</h3>
                                    <h3 class="text-center">(PNG, JPG)</h3>
                                    <img src="{{ asset('assets/media/PERSYARATAN GENSEN/ZARYU CARD BELAKANG.png') }}"
                                        alt="" class="">
                                </div>
                            </div>
                            @if ($zairyou_card_back_old && $zairyou_card_back_old['id'])
                                @if ($zairyou_card_back_old['isImage'])
                                    <div
                                        class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                        <!-- Actions -->
                                        <div class="absolute top-1 right-1 z-10">
                                            <button type="button"
                                                wire:click.stop="showDialogDeleteFile('{{ $zairyou_card_back_old['id'] }}','zairyou_card_back_old')"
                                                class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                <span class="material-symbols-outlined text-[20]">delete</span>
                                            </button>
                                        </div>
                                        <img class="w-full h-full object-cover" data-alt=""
                                            src="{{ $zairyou_card_back_old['url'] }}" />
                                    </div>
                                @endif
                            @else
                                <div x-data="{
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
                                }" @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                                    :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                    class="form-group">
                                    <div
                                        class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                        <input class="hidden validate-upload-file" id="zairyou_card_back"
                                            name="zairyou_card_back" type="file" x-ref="input"
                                            {{-- wire:model="zairyou_card_back" --}} @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible" />
                                        <label class="cursor-pointer flex flex-col items-center gap-3"
                                            for="zairyou_card_back">
                                            <span class="material-symbols-outlined text-5xl text-primary-container"
                                                data-icon="description">description</span>
                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu
                                                disini, atau <span class="text-primary font-semibold">CARI FILE</span>
                                            </p>
                                            <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)
                                            </p>
                                        </label>
                                    </div>
                                </div>
                                @if ($zairyou_card_back)
                                    @php
                                        $ext = $zairyou_card_back->getClientOriginalExtension();
                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                            $url = $zairyou_card_back->temporaryUrl();
                                        } elseif (in_array($ext, ['pdf'])) {
                                            $url = route('preview.temp.pdf', $zairyou_card_back->getFileName());
                                            $filename = $zairyou_card_back->getClientOriginalName();
                                        } else {
                                            $filename = $zairyou_card_back->getClientOriginalName();
                                        }
                                        $ext = strtolower($ext);
                                    @endphp
                                    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                        <div
                                            class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                            <img class="w-full h-full object-cover" data-alt=""
                                                src="{{ $url }}" />
                                        </div>
                                    @endif
                                @endif
                            @endif

                        </section>
                        {{-- My Number Depan --}}
                        {{-- @if (!$my_number_front_old || !$my_number_front_old['id']) --}}
                        <section class="mt-5">

                            <div class="flex items-center gap-3 mb-5">
                                <span class="material-symbols-outlined text-primary"
                                    data-icon="cloud_upload">cloud_upload</span>
                                <h2 class="font-headline font-bold text-2xl">MY NUMBER (Depan)</h2>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <h3 class="text-center ">Contoh: MY NUMBER DEPAN</h3>
                                    <h3 class="text-center">(PNG, JPG)</h3>
                                    <img src="{{ asset('assets/media/PERSYARATAN GENSEN/MY NUMBER DEPAN.png') }}"
                                        alt="" class="">
                                </div>
                            </div>
                            @if ($my_number_front_old && $my_number_front_old['id'])
                                @if ($my_number_front_old['isImage'])
                                    <div
                                        class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                        <!-- Actions -->
                                        <div class="absolute top-1 right-1 z-10">
                                            <button type="button"
                                                wire:click.stop="showDialogDeleteFile('{{ $my_number_front_old['id'] }}', 'my_number_front_old')"
                                                class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                <span class="material-symbols-outlined text-[20]">delete</span>
                                            </button>
                                        </div>
                                        <img class="w-full h-full object-cover" data-alt=""
                                            src="{{ $my_number_front_old['url'] }}" />
                                    </div>
                                @endif
                            @else
                                <div x-data="{
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
                                }" @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                                    :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                    class="form-group">
                                    <div
                                        class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                        <input class="hidden validate-upload-file" id="my_number_front"
                                            name="my_number_front" type="file" x-ref="input"
                                            {{-- wire:model="my_number_front" --}} @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible" />
                                        <label class="cursor-pointer flex flex-col items-center gap-3"
                                            for="my_number_front">
                                            <span class="material-symbols-outlined text-5xl text-primary-container"
                                                data-icon="description">description</span>
                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu
                                                disini, atau <span class="text-primary font-semibold">CARI FILE</span>
                                            </p>
                                            <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)
                                            </p>
                                        </label>
                                    </div>
                                </div>
                                @if ($my_number_front)
                                    @php
                                        $ext = $my_number_front->getClientOriginalExtension();
                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                            $url = $my_number_front->temporaryUrl();
                                        } elseif (in_array($ext, ['pdf'])) {
                                            $url = route('preview.temp.pdf', $my_number_front->getFileName());
                                            $filename = $my_number_front->getClientOriginalName();
                                        } else {
                                            $filename = $my_number_front->getClientOriginalName();
                                        }
                                        $ext = strtolower($ext);
                                    @endphp
                                    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                        <div
                                            class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                            <img class="w-full h-full object-cover" data-alt=""
                                                src="{{ $url }}" />
                                        </div>
                                    @endif
                                @endif
                            @endif

                        </section>
                        {{-- @endif --}}
                        {{-- My Number Belakang --}}
                        {{-- @if (!$my_number_back_old || !$my_number_back_old['id']) --}}
                        <section class="mt-5">

                            <div class="flex items-center gap-3 mb-5">
                                <span class="material-symbols-outlined text-primary"
                                    data-icon="cloud_upload">cloud_upload</span>
                                <h2 class="font-headline font-bold text-2xl">MY NUMBER (Belakang)</h2>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-10">
                                    <h3 class="text-center ">Contoh: MY NUMBER BELAKANG</h3>
                                    <h3 class="text-center">(PNG, JPG)</h3>
                                    <img src="{{ asset('assets/media/PERSYARATAN GENSEN/MY NUMBER BELAKANG.png') }}"
                                        alt="" class="">
                                </div>
                            </div>
                            @if ($my_number_back_old && $my_number_back_old['id'])
                                @if ($my_number_back_old['isImage'])
                                    <div
                                        class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                        <!-- Actions -->
                                        <div class="absolute top-1 right-1 z-10">
                                            <button type="button"
                                                wire:click.stop="showDialogDeleteFile('{{ $my_number_back_old['id'] }}', 'my_number_back_old')"
                                                class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                <span class="material-symbols-outlined text-[20]">delete</span>
                                            </button>
                                        </div>
                                        <img class="w-full h-full object-cover" data-alt=""
                                            src="{{ $my_number_back_old['url'] }}" />
                                    </div>
                                @endif
                            @else
                                <div x-data="{
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
                                }" @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                                    :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                    class="form-group">
                                    <div
                                        class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                        <input class="hidden validate-upload-file" id="my_number_back"
                                            name="my_number_back" type="file" x-ref="input"
                                            {{-- wire:model="my_number_back" --}} @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible" />
                                        <label class="cursor-pointer flex flex-col items-center gap-3"
                                            for="my_number_back">
                                            <span class="material-symbols-outlined text-5xl text-primary-container"
                                                data-icon="description">description</span>
                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu
                                                disini, atau <span class="text-primary font-semibold">CARI FILE</span>
                                            </p>
                                            <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)
                                            </p>
                                        </label>
                                    </div>
                                </div>
                                @if ($my_number_back)
                                    @php
                                        $ext = $my_number_back->getClientOriginalExtension();
                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                            $url = $my_number_back->temporaryUrl();
                                        } elseif (in_array($ext, ['pdf'])) {
                                            $url = route('preview.temp.pdf', $my_number_back->getFileName());
                                            $filename = $my_number_back->getClientOriginalName();
                                        } else {
                                            $filename = $my_number_back->getClientOriginalName();
                                        }
                                        $ext = strtolower($ext);
                                    @endphp
                                    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                        <div
                                            class="relative aspect-video bg-surface-container rounded-lg overflow-hidden group/thumb">
                                            <img class="w-full h-full object-cover" data-alt=""
                                                src="{{ $url }}" />
                                        </div>
                                    @endif
                                @endif
                            @endif

                        </section>
                        {{-- @endif --}}
                        {{-- Rekening Indonesia --}}
                        {{-- @if (!$rekening_indonesia_old || !$rekening_indonesia_old['id']) --}}
                        <section class="mt-5">

                            <div class="flex items-center gap-3 mb-5">
                                <span class="material-symbols-outlined text-primary"
                                    data-icon="cloud_upload">cloud_upload</span>
                                <h2 class="font-headline font-bold text-2xl">REKENING INDONESIA </h2>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-10">
                                    <h3 class="text-center ">Contoh: REKENING INDONESIA</h3>
                                    <h3 class="text-center">(PNG, JPG)</h3>
                                    <img src="{{ asset('assets/media/PERSYARATAN GENSEN/REKENING INDONESIA.png') }}"
                                        alt="" class="">
                                </div>
                            </div>
                            @if ($rekening_indonesia_old && $rekening_indonesia_old['id'])
                                @if ($rekening_indonesia_old['isImage'])
                                    <div class="relative group/thumb">
                                        <!-- Actions -->
                                        <div class="absolute top-1 right-1 z-10">
                                            <button type="button"
                                                wire:click.stop="showDialogDeleteFile('{{ $rekening_indonesia_old['id'] }}', 'rekening_indonesia_old')"
                                                class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                <span class="material-symbols-outlined text-[20]">delete</span>
                                            </button>
                                        </div>
                                        <img class="w-100 h-100 object-cover" data-alt=""
                                            src="{{ $rekening_indonesia_old['url'] }}" />
                                    </div>
                                @endif
                            @else
                                <div x-data="{
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
                                }" @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                                    :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                    class="form-group">
                                    <div
                                        class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                        <input class="hidden validate-upload-file" id="rekening_indonesia"
                                            name="rekening_indonesia" type="file" x-ref="input"
                                            {{-- wire:model="rekening_indonesia" --}} @change="handleFiles"
                                            accept="image/jpeg, image/png"
                                            class="position-absolute invisible" />
                                        <label class="cursor-pointer flex flex-col items-center gap-3"
                                            for="rekening_indonesia">
                                            <span class="material-symbols-outlined text-5xl text-primary-container"
                                                data-icon="description">description</span>
                                            <p class="font-body text-on-surface-variant">Drag and drop file kamu
                                                disini, atau <span class="text-primary font-semibold">CARI FILE</span>
                                            </p>
                                            <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)
                                            </p>
                                        </label>
                                    </div>
                                </div>
                                @if ($rekening_indonesia)
                                    @php
                                        $ext = $rekening_indonesia->getClientOriginalExtension();
                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                            $url = $rekening_indonesia->temporaryUrl();
                                        } elseif (in_array($ext, ['pdf'])) {
                                            $url = route('preview.temp.pdf', $rekening_indonesia->getFileName());
                                            $filename = $rekening_indonesia->getClientOriginalName();
                                        } else {
                                            $filename = $rekening_indonesia->getClientOriginalName();
                                        }
                                        $ext = strtolower($ext);
                                    @endphp
                                    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                        <div class="relative group/thumb">
                                            <img class="w-full h-full object-cover" data-alt=""
                                                src="{{ $url }}" />
                                        </div>
                                    @endif
                                @endif
                            @endif

                        </section>
                        {{-- @endif --}}
                        {{-- Rekap Pengiriman Uang --}}
                        {{-- @if (!isset($rekap_pengiriman_uang_old['groups']) || !$rekap_pengiriman_uang_old['groups']->isNotEmpty()) --}}
                        <section class="mt-5">
                            <div class="row mt-5">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary"
                                        data-icon="cloud_upload">cloud_upload</span>
                                    <h2 class="font-headline font-bold text-2xl">REKAP PENGIRIMAN UANG</h2>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-10">
                                        <h3 class="text-center ">Contoh: REMITTANCE</h3>
                                        <h3 class="text-center">(PDF)</h3>
                                        <img src="{{ asset('assets/media/PERSYARATAN GENSEN/REMITTANCE.png') }}"
                                            alt="" class="">
                                    </div>
                                </div>
                            </div>
                            {{-- REMITTANCE EXAMPLE --}}
                            {{-- <div class="row justify-content-evenly">

                                <div class="col-6 col-md-3 d-flex justify-content-center">
                                    <div class="card-flex text-center">
                                        <h3 class="fw-bold mt-auto">DCOM</h3>
                                        <div class="image-box">
                                            <img src="{{ Storage::url('remittance_example/Remittance_DCOM.jpg') }}"
                                                class="img-thumbnail example-img">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3 d-flex justify-content-center">
                                    <div class="card-flex text-center">
                                        <h3 class="fw-bold mt-auto">KYODAI</h3>
                                        <div class="image-box">
                                            <img src="{{ Storage::url('remittance_example/Remittance_KYODAI.jpg') }}"
                                                class="img-thumbnail example-img">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3 d-flex justify-content-center">
                                    <div class="card-flex text-center">
                                        <h3 class="fw-bold mt-auto">RIA KYODAI</h3>
                                        <div class="image-box">
                                            <img src="{{ Storage::url('remittance_example/Remittance_RIA_KYODAI.jpg') }}"
                                                class="img-thumbnail example-img">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3 d-flex justify-content-center">
                                    <div class="card-flex text-center">
                                        <h3 class="fw-bold mt-auto">SMILES</h3>
                                        <div class="image-box">
                                            <img src="{{ Storage::url('remittance_example/Remittance_SMILES.jpg') }}"
                                                class="img-thumbnail example-img">
                                        </div>
                                    </div>
                                </div>

                            </div> --}}

                            @if ($rekap_pengiriman_uang)
                                @foreach ($rekap_pengiriman_uang as $rekap_index => $rekap)
                                    <div wire:key="rekap_pengiriman_uang_{{ $rekap_index }}" x-data="{
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
                                            <input class="hidden validate-upload-file"
                                                id="rekap_pengiriman_uang.{{ $rekap_index }}.file"
                                                name="rekap_pengiriman_uang.{{ $rekap_index }}.file" type="file"
                                                multiple x-ref="input"
                                                wire:model="rekap_pengiriman_uang.{{ $rekap_index }}.file"
                                                @change="handleFiles" accept="application/pdf"
                                                class="position-absolute invisible" />

                                            <select class="form-select w-75 m-auto text-center"
                                                wire:model.live="rekap_pengiriman_uang.{{ $rekap_index }}.remittance_type">
                                                @foreach (App\Enums\Gensen\GensenAttachmentRemittanceType::options() as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>

                                            <label
                                                class="cursor-pointer w-full md:w-3/4 flex flex-col items-center gap-2 border-2 border-dashed border-blue-100 rounded-lg p-2 rounded {{ $rekap['remittance_type'] ? '' : 'd-none' }}"
                                                for="rekap_pengiriman_uang.{{ $rekap_index }}.file">
                                                <span
                                                    class=" my-0 material-symbols-outlined text-5xl text-primary-container"
                                                    data-icon="description">description</span>
                                                <p class=" my-0 font-body text-on-surface-variant">Drag and drop file
                                                    kamu disini, atau <span
                                                        class=" my-0 text-primary font-semibold">CARI FILE</span></p>
                                                <p class=" my-0 text-xs text-outline font-medium">Format: PDF (Max
                                                    10MB)</p>
                                            </label>


                                            <div
                                                class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">

                                                @foreach ($rekap['file'] as $file_index => $item)
                                                    @php
                                                        $ext = $item->getClientOriginalExtension();
                                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                            $url = $item->temporaryUrl();
                                                        } elseif (in_array($ext, ['pdf'])) {
                                                            $url = route('preview.temp.pdf', $item->getFileName());
                                                            $filename = $item->getClientOriginalName();
                                                        } else {
                                                            $filename = $item->getClientOriginalName();
                                                        }

                                                        $ext = strtolower($ext);

                                                    @endphp
                                                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                        <img src="{{ $url }}"
                                                            class="img-fluid rounded img-thumbnail">
                                                    @elseif(in_array($ext, ['pdf']))
                                                        <embed src="{{ $url }}" type="application/pdf"
                                                            width="100%" style="height: 60vh;">
                                                        {{-- <iframe
                                                                src="{{ $url }}#toolbar=0"
                                                                width="100%"
                                                                style="border:none">
                                                            </iframe> --}}
                                                    @else
                                                        <div class="border rounded p-4 text-center bg-light">
                                                            <i class="bi bi-file-earmark fs-1"></i>
                                                            <div class="mt-2">
                                                                {{ $filename }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="row mb-2">
                                <button type="button" class="btn btn-success w-100 mx-auto"
                                    wire:click="addRekapPengirimanUang"><i class='fa fa-plus'></i> Tambah File <i
                                        class='fa fa-plus'></i></button>
                            </div>
                            @if ($rekap_pengiriman_uang_old)
                                @foreach ($rekap_pengiriman_uang_old['groups'] as $group_index => $group)
                                    <h3 class="fw-bold my-3 text-center">
                                        {{ $rekap_pengiriman_uang_old['groups'][$group_index]['provider'] }}</h3>

                                    <div
                                        class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0 file-preview">
                                        @if (!empty($group['files']))
                                            @foreach ($group['files'] as $rekap_index => $item)
                                                @if ($item['isPdf'])
                                                    <div class="relative group/thumb w-100">
                                                        {{-- IFRAME PDF Preview --}}

                                                        <embed src="{{ $item['url'] }}" type="application/pdf"
                                                            width="100%" style="min-height: 450px;">
                                                        <!-- Actions -->
                                                        <div class="absolute top-1 right-1 z-10">
                                                            <button type="button"
                                                                wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', 'rekap_pengiriman_uang_old')"
                                                                class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                                <span
                                                                    class="material-symbols-outlined text-[20]">delete</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="border rounded p-4 text-center bg-light">
                                                        <i class="bi bi-file-earmark fs-1"></i>
                                                        <div class="mt-2">
                                                            {{ $item['url'] }}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </section>
                        {{-- @endif --}}
                        {{-- Kartu Keluarga --}}
                        {{-- @if (!isset($kartu_keluarga_old['groups']) || !$kartu_keluarga_old['groups']->isNotEmpty()) --}}
                        <section class="mt-5">
                            <div x-data="{
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
                            }" @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)"
                                :class="isDragging ? 'border-primary bg-light border-3' : 'border-secondary'"
                                class="form-group mt-5">
                                <div class="flex items-center gap-3 mb-5">
                                    <span class="material-symbols-outlined text-primary"
                                        data-icon="cloud_upload">cloud_upload</span>
                                    <h2 class="font-headline font-bold text-2xl">KARTU KELUARGA</h2>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-10">
                                        <h3 class="text-center ">Contoh: KARTU KELUARGA</h3>
                                        <h3 class="text-center">(PDF, PNG, JPG)</h3>
                                        <img src="{{ asset('assets/media/PERSYARATAN GENSEN/KARTU KELUARGA.png') }}"
                                            alt="" class="">
                                    </div>
                                </div>
                                <div
                                    class="border-2 border-dashed border-outline-variant/30 rounded-xl p-10 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                                    <input class="hidden validate-upload-file" id="kartu_keluarga"
                                        name="kartu_keluarga" type="file" multiple x-ref="input"
                                        {{-- wire:model="kartu_keluarga" --}} @change="handleFiles"
                                        accept="application/pdf, image/jpeg, image/png"
                                        class="position-absolute invisible" />
                                    <label class="cursor-pointer flex flex-col items-center gap-3"
                                        for="kartu_keluarga">
                                        <span class="material-symbols-outlined text-5xl text-primary-container"
                                            data-icon="description">description</span>
                                        <p class="font-body text-on-surface-variant">Drag and drop file kamu disini,
                                            atau <span class="text-primary font-semibold">CARI FILE</span></p>
                                        <p class="text-xs text-outline font-medium">Format: PDF, JPG/PNG (Max 10MB)</p>
                                    </label>
                                </div>
                                <div
                                    class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0 file-preview">
                                    @if ($kartu_keluarga)
                                        <h1>File baru</h1>
                                        @foreach ($kartu_keluarga as $index => $item)
                                            @php
                                                $ext = $item->getClientOriginalExtension();
                                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                    $url = $item->temporaryUrl();
                                                } elseif (in_array($ext, ['pdf'])) {
                                                    $url = route('preview.temp.pdf', $item->getFileName());
                                                    $filename = $item->getClientOriginalName();
                                                } else {
                                                    $filename = $item->getClientOriginalName();
                                                }

                                                $ext = strtolower($ext);

                                            @endphp
                                            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                <div class="row">
                                                    <div style="margin-top: 10px; text-align: center;"
                                                        class="row d-flex jusify-content-center">
                                                        <img src="{{ $url }}" alt="Preview"
                                                            style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 2px solid #e0e0e0; object-fit: contain;">
                                                    </div>
                                                </div>

                                                {!! $kartu_keluarga_note[$index] !!}
                                                {{-- <img src="{{ $url }}" class="img-fluid rounded img-thumbnail"> --}}
                                            @elseif(in_array($ext, ['pdf']))
                                                <embed src="{{ $url }}" type="application/pdf"
                                                    width="100%" style="height: 60vh;">
                                                {{-- <iframe
                                                        src="{{ $url }}#toolbar=0"
                                                        width="100%"
                                                        style="border:none">
                                                    </iframe> --}}
                                            @else
                                                <div class="border rounded p-4 text-center bg-light">
                                                    <i class="bi bi-file-earmark fs-1"></i>
                                                    <div class="mt-2">
                                                        {{ $filename }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if (!empty($kartu_keluarga_old['groups']))
                                        @foreach ($kartu_keluarga_old['groups'][0]['files'] as $item)
                                            {{-- {!! $kartu_keluarga_old_note[$index] !!} --}}
                                            @if ($item['isImage'])
                                                <div class="relative group/thumb">
                                                    <!-- Preview -->

                                                    <img src="{{ $item['url'] }}" class="w-100 h-full object-cover">

                                                    <!-- Actions -->
                                                    <div class="absolute top-1 right-1 z-10">
                                                        <button type="button"
                                                            wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', 'kartu_keluarga_old')"
                                                            class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                            <span
                                                                class="material-symbols-outlined text-[20]">delete</span>
                                                        </button>
                                                    </div>

                                                </div>
                                            @elseif($item['isPdf'])
                                                <div class="relative group/thumb w-100">
                                                    {{-- IFRAME PDF Preview --}}

                                                    <embed src="{{ $item['url'] }}" type="application/pdf"
                                                        width="100%" style="min-height: 450px;">
                                                    <!-- Actions -->
                                                    <div class="absolute top-1 right-1 z-10">
                                                        <button type="button"
                                                            wire:click.stop="showDialogDeleteFile('{{ $item['id'] }}', 'kartu_keluarga_old')"
                                                            class="p-1 bg-white/80 hover:bg-error/10 text-error rounded">
                                                            <span
                                                                class="material-symbols-outlined text-[20]">delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="border rounded p-4 text-center bg-light">
                                                    <i class="bi bi-file-earmark fs-1"></i>
                                                    <div class="mt-2">
                                                        {{ $item['url'] }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        </section>
                        {{-- @endif --}}
                    </div>
                    <!--begin::Upload Attachment-->
                </div>
                <!--end::Group-->

                <!--begin::Actions-->
                <div class="d-flex flex-stack justify-content-end">
                    <!--begin::Wrapper-->
                    <div class="">
                        <button type="button" class="btn btn-primary" wire:ignore wire:click="submitForm"
                            data-kt-stepper-action="submit">
                            <span class="indicator-label">
                                Submit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>

                        <button type="button" class="btn btn-primary" wire:ignore data-kt-stepper-action="next">
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
    @else
        <form wire:submit.prevent="checkPassword">

            <div class="row d-flex justify-content-center">
                <div class="col-md-4 text-center">
                    <h3>Masukkan Password</h3>
                    <input type="text" placeholder="isi" class="form-control text-center"
                        wire:model="input_password">
                    <div class="col-auto">
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary mt-3">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

        </form>
    @endif

    <div class="loading-screen" id="loadingScreen">
        <div class="loader"></div>
        <div class="loading-text" id="loadingText">Mengompresi gambar... (15.71 MB)</div>
    </div>

</div>

@include('js.stepper')

@push('css')
    <style>
        /* hide submit normally */
        [data-kt-stepper-action="submit"] {
            display: none;
        }

        /* show submit only on last step */
        .kt-stepper.last [data-kt-stepper-action="submit"] {
            display: inline-block;
        }

        /* hide continue on last step */
        .kt-stepper.last [data-kt-stepper-action="next"] {
            display: none;
        }

        .detail-text h3 {
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            margin: 0 0 8px 0;
        }

        .detail-text p {
            font-size: 12px;
            color: #718096;
            margin: 0;
            line-height: 1.6;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            text-align: left;
            padding: 24px;
            margin-bottom: 16px;
            background: #f7fafc;
            border-radius: 16px;
            transition: all 0.3s ease;
            animation: fadeIn 0.6s ease-out both;
        }

        .detail-item:nth-child(1) {
            animation-delay: 0.6s;
        }

        .detail-item:nth-child(2) {
            animation-delay: 0.7s;
        }

        .detail-item:nth-child(3) {
            animation-delay: 0.8s;
        }

        .detail-item:hover {
            background: #edf2f7;
            transform: translateX(8px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
    <style>
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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
@endpush

@include('js.imask')

@push('js')
    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('onAuthorized', () => {

                setTimeout(() => {
                    initializeFileInputs();
                }, 500);
                // setTimeout(() => {
                //     // initStepper();
                //     // updateSubstepDescription();
                //     // showUploadedFilesSummary();
                //     initializeFileInputs();
                //     // initializeFormSubmits();
                // }, 500); 

            });

            // document.addEventListener('DOMContentLoaded', () => {
            //     document.querySelectorAll('input[type="file"]').forEach(input => {
            //         input.addEventListener('change', async function(e) {
            //             console.log('change');
            //             // Prevent the generic public.php handler from running
            //             e.stopImmediatePropagation();
            //             const id = e.target.id;

            //             const fileKey = id.split('.')[0];

            //             // Handle special case for ktp_file
            //             const previewId = fileKey === 'ktp_file' ? 'preview_ktp_file' : 'preview_' + fileKey ;
            //             const preview = document.getElementById(previewId);

            //             const multiUpload = ['kertas_gensen', 'kartu_keluarga', 'rekap_pengiriman_uang'];
            //             previewResult = '';
            //             uploadIndex = 0;
            //             console.log('fileKey');
            //             console.log(fileKey);
            //             if(multiUpload.includes(fileKey)){
            //                 const files = e.target.files;
            //                 uploadMulti = true;
            //                 if (files.length) {
            //                     await processUploadQueue(files, fileKey, preview);
            //                 }
            //             }else{
            //                 uploadMulti = false;
            //                 const file = e.target.files[0];
            //                 handleUploadedFile(file, fileKey, preview);
            //             }

            //             // preview.innerHTML = previewResult;

            //             // ✅ NOW file exists
            //             setTimeout(() => {
            //                 @this.call('cobaStore');
            //             }, 3000);

            //         });
            //     }, true);
            //     document.addEventListener('change', function (e) {

            //         if (!e.target.classList.contains('validate-upload-file')) return;

            //         const input = e.target;
            //         const files = Array.from(input.files);

            //         if (!files.length) return;

            //         const maxSize = 2 * 1024 * 1024; // 2MB

            //         const validFiles = [];
            //         let hasError = false;

            //         files.forEach(file => {
            //             if (file.size > maxSize) {
            //                 hasError = true;
            //             } else {
            //                 validFiles.push(file);
            //             }
            //         });

            //         // ❌ if any file invalid
            //         if (hasError) {

            //             Livewire.dispatch('{{ Alert::EVENT_INFO }}', [
            //                 '{{ Alert::ICON_ERROR }}',
            //                 'Gagal',
            //                 'Ukuran file maksimal 2MB'
            //             ]);

            //             // rebuild file list (only valid files)
            //             const dataTransfer = new DataTransfer();

            //             validFiles.forEach(file => {
            //                 dataTransfer.items.add(file);
            //             });

            //             input.files = dataTransfer.files;

            //             // VERY IMPORTANT → re-trigger change
            //             input.dispatchEvent(new Event('change', { bubbles: true }));

            //             return false;
            //         }

            //     }, true); // CAPTURE MODE

            // });
        });


        {{-- Compress File Upload --}}
        const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB in bytes (before compression)
        const TARGET_FILE_SIZE = 2 * 1024 * 1024; // Target 2MB after compression
        const MAX_UPLOAD_SIZE = 3 * 1024 * 1024; // Maximum 3MB after compression
        const formId = '7035';
        let currentSubstep = 1;
        let previewResult = '';
        let uploadIndex = 0;
        let uploadMulti = false;
        const uploadedFiles = [];
        const substepCompleted = {
            "1": 0,
            "2": 0,
            "3": 0,
            "4": 0
        };

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
                        let quality = 0.75;

                        // Calculate initial scaling if image is too large
                        const maxDimension = 2400; // Maximum dimension for compatibility
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
                            while (blob.size > maxSizeBytes && quality > 0.1 && attempts <
                                maxAttempts) {
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
                                    const testBlob = await tryCompress(width, height,
                                        testQuality);
                                    if (testBlob.size <= maxSizeBytes) {
                                        blob = testBlob;
                                        quality = testQuality;
                                    }
                                }
                            }

                            // Create a new File object from the blob
                            const compressedFile = new File(
                                [blob],
                                file.name.replace(/\.[^/.]+$/,
                                '.jpg'), // Change extension to jpg
                                {
                                    type: 'image/jpeg',
                                    lastModified: Date.now()
                                }
                            );
                            let upload_name = uploadMulti ? `${fileKey}.${uploadIndex}` :
                                `${fileKey}`;
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
                                    progress.detail.progress
                                ])
                            );
                            // uploadIndex++;
                            resolve({
                                file: compressedFile,
                                originalSize: file.size,
                                compressedSize: blob.size,
                                compressionRatio: ((1 - blob.size / file.size) * 100)
                                    .toFixed(1)
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
                    const previewId = fileKey === 'ktp_file' ? 'preview_ktp_file' : 'preview_' +
                    fileKey;
                    const preview = document.getElementById(previewId);

                    const multiUpload = ['kertas_gensen', 'kartu_keluarga'];
                    const excludeUpload = ['rekap_pengiriman_uang'];
                    previewResult = '';
                    uploadIndex = 0;
                    console.log('fileKey');
                    console.log(fileKey);
                    if (!excludeUpload.includes(fileKey)) {
                        if (multiUpload.includes(fileKey)) {
                            const files = e.target.files;
                            uploadMulti = true;
                            await processUploadQueue(files, fileKey, preview);
                            // if (files.length) {
                            // }
                        } else {
                            uploadMulti = false;
                            const file = e.target.files[0];
                            handleUploadedFile(file, fileKey, preview);
                        }

                        // preview.innerHTML = previewResult;

                        // ✅ NOW file exists
                        setTimeout(() => {
                            @this.call('cobaStore');
                        }, 3000);
                    }

                });
            });
        }
        async function processUploadQueue(files, fileKey, preview) {
            for (const file of files) {
                console.log('queue upload:', file.name);

                let processedFile = file;
                console.log([
                    'file type =',
                    file.type
                ]);
                /*
                |--------------------------------------------------------------------------
                | Compress ONLY images
                |--------------------------------------------------------------------------
                */
                if (isImage(file)) {
                    await handleUploadedFile(file, fileKey, preview);
                }

                /*
                |--------------------------------------------------------------------------
                | Skip compression for PDF
                |--------------------------------------------------------------------------
                */
                if (isPDF(file)) {
                    let upload_name = uploadMulti ? `${fileKey}.${uploadIndex}` : `${fileKey}`;
                    console.log('upload name oi');
                    console.log(upload_name);
                    @this.upload(
                        upload_name,
                        // `photo.${uploadIndex}`,
                        file,

                        () => {
                            console.log('uploaded pdf');
                        },

                        () => console.log('error'),

                        (progress) => console.log([
                            'progress',
                            progress.detail.progress
                        ])
                    );
                    console.log('uploadIndex ++');
                    uploadIndex++;
                    console.log('PDF detected — skip compression');
                }

            }

            console.log('All uploads finished');
        }

        function isImage(file) {

            return file.type.startsWith('image/');
        }

        function isPDF(file) {
            return file.type === 'application/pdf';
        }

        async function handleUploadedFile(file, fileKey, preview) {
            console.log('handle upload');
            if (file) {
                // Block if another file is being processed
                if (isProcessingFile) {
                    alert('Mohon tunggu proses file sebelumnya selesai.');

                    return;
                }

                // Check file size before compression
                if (file.size > MAX_FILE_SIZE) {
                    console.log(file);
                    alert(
                        `File "${file.name}" terlalu besar! Maksimal 10MB per file.\n\nUkuran file: ${(file.size / 1024 / 1024).toFixed(2)} MB`);

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
                const loadingMessage = isHeic ?
                    `Mengonversi dan mengompresi gambar... (${originalSizeMB} MB)` :
                    `Mengompresi gambar... (${originalSizeMB} MB)`;
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
                                            file.name.replace(/\.(heic|heif)$/i, '.jpg'), {
                                                type: 'image/jpeg',
                                                lastModified: Date.now()
                                            }
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

                            errorMsg +=
                                '\n\nSilakan coba:\n1. Gunakan file HEIC lain\n2. Konversi ke JPG/PNG terlebih dahulu\n3. Ambil foto ulang jika memungkinkan';

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
                        alert(
                            `Gagal mengompresi file "${file.name}" ke ukuran yang sesuai.\n\nUkuran asli: ${(file.size / 1024 / 1024).toFixed(2)} MB\nSetelah kompresi: ${(compressedFile.size / 1024 / 1024).toFixed(2)} MB\n\nSilakan gunakan gambar dengan ukuran lebih kecil.`);
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
                    alert(
                        `Gagal mengompresi file "${file.name}".\n\nError: ${error.message}\n\nSilakan coba file lain.`);
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
                        alert(
                            'Upload berhasil! Semua dokumen telah diterima.\n\nAnda akan diarahkan ke halaman konfirmasi...');
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
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
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

            let upload_name = uploadMulti ? `${fileKey}_note.${uploadIndex}` : `${fileKey}_note`;
            console.log(upload_name);
            @this.set(upload_name, previewResult);
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
    </script>
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

        //     document.addEventListener('change', function (e) {

        //         if (!e.target.classList.contains('validate-upload-file')) return;

        //         const input = e.target;
        //         const files = Array.from(input.files);

        //         if (!files.length) return;

        //         const maxSize = 2 * 1024 * 1024; // 2MB

        //         const validFiles = [];
        //         let hasError = false;

        //         files.forEach(file => {
        //             if (file.size > maxSize) {
        //                 hasError = true;
        //             } else {
        //                 validFiles.push(file);
        //             }
        //         });

        //         // ❌ if any file invalid
        //         if (hasError) {

        //             Livewire.dispatch('{{ Alert::EVENT_INFO }}', [
        //                 '{{ Alert::ICON_ERROR }}',
        //                 'Gagal',
        //                 'Ukuran file maksimal 2MB'
        //             ]);

        //             // rebuild file list (only valid files)
        //             const dataTransfer = new DataTransfer();

        //             validFiles.forEach(file => {
        //                 dataTransfer.items.add(file);
        //             });

        //             input.files = dataTransfer.files;

        //             // VERY IMPORTANT → re-trigger change
        //             input.dispatchEvent(new Event('change', { bubbles: true }));

        //             return false;
        //         }

        //     }, true); // CAPTURE MODE

        // });
    </script>
@endpush
