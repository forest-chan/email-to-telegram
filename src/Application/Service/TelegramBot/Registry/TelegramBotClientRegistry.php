<?php

declare(strict_types=1);

namespace App\Application\Service\TelegramBot\Registry;

use App\Application\Service\TelegramBot\Assembler\TelegramBotDTOAssembler;
use App\Application\Service\TelegramBot\Enum\TelegramBot;
use App\Infrastructure\TelegramBot\Client\TelegramBotClientInterface;
use App\Infrastructure\TelegramBot\Factory\TelegramBotClientFactoryInterface;
use RuntimeException;

class TelegramBotClientRegistry
{
    /** @var array<TelegramBotClientInterface> $telegramBotClients */
    private array $telegramBotClients = [];

    public function __construct(
        private array $telegramBotConfig,
        private TelegramBotDTOAssembler $telegramBotDTOAssembler,
        private TelegramBotClientFactoryInterface $telegramBotClientFactory,
    ) {
    }

    public function getTelegramBotClient(TelegramBot $telegramBot): TelegramBotClientInterface
    {
        $telegramBotName = $telegramBot->value;

        if (!array_key_exists($telegramBotName, $this->telegramBotConfig)) {
            throw new RuntimeException("Got unregistered telegram bot: $telegramBotName");
        }

        $telegramBotClient = $this->telegramBotClients[$telegramBotName] ?? null;

        if (!$telegramBotClient instanceof TelegramBotClientInterface) {
            $telegramBotDTO = $this->telegramBotDTOAssembler->assembleFromConfig($this->telegramBotConfig[$telegramBotName]);

            $this->telegramBotClients[$telegramBotName] = $this->telegramBotClientFactory->create($telegramBotDTO);
        }

        return $this->telegramBotClients[$telegramBotName];
    }
}
