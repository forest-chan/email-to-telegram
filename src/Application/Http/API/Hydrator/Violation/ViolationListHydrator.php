<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\Violation;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationListHydrator
{
    public function __construct(private ViolationItemHydrator $itemHydrator)
    {
    }

    public function extract(ConstraintViolationListInterface $violations): array
    {
        $extractedItems = [];

        foreach ($violations as $violation) {
            $extractedItems[] = $this->itemHydrator->extract($violation);
        }

        return [
            'errors' => $extractedItems,
        ];
    }
}
