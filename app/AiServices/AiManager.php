<?php

namespace App\AiServices;

class AiManager
{
    public function validate(Document $document)
    {
        return app(GeminiService::class)
            ->classifyDocument($document);
    }

    public function extract(Document $document)
    {
        return app(OpenAIService::class)
            ->extractGensen($document);
    }
}
