<?php declare(strict_types=1);

namespace AlgotequeRecommendationSystem\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints;

class TopicRequestDataValidator
{
    private array $topicRequestConstraints;

    public function __construct(
        private readonly ValidatorInterface $validator
    ) {
        $this->setConstraints();
    }

    private function setConstraints(): void
    {
        $this->topicRequestConstraints = [
            new Constraints\Type('array'),
            new Constraints\NotBlank(),
            new Constraints\Collection([
                'fields' => [
                    'topics' => [
                        new Constraints\NotNull([
                            'message' => 'The topics field is required'
                        ]),
                        new Constraints\Type('array'),
                        new Constraints\Count([
                            'min' => 1,
                            'minMessage' => 'At least one topic must be provided'
                        ]),
                        // Validate the structure of topics array
                        new Constraints\All([
                            'constraints' => [
                                new Constraints\Type([
                                    'type' => 'numeric',
                                    'message' => 'Topic value must be a number'
                                ]),
                                new Constraints\GreaterThanOrEqual([
                                    'value' => 0,
                                    'message' => 'Topic value must be greater than or equal to 0'
                                ]),
                            ],
                        ]),
                    ],
                ],
                'allowExtraFields' => false,
                'extraFieldsMessage' => 'Only topics field is allowed',
            ])
        ];
    }

    public function validateTopicRequest(array $data): array
    {
        $errors = [];
        $violations = $this->validator->validate($data, $this->topicRequestConstraints);
        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $errors[] = $violation->getMessage();
            }
        }

        return $errors;
    }
}