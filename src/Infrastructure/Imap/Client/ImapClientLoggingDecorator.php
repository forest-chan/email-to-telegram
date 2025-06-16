<?php

declare(strict_types=1);

namespace App\Infrastructure\Imap\Client;

use App\Infrastructure\Imap\DTO\GetMailIdsRequestDTO;
use App\Infrastructure\Imap\DTO\MailDTO;
use App\Infrastructure\Imap\Exception\ImapException;
use Psr\Log\LoggerInterface;

class ImapClientLoggingDecorator implements ImapClientInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private ImapClientInterface $innerClient
    ) {
    }

    /**
     * @throws ImapException
     */
    public function getMailIds(GetMailIdsRequestDTO $getMailIdsRequestDTO): array
    {
        $this->logger->info(
            message: 'Get imap mail ids',
            context: [
                'method' => __METHOD__,
                'parameters' => $getMailIdsRequestDTO->toArray(),
            ]
        );

        try {
            $mailIds = $this->innerClient->getMailIds($getMailIdsRequestDTO);
        } catch(ImapException $exception) {
            $this->logger->error(
                message: 'Get imap mail ids failed',
                context: [
                    'method' => __METHOD__,
                    'exception' => (string) $exception,
                    'exceptionMessage' => $exception->getMessage(),
                ]
            );

            throw $exception;
        }

        return $mailIds;
    }

    /**
     * @throws ImapException
     */
    public function getMail(int $mailId): MailDTO
    {
        $this->logger->info(
            message: 'Get imap mail',
            context: [
                'method' => __METHOD__,
                'parameters' => [
                    'mail_id' => $mailId,
                ],
            ]
        );

        try {
            $mailDTO = $this->innerClient->getMail($mailId);
        } catch(ImapException $exception) {
            $this->logger->error(
                message: 'Get imap mail failed',
                context: [
                    'method' => __METHOD__,
                    'exception' => (string) $exception,
                    'exceptionMessage' => $exception->getMessage(),
                ]
            );

            throw $exception;
        }

        return $mailDTO;
    }
}
