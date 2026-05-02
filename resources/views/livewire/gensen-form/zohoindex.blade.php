<form wire:submit.prevent="store">
            <div class="zf-templateWrapper">
               <ul class="zf-tempHeadBdr">
                  <li class="zf-tempHeadContBdr">
                     <h2 class="zf-frmTitle">
                        <em>GENSEN</em>
                     </h2>
                     <p class="zf-frmDesc"></p>
                     <div class="zf-clearBoth"></div>
                  </li>
               </ul>
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
                        <label class="form-label">Upload KTP / SIM</label>
        
                        <label
                            for="upload_image_background"
                            class="upload_dropZone text-center mb-3 p-4 w-100 border border-dashed rounded"
                            :class="isDragging ? 'bg-light border-primary border-3' : 'border-secondary'"
                        >
                            <legend class="visually-hidden">Image uploader</legend>
        
                            <svg class="upload_svg" width="60" height="60" aria-hidden="true">
                                <use href="#icon-imageUpload"></use>
                            </svg>
        
                            <p class="small my-2">
                                Drag & Drop KTP / SIM di dalam wilayah putus-putus<br><i>atau</i>
                            </p>
        
                            <input
                                x-ref="input"
                                id="upload_image_background"
                                type="file"
                                wire:model="customer_ktp"
                                @change="handleFiles"
                                accept="image/jpeg, image/png, .pdf"
                                class="position-absolute invisible"
                            />
        
                            <label class="btn btn-upload mb-3" for="upload_image_background">Choose file(s)</label>
        
                            <!-- Optional preview -->
                            <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0">
                                @if ($customer_ktp)
                                    <div class="text-center">
                                        <img src="{{ $customer_ktp->temporaryUrl() }}" alt="preview" class="img-thumbnail">
                                    </div>
                                @endif
                            </div>
                        </label>
        
                        @error('customer_ktp.*') <div class="text-danger">{{ $message }}</div> @enderror
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
                  <li class="zf-fmFooter"><button class="zf-submitColor" type="submit">Submit</button></li>
               </ul>
            </div>
         </form>