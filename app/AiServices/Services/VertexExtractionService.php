<?php

namespace App\AiServices\Services;

use App\Models\GensenForm\GensenForm;
use Google\Cloud\AIPlatform\V1\PredictionServiceClient;
use Google\Cloud\AIPlatform\V1\Type\Content;
use Google\Cloud\AIPlatform\V1\Type\Part;
use Google\Protobuf\Struct;
use Illuminate\Support\Facades\Storage;

class VertexExtractionService
{
    /**
     * Menggunakan Vertex AI (Paid/Private Tier) melalui Region Singapore.
     * Memastikan data PII pajak tetap aman dan tidak digunakan untuk training.
     */
    public function extractRemittance(GensenForm $gensen_form): array
    {
        $attachments = $gensen_form->attachmentsConvertedRekapanPengirimanUang;
        $project = env('GOOGLE_CLOUD_PROJECT');
        $location = 'asia-southeast1'; // Singapore untuk latensi rendah & privasi
        $modelId = config('gemini.model');

        // 1. Setup Vertex Client
        $client = new PredictionServiceClient([
            'apiEndpoint' => "{$location}-aiplatform.googleapis.com",
        ]);

        // 2. Prepare Blobs (Data tetap sama)
        $parts = [
            new Part(['text' => $this->getTaxPrompt()])
        ];

        foreach ($attachments as $file) {
            $path = Storage::disk('private')->path($file['path']);
            $parts[] = new Part([
                'inline_data' => [
                    'mime_type' => $this->getMimeType($file['extension']),
                    'data' => base64_encode(file_get_contents($path))
                ]
            ]);
        }

        // 3. Konfigurasi Generasi (Strict & Private)
        // Kita menggunakan PHP Array yang akan dikonversi ke Protobuf Struct oleh SDK
        $generationConfig = [
            'temperature' => 0.0,
            'response_mime_type' => 'application/json',
            'response_schema' => $this->getResponseSchema(),
            'presence_penalty' => 0.0,
            'frequency_penalty' => 0.0,
            // Media Resolution High (set via system instruction atau manual if supported by SDK version)
        ];

        // 4. Thinking Config (Hanya berlaku untuk model 2.0 atau versi tertentu)
        // Jika menggunakan 1.5 Pro, fitur 'thinking' biasanya otomatis terintegrasi 
        // dalam model output jika diinstruksikan.

        $endpoint = $client->endpointName($project, $location, "publishers/google/models/{$modelId}");

        try {
            $systemInstruction = new Content([
                'role' => 'system',
                'parts' => [new Part(['text' => "You are a strict Financial Auditor and Remittance Extraction Engine. GOAL: Extract, aggregate, and group valid JPY remittance transfers. OUTPUT: Return strict JSON only. No preamble."])]
            ]);

            $content = new Content([
                'role' => 'user',
                'parts' => $parts
            ]);

            $response = $client->generateContent([
                'model' => $endpoint,
                'contents' => [$content],
                'system_instruction' => $systemInstruction,
                'generation_config' => $generationConfig,
            ]);

            return $this->formatVertexResponse($response, $parts);
        } catch (\Exception $e) {
            logger()->error("Vertex AI Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Menyamakan format output agar kompatibel dengan kode lama Anda.
     */
    private function formatVertexResponse($result, $parts): array
    {
        $candidate = $result->getCandidates()[0];
        $content = $candidate->getContent();
        $metadata = $result->getUsageMetadata();

        $responseText = "";
        $thoughts = null;

        foreach ($content->getParts() as $part) {
            // Pada Vertex SDK, pengecekan thought mungkin sedikit berbeda tergantung versi
            // Namun secara standar text akan berada di getText()
            $responseText .= $part->getText();
        }

        $jsonOutput = json_decode($responseText, true);

        return [
            'json' => $jsonOutput,
            'confidence_score' => $jsonOutput['confidence_score'] ?? 0,
            'confidence_note' => $jsonOutput['confidence_note'] ?? null,
            'request_payload' => json_encode([
                'project' => env('GOOGLE_CLOUD_PROJECT'),
                'region' => 'asia-southeast1',
                'attachments_count' => count($parts) - 1,
            ]),
            'response_payload' => json_encode([
                'data' => $jsonOutput,
                'usage' => [
                    'prompt_tokens' => $metadata->getPromptTokenCount(),
                    'candidates_tokens' => $metadata->getCandidatesTokenCount(),
                    'total_tokens' => $metadata->getTotalTokenCount(),
                ]
            ]),
            'input_tokens' => $metadata->getPromptTokenCount(),
            'output_tokens' => $metadata->getCandidatesTokenCount(),
            'total_tokens' => $metadata->getTotalTokenCount(),
            // Kalkulasi biaya tetap sama dengan logic Anda
            'total_cost' => ($metadata->getPromptTokenCount() / 1000000 * env('GEMINI_INPUT_PRICE', 0.25)) +
                ($metadata->getCandidatesTokenCount() / 1000000 * env('GEMINI_OUTPUT_PRICE', 1.50))
        ];
    }

    private function getResponseSchema(): array
    {
        // Format schema untuk Vertex AI menggunakan standard OpenAPI object
        return [
            'type' => 'object',
            'properties' => [
                'groups' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'receiver_name' => ['type' => 'string'],
                            'transaction_year' => ['type' => 'integer'],
                            'amount_details' => ['type' => 'array', 'items' => ['type' => 'number']],
                            'total_amount' => ['type' => 'number'],
                            'currency' => ['type' => 'string'],
                            'transfer_transaction_count' => ['type' => 'integer'],
                        ],
                        'required' => ['receiver_name', 'transaction_year', 'total_amount']
                    ]
                ],
                'confidence_score' => ['type' => 'integer'],
                'confidence_note' => ['type' => 'string'],
            ],
            'required' => ['groups', 'confidence_score']
        ];
    }

    private function getTaxPrompt(): string
    {
        // Tetap gunakan prompt yang sudah Anda buat karena sudah sangat bagus/detail
        return "You are a financial remittance extraction... (isi sama dengan prompt lama Anda)";
    }

    private function getMimeType(string $ext): string
    {
        return match ($ext) {
            'pdf' => 'application/pdf',
            'png' => 'image/png',
            default => 'image/jpeg',
        };
    }
}
