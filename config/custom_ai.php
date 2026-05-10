<?php

return [

    'default' => env('AI_PROVIDER', 'openai'),

    'providers' => [

        'openai' => [

            'driver' => 'openai',

            'api_key' => env('OPENAI_API_KEY'),

            'base_url' => 'https://api.openai.com/v1',

            'models' => [
                'extract' => 'gpt-4o',
            ],
        ],

        'gemini' => [

            'driver' => 'gemini',

            'api_key' => env('GEMINI_API_KEY'),

            'base_url' => 'https://generativelanguage.googleapis.com/v1beta',

            'models' => [
                // 'validate' => 'gemini-1.5-flash',
                'extract' => 'gemini-flash-latest',
            ],
        ],

        'openrouter' => [

            'driver' => 'openrouter',

            'api_key' => env('OPENROUTER_API_KEY'),

            'base_url' => 'https://openrouter.ai/api/v1',

            'headers' => [
                'HTTP-Referer' => env('APP_URL'),
                'X-OpenRouter-Title' => env('APP_NAME'),
            ],

            'models' => [
                // 'free_extract' => 'nvidia/llama-nemotron-embed-vl-1b-v2:free',
                'free_extract' => 'meta-llama/llama-3.2-11b-vision-instruct:free',
            ],
        ],
    ],
];
