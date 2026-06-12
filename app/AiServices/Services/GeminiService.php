<?php

namespace App\AiServices\Services;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Models\Ai\AiJob;
use App\Models\GensenForm\GensenForm;
use Exception;
use Gemini\Data\Blob;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\SafetySetting;
use Gemini\Data\Schema;
use Gemini\Data\ThinkingConfig;
use Gemini\Enums\DataType;
use Gemini\Enums\HarmBlockThreshold;
use Gemini\Enums\HarmCategory;
use Gemini\Enums\MediaResolution;
use Gemini\Enums\MimeType;
use Gemini\Enums\ResponseMimeType;
use Gemini\Enums\ThinkingLevel;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Storage;


class GeminiService
{
    //· IDR4,310,625.10 Billing Account Tier Cap
    /**
     * Process multiple files for tax data extraction.
     */
    public function extractRemittance(GensenForm $gensen_form): array
    {
        $attachments = $gensen_form->attachmentsConvertedRekapanPengirimanUang;

        // logger(['attachments', $attachments]);

        $blobs = collect($attachments)->map(function ($file) {

            $storage = Storage::disk($file['disk']);

            if (!$storage->exists($file['path'])) {
                logger("File missing: {$file['path']}");
            }

            // $stream = $storage->path($file['path']);

            // if ($stream === false) {
            //     logger("Cannot read file stream");
            // }

            $stream = $storage->readStream($file['path']);

            logger(['data attachment to blob', $file['path']]);
            if (!is_resource($stream)) {
                logger("Unable to open stream: {$file['path']}");
            }

            $data = stream_get_contents($stream);

            fclose($stream);
            // $data = file_get_contents($stream);
            // logger(['data stream', $stream]);

            return new Blob(
                mimeType: $this->getMimeType($file['extension']),
                data: base64_encode($data)
            );
        })->toArray();


        // High-precision configuration for tax data
        $responseSchema = new Schema(
            type: DataType::OBJECT,
            properties: [
                'groups' => new Schema(
                    type: DataType::ARRAY,
                    items: new Schema(
                        type: DataType::OBJECT,
                        description: "Group the data by BOTH name of the recipient AND transaction year. Do not create multiple entries for the same name/year pair.",
                        properties: [
                            'receiver_name' => new Schema(
                                type: DataType::STRING,
                                description: "The full name of the recipient (normalized to Romaji if possible)."
                            ),
                            'transaction_year' => new Schema(
                                type: DataType::INTEGER,
                                description: "The Gregorian year (YYYY). Convert Reiwa/Heisei if necessary."
                            ),
                            'amount_details' => new Schema(
                                type: DataType::ARRAY,
                                description: "AUDIT TRAIL: A list of every individual transaction amount found for this person in the year before aggregation.",
                                items: new Schema(
                                    type: DataType::NUMBER,
                                    description: "The raw numeric value of a single valid transfer entry on Yen/JPY."
                                )
                            ),
                            'total_amount' => new Schema(
                                type: DataType::NUMBER,
                                description: "The mathematical SUM of all values listed in 'amount_details'."
                            ),
                            'currency' => new Schema(
                                type: DataType::STRING,
                                description: "Standardized currency code, e.g., 'JPY'."
                            ),
                            'transfer_transaction_count' => new Schema(
                                type: DataType::INTEGER,
                                description: "The count of items in the 'amount_details' array."
                            ),
                        ],
                        required: [
                            'receiver_name',
                            'transaction_year',
                            'amount_details',
                            'total_amount',
                            'currency',
                            'transfer_transaction_count'
                        ]
                    )
                ),
                'confidence_score' => new Schema(
                    type: DataType::INTEGER,
                    description: "Extraction confidence (0-100) based on document clarity."
                ),
                'confidence_note' => new Schema(
                    type: DataType::STRING,
                    description: "IF confidence_score < 85 should explain the reason, ELSE null."
                )
            ],
            required: ['groups', 'confidence_score',]
        );
        $systemInstruction = "You are a strict Financial Auditor and Remittance Extraction Engine." .

            "GOAL: Extract, aggregate, and group valid JPY remittance transfers." .

            "OUTPUT: Return strict JSON only. No preamble.";
        $result = Gemini::generativeModel(model: config('gemini.model'))
            ->withSystemInstruction(Content::parse($systemInstruction))
            ->withGenerationConfig(
                generationConfig: new GenerationConfig(
                    responseMimeType: ResponseMimeType::APPLICATION_JSON,
                    responseSchema: $responseSchema,

                    // Critical for legal/tax accuracy:
                    temperature: 0.0,
                    mediaResolution: MediaResolution::MEDIA_RESOLUTION_HIGH,

                    // Advanced Reasoning:
                    thinkingConfig: new ThinkingConfig(
                        includeThoughts: true,
                        thinkingLevel: ThinkingLevel::HIGH,
                    )
                )
            )
            ->generateContent([
                $this->getTaxPrompt(),
                ...$blobs
            ]);

        // logger(['result', $result]);

        $response = [];
        $thoughts = null;
        foreach ($result->parts() as $part) {
            if ($part->thought === true) {
                // This part contains the model's thinking process
                $thoughts = json_encode($part->text, true);
            } else if ($part->text !== null) {
                // This is the final answer
                $response['json'] = json_decode($part->text, true);
            }
        }
        $response['request_payload'] = json_encode([
            'system_instruction' => $systemInstruction,
            'prompt' => $this->getTaxPrompt(),
            'attachments_count' => count($blobs),
            'config' => [
                'temperature' => 0.0,
                'thinking_level' => 'HIGH',
                'resolution' => 'HIGH'
            ]
        ], true);
        logger(['score', $response['json']['confidence_score']]);
        $response['confidence_score'] = $response['json']['confidence_score'];
        $response['confidence_note'] = isset($response['json']['confidence_note']) ? $response['json']['confidence_note'] : null;

        $metadata = $result->usageMetadata;

        $response['response_payload'] = json_encode([
            'data' => $response['json'],
            'thinking_process' => $thoughts, // Crucial for debugging why an extraction failed
            'usage' => [
                'prompt_tokens' => $metadata->promptTokenCount,
                'candidates_tokens' => $metadata->candidatesTokenCount,
                'total_tokens' => $metadata->totalTokenCount,
            ]
        ], true);

        $response['input_tokens']    = $metadata->promptTokenCount;
        $response['output_tokens']   = $metadata->candidatesTokenCount;
        $response['cached_tokens']   = $metadata->cachedContentTokenCount ?? 0;
        $response['thinking_tokens'] = $metadata->thoughtsTokenCount ?? 0;
        $response['total_tokens']    = $metadata->totalTokenCount;

        $input_price = env('GEMINI_INPUT_PRICE', 0.25); // per 1M tokens
        $output_price = env('GEMINI_OUTPUT_PRICE', 1.50); // per 1M tokens

        // 1. Calculate costs by dividing by 1,000,000
        $response['input_cost']    = ($response['input_tokens'] / 1000000) * $input_price;

        // 2. Note: 'output_tokens' usually includes the 'thinking_tokens' 
        // if you are using candidatesTokenCount + thoughtsTokenCount
        $response['output_cost']   = ($response['output_tokens'] / 1000000) * $output_price;

        $response['thinking_cost'] = ($response['thinking_tokens'] / 1000000) * $output_price;

        // 3. Total Cost is just the sum of input and output costs
        // (Do NOT add the token counts to the currency amount)
        $response['total_cost']    = $response['input_cost'] + $response['output_cost'];
        logger([
            'RESPONSE FINAL',
            $response
        ]);
        return $response ?? [];
    }

    private function getTaxPrompt(): string
    {
        return 'You are a financial remittance extraction and aggregation engine specialized in
            Japanese remittance documents.

            You will receive MULTIPLE remittance documents in a SINGLE request.

            OBJECTIVE: Extract and aggregate valid remittance transfer amounts accurately
            across all provided documents.

            ━━━━━━━━━━ EXTRACTION RULES ━━━━━━━━━━

            1.  Extract ONLY actual transferred money yen amounts

            2.  EXCLUDE:

                - transfer fees
                - taxes
                - service charges
                - exchange fees
                - handling fees
                - subtotal rows
                - duplicated summary values

            3.  Treat ALL uploaded documents as ONE dataset

            4.  DO NOT duplicate transactions across pages or repeated receipts

            5.  Merge identical transactions carefully

            ━━━━━━━━━━ GROUPING RULES ━━━━━━━━━━

            Group results by:

            - receiver_name
            - transaction_year

            transaction_year:

            - Extract ONLY the year from transaction date
            - Must be integer format
            - Example: 2024 2025

            ━━━━━━━━━━ AMOUNT NORMALIZATION RULES ━━━━━━━━━━

            CRITICAL: Preserve decimal values correctly.

            Examples:

            - "120,000 JPY" → 120000

            Rules:

            1.  Remove currency symbols and text

            2.  Remove thousand separators

            3.  Preserve decimal digits exactly

            4.  NEVER multiply decimal values incorrectly

            5.  NEVER convert: 8887844.00 into 888784400

            6.  total_amount MUST be numeric

            7.  Use decimal number format when decimals exist

            8.  Do not round values unless document explicitly rounds them

            9.  Put only Yen/JPY Amount

            ━━━━━━━━━━ OUTPUT FORMAT ━━━━━━━━━━

            Return STRICT VALID JSON ONLY.

            { "groups": [ { "receiver_name": "string", "transaction_year": 2025,
            "total_amount": 98920, "currency": "YEN", "transfer_transaction_count": 3 } ],
            "confidence_score": 98 }

            ━━━━━━━━━━ OUTPUT RULES ━━━━━━━━━━

            1.  confidence_score:

                - integer
                - range 0-100

            2.  currency:

                - put only yen amount

            3.  If value is uncertain:

                - choose safest conservative interpretation
                - NEVER overcount

            4.  Do NOT hallucinate missing values

            5.  Return JSON ONLY

            6.  No markdown

            7.  No explanations

            8.  No additional text
';
    }

    private function getMimeType(string $ext): MimeType
    {
        return match ($ext) {
            'pdf' => MimeType::APPLICATION_PDF,
            'png' => MimeType::IMAGE_PNG,
            default => MimeType::IMAGE_JPEG,
        };
    }
}
