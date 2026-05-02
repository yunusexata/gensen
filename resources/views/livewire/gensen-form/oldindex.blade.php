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

               <div class="zf-subContWrap zf-topAlign">
                  <ul>
                     <div class="zf-tempFrmWrapper zf-name  zf-namelarge">
                        <label class="zf-labelName"> 
                        Name 
                        <em class="zf-important"> *</em> 
                        </label>
                        <div class="zf-tempContDiv zf-twoType">
                           <div class="zf-nameWrapper">
                              <span> <input type="text" maxlength="255" name="Name_First" fieldType=7 placeholder=""/>
                              <label>First Name                                                            </label> </span>
                              <span> <input type="text" maxlength="255" name="Name_Last" fieldType=7 placeholder=""/>
                              <label>Last Name                                                            </label> </span>
                              <div class="zf-clearBoth"></div>
                           </div>
                           <p id="Name_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </div>
                     <div class="zf-tempFrmWrapper  zf-large ">
                        <label class="zf-labelName">  
                        Email 
                        <em class="zf-important"> *</em> 
                        </label>
                        <div class="zf-tempContDiv">
                           <span> 
                           <input type="text" name="Email" checktype="c5" value="" maxlength="255" fieldType=9 placeholder="" /> </span>
                           <p id="Email_error" class="zf-errorMessage" style="display: none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </div>
                     <div class="zf-tempFrmWrapper  zf-large ">
                        <label class="zf-labelName"> 
                        Select a position to apply 
                        <em class="zf-important"> *</em> 
                        </label>
                        <div class="zf-tempContDiv">
                           <select class="zf-form-sBox" name="Dropdown" checktype="c1">
                              <option selected="true" value="-Select-">-Select-</option>
                              <option value="Job 1">Job 1</option>
                              <option value="Job 2">Job 2</option>
                              <option value="Job 3">Job 3</option>
                           </select>
                           <p id="Dropdown_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </div>
                     <div class="zf-tempFrmWrapper  zf-date">
                        <label class="zf-labelName"> Available date 
                        <em class="zf-important"> *</em> 
                        </label>
                        <div class="zf-tempContDiv">
                           <span> <input type="text" name="Date" checktype="c4" value="" maxlength="25" placeholder="" />
                           <label>dd-MMM-yyyy</label> </span>
                           <div class="zf-clearBoth"></div>
                           <p id="Date_error" class="zf-errorMessage" style="display: none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </div>
                     <div class="zf-radio zf-tempFrmWrapper zf-oneColumns">
                        <label class="zf-labelName">
                        Current employment status 
                        <em class="zf-important">*</em> 
                        </label>
                        <div class="zf-tempContDiv">
                           <div class="zf-overflow">
                              <span class="zf-multiAttType"> 
                              <input class="zf-radioBtnType" type="radio" id="Radio_1" name="Radio" checktype="c1" value="Employed">
                              <label for="Radio_1" class="zf-radioChoice">Employed</label> </span>
                              <span class="zf-multiAttType"> 
                              <input class="zf-radioBtnType" type="radio" id="Radio_2" name="Radio" checktype="c1" value="Self-employed">
                              <label for="Radio_2" class="zf-radioChoice">Self-employed</label> </span>
                              <span class="zf-multiAttType"> 
                              <input class="zf-radioBtnType" type="radio" id="Radio_3" name="Radio" checktype="c1" value="Unemployed">
                              <label for="Radio_3" class="zf-radioChoice">Unemployed</label> </span>
                              <span class="zf-multiAttType"> 
                              <input class="zf-radioBtnType" type="radio" id="Radio_4" name="Radio" checktype="c1" value="Student">
                              <label for="Radio_4" class="zf-radioChoice">Student</label> </span>
                              <div class="zf-clearBoth"></div>
                           </div>
                           <p id="Radio_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </div>
                     <div class="zf-tempFrmWrapper">
                        <label class="zf-labelName">
                        Upload your resumé 
                        <em class="zf-important">*</em> 
                        </label>
                        <div class="zf-tempContDiv">
                           <input type="file"  name="FileUpload" checktype="c1"  />
                           <p id="FileUpload_error" class="zf-errorMessage" style="display: none;">
                              Choose any file for this field.
                           </p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </div>
                     <div class="zf-tempFrmWrapper  zf-large ">
                        <label class="zf-labelName">  
                        References
                        </label>
                        <div class="zf-tempContDiv">
                           <span> 
                           <input type="text" name="SingleLine" checktype="c1" value="" maxlength="255" fieldType=1 placeholder="" /> </span>
                           <p id="SingleLine_error" class="zf-errorMessage" style="display: none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </div>
                     <div class="zf-tempFrmWrapper  zf-large ">
                        <label class="zf-labelName">  
                        Reference email
                        </label>
                        <div class="zf-tempContDiv">
                           <span> 
                           <input type="text" name="Email1" checktype="c5" value="" maxlength="255" fieldType=9 placeholder="" /> </span>
                           <p id="Email1_error" class="zf-errorMessage" style="display: none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </div>
                  </ul>
               </div>
               <ul>
                  <li class="zf-fmFooter"><button class="zf-submitColor">Submit</button></li>
               </ul>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nama Lengkap</label>
                <input placeholder="Nama Lengkap" type="text" wire:model="nama_lengkap" class="form-control">

                @error('nama_lengkap')
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
                <label>Tanggal Kepulangan</label>
                <input placeholder="Tanggal Kepulangan" type="date" wire:model="tanggal_kepulangan" class="form-control">

                @error('tanggal_kepulangan')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama Facebook</label>
                <input placeholder="Nama Facebook" type="text" wire:model="nama_facebook" class="form-control">

                @error('nama_facebook')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Nomor Whatsapp</label>
                <input placeholder="Nomor Whatsapp" type="text" wire:model="nomor_whatsapp" class="form-control">

                @error('nomor_whatsapp')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Alamat Email</label>
                <input placeholder="Alamat Email" type="email" wire:model="email" class="form-control">

                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Alamat tinggal di Jepang</label>
                <input placeholder="Alamat tinggal di Jepang" type="text" wire:model="alamat_jepang" class="form-control">

                @error('alamat_jepang')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Kode Pos Jepang</label>
                <input placeholder="Kode Pos Jepang" type="text" wire:model="kode_pos_jepang" class="form-control">

                @error('kode_pos_jepang')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Nama LPK/SO/PT</label>
                <input placeholder="Nama LPK/SO/PT" type="text" wire:model="nama_lpk" class="form-control">

                @error('nama_lpk')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Tahun Gensen</label>
                <input placeholder="cth: {{Carbon\Carbon::now()->format('Y')}}" type="number" wire:model="tahun_gensen" class="form-control">

                @error('tahun_gensen')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Tahun Transfer</label>
                <input placeholder="cth: {{Carbon\Carbon::now()->format('Y')}}" type="number" wire:model="tahun_transfer" class="form-control">

                @error('tahun_transfer')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- FILE --}}
            <div class="col-md-6">
                <label>Kertas Gensen</label>
                <input type="file"
                    wire:model="kertas_gensen"
                    multiple
                    class="form-control @error('kertas_gensen') is-invalid @enderror">
                @error('kertas_gensen')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label>My Number (opsional)</label>
                <input type="file"
                    wire:model="my_number"
                    multiple
                    class="form-control @error('my_number') is-invalid @enderror">
                @error('my_number')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Zairyou Card</label>
                <input type="file"
                    wire:model="zairyou_card"
                    multiple
                    class="form-control @error('zairyou_card') is-invalid @enderror">
                @error('zairyou_card')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Kartu Keluarga</label>
                <input type="file"
                    wire:model="kartu_keluarga"
                    multiple
                    class="form-control @error('kartu_keluarga') is-invalid @enderror">
                @error('kartu_keluarga')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Rekap Pengiriman Uang</label>
                <input type="file"
                    wire:model="rekap_pengiriman_uang"
                    multiple
                    class="form-control @error('rekap_pengiriman_uang') is-invalid @enderror">
                @error('rekap_pengiriman_uang')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Rekening Indonesia</label>
                <input type="file"
                    wire:model="rekening_indonesia"
                    multiple
                    class="form-control @error('rekening_indonesia') is-invalid @enderror">
                @error('rekening_indonesia')
                <div class="text-danger">{{ $message }}</div>
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