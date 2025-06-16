<?php

declare(strict_types=1);

namespace App\Domain\Entity\MailTelegramUser;

use App\Domain\Entity\AbstractEntity;
use App\Domain\Entity\User\User;
use App\Domain\Enum\EncodingType;
use App\Domain\Enum\MailDirectory;
use App\Domain\Repository\MailTelegramUser\MailTelegramUserRepository;
use App\Domain\Repository\MailTelegramUser\MailTelegramUserRepositoryInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailTelegramUserRepository::class)]
#[ORM\Table(name: 'mail_telegram_user')]
class MailTelegramUser extends AbstractEntity
{
    #[ORM\Column(name: 'mail_server_path', type: Types::STRING, length: 255, nullable: false)]
    private string $mailServerPath;

    #[ORM\Column(name: 'mail', type: Types::STRING, length: 255, nullable: false)]
    private string $mail;

    #[ORM\Column(name: 'password', type: Types::STRING, length: 255, nullable: false)]
    private string $password;

    #[ORM\Column(
        name: 'mail_directory',
        type: Types::STRING,
        length: 255,
        nullable: false,
        enumType: MailDirectory::class,
        options: ['default' => MailDirectory::INBOX]
    )]
    private MailDirectory $mailDirectory;

    #[ORM\Column(
        name: 'mail_server_encoding_type',
        type: Types::STRING,
        length: 255,
        nullable: false,
        enumType: EncodingType::class,
        options: ['default' => EncodingType::UTF8]
    )]
    private EncodingType $mailServerEncodingType;

    #[ORM\Column(name: 'telegram_chat_id', type: Types::INTEGER, nullable: false)]
    private int $telegramChatId;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'mailTelegrams')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private User $user;

    public function __construct(
        string $mailServerPath,
        string $mail,
        string $password,
        MailDirectory $mailDirectory,
        EncodingType $mailServerEncodingType,
        int $telegramChatId,
        User $user
    ) {
        $this->mailServerPath = $mailServerPath;
        $this->mail = $mail;
        $this->password = $password;
        $this->mailDirectory = $mailDirectory;
        $this->mailServerEncodingType = $mailServerEncodingType;
        $this->telegramChatId = $telegramChatId;
        $this->user = $user;
    }

    public function getMailServerPath(): string
    {
        return $this->mailServerPath;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getMailDirectory(): MailDirectory
    {
        return $this->mailDirectory;
    }

    public function getMailServerEncodingType(): EncodingType
    {
        return $this->mailServerEncodingType;
    }

    public function getTelegramChatId(): int
    {
        return $this->telegramChatId;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
