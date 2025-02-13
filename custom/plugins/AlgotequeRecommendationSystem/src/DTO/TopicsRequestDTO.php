<?php declare(strict_types=1);

namespace AlgotequeRecommendationSystem\DTO;

class TopicsRequestDTO
{
    private array $topics;

    public function __construct(array $topics)
    {
        $this->topics = $topics;
    }

    public static function fromRequestArray(array $data): self
    {
        return new self($data['topics']);
    }

    public function getTopThreeTopics(): array
    {
        arsort($this->topics);
        
        return array_slice($this->topics, 0, 3, true);
    }
}