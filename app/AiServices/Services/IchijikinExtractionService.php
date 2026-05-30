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
                    type: DataType::INTEGER,
                    description: 'Remove all spaces. Example: 4161 325041 -> 4161325041'
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
            required: [
                'kokumin',
                'nama_lengkap',
                'nenkin_100',
                'nenkin_20',
                'nenkin_80',
                'no_nenkin',
                'confidence_score'
            ]
        );

        // 2. Set up the Generation Config
        $generationConfig = new GenerationConfig(
            responseMimeType: ResponseMimeType::APPLICATION_JSON,
            responseSchema: $schema,
            temperature: 0.0 // Set to 0 for maximum factual extraction
        );

        // 3. Define the System Instruction / Primary Prompt
        $promptParts = [
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

        // 4. Interleave Field Names and Image Blobs into the payload
        $files = [
            'kokumin' => 'kokumin.png',
            'nenkin_100' => 'nenkin_100.png',
            'nenkin_20' => 'nenkin_20.png',
            'nenkin_80' => 'nenkin_80.png',
            'no_nenkin' => 'no_nenkin.png',
            'nama_lengkap' => 'nama_lengkap.png'
        ];
        foreach ($files as $key => $fileName) {
            $filePath = storage_path("app/public/ichijikin/{$ichijikin->ichijikinExtraction->batch_name}_ID_{$ichijikin->ichijikinExtraction->id}/crop/$ichijikin->file_stored_name/{$fileName}");

            if (file_exists($filePath)) {
                // Tell Gemini which field this image belongs to
                $promptParts[] = "Field Name: " . $key;

                // Provide the image
                $promptParts[] = new Blob(
                    mimeType: MimeType::IMAGE_PNG,
                    data: base64_encode(file_get_contents($filePath))
                );
            }
        }

        logger([
            'ICHIJIKIN AI PROMPT PART',
            $promptParts
        ]);

        // 5. Send the SINGLE request to Gemini
        $result = Gemini::generativeModel('gemini-1.5-flash')
            ->withGenerationConfig($generationConfig)
            ->generateContent($promptParts);

        logger(['result', $result]);

        // 6. Decode and return the result
        // Gemini will return a perfectly formatted JSON string because of our Schema
        $extractedData = json_decode($result->text(), true);

        return response()->json($extractedData);
    }
}
