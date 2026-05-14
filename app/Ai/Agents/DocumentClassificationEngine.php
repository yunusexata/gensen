<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

// use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\MaxSteps;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Enums\Lab;

#[Provider(Lab::OpenAI)]
#[Model('gpt-4o-mini')]
#[MaxSteps(5)]
// #[MaxTokens(4096)]
#[Temperature(0.0)]
#[Timeout(120)]
class DocumentClassificationEngine implements Agent, HasStructuredOutput, HasTools
{
    use Promptable;

    /** halo
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a document classification engine.
Rules:
- Output STRICT valid JSON only.
- Never explain.
- Never add commentary.
- Never guess missing information.
- If uncertain, return null values.
- Classification must be mutually exclusive.
- Choose the single BEST document_type.';
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }

    /**
     * Get the agent's structured output schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [

            'document_type' => $schema->string()->enum([
                'gensen_form',
                'remittance',
                'kartu_keluarga',
                'unknown',
            ])->required(),

            'confidence' => $schema->integer()->max(0)->max(100)->required(),

            'gensen' => $schema->object(fn($schema) => [
                // 'confidence' => $schema->string()->enum(['low', 'medium', 'high'])->required(),
                // 'language' => $schema->string()->required(),
                'reiwa_year' => $schema->integer(),
                'owner_name' => $schema->string(),
            ])->required(),
            // 'gensen' => $schema->object(fn($schema) => [

            // ]),

            // 'remittance' => $schema->object(fn($schema) => [
            //     'nama_pengirim' => $schema->string()->nullable(),
            //     'provider' => $schema->string()->nullable(),
            // ]),

            // 'kartu_keluarga' => $schema->object(fn($schema) => [
            //     'detected' => $schema->boolean()->nullable(),
            // ]),
        ];
    }
}
