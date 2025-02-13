<?php declare(strict_types=1);

namespace AlgotequeRecommendationSystem\DTO;

class ProviderDTO
{
    private array $providerTopics;
    public function __construct(
        private readonly string $name,
        string $topics
    ) {
        $this->providerTopics = explode('+', $topics);
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getTopics():array
    {
        return $this->providerTopics;
    }
}