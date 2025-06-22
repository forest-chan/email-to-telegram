<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\Violation;

use Symfony\Component\Validator\ConstraintViolationInterface;

class ViolationListItemHydrator
{
    public function extract(ConstraintViolationInterface $violation): array
    {
        return [
            'path' => $violation->getPropertyPath(),
            'message' => $violation->getMessage(),
            'code' => $violation->getCode(),
        ];
    }
}
