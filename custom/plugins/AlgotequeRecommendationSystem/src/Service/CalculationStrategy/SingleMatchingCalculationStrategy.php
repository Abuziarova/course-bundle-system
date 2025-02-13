<?php declare(strict_types=1);

namespace AlgotequeRecommendationSystem\Service\CalculationStrategy;

class SingleMatchingCalculationStrategy implements QuoteCalculationStrategyInterface
{
    private const HIGHEST_TOPIC_RATE = 0.20;
    private const SECOND_TOPIC_RATE = 0.25;
    private const THIRD_TOPIC_RATE = 0.30;

    public function calculate(array $matchingTopics, array $topThreeTopics): float
    {
        $matchingTopic = reset($matchingTopics);
        $topicRank = array_search($matchingTopic, array_keys($topThreeTopics));
        return match($topicRank) {
            0 => $topThreeTopics[$matchingTopic] * self::HIGHEST_TOPIC_RATE,
            1 => $topThreeTopics[$matchingTopic] * self::SECOND_TOPIC_RATE,
            2 => $topThreeTopics[$matchingTopic] * self::THIRD_TOPIC_RATE,
            default => 0
        };
    }
}
