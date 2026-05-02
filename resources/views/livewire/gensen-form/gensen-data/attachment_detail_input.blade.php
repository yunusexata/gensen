<div class="row d-flex justify-content-evenly">
        <!-- Main Content Area -->
         

        {{-- GENSEN --}}
        <section class="col-md-4 mt-5">
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
                class="form-group"
            >
                <div class="flex items-center gap-3 mb-5 mt-5">
                    <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                    <h2 class="font-headline font-bold text-2xl">KERTAS GENSEN</h2>
                </div>
                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                   
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
                                        {{$item['id']}}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        {{-- Rekap Pengiriman Uang --}}
        <section class="col-md-4 mt-5">
            <div class="row mt-5">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                    <h2 class="font-headline font-bold text-2xl">REKAP PENGIRIMAN UANG</h2>
                </div>
            </div>
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
        </section>
        {{-- Kartu Keluarga --}}
        <section class="col-md-4 mt-5">
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
                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                    
                    @if ($kartu_keluarga_old && $kartu_keluarga_old['groups']->isNotEmpty())
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
                                        {{$item['id']}}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        {{-- Zairyou Card Depan--}}
        <section class="col-md-4 mt-5">
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
                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                    

                    @if ($zairyou_card_front_old['url'])
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
        <section class="col-md-4 mt-5">
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
                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                    

                    @if ($zairyou_card_back_old['url'])
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
        <section class="col-md-4 mt-5">
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
                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                    

                    @if ($my_number_front_old['url'])
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
        {{-- My Number Belakang --}}
        <section class="col-md-4 mt-5">
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
                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                    
                    @if ($my_number_back_old['url'])
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
        <section class="col-md-4 mt-5">
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
                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                    
                    @if ($rekening_indonesia_old['url'])
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
        <section>
            <div class="pt-10">
                <!--begin::Heading-->
                <h1 class="anchor fw-bold mb-5" data-kt-scroll-offset="85" id="basic">
                    <a href="#basic" data-kt-scroll-toggle=""></a>
                    Cropper.js Example
                </h1>
                <button type="button" class="btn btn-success" onclick="getCroppedCanvasBaru()">Get Cropped</button>
                <!--end::Heading-->
                <!--begin::Block-->
                <div class="py-5">
                    Visit Cropper.js's <a href="https://fengyuanchen.github.io/cropperjs/" class="me-1">official website</a> for more examples.
                </div>
                <!--end::Block-->
                <!--begin::Block-->
                <div class="pt-5">
                    <!--begin::Cropper-->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                            <img id="image" src="{{ asset('assets/media/stock/600x600/img-9.jpg') }}" alt="" class="cropper-hidden">
                            <div class="cropper-container cropper-bg" touch-action="none" style="width: 209px; height: 600px;">
                                <div class="cropper-wrap-box">
                                    <div class="cropper-canvas" style="width: 209px; height: 209px; transform: translateY(2.31431px);"><img src="https://preview.keenthemes.com/html/metronic/docs/assets/media/stock/600x600/img-9.jpg" alt="The image to crop" class="" style="width: 209px; height: 209px; transform: none;"></div>
                                </div>
                                <div class="cropper-drag-box cropper-crop cropper-modal" data-cropper-action="crop"></div>
                                <div class="cropper-crop-box" style="width: 167.2px; height: 143.658px; transform: translateX(20.9px) translateY(23.2143px);"><span class="cropper-view-box"><img src="https://preview.keenthemes.com/html/metronic/docs/assets/media/stock/600x600/img-9.jpg" alt="The image to preview" style="width: 209px; height: 209px; transform: translateX(-20.9px) translateY(-20.9px);"></span><span class="cropper-dashed dashed-h"></span><span class="cropper-dashed dashed-v"></span><span class="cropper-center"></span><span class="cropper-face cropper-move" data-cropper-action="all"></span><span class="cropper-line line-e" data-cropper-action="e"></span><span class="cropper-line line-n" data-cropper-action="n"></span><span class="cropper-line line-w" data-cropper-action="w"></span><span class="cropper-line line-s" data-cropper-action="s"></span><span class="cropper-point point-e" data-cropper-action="e"></span><span class="cropper-point point-n" data-cropper-action="n"></span><span class="cropper-point point-w" data-cropper-action="w"></span><span class="cropper-point point-s" data-cropper-action="s"></span><span class="cropper-point point-ne" data-cropper-action="ne"></span><span class="cropper-point point-nw" data-cropper-action="nw"></span><span class="cropper-point point-sw" data-cropper-action="sw"></span><span class="cropper-point point-se" data-cropper-action="se"></span></div>
                            </div>
                            </div>
                            <div id="cropper-buttons">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary mb-3" data-method="setDragMode" data-option="move" title="Move">
                                <span data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
                                <i class="ki-duotone ki-chart-simple-2 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> 
                                <span class="fa fa-arrows-alt"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="setDragMode" data-option="crop" title="Crop">
                                <span data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
                                <span class="fa fa-crop-alt"></span>
                                </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary mb-3" data-method="zoom" data-option="0.1" title="Zoom In">
                                <span data-toggle="tooltip" title="cropper.zoom(0.1)">
                                <span class="fa fa-search-plus"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                <span title="cropper.zoom(-0.1)">
                                <span class="fa fa-search-minus"></span>
                                </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary mb-3" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                <span data-toggle="tooltip" title="cropper.move(-10, 0)">
                                <span class="fa fa-arrow-left"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                <span data-toggle="tooltip" title="cropper.move(10, 0)">
                                <span class="fa fa-arrow-right"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                <span data-toggle="tooltip" title="cropper.move(0, -10)">
                                <span class="fa fa-arrow-up"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                <span data-toggle="tooltip" title="cropper.move(0, 10)">
                                <span class="fa fa-arrow-down"></span>
                                </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary mb-3" data-method="rotate" data-option="-45" title="Rotate Left">
                                <span data-toggle="tooltip" title="cropper.rotate(-45)">
                                <span class="fa fa-undo-alt"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="rotate" data-option="45" title="Rotate Right">
                                <span data-toggle="tooltip" title="cropper.rotate(45)">
                                <span class="fa fa-redo-alt"></span>
                                </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary mb-3" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                <span data-toggle="tooltip" title="cropper.scaleX(-1)">
                                <span class="fa fa-arrows-alt-h"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                <span data-toggle="tooltip" title="cropper.scaleY(-1)">
                                <span class="fa fa-arrows-alt-v"></span>
                                </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary mb-3" data-method="crop" title="Crop">
                                <span data-toggle="tooltip" title="cropper.crop()">
                                <span class="fa fa-check"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="clear" title="Clear">
                                <span data-toggle="tooltip" title="cropper.clear()">
                                <span class="fa fa-times"></span>
                                </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary mb-3" data-method="disable" title="Disable">
                                <span data-toggle="tooltip" title="cropper.disable()">
                                <span class="fa fa-lock"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="enable" title="Enable">
                                <span data-toggle="tooltip" title="cropper.enable()">
                                <span class="fa fa-unlock"></span>
                                </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary mb-3" data-method="reset" title="Reset">
                                <span data-toggle="tooltip" title="cropper.reset()">
                                <span class="fa fa-sync-alt"></span>
                                </span>
                                </button>
                                <button class="btn btn-primary btn-upload mb-3" title="Upload image file">
                                <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                                <span class=" kt-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                                <span class="fa fa-upload"></span>
                                </span>
                                </button>
                                <button type="button" class="btn btn-primary mb-3" data-method="destroy" title="Destroy">
                                <span data-toggle="tooltip" title="cropper.destroy()">
                                <span class="fa fa-power-off"></span>
                                </span>
                                </button>
                            </div>
                            <div class="btn-group btn-group-crop">
                                <button type="button" data-toggle="modal" data-target="#getCroppedCanvasModal" class="btn btn-success mb-3" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 540, &quot;maxHeight&quot;: 260 }">
                                <span data-toggle="tooltip" title="cropper.getCroppedCanvas({ maxWidth: 540, maxHeight: 260 })">
                                Get Cropped Canvas
                                </span>
                                </button>
                                <button type="button" data-toggle="modal" data-target="#getCroppedCanvasModal" class="btn btn-success mb-3" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
                                <span data-toggle="tooltip" title="cropper.getCroppedCanvas({ width: 160, height: 90 })">
                                160×90
                                </span>
                                </button>
                                <button type="button" data-toggle="modal" data-target="#getCroppedCanvasModal" class="btn btn-success mb-3" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
                                <span data-toggle="tooltip" title="cropper.getCroppedCanvas({ width: 320, height: 180 })">
                                320×180
                                </span>
                                </button>
                            </div>
                            <!-- Show the cropped image in modal -->
                            <div class="modal fade cropper-cropped" id="getCroppedCanvasModal" role="dialog" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        <canvas width="260" height="260"></canvas>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal -->
                            <button type="button" class="btn btn-secondary mb-3" data-method="getData" data-target="#putData">
                            <span data-toggle="tooltip" title="cropper.getData()">
                            Get Data
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="setData" data-target="#putData">
                            <span data-toggle="tooltip" title="cropper.setData(data)">
                            Set Data
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="getContainerData" data-target="#putData">
                            <span data-toggle="tooltip" title="cropper.getContainerData()">
                            Get Container Data
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="getImageData" data-target="#putData">
                            <span data-toggle="tooltip" title="cropper.getImageData()">
                            Get Image Data
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="getCanvasData" data-target="#putData">
                            <span data-toggle="tooltip" title="cropper.getCanvasData()">
                            Get Canvas Data
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="setCanvasData" data-target="#putData">
                            <span data-toggle="tooltip" title="cropper.setCanvasData(data)">
                            Set Canvas Data
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="getCropBoxData" data-target="#putData">
                            <span data-toggle="tooltip" title="cropper.getCropBoxData()">
                            Get Crop Box Data
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="setCropBoxData" data-target="#putData">
                            <span data-toggle="tooltip" title="cropper.setCropBoxData(data)">
                            Set Crop Box Data
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="moveTo" data-option="0">
                            <span data-toggle="tooltip" title="cropper.moveTo(0)">
                            Move to [0,0]
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="zoomTo" data-option="1">
                            <span data-toggle="tooltip" title="cropper.zoomTo(1)">
                            Zoom to 100%
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="rotateTo" data-option="180">
                            <span data-toggle="tooltip" title="cropper.rotateTo(180)">
                            Rotate 180°
                            </span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-3" data-method="scale" data-option="-2" data-second-option="-1">
                            <span data-toggle="tooltip" title="cropper.scale(-2, -1)">
                            Scale (-2, -1)
                            </span>
                            </button>
                            <label for="putData"></label>
                            <textarea class="form-control fw-normal" id="putData" placeholder="Get data to here or set data with this value"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cropper-preview clearfix d-flex flex-wrap mb-3">
                            <div id="cropper-preview-lg" class="img-preview preview-lg w-100 img-fluid mb-3" style="width: 256px; height: 160px; overflow: hidden; background-color: #f7f7f7;">
                                <canvas width="186" height="160"></canvas>
                            </div>
                            <div id="cropper-preview-md" class="img-preview preview-md float-left" style="width: 128px; height: 80px; overflow: hidden; background-color: #f7f7f7;">
                                <canvas width="93" height="80"></canvas>
                            </div>
                            <div id="cropper-preview-sm" class="img-preview preview-sm float-left ms-3" style="width: 64px; height: 40px; overflow: hidden; background-color: #f7f7f7;">
                                <canvas width="46" height="40"></canvas>
                            </div>
                            <div id="cropper-preview-xs" class="img-preview preview-xs float-left ms-3" style="width: 32px; height: 20px; overflow: hidden; background-color: #f7f7f7;">
                                <canvas width="23" height="20"></canvas>
                            </div>
                            </div>
                            <!-- <h3>Data:</h3> -->
                            <div id="cropper-data" class="mb-3">
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <label class="input-group-text" for="dataX">X</label>
                                    <input type="text" class="form-control" id="dataX" placeholder="x">
                                    <span class="input-group-text">px</span>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <label class="input-group-text" for="dataY">Y</label>
                                    <input type="text" class="form-control" id="dataY" placeholder="y">
                                    <span class="input-group-text">px</span>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <label class="input-group-text" for="dataWidth">Width</label>
                                    <input type="text" class="form-control" id="dataWidth" placeholder="width">
                                    <span class="input-group-text">px</span>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <label class="input-group-text" for="dataHeight">Height</label>
                                    <input type="text" class="form-control" id="dataHeight" placeholder="height">
                                    <span class="input-group-text">px</span>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <label class="input-group-text" for="dataRotate">Rotate</label>
                                    <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                                    <span class="input-group-text">deg</span>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <label class="input-group-text" for="dataScaleX">ScaleX</label>
                                    <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="input-group-text" for="dataScaleY">ScaleY</label>
                                    <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                                </div>
                            </div>
                            </div>
                            <div class="btn-group d-flex flex-nowrap mb-3" data-toggle="buttons" id="setAspectRatio">
                            <label class="btn btn-primary active">
                            <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 16 / 9">
                            16:9
                            </span>
                            </label>
                            <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">
                            4:3
                            </span>
                            </label>
                            <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">
                            1:1
                            </span>
                            </label>
                            <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">
                            2:3
                            </span>
                            </label>
                            <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">
                            Free
                            </span>
                            </label>
                            </div>
                            <div class="btn-group d-flex flex-nowrap" data-toggle="buttons" id="viewMode">
                            <label class="btn btn-primary active">
                            <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked="">
                            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
                            VM0
                            </span>
                            </label>
                            <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
                            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
                            VM1
                            </span>
                            </label>
                            <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
                            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
                            VM2
                            </span>
                            </label>
                            <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
                            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
                            VM3
                            </span>
                            </label>
                            </div>
                            <div class="btn-group d-flex flex-nowrap" id="toggleOptionButtons">
                            <div class="dropdown" style="width: 100%;">
                                <button class="btn btn-brand dropdown-toggle" style="width: 100%;" type="button" id="toggleOption" data-bs-toggle="dropdown">
                                Toggle options
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="toggleOption">
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="responsive" checked="">
                                        <span></span>
                                        responsive
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="restore" checked="">
                                        <span></span>
                                        restore
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="checkCrossOrigin" checked="">
                                        <span></span>
                                        checkCrossOrigin
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="checkOrientation" checked="">
                                        <span></span>
                                        checkOrientation
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="modal" checked="">
                                        <span></span>
                                        modal
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="guides" checked="">
                                        <span></span>
                                        guides
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="center" checked="">
                                        <span></span>
                                        center
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="highlight" checked="">
                                        <span></span>
                                        highlight
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="data-toggle=" tooltip="">
                                        <input type="checkbox" name="background" checked="">
                                        <span></span>
                                        background
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="autoCrop" checked="">
                                        <span></span>
                                        autoCrop
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="movable" checked="">
                                        <span></span>
                                        movable
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="rotatable" checked="">
                                        <span></span>
                                        rotatable
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="scalable" checked="">
                                        <span></span>
                                        scalable
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="zoomable" checked="">
                                        <span></span>
                                        zoomable
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="zoomOnTouch" checked="">
                                        <span></span>
                                        zoomOnTouch
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="zoomOnWheel" checked="">
                                        <span></span>
                                        zoomOnWheel
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="cropBoxMovable" checked="">
                                        <span></span>
                                        cropBoxMovable
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="cropBoxResizable" checked="">
                                        <span></span>
                                        cropBoxResizable
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="toggleDragModeOnDblclick" checked="">
                                        <span></span>
                                        toggleDragModeOnDblclick
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Cropper-->
                    <div class="row">
                        <div wire:ignore>
                            <img id="preview">
                        </div>
                    </div>
                </div>
                <!--end::Block-->
            </div>
        </section>
    </div>
    @push('css')
        
        <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/custom/cropper/cropper.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&amp;family=Work+Sans:wght@600;700;800&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

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
    @endpush
    @push('js')
        
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/cropper/cropper.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('assets/js/custom/documentation/general/cropper.js') }}"></script>
    <script>
        let cropper;
        document.addEventListener('DOMContentLoaded', function () {

            const image = document.getElementById('preview');

            cropper = new Cropper(image, {
                aspectRatio: NaN,
                viewMode: 1,
            });

        });
        function getCroppedCanvasBaru() {

            if (!cropper) {
                console.log('Cropper not ready');
                return;
            }

            const canvas = cropper.getCroppedCanvas({
                maxWidth: 1500,
                maxHeight: 1500
            });

            console.log(canvas);
        }
    </script>
    @endpush