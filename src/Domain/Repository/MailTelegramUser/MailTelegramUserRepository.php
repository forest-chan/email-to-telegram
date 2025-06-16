<?php

declare(strict_types=1);

namespace App\Domain\Repository\MailTelegramUser;

use App\Domain\Entity\MailTelegramUser\MailTelegramUser;
use App\Domain\Entity\User\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class MailTelegramUserRepository extends EntityRepository implements MailTelegramUserRepositoryInterface
{
    public function findAllWithUser(): array
    {
        return $this->createQueryBuilder('mtu')
            ->leftJoin(User::class, 'u', Join::WITH, 'mtu.user = u.id')
            ->getQuery()
            ->getResult();
    }

    protected function getEntityName(): string
    {
        return MailTelegramUser::class;
    }
}
