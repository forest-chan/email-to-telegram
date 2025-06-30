<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\MailTelegram;

use App\Domain\Entity\MailTelegram\MailTelegram;
use App\Domain\Repository\MailTelegram\MailTelegramRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method array<MailTelegram> findAll()
 */
class MailTelegramRepository extends EntityRepository implements MailTelegramRepositoryInterface
{
    public function findById(int $id): ?MailTelegram
    {
        return $this->find($id);
    }

    public function save(MailTelegram $mailTelegram): MailTelegram
    {
        $this->getEntityManager()->persist($mailTelegram);
        $this->getEntityManager()->flush();

        return $mailTelegram;
    }

    protected function getEntityName(): string
    {
        return MailTelegram::class;
    }
}
