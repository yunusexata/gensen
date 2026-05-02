<main class="h-screen flex">
    <div class="row d-flex">
        {{-- GENSEN --}}
        <div class="col-md-4 mt-3">
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
                class="form-group mt-5">
                <div class="flex items-center gap-3 mb-5">
                    <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                    <h2 class="font-headline font-bold text-2xl">KERTAS GENSEN</h2>
                </div>
                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                    <input class="hidden validate-upload-file" id="kertas_gensen" name="kertas_gensen"
                        type="file"
                        multiple
                        x-ref="input"
                        wire:model="kertas_gensen"
                        @change="handleFiles"
                        accept="application/pdf, image/jpeg, image/png"
                        class="position-absolute invisible" />
                    <label class="cursor-pointer flex flex-col items-center gap-3" for="kertas_gensen">
                        <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                        <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                        <p class="text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                    </label>
                </div>
                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0 file-preview">
                    @if ($kertas_gensen)
                    @foreach ($kertas_gensen as $index => $item)
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
                    {{-- {!! $kertas_gensen_note[$index] !!} --}}
                    @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                    <div style="margin-top: 10px; text-align: center;" class="row d-flex jusify-content-center w-full">
                        <img src="{{$url}}" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 2px solid #e0e0e0; object-fit: contain;">
                    </div>
                    {{-- <img src="{{ $url }}" class="img-fluid rounded img-thumbnail"> --}}
                    @elseif(in_array($ext, ['pdf']))
                    <div class="row w-full">
                        <embed src="{{ $url }}" type="application/pdf" width="100%" style="height: 300px;">
                    </div>
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
                    {{-- {!! $kertas_gensen_old_note[$index] !!} --}}
                    @if($item['isImage'] ?? 0)
                    <div style="margin-top: 10px; text-align: center;" class="row d-flex jusify-content-center w-full">
                        <img src="{{$item['url']}}" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 2px solid #e0e0e0; object-fit: contain;">
                    </div>
                    {{-- <img src="{{$item['url']}}" class="img-fluid rounded img-thumbnail"> --}}
                    @elseif($item['isPdf'])
                    <div class="row w-full">
                        <embed src="{{$item['url']}}" type="application/pdf" style="height: 300px;">
                    </div>
                    {{-- <iframe
               src="{{$item['url']}}#toolbar=0"
                    width="100%"
                    style="border:none">
                    </iframe> --}}
                    @else
                    <div class="border rounded p-4 text-center bg-light">
                        <i class="bi bi-file-earmark fs-1"></i>
                        <div class="mt-2">
                            {{$item['url']}}
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-auto d-flex align-items-center">
                            <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors'
                                wire:click="showDialogDeleteFile('{{$item['id']}}')">
                                <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        {{-- Rekap Pengiriman Uang --}}
        <div class="col-md-4 mt-3">
            <div class="row mt-5">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                    <h2 class="font-headline font-bold text-2xl">REKAP PENGIRIMAN UANG</h2>
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
                    <label class="cursor-pointer w-75 flex flex-col items-center gap-2 border-2 border-dashed border-blue-100 rounded-lg p-2 rounded {{($rekap['remittance_type']) ? '' : 'd-none'}}" for="rekap_pengiriman_uang.{{$rekap_index}}.file">
                        <p class=" my-0 font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class=" my-0 text-primary font-semibold">CARI</span></p>
                        <p class=" my-0 text-xs text-outline font-medium">Format: PDF (Max 10MB)</p>
                    </label>
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
                        <div style="margin-top: 10px; text-align: center;" class="row d-flex jusify-content-center w-full mt-3">
                            <img src="{{$url}}" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 2px solid #e0e0e0; object-fit: contain;">
                        </div>
                        {{-- <img src="{{ $url }}" class="img-fluid rounded img-thumbnail"> --}}
                        @elseif(in_array($ext, ['pdf']))
                        <div class="row w-full mt-3">
                            <embed src="{{ $url }}" type="application/pdf" width="100%" style="height: 300px;">
                        </div>
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
            <div class="row mb-2 mt-5 h-[100px]">
                <button type="button" class="btn btn-success w-100 mx-auto" wire:click="addRekapPengirimanUang"><i class='fa fa-plus'></i> Tambah File <i class='fa fa-plus'></i></button>
            </div>
            @if ($rekap_pengiriman_uang_old)
            @foreach ($rekap_pengiriman_uang_old['groups'] as $group_index => $group)
            {{--
   <h3 class="ms-[10px] text-center">{{$rekap_pengiriman_uang_old['groups'][$group_index]['provider']}}</h3>
            --}}
            <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0 file-preview">
                @if ($group['files']->isNotEmpty())
                @foreach ($group['files'] as $rekap_index => $item)
                @if($item['isImage'] ?? 0)
                <div style="margin-top: 10px; text-align: center;" class="row d-flex jusify-content-center w-full">
                    <img src="{{$item['url']}}" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 2px solid #e0e0e0; object-fit: contain;">
                </div>
                @elseif($item['isPdf'])
                <div class="row w-full">
                    <embed src="{{$item['url']}}" type="application/pdf" style="height: 300px;">
                </div>
                {{-- <iframe
         src="{{$item['url']}}#toolbar=0"
                width="100%"
                style="border:none">
                </iframe> --}}
                @else
                <div class="border rounded p-4 text-center bg-light">
                    <i class="bi bi-file-earmark fs-1"></i>
                    <div class="mt-2">
                        {{$item['url']}}
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-auto d-flex align-items-center">
                        <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors'
                            wire:click="showDialogDeleteFile('{{$item['id']}}')">
                            <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                        </button>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            @endforeach
            @endif
        </div>
        {{-- Kartu Keluarga --}}
        <div class="col-md-4 mt-3">
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
                <div class="flex items-center gap-3 mb-5">
                    <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                    <h2 class="font-headline font-bold text-2xl">KARTU KELUARGA</h2>
                </div>
                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                    <input class="hidden validate-upload-file" id="kartu_keluarga" name="kartu_keluarga"
                        type="file"
                        multiple
                        x-ref="input"
                        wire:model="kartu_keluarga"
                        @change="handleFiles"
                        accept="application/pdf, image/jpeg, image/png"
                        class="position-absolute invisible" />
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
                    <div style="margin-top: 10px; text-align: center;" class="row d-flex jusify-content-center w-full">
                        <img src="{{$url}}" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 2px solid #e0e0e0; object-fit: contain;">
                    </div>
                    {{-- <img src="{{ $url }}" class="img-fluid rounded img-thumbnail"> --}}
                    @elseif(in_array($ext, ['pdf']))
                    <div class="row w-full">
                        <embed src="{{ $url }}" type="application/pdf" width="100%" style="height: 300px;">
                    </div>
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
                    @if ($kartu_keluarga_old && $kartu_keluarga_old['groups']->isNotEmpty())
                    @foreach ($kartu_keluarga_old['groups']->first()['files'] as $item)
                    @if($item['isImage'] ?? 0)
                    <div style="margin-top: 10px; text-align: center;" class="row d-flex jusify-content-center w-full">
                        <img src="{{$item['url']}}" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 4px; border: 2px solid #e0e0e0; object-fit: contain;">
                    </div>
                    {{-- <img src="{{$item['url']}}" class="img-fluid rounded img-thumbnail"> --}}
                    @elseif($item['isPdf'])
                    <div class="row w-full">
                        <embed src="{{$item['url']}}" type="application/pdf" style="height: 300px;">
                    </div>
                    @else
                    <div class="border rounded p-4 text-center bg-light">
                        <i class="bi bi-file-earmark fs-1"></i>
                        <div class="mt-2">
                            {{$item['url']}}
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-auto d-flex align-items-center">
                            <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors'
                                wire:click="showDialogDeleteFile('{{$item['id']}}')">
                                <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        {{-- Zairyou Card Depan--}}
        <div class="col-md-4 mt-3">
            <div class="flex items-center gap-3 mb-5">
                <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                <h2 class="font-headline font-bold text-2xl">ZAIRYOU CARD (Depan)</h2>
            </div>
            @if (!$zairyou_card_front_old)
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
                class="form-group mt-5">
                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                    <input class="hidden validate-upload-file" id="zairyou_card_front" name="zairyou_card_front" type="file"
                        x-ref="input"
                        wire:model="zairyou_card_front"
                        @change="handleFiles"
                        accept="image/jpeg, image/png"
                        class="position-absolute invisible" />
                    <label class="cursor-pointer flex flex-col items-center gap-3" for="zairyou_card_front">
                        <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                        <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                        <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)</p>
                    </label>
                </div>
            </div>
            @endif
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
                @if($zairyou_card_front_old['isImage'])
                <img src="{{$zairyou_card_front_old['url']}}" class="img-fluid rounded img-thumbnail">
                @elseif($zairyou_card_front_old['isPdf'])
                <embed src="{{$zairyou_card_front_old['url']}}" type="application/pdf" width="100%">
                {{-- <iframe
         src="{{$zairyou_card_front_old['url']}}#toolbar=0"
                width="100%"
                style="border:none">
                </iframe> --}}
                @else
                <div class="border rounded p-4 text-center bg-light">
                    <i class="bi bi-file-earmark fs-1"></i>
                    <div class="mt-2">
                        {{$zairyou_card_front_old['url']}}
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-auto d-flex align-items-center">
                        <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors'
                            wire:click="showDialogDeleteFile('{{$zairyou_card_front_old['id']}}')">
                            <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
        {{-- Zairyou Card Belakang --}}
        <div class="col-md-4 mt-3">
            <div class="flex items-center gap-3 mb-5">
                <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                <h2 class="font-headline font-bold text-2xl">ZAIRYOU CARD (Belakang)</h2>
            </div>
            @if (!$zairyou_card_back_old)
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
                class="form-group mt-5">
                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                    <input class="hidden validate-upload-file" id="zairyou_card_back" name="zairyou_card_back" type="file"
                        x-ref="input"
                        wire:model="zairyou_card_back"
                        @change="handleFiles"
                        accept="image/jpeg, image/png"
                        class="position-absolute invisible" />
                    <label class="cursor-pointer flex flex-col items-center gap-3" for="zairyou_card_back">
                        <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                        <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                        <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)</p>
                    </label>
                </div>
            </div>
            @endif
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
                @if($zairyou_card_back_old['isImage'])
                <img src="{{$zairyou_card_back_old['url']}}" class="img-fluid rounded img-thumbnail">
                @elseif($zairyou_card_back_old['isPdf'])
                <embed src="{{$zairyou_card_back_old['url']}}" type="application/pdf" width="100%">
                {{-- <iframe
         src="{{$zairyou_card_back_old['url']}}#toolbar=0"
                width="100%"
                style="border:none">
                </iframe> --}}
                @else
                <div class="border rounded p-4 text-center bg-light">
                    <i class="bi bi-file-earmark fs-1"></i>
                    <div class="mt-2">
                        {{$zairyou_card_front_old['url']}}
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-auto d-flex align-items-center justify-content-center">
                        <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors'
                            wire:click="showDialogDeleteFile('{{$zairyou_card_back_old['id']}}')">
                            <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
        {{-- My Number Depan --}}
        <div class="col-md-4 mt-3">
            <div class="flex items-center gap-3 mb-5">
                <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                <h2 class="font-headline font-bold text-2xl">MY NUMBER (Depan)</h2>
            </div>
            @if (!$my_number_front_old)
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
                class="form-group mt-5">
                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                    <input class="hidden validate-upload-file" id="my_number_front" name="my_number_front" type="file"
                        x-ref="input"
                        wire:model="my_number_front"
                        @change="handleFiles"
                        accept="image/jpeg, image/png"
                        class="position-absolute invisible" />
                    <label class="cursor-pointer flex flex-col items-center gap-3" for="my_number_front">
                        <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                        <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                        <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)</p>
                    </label>
                </div>
            </div>
            @endif
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
                @if($my_number_front_old['isImage'])
                <img src="{{$my_number_front_old['url']}}" class="img-fluid rounded img-thumbnail">
                @elseif($my_number_front_old['isPdf'])
                <embed src="{{$my_number_front_old['url']}}" type="application/pdf" width="100%">
                {{-- <iframe
         src="{{$my_number_front_old['url']}}#toolbar=0"
                width="100%"
                style="border:none">
                </iframe> --}}
                @else
                <div class="border rounded p-4 text-center bg-light">
                    <i class="bi bi-file-earmark fs-1"></i>
                    <div class="mt-2">
                        {{$my_number_front_old['url']}}
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-auto d-flex align-items-center justify-content-center">
                        <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors'
                            wire:click="showDialogDeleteFile('{{$my_number_front_old['id']}}')">
                            <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
        {{-- My Number Belakang --}}
        <div class="col-md-4 mt-3">
            <div class="flex items-center gap-3 mb-5">
                <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                <h2 class="font-headline font-bold text-2xl">MY NUMBER (Belakang)</h2>
            </div>
            @if (!$my_number_back_old)
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
                class="form-group mt-5">
                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                    <input class="hidden validate-upload-file" id="my_number_back" name="my_number_back" type="file"
                        x-ref="input"
                        wire:model="my_number_back"
                        @change="handleFiles"
                        accept="image/jpeg, image/png"
                        class="position-absolute invisible" />
                    <label class="cursor-pointer flex flex-col items-center gap-3" for="my_number_back">
                        <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                        <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                        <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)</p>
                    </label>
                </div>
            </div>
            @endif
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
                @if($my_number_back_old['isImage'])
                <img src="{{$my_number_back_old['url']}}" class="img-fluid rounded img-thumbnail">
                @elseif($my_number_back_old['isPdf'])
                <embed src="{{$my_number_back_old['url']}}" type="application/pdf" width="100%">
                {{-- <iframe
         src="{{$my_number_back_old['url']}}#toolbar=0"
                width="100%"
                style="border:none">
                </iframe> --}}
                @else
                <div class="border rounded p-4 text-center bg-light">
                    <i class="bi bi-file-earmark fs-1"></i>
                    <div class="mt-2">
                        {{$my_number_back_old['url']}}
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-auto d-flex align-items-center">
                        <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors'
                            wire:click="showDialogDeleteFile('{{$my_number_back_old['id']}}')">
                            <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
        {{-- Rekening Indonesia --}}
        <div class="col-md-4 mt-3">
            <div class="flex items-center gap-3 mb-5">
                <span class="material-symbols-outlined text-primary" data-icon="cloud_upload">cloud_upload</span>
                <h2 class="font-headline font-bold text-2xl">REKENING INDONESIA</h2>
            </div>
            @if (!$rekening_indonesia_old)
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
                class="form-group mt-5">
                <div class="border-2 border-dashed border-outline-variant/30 rounded-xl p-2 text-center bg-surface-container-low/30 hover:bg-surface-container-low transition-colors duration-300">
                    <input class="hidden validate-upload-file" id="rekening_indonesia" name="rekening_indonesia" type="file"
                        x-ref="input"
                        {{-- wire:model="rekening_indonesia" --}}
                        @change="handleFiles"
                        accept="image/jpeg, image/png"
                        class="position-absolute invisible" />
                    <label class="cursor-pointer flex flex-col items-center gap-3" for="rekening_indonesia">
                        <span class="material-symbols-outlined text-5xl text-primary-container" data-icon="description">description</span>
                        <p class="font-body text-on-surface-variant">Drag and drop file kamu disini, atau <span class="text-primary font-semibold">CARI FILE</span></p>
                        <p class="text-xs text-outline font-medium">Format: JPG/PNG (Max 10MB)</p>
                    </label>
                </div>
            </div>
            @endif
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
                @if($rekening_indonesia_old['isImage'])
                <img src="{{$rekening_indonesia_old['url']}}" class="img-fluid rounded img-thumbnail">
                @elseif($rekening_indonesia_old['isPdf'])
                <embed src="{{$rekening_indonesia_old['url']}}" type="application/pdf">
                {{-- <iframe
         src="{{$rekening_indonesia_old['url']}}#toolbar=0"
                width="100%"
                style="border:none">
                </iframe> --}}
                @else
                <div class="border rounded p-4 text-center bg-light">
                    <i class="bi bi-file-earmark fs-1"></i>
                    <div class="mt-2">
                        {{$rekening_indonesia_old['url']}}
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-auto d-flex align-items-center">
                        <button type='button' class='p-0 hover:bg-error/10 text-error rounded transition-colors'
                            wire:click="showDialogDeleteFile('{{$rekening_indonesia_old['id']}}')">
                            <span class='material-symbols-outlined text-xl' data-icon='delete'>delete</span>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>