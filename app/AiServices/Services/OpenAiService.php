<?php

namespace App\AiServices\Services;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Facades\AI;
use App\Models\GensenForm\GensenForm;
use Illuminate\Support\Facades\Storage;

class OpenAIService
{
    /**
     * Extract and aggregate remittance data from multiple documents
     * using GPT-4o mini (single request, multi-page reasoning).
     */
    public function extractRemittance(GensenForm $gensen_form): array
    {
        $client = AI::connection('openai')->client();
        $gensen_form = $gensen_form->with([
            'attachments' => function ($q) {
                return $q->where('type', GensenAttachmentType::REKAP_PENGIRIMAN_UANG)
                    ->where('status', GensenAttachmenStatus::STATUS_CONVERTED);
            }
        ])->first();
        $documents = $gensen_form->attachments;
        $content = $this->buildMultiFileContent($documents->toArray());

        logger([
            'content',
            $content
        ]);

        $response = $client->responses()->create([

            // 'model' => 'gpt-4o-mini',
            'model' => 'hemini 3.1 flash-lite',

            'input' => [[
                'role' => 'user',
                'content' => $content,
            ]],

            'text' => [
                'format' => [
                    'type' => 'json_object',
                ],
            ],
        ]);

        logger([
            'response',
            $response
        ]);

        $json = json_decode(
            $response->outputText ?? '{}',
            true
        );

        return [
            'json' => $json,

            'usage' => [
                'input_tokens' =>
                $response->usage->inputTokens ?? 0,

                'output_tokens' =>
                $response->usage->outputTokens ?? 0,
            ],

            'raw' => $response,
        ];
    }

    /**
     * Build multi-document vision input (NO batching, single request)
     */
    private function buildMultiFileContent(array $documents): array
    {
        $content = [];

        // SYSTEM PROMPT (single reusable instruction)
        $content[] = [
            'type' => 'input_text',
            'text' => $this->prompt(),
        ];

        foreach ($documents as $index => $document) {

            $path = Storage::disk('private')
                ->path($document['path']);

            $mime = mime_content_type($path);

            /**
             * IMPORTANT:
             * Only image inputs are safe for GPT-4o vision.
             * PDF MUST be converted BEFORE reaching this layer.
             */

            $content[] = [
                'type' => 'input_text',
                'text' => "DOCUMENT #" . ($index + 1),
            ];

            $content[] = [
                'type' => 'input_image',
                'image_url' => $this->toBase64($path, $mime),
                'detail' => 'high'
            ];
        }

        return $content;
    }

    /**
     * Core extraction + aggregation prompt
     */
    private function prompt(): string
    {
        return <<<PROMPT
You are a financial remittance extraction and aggregation engine specialized in Japanese remittance documents.

You will receive MULTIPLE remittance documents in a SINGLE request.

OBJECTIVE:
Extract and aggregate valid remittance transfer amounts accurately across all provided documents.

━━━━━━━━━━
EXTRACTION RULES
━━━━━━━━━━

1. Extract ONLY actual transferred money amounts
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
- Example:
  2024
  2025

━━━━━━━━━━
AMOUNT NORMALIZATION RULES
━━━━━━━━━━

CRITICAL:
Preserve decimal values correctly.

Examples:
- "8,887,844.00 IDR" → 8887844.00
- "120,000 JPY" → 120000
- "1,500.50 USD" → 1500.50

Rules:
1. Remove currency symbols and text
2. Remove thousand separators
3. Preserve decimal digits exactly
4. NEVER multiply decimal values incorrectly
5. NEVER convert:
   8887844.00
   into
   888784400

6. total_amount MUST be numeric
7. Use decimal number format when decimals exist
8. Do not round values unless document explicitly rounds them

━━━━━━━━━━
OUTPUT FORMAT
━━━━━━━━━━

Return STRICT VALID JSON ONLY.

{
  "groups": [
    {
      "receiver_name": "string",
      "transaction_year": 2025,
      "total_amount": 8887844.00,
      "currency": "IDR",
      "transfer_transaction_count": 3
    }
  ],
  "confidence_score": 95
}

━━━━━━━━━━
OUTPUT RULES
━━━━━━━━━━

1. confidence_score:
   - integer
   - range 0-100

2. currency:
   - use ISO currency code when visible
   - examples:
     IDR
     JPY
     USD

3. If value is uncertain:
   - choose safest conservative interpretation
   - NEVER overcount

4. Do NOT hallucinate missing values

5. Return JSON ONLY
6. No markdown
7. No explanations
8. No additional text
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
}
