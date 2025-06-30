<?php

declare(strict_types=1);

namespace App\Domain\Repository\MailTelegram;

use App\Domain\Entity\MailTelegram\MailTelegram;

interface MailTelegramRepositoryInterface
{
    /** @return array<MailTelegram> */
    public function findAll(): array;

    public function findById(int $id): ?MailTelegram;

    public function save(MailTelegram $mailTelegram): MailTelegram;
}
