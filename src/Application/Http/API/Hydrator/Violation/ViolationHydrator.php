<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\Violation;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationHydrator
{
    public function extract(ConstraintViolationListInterface $violations): array
    {
        $extractedViolations = array_map(
            static fn (ConstraintViolationInterface $violation) => [
                'path' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
                'code' => $violation->getCode(),
            ],
            iterator_to_array($violations)
        );

        return [
            'errors' => $extractedViolations,
        ];
    }
}
