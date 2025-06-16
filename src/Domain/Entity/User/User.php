<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use App\Domain\Entity\AbstractEntity;
use App\Domain\Entity\MailTelegramUser\MailTelegramUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User extends AbstractEntity
{
    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false)]
    private string $name;

    #[ORM\OneToMany(
        targetEntity: MailTelegramUser::class,
        mappedBy: 'user',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $mailTelegrams;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
        $this->mailTelegrams = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMailTelegrams(): Collection
    {
        return $this->mailTelegrams;
    }

    public function addMailTelegram(MailTelegramUser $mailTelegram): self
    {
        if (!$this->mailTelegrams->contains($mailTelegram)) {
            $this->mailTelegrams->add($mailTelegram);
        }

        return $this;
    }
}
