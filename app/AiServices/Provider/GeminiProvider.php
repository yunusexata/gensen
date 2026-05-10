<?php

namespace App\AiServices\Provider;

use App\AiServices\Contract\AiProviderInterface;
use App\Models\GensenForm\GensenFormAttachment;
use Illuminate\Support\Facades\Http;

class GeminiProvider implements AiProviderInterface
{
    public function __construct(
        protected array $config
    ) {}

    public function client()
    {
        return Http::baseUrl(
            $this->config['base_url']
        )->withQueryParameters([
            'key' => $this->config['api_key']
        ]);
    }
}
