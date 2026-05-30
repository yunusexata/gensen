<?php

namespace App\Jobs\IchijikinExtraction;

use App\AiServices\Services\GeminiExtractionService;
use App\AiServices\Services\IchijikinExtractionService;
use App\AiServices\Services\VertexExtractionService;
use App\Enums\Gensen\JobStatus;
use App\Models\Ai\AiJob;
use App\Models\Ai\AiPayload;
use App\Models\Ai\AiResult;
use App\Models\Ai\AiUsage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class ExtractionIchijikinJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;
    public function __construct(
        public AiJob $aiJob
    ) {}
    public function handle(
        IchijikinExtractionService $service
    ): void {
        logger('prosessing');
        $this->aiJob->update([
            'status' => JobStatus::PROCESSING,
            'started_at' => now(),
        ]);

        $started = microtime(true);

        try {
            $result =
                $service->extract(
                    $this->aiJob->subject
                );

            $latency =
                round(
                    (microtime(true) - $started) * 1000
                );

            DB::transaction(function () use (
                $result,
                $latency
            ) {

                AiPayload::create([

                    'ai_job_id' => $this->aiJob->id,

                    'request_payload' =>
                    $result['request_payload'],
                    'response_payload' =>
                    $result['response_payload'],
                ]);

                AiResult::create([

                    'ai_job_id' => $this->aiJob->id,

                    'result_type' =>
                    $this->aiJob->job_type,

                    'result_json' =>
                    json_encode($result['json'], true),

                    'confidence_score' =>
                    $result['confidence_score'],

                    'confidence_note' =>
                    $result['confidence_note'],

                    'requires_human_review' =>
                    $result['confidence_score'] < 85,
                ]);

                AiUsage::create([

                    'ai_job_id' => $this->aiJob->id,

                    'input_tokens' =>
                    $result['input_tokens'],

                    'output_tokens' =>
                    $result['output_tokens'],

                    'thinking_tokens' =>
                    $result['thinking_tokens'],

                    'cached_tokens' =>
                    $result['cached_tokens'],

                    'input_cost' =>
                    $result['input_cost'],

                    'thinking_cost' =>
                    $result['thinking_cost'],

                    'output_cost' =>
                    $result['output_cost'],

                    'total_cost' =>
                    $result['total_cost'],

                    'latency_ms' =>
                    $latency,

                ]);

                $this->aiJob->update([
                    'status' => JobStatus::DONE,
                    'finished_at' => now(),
                ]);
            });
        } catch (\Throwable $e) {

            $this->aiJob->update([
                'status' => JobStatus::FAILED,
                'finished_at' => now(),
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(?Throwable $e): void
    {
        $this->aiJob->update([
            'status' => JobStatus::FAILED,
            'finished_at' => now(),
            'error_message' => $e->getMessage(),
        ]);
    }
}
