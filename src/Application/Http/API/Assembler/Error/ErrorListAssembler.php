<?php

declare(strict_types=1);

namespace App\Application\Http\API\Assembler\Error;

use App\Application\Http\API\DTO\Error\ErrorListItemResponseDTO;
use App\Application\Http\API\DTO\Error\ErrorListResponseDTO;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorListAssembler
{
    public function assembleFromViolationList(ConstraintViolationListInterface $violations): ErrorListResponseDTO
    {
        return $this->assemble(
            errorMessages: array_map(
                callback: static fn (ConstraintViolationInterface $violation): string
                    => sprintf('Property at path: %s. Has error message: %s', $violation->getPropertyPath(), mb_lcfirst($violation->getMessage())),
                array: iterator_to_array($violations)
            )
        );
    }

    /**
     * @param array $errorMessages<string>
     */
    public function assembleFromErrorMessages(array $errorMessages): ErrorListResponseDTO
    {
        return $this->assemble($errorMessages);
    }

    /**
     * @param array $errorMessages<string>
     */
    private function assemble(array $errorMessages): ErrorListResponseDTO
    {
        $errorList = new ErrorListResponseDTO();

        foreach ($errorMessages as $errorMessage) {
            $errorList->addErrorListItem(
                errorListItemResponseDTO: new ErrorListItemResponseDTO($errorMessage)
            );
        }

        return $errorList;
    }
}
