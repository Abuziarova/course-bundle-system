<?php declare(strict_types=1);

namespace AlgotequeRecommendationSystem\Storefront\Controller;

use AlgotequeRecommendationSystem\Service\QuoteCalculatorService;
use AlgotequeRecommendationSystem\Validator\TopicRequestDataValidator;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class BundleQuotesController extends StorefrontController
{
    public function __construct(
        private readonly QuoteCalculatorService    $quoteCalculator,
        private readonly TopicRequestDataValidator $validator,
        private readonly LoggerInterface           $logger
    ) {}

    #[Route(
        path: '/get-bundle-quotes',
        name: 'frontend.bundle.quotes',
        methods: ['POST']
    )]
    public function getBundleQuotes(Request $request): JsonResponse
    {
        try {
            $this->logger->info('Received quote request', ['payload' => $request->getContent()]);
            $requestData = $request->request->all();
            $errors = $this->validator->validateTopicRequest($requestData);  
     
            if (count($errors) > 0) {
             $this->logger->error('Validation errors', ['errors' => $errors]);
             return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
            }
     
            $quotes = $this->quoteCalculator->calculateQuotes($requestData);
            $this->logger->info('Quote calculation successful', ['quotes' => $quotes]);
     
            return new JsonResponse(['quotes' => $quotes ?: 0]);

        } catch (\Exception $e) {
            $this->logger->error('Error processing quote request', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return new JsonResponse([
                'error' => 'An error occurred while processing your request'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
