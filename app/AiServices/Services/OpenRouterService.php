<?php

namespace App\AiServices\Services;

use App\AiServices\Support\AiUsageCalculator;
use App\Enums\Gensen\GensenAttachmentType;
use App\Facades\AI;
use App\Models\GensenForm\GensenForm;
use Illuminate\Support\Facades\Storage;

class OpenRouterService
{
    public function extractRemittance(
        GensenForm $gensen_form
    ): array {
        $gensen_form = $gensen_form->with([
            'attachments' => function ($q) {
                return $q->where('type', GensenAttachmentType::REKAP_PENGIRIMAN_UANG);
            }
        ])->first();
        $documents = $gensen_form->attachments;


        $content = [];
        foreach ($documents as $document) {

            $path = Storage::disk('private')
                ->path($document['path']);

            $mime = mime_content_type($path);

            $content[] = [

                'type' => 'image_url',

                'image_url' => [

                    'url' => sprintf(
                        'data:%s;base64,%s',
                        $mime,
                        base64_encode(
                            file_get_contents($path)
                        )
                    ),
                ],
            ];
        }
        $path = Storage::disk('private')
            ->path($document->path);

        $client = AI::connection('openrouter')
            ->client();

        $prompt = <<<PROMPT
You are a highly accurate remittance document extraction assistant.

Analyze the uploaded document carefully.

Rules:
- Output STRICT valid JSON only.
- Never explain.
- Never add commentary.
- Never guess missing information.
- If uncertain, return null values.
- Classification must be mutually exclusive.
- group as year and receiver_name

Extract the data and return ONLY a valid JSON object matching this exact structure,
Do not include markdown tags like ```json. Return only the raw JSON:
[
  {
    "document_type": "remittance",
    "confidence_document_type": 0-100,
    "data": [
      {
        "receiver_name": "",
        "total_transfer": amount remittance total without fee and tax(double),
        "transfer_year": "year",
        "confidence_total_and_year": 0-100
      },
      {
        "receiver_name": "",
        "total_transfer": amount remittance total without fee and tax(double),
        "transfer_year": "year",
        "confidence_total_and_year": 0-100
      },
      {
        "receiver_name": "",
        "total_transfer": amount remittance total without fee and tax(double),
        "transfer_year": "year",
        "confidence_total_and_year": 0-100
      },
      {
        "receiver_name": "",
        "total_transfer": amount remittance total without fee and tax(double),
        "transfer_year": "year",
        "confidence_total_and_year": 0-100
      }
    ]
  }
]

PROMPT;

        $started = microtime(true);

        $response = $client->chat()->create([

            'model' => config(
                'custom_ai.providers.openrouter.models.free_extract'
            ),

            'messages' => [

                [
                    'role' => 'user',

                    'content' => array_merge(

                        [
                            [
                                'type' => 'text',
                                'text' => $prompt,
                            ],
                        ],

                        $content // <-- images array goes here
                    ),
                ],
            ],

            'response_format' => [
                'type' => 'json_object',
            ],
        ]);

        $latency =
            round(
                (microtime(true) - $started) * 1000
            );
        logger([
            'RESULT AI',
            $response
        ]);
        $content =
            $response->choices[0]
            ->message
            ->content ?? '{}';

        $json = json_decode(
            $content,
            true
        );

        $inputTokens =
            $response->usage->promptTokens ?? 0;

        $outputTokens =
            $response->usage->completionTokens ?? 0;

        $calculator = app(
            AiUsageCalculator::class
        );

        $cost = $calculator->calculate(
            model: 'openrouter/free',
            inputTokens: $inputTokens,
            outputTokens: $outputTokens,
        );

        return [

            'json' => $json,

            'confidence_score' => match (true) {

                ($json['document_type'] ?? null)
                    === 'unknown'
                => 40,

                empty($json['transfer_amount'])
                => 55,

                empty($json['sender_name'])
                => 65,

                default
                => 85,
            },

            'confidence_notes' => collect([

                empty($json['sender_name'])
                    ? 'Sender name not clearly detected'
                    : null,

                empty($json['transfer_amount'])
                    ? 'Transfer amount missing'
                    : null,

                ($json['document_type'] ?? null)
                    === 'unknown'
                    ? 'Document does not appear to be remittance'
                    : null,

            ])->filter()->values(),

            'usage' => [

                'input_tokens' => $inputTokens,

                'output_tokens' => $outputTokens,

                'cached_tokens' => 0,

                'input_cost' =>
                $cost['input_cost'],

                'output_cost' =>
                $cost['output_cost'],

                'total_cost' =>
                $cost['total_cost'],

                'latency_ms' => $latency,
            ],

            'raw_response' => $response,
        ];
    }
}
