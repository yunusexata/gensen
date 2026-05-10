<?php

namespace App\AiServices\Provider;

use App\AiServices\Contract\AiProviderInterface;
use OpenAI;

class OpenRouterProvider implements AiProviderInterface
{
    public function __construct(
        protected array $config
    ) {}

    public function client()
    {
        return OpenAI::factory()

            ->withApiKey(
                $this->config['api_key']
            )

            ->withBaseUri(
                $this->config['base_url']
            )

            ->withHttpHeader(
                'HTTP-Referer',
                $this->config['headers']['HTTP-Referer']
            )

            ->withHttpHeader(
                'X-OpenRouter-Title',
                $this->config['headers']['X-OpenRouter-Title']
            )

            ->make();
    }
}
