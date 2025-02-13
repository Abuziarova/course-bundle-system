<?php declare(strict_types=1);

namespace AlgotequeRecommendationSystem\Service\CalculationStrategy;

interface QuoteCalculationStrategyInterface
{
    public function calculate(array $matchingTopics, array $top3Topics): float;
}
