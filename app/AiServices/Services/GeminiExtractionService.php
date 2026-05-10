<?php

namespace App\AiServices\Services;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Facades\AI;
use App\Models\GensenForm\GensenForm;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GeminiExtractionService
{



    /**
     * Extract and aggregate remittance data from multiple documents
     * using GPT-4o mini (single request, multi-page reasoning).
     */
    public function extractRemittance(GensenForm $gensen_form): array
    {
        $model = config('custom_ai.providers.gemini.models.extract');
        $apiKey = config('custom_ai.providers.gemini.api_key');

        $endpoint =
            "https://generativelanguage.googleapis.com/v1beta/models/{$model}:streamGenerateContent?key={$apiKey}";

        /*
        |--------------------------------------------------------------------------
        | Build image inlineData
        |--------------------------------------------------------------------------
        */
        $gensenForm = $gensen_form
            ->with([
                'attachments' => fn($q) =>
                $q->where('type', GensenAttachmentType::REKAP_PENGIRIMAN_UANG)
                    ->where('status', GensenAttachmenStatus::STATUS_CONVERTED)
            ])
            ->firstOrFail();

        $imageParts = $gensenForm->attachments
            ->pluck('path')
            ->filter()
            ->map(function ($path) {

                $path = Storage::disk('private')
                    ->path($path);
                $mime = mime_content_type($path);
                logger([
                    'path',
                    $path
                ]);
                return [
                    'inlineData' => [
                        'mimeType' => $mime,
                        'data' => base64_encode(file_get_contents($path))
                    ],
                ];
            })
            ->values()
            ->all();
        /*
        |--------------------------------------------------------------------------
        | Build request payload
        |--------------------------------------------------------------------------
        */

        logger([
            'imageParts',
            $imageParts
        ]);

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => array_merge(
                        [
                            ['text' => $this->prompt()],
                        ],
                        $imageParts
                    ),
                ],
                // [
                //     'role' => 'user',
                //     'parts' => [
                //         [
                //             'text' => $input ?: 'INSERT_INPUT_HERE',
                //         ],
                //     ],
                // ],
            ],

            'generationConfig' => [
                'thinkingConfig' => [
                    'thinkingLevel' => 'HIGH',
                ],
                'mediaResolution' => 'MEDIA_RESOLUTION_HIGH',
                'responseMimeType' => 'application/json',
            ],
            'generationConfig' => [
                'response_mime_type' => 'application/json',
                'response_schema' => [
                    'type' => 'object',
                    'properties' => [
                        'groups' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'receiver_name' => ['type' => 'string'],
                                    'transaction_year' => ['type' => 'integer'],
                                    'total_amount' => ['type' => 'number'],
                                    'currency' => ['type' => 'string'],
                                    'transfer_transaction_count' => ['type' => 'integer'],
                                ]
                            ]
                        ],
                        'confidence_score' => ['type' => 'integer']
                    ]
                ]
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | Call Gemini API
        |--------------------------------------------------------------------------
        */

        logger([
            'payload',
            $payload
        ]);
        logger([
            'endpoint',
            $endpoint
        ]);

        $response = Http::timeout(300)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($endpoint, $payload);

        if (!$response->successful()) {
            throw new \Exception($response->body());
        }

        /*
        |--------------------------------------------------------------------------
        | Gemini streamGenerateContent response parsing
        |--------------------------------------------------------------------------
        */

        $chunks = $response;

        logger([
            'chunks',
            $chunks,
        ]);

        $text = collect($chunks)
            ->pluck('candidates')
            ->flatten(1)
            ->pluck('content.parts')
            ->flatten(2)
            ->pluck('text')
            ->implode('');

        logger([
            'result chunks',
            $text
        ]);
        return json_decode($chunks, true);
    }

    /**
     * Build multi-document vision input (NO batching, single request)
     */
    private function buildMultiFileContent(array $documents): array
    {
        $content = [];

        // SYSTEM PROMPT (single reusable instruction)


        $file_content = [];
        foreach ($documents as $index => $document) {

            $path = Storage::disk('private')
                ->path($document['path']);

            $mime = mime_content_type($path);

            /**
             * IMPORTANT:
             * Only image inputs are safe for GPT-4o vision.
             * PDF MUST be converted BEFORE reaching this layer.
             */

            $file_content[] = [
                'inlineData' => [
                    'mimeType' => $mime,
                    'data' => $this->toBase64($path, $mime),
                ],

            ];
        }
        $content[] = [
            'role' => 'user',
            'parts' => [
                [
                    'text' => $this->prompt(),
                ],
                $file_content
            ]
        ];

        return $content;
    }

    /**
     * Core extraction + aggregation prompt
     */
    private function prompt(): string
    {
        return <<<PROMPT
You are a financial remittance extraction and aggregation engine specialized in Japanese remittance documents.

OBJECTIVE:
Extract, aggregate, and group valid remittance transfer amounts from the provided documents. 

━━━━━━━━━━
EXTRACTION & AGGREGATION RULES
━━━━━━━━━━
1. Extract ONLY actual transferred JPY amounts.
2. EXCLUDE: fees, taxes, service charges, exchange fees, and subtotal/summary rows.
3. Group the data by BOTH 'receiver_name' AND 'transaction_year'.
4. If the same person has transfers in different years, create a separate entry for each year.
5. 'transaction_year' must be an integer (e.g., 2024).
6. 'total_amount' must be a numeric value. Preserve decimals if present, but do not include thousand separators or currency symbols.
7. 'transfer_transaction_count' is the total number of valid transactions for that specific receiver in that specific year.

━━━━━━━━━━
OUTPUT FORMAT
━━━━━━━━━━
Return STRICT VALID JSON ONLY. No markdown, no backticks, no preamble.

{
  "groups": [
    {
      "receiver_name": "STRING",
      "transaction_year": INTEGER,
      "total_amount": NUMBER,
      "currency": "YEN",
      "transfer_transaction_count": INTEGER
    }
  ],
  "confidence_score": INTEGER
}

━━━━━━━━━━
CONSTRAINTS
━━━━━━━━━━
- Do not duplicate transactions.
- Use a conservative interpretation for uncertain values.
- Return ONLY the JSON object.
PROMPT;
    }

    /**
     * Convert file to base64 image for GPT-4o vision
     */
    private function toBase64(string $path, string $mime)
    {
        if (!str_starts_with($mime, 'image/')) {
            throw new \Exception(
                "Invalid file type for vision: {$mime}. Convert PDF to image first."
            );
        }

        return base64_encode(file_get_contents($path));
        // return sprintf(
        //     'data:%s;base64,%s',
        //     $mime,
        //     base64_encode(file_get_contents($path))
        // );
    }

    public function extractOld(array $imagePaths, string $input = ''): array
    {
        $apiKey = config('custom_ai.gemini.key');

        $endpoint =
            // "https://generativelanguage.googleapis.com/v1beta/models/{$model}:streamGenerateContent?key={$apiKey}";

            /*
        |--------------------------------------------------------------------------
        | SYSTEM PROMPT (your original prompt)
        |--------------------------------------------------------------------------
        */

            $systemPrompt = <<<PROMPT
You are a financial remittance extraction and aggregation engine specialized in Japanese remittance documents.

You will receive MULTIPLE remittance documents in a SINGLE request.

OBJECTIVE:
Extract and aggregate valid remittance transfer amounts accurately across all provided documents.

━━━━━━━━━━
EXTRACTION RULES
━━━━━━━━━━

1. Extract ONLY actual transferred money yen amounts
2. EXCLUDE:
   - transfer fees
   - taxes
   - service charges
   - exchange fees
   - handling fees
   - subtotal rows
   - duplicated summary values

3. Treat ALL uploaded documents as ONE dataset
4. DO NOT duplicate transactions across pages or repeated receipts
5. Merge identical transactions carefully

━━━━━━━━━━
GROUPING RULES
━━━━━━━━━━

Group results by:
- receiver_name
- transaction_year

transaction_year:
- Extract ONLY the year from transaction date
- Must be integer format

━━━━━━━━━━
AMOUNT NORMALIZATION RULES
━━━━━━━━━━

CRITICAL:
Preserve decimal values correctly.

Rules:
1. Remove currency symbols and text
2. Remove thousand separators
3. Preserve decimal digits exactly
4. NEVER multiply decimal values incorrectly
5. total_amount MUST be numeric

━━━━━━━━━━
OUTPUT FORMAT
━━━━━━━━━━

Return STRICT VALID JSON ONLY.

{
  "groups": [],
  "confidence_score": 98
}

OUTPUT RULES:
Return JSON ONLY.
PROMPT;

        /*
        |--------------------------------------------------------------------------
        | Build image inlineData
        |--------------------------------------------------------------------------
        */

        $imageParts = collect($imagePaths)->map(function ($path) {

            $binary = Storage::get($path);

            return [
                'inlineData' => [
                    'mimeType' => 'image/jpeg',
                    'data' => base64_encode($binary),
                ],
            ];
        })->values()->all();

        /*
        |--------------------------------------------------------------------------
        | Build request payload
        |--------------------------------------------------------------------------
        */

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => array_merge(
                        [
                            ['text' => $systemPrompt],
                        ],
                        $imageParts
                    ),
                ],
                [
                    'role' => 'user',
                    'parts' => [
                        [
                            'text' => $input ?: 'INSERT_INPUT_HERE',
                        ],
                    ],
                ],
            ],

            'generationConfig' => [
                'thinkingConfig' => [
                    'thinkingLevel' => 'HIGH',
                ],
                'mediaResolution' => 'MEDIA_RESOLUTION_HIGH',
                'responseMimeType' => 'application/json',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Call Gemini API
        |--------------------------------------------------------------------------
        */

        $response = Http::timeout(180)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($endpoint, $payload);

        if (!$response->successful()) {
            throw new \Exception($response->body());
        }

        /*
        |--------------------------------------------------------------------------
        | Gemini streamGenerateContent response parsing
        |--------------------------------------------------------------------------
        */

        $chunks = $response->json();

        $text = collect($chunks)
            ->pluck('candidates')
            ->flatten(1)
            ->pluck('content.parts')
            ->flatten(2)
            ->pluck('text')
            ->implode('');

        return json_decode($text, true);
    }
}
