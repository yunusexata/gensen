<?php

namespace App\Observers;

use App\Models\GensenForm\GensenFormAttachment;
use Illuminate\Support\Facades\Storage;


class GensenAttachmentObserver
{
    /**
     * Handle the GensenFormAttachment "created" event.
     */
    public function created(GensenFormAttachment $model): void
    {
        //
    }

    /**
     * Handle the GensenFormAttachment "updated" event.
     */
    public function updated(GensenFormAttachment $model): void
    {
        //
    }

    /**
     * Handle the GensenFormAttachment "deleted" event.
     */
    public function deleted(GensenFormAttachment $model): void
    {
        // 
    }

    /**
     * Handle the GensenFormAttachment "restored" event.
     */
    public function restored(GensenFormAttachment $model): void
    {
        //
    }

    /**
     * Handle the GensenFormAttachment "force deleted" event.
     */
    public function forceDeleted(GensenFormAttachment $model): void
    {

        if ($model->path) {
            Storage::disk($model->disk)->delete($model->path);
        }
    }
}
