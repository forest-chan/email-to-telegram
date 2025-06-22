<?php

declare(strict_types=1);

namespace App\Application\Http\API\Controller\MailTelegram;

use App\Application\Http\API\Controller\AbstractAPIController;
use App\Application\Http\API\Hydrator\MailTelegram\DeleteMailTelegramHandler;
use App\Domain\Exception\EntityNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteMailTelegramController extends AbstractAPIController
{
    public function __invoke(
        int $id,
        DeleteMailTelegramHandler $handler
    ): JsonResponse {
        try {
            $handler->handle($id);

            return $this->jsonSuccessResponse();
        } catch (EntityNotFoundException $exception) {
            $this->logger->warning('Not found mail telegram to deletion', [
                'method' => __METHOD__,
                'exception' => (string) $exception,
            ]);

            return $this->jsonFailResponse(Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception) {
            $this->logger->error('Unexpected error on delete mail telegram', [
                'method' => __METHOD__,
                'exception' => (string) $exception,
            ]);

            return $this->jsonFailResponse();
        }
    }
}
