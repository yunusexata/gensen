@push('js')
    <script>
        let stepper;

        document.addEventListener('livewire:init', () => {
            // const isUploadAttachment = {{$isUploadAttachment}}

            // if(isUploadAttachment){
            //     setTimeout(() => {
            //         console.log('init')
            //         initStepper();
            //     }, 300);
            // }
        });

function initStepper() {

    const element = document.querySelector("#kt_stepper_example_clickable");

    if (!element) return;
    if (stepper) {
        try {
            stepper.destroy();
        } catch(e) {
            console.log("Stepper already destroyed");
        }

        stepper = null;
    }
    stepper = new KTStepper(element);
   
    /*
    |--------------------------------------------------------------------------
    | NEXT
    |--------------------------------------------------------------------------
    */
    stepper.on("kt.stepper.next", function (stepperObj) {

        event.preventDefault();
        console.log('harusnya next')
        Livewire.dispatch('stepper-next-request');
    });

    /*
    |--------------------------------------------------------------------------
    | CLICK STEP NAV
    |--------------------------------------------------------------------------
    */
    stepper.on("kt.stepper.click", function () {
        event.preventDefault();
        console.log('stepper click')
        Livewire.dispatch(
            'stepper-click-request',
            { step: stepper.getClickedStepIndex() }
        );
    });

     /*
    |--------------------------------------------------------------------------
    | AFTER STEP CHANGED ⭐ IMPORTANT
    |--------------------------------------------------------------------------
    */
   stepper.on("kt.stepper.changed", function () {
    
    });

    /*
    |--------------------------------------------------------------------------
    | PREVIOUS
    |--------------------------------------------------------------------------
    */
    stepper.on("kt.stepper.previous", function () {
        stepper.goPrevious();
    });

}


/*
|--------------------------------------------------------------------------
| LIVEWIRE RESPONSE EVENTS
|--------------------------------------------------------------------------
*/

Livewire.on('stepper-go-next', () => {
    stepper.goNext();
});

Livewire.on('stepper-go-to', (index) => {
    console.log(['goto', index])
    stepper.goTo(index);
});
Livewire.on('onAuthorized', () => {
    setTimeout(() => {
        console.log('init')
        initStepper();
    }, 300);
});
    </script>
@endpush