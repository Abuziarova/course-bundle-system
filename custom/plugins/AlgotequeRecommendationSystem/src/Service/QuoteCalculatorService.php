<?php declare(strict_types=1);

namespace AlgotequeRecommendationSystem\Service;

use AlgotequeRecommendationSystem\DTO\ProviderDTO;
use AlgotequeRecommendationSystem\DTO\TopicsRequestDTO;
use AlgotequeRecommendationSystem\Service\CalculationStrategy\SingleMatchingCalculationStrategy;
use AlgotequeRecommendationSystem\Service\CalculationStrategy\DoubleMatchingCalculationStrategy;
use AlgotequeRecommendationSystem\Service\ProviderConfigService;

class QuoteCalculatorService
{
    public function __construct(
        private readonly ProviderConfigService $providerConfigService
    ) {}

    public function calculateQuotes(array $data): array
    {
        $topicsRequest = TopicsRequestDTO::fromRequestArray($data);
        $topThreeTopics = $topicsRequest->getTopThreeTopics();

        $providers = $this->providerConfigService->getProviderDTOS();
        $quotes = [];
        foreach ($providers as $provider) {
            $quote = $this->calculateProviderQuote($provider, $topThreeTopics);
            if ($quote > 0) {
                $quotes[$provider->getName()] = $quote;
            }
        }

        return $quotes;
    }

    private function calculateProviderQuote(ProviderDTO $provider, array $topThreeTopics): float
    {
        $matchingTopics = array_intersect(array_keys($topThreeTopics), $provider->getTopics());
        $quoteCalculationStrategy  = match(count($matchingTopics)) {
            1 => new SingleMatchingCalculationStrategy(),
            2 => new DoubleMatchingCalculationStrategy(),
            default => null
        };

        if($quoteCalculationStrategy) {
            return $quoteCalculationStrategy->calculate($matchingTopics, $topThreeTopics);
        }

        return 0;
    }
}