<?php

namespace App\Observers;

use App\Jobs\SendGensenFormCreatedEmailJob;
use App\Models\GensenForm\GensenForm;

class GensenFormObserver
{
    /**
     * Handle the GensenForm "created" event.
     */
    public function created(GensenForm $gensenForm): void {}

    /**
     * Handle the GensenForm "updated" event.
     */
    public function updated(GensenForm $gensenForm): void
    {
        if ($gensenForm->is_should_filled) {
            SendGensenFormCreatedEmailJob::dispatch($gensenForm);
        }
    }

    /**
     * Handle the GensenForm "deleted" event.
     */
    public function deleted(GensenForm $gensenForm): void
    {
        //
    }

    /**
     * Handle the GensenForm "restored" event.
     */
    public function restored(GensenForm $gensenForm): void
    {
        //
    }

    /**
     * Handle the GensenForm "force deleted" event.
     */
    public function forceDeleted(GensenForm $gensenForm): void
    {
        //
    }
}
