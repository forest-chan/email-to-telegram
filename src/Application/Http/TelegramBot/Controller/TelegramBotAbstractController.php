<?php

declare(strict_types=1);

namespace App\Application\Http\TelegramBot\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class TelegramBotAbstractController extends SymfonyController
{
    public function __construct(
        protected LoggerInterface $logger,
    ) {
    }

    public function jsonSuccessResponse(int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->json(null, $statusCode);
    }

    public function jsonErrorResponse(int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->json(null, $statusCode);
    }
}
