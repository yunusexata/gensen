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


class IchijikinExtractionService
{
    //· IDR4,310,625.10 Billing Account Tier Cap
    /**
     * Process multiple files for tax data extraction.
     */
    public function extract(GensenForm $gensen_form): array
    {
        $attachments = $gensen_form->attachmentsConvertedRekapanPengirimanUang;

        logger(['attachments', $attachments]);

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
        $systemInstruction = "You are an automated OCR and data extraction system specializing in Japanese National Pension 'Lump-sum Withdrawal Payments' (Ichijikin) notices. Your strict requirement is to extract data from the provided image and return it EXCLUSIVELY as a valid, raw JSON object. Do not include markdown formatting (like ```json), do not include greetings, and do not provide explanations. If a value cannot be found, use null.";
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

        logger(['result', $result]);

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
                'temperature' => 0.3,
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
        return $response ?? [];
    }

    private function getTaxPrompt(): string
    {
  return 
  "instruction": "Extract the following fields from the provided Ichijikin document image. Format dates as YYYY-MM-DD. Remove commas from currency amounts and return them as integers.",
  "expected_schema": {
    "date_of_entitlement": "Look for 'Date of entitlement' or '支給決定年月日' (e.g., 2025-10-15)",
    "gross_payment_amount": "Look for 'Payments amount' or '支給額' under the Employees' Pension Insurance system section (Integer)",
    "income_tax_deducted": "Look for 'Income Tax' or '所得税' (Integer)",
    "net_payment_amount": "Look for 'Net payment amount' or '支払額' (Integer)",
    "basic_pension_number": "Look for 'Your Basic Pension Number' or '基礎年金番号' (String)",
    "recipient_name": "Look for the name printed above the address block at the bottom (String)",
    "recipient_address": "Look for the full address block at the bottom right (String)";
  
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
