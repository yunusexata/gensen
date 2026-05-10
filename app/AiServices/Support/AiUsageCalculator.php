<?php

namespace App\AiServices\Support;

class AiUsageCalculator
{
    public function calculate(
        string $model,
        int $inputTokens,
        int $outputTokens,
        int $cachedTokens = 0,
    ): array {

        $pricing = AiModelRegistry::get($model);

        $inputCost =
            ($inputTokens / 1_000_000)
            * $pricing['input_cost_per_million'];

        $outputCost =
            ($outputTokens / 1_000_000)
            * $pricing['output_cost_per_million'];

        return [
            'input_cost' => round($inputCost, 6),
            'output_cost' => round($outputCost, 6),
            'total_cost' => round(
                $inputCost + $outputCost,
                6
            ),
        ];
    }
}
