<?php

declare(strict_types=1);

namespace App\Application\Http\API\Hydrator\MailTelegram;

use App\Domain\Entity\MailTelegram\MailTelegram;
use App\Domain\Exception\EntityNotFoundException;
use App\Domain\Repository\MailTelegram\MailTelegramRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DeleteMailTelegramHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MailTelegramRepositoryInterface $mailTelegramRepository
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function handle(int $mailTelegramId): void
    {
        $mailTelegram = $this->mailTelegramRepository->findById($mailTelegramId);

        if (!$mailTelegram instanceof MailTelegram) {
            throw new EntityNotFoundException("Mail telegram with id $mailTelegramId not found");
        }

        $this->entityManager->remove($mailTelegram);
        $this->entityManager->flush();
    }
}
