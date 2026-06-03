<?php

namespace App\AiServices\Services;

use App\Models\Ichijikin\IchijikinExtraction;
use App\Models\Ichijikin\IchijikinExtractionFile;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Data\GenerationConfig;
use Gemini\Enums\ResponseMimeType;
use Gemini\Data\Schema;
use Gemini\Enums\DataType;
use Gemini\Data\Content;
use Gemini\Enums\MediaResolution;
use Gemini\Enums\ThinkingLevel;
use Gemini\Data\ThinkingConfig;

class IchijikinExtractionService
{
    public function extract(IchijikinExtractionFile $ichijikin)
    {


        // 1. Define the Strict JSON Schema
        // This forces Gemini to return the exact keys and data types you requested.
        $schema = new Schema(
            type: DataType::OBJECT,
            properties: [
                'kokumin' => new Schema(type: DataType::INTEGER, description: 'Return 0 if the image is blank/empty.', nullable: true),
                'nama_lengkap' => new Schema(
                    type: DataType::STRING,
                    description: 'Extract the full name exactly as shown.'
                ),
                'nenkin_20' => new Schema(
                    type: DataType::INTEGER,
                    description: 'Remove commas and currency symbols (円). Example: 20,547円 -> 20547'
                ),
                'nenkin_80' => new Schema(
                    type: DataType::INTEGER,
                    description: 'Remove commas and currency symbols (円). Example: 20,547円 -> 20547'
                ),
                'nenkin_100' => new Schema(
                    type: DataType::INTEGER,
                    description: 'Remove commas and currency symbols (円). Example: 20,547円 -> 20547'
                ),
                'no_nenkin' => new Schema(
                    type: DataType::STRING,
                    description: 'Remove all spaces but PRESERVE any leading zeros. Return as a single continuous string. Example: "0160 618880" -> "0160618880"'
                ),
                'lama_kerja' => new Schema(
                    type: DataType::INTEGER,
                    description: 'Remove all spaces. Example: 48'
                ),
                'confidence_score' => new Schema(
                    type: DataType::INTEGER,
                    description: "MUST be 0 if ALL or MOST image crops are blank, empty, or contain no data values. Otherwise, provide a score from 1 to 100 based on text readability."
                ),
                'confidence_note' => new Schema(
                    type: DataType::STRING,
                    description: "IF confidence_score < 85, explain the exact reason (e.g., 'All crops are blank, layout might be rotated or incorrect'). ELSE, return null.",
                    nullable: true
                )
            ],
            required: [
                'kokumin',
                'nama_lengkap',
                'nenkin_100',
                'nenkin_20',
                'nenkin_80',
                'no_nenkin',
                'lama_kerja',
                'confidence_score'
            ]
        );

        // 3. Define the System Instruction / Primary Prompt
        $promptParts = $this->getPrompt();

        // 4. Interleave Field Names and Image Blobs into the payload
        $files = [
            'kokumin' => 'kokumin.png',
            'nenkin_100' => 'nenkin_100.png',
            'nenkin_20' => 'nenkin_20.png',
            'nenkin_80' => 'nenkin_80.png',
            'no_nenkin' => 'no_nenkin.png',
            'lama_kerja' => 'lama_kerja.png',
            'nama_lengkap' => 'nama_lengkap.png'
        ];
        foreach ($files as $key => $fileName) {
            $filePath = storage_path("app/public/ichijikin/{$ichijikin->ichijikinExtraction->batch_name}/crop/$ichijikin->file_stored_name/{$fileName}");

            // logger([
            //     'param att path',
            //     $filePath
            // ]);
            if (file_exists($filePath)) {
                // Tell Gemini which field this image belongs to
                $promptParts[] = "Field Name: " . $key;

                // Provide the image
                $promptParts[] = new Blob(
                    mimeType: MimeType::IMAGE_PNG,
                    // data: filesize($filePath)
                    data: base64_encode(file_get_contents($filePath))
                );
            }
        }
        // logger([
        //     'FILE ATTACHMENTS',
        //     $promptParts
        // ]);

        // logger([
        //     'ICHIJIKIN AI PROMPT PART',
        //     $promptParts
        // ]);

        $systemInstruction = "You are a precise data extraction AI. Analyze the provided Ichijikin document and extract the key fields accurately. Return the data ONLY as a valid JSON object matching the requested fields. If a field is missing, return null.";

        logger([
            'GEMINI API KEY',
            config('gemini.api_key')
        ]);
        return;
        // 5. Send the SINGLE request to Gemini
        $result = Gemini::generativeModel(model: config('gemini.model'))
            ->withSystemInstruction(Content::parse($systemInstruction))
            ->withGenerationConfig(
                generationConfig: new GenerationConfig(
                    responseMimeType: ResponseMimeType::APPLICATION_JSON,
                    responseSchema: $schema,

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
            ->generateContent($promptParts);

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
            'prompt' => $this->getPrompt(),
            'attachments_count' => count($files),
            'config' => [
                'temperature' => 0.0,
                'thinking_level' => new ThinkingConfig(
                    includeThoughts: true,
                    thinkingLevel: ThinkingLevel::HIGH,
                )
            ]
        ], true);
        // logger(['score', $response['json']['confidence_score']]);
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
        // logger([
        //     'RESPONSE FINAL',
        //     $response
        // ]);
        return $response ?? [];
    }

    private function getPrompt()
    {
        return [
            "You are an expert OCR and data extraction system. I am providing you with multiple cropped images from a document. Each image is preceded by its field name.
            You will receive MULTIPLE image in a SINGLE request.
            
            GOAL: Extract valid data in images.
            OBJECTIVE: Extract and aggregate valid value accurately
            across all documents.
            OUTPUT: Return strict JSON only. No preamble.
        
        RULES:
        1. Extract the text from each image and map it to the corresponding field name.
        2. For the 'nama_lengkap' field, extract the exact text.
        3. For all 'nenkin_100', 'nenkin_80', 'nenkin_20', 'kokumin', and 'no_nenkin' fields, you MUST return ONLY an integer.
        4. Strip out all currency symbols (like 円), commas (,), and spaces ( ). For example, '100,625円' becomes 100625. '4161 325041' becomes 4161325041.
        5. If an image is completely blank or empty (like 'kokumin'), return 0 or null.
        6.If value is uncertain:
                - choose safest conservative interpretation
                - NEVER overcount
        "
        ];
    }
}
