<?php

namespace App\AiServices\Support;

class AiModelRegistry
{
    public static function all(): array
    {
        return [

            'gpt-4o' => [
                'provider' => 'openai',

                'input_cost_per_million' => 5.00,
                'output_cost_per_million' => 15.00,

                'supports_cached_tokens' => true,
            ],

            'gpt-4o-mini' => [
                'provider' => 'openai',

                'input_cost_per_million' => 0.15,
                'output_cost_per_million' => 0.60,

                'supports_cached_tokens' => true,
            ],

            'gemini-1.5-flash' => [
                'provider' => 'google',

                'input_cost_per_million' => 0.35,
                'output_cost_per_million' => 0.53,

                'supports_cached_tokens' => false,
            ],

            'openrouter/free' => [
                'provider' => 'openrouter',

                'input_cost_per_million' => 0,
                'output_cost_per_million' => 0,

                'supports_cached_tokens' => false,
            ],
        ];
    }

    public static function get(string $model): array
    {
        return static::all()[$model];
    }
}
