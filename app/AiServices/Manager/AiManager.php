<?php

namespace App\AiServices\Manager;

use InvalidArgumentException;

use App\AiServices\Provider\GeminiProvider;
use App\AiServices\Provider\OpenAiProvider;
use App\AiServices\Provider\OpenRouterProvider;

class AiManager
{
    public function connection(?string $provider = null)
    {
        $provider ??= config('custom_ai.default');

        $config = config("custom_ai.providers.{$provider}");

        return match ($config['driver']) {

            'openai' => new OpenAiProvider($config),

            'gemini' => new GeminiProvider($config),

            'openrouter' => new OpenRouterProvider($config),

            default => throw new InvalidArgumentException(
                "Unsupported AI provider [{$provider}]"
            ),
        };
    }
}
