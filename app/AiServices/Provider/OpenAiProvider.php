<?php

namespace App\AiServices\Provider;

use App\AiServices\Contract\AiProviderInterface;
use App\Models\GensenForm\GensenFormAttachment;
use OpenAI;

class OpenAIProvider implements AiProviderInterface
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function client()
    {
        return OpenAI::factory()
            ->withApiKey($this->config['api_key'])
            ->withBaseUri($this->config['base_url'])
            ->make();
    }

    public function extract(
        GensenFormAttachment $document
    ): array {

        return $this->extractGensen($document);
    }
}
