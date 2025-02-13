<?php declare(strict_types=1);

namespace AlgotequeRecommendationSystem\Service\CalculationStrategy;

class DoubleMatchingCalculationStrategy implements QuoteCalculationStrategyInterface
{
    private const DOUBLE_MATCH_RATE = 0.10;
    public function calculate(array $matchingTopics, array $topThreeTopics): float
    {
        $total = 0;
        foreach ($matchingTopics as $topic) {
            $total += $topThreeTopics[$topic];
        }
        return $total * self::DOUBLE_MATCH_RATE;
    }
}
