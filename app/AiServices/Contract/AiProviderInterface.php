<?php

namespace App\AiServices\Contract;

use App\Models\GensenForm\GensenFormAttachment;

interface AiProviderInterface
{
    // public function extract(
    //     GensenFormAttachment $document
    // ): array;

    public function client();
}
