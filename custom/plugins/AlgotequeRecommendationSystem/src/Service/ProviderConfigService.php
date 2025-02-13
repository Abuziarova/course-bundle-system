<?php declare(strict_types=1);

namespace AlgotequeRecommendationSystem\Service;

use AlgotequeRecommendationSystem\DTO\ProviderDTO;

class ProviderConfigService
{
    private const CONFIG_PATH = __DIR__ . '/../Resources/config/providers.json';

    public function getProviderDTOS(): array
    {
        $providerTopicsData = $this->getProviderConfigData()['provider_topics'];

        return array_map(function ($topics, $providerName,) {
            return new ProviderDTO($providerName, $topics);
        }, $providerTopicsData, array_keys($providerTopicsData));
    }

    private function getProviderConfigData(): array
    {
        if (!file_exists(self::CONFIG_PATH)) {
            throw new \RuntimeException('Provider configuration file not found');
        }

        $config = json_decode(file_get_contents(self::CONFIG_PATH), true);

        if (!isset($config['provider_topics'])) {
            throw new \RuntimeException('Invalid provider configuration format');
        }
        return $config;
    }
}