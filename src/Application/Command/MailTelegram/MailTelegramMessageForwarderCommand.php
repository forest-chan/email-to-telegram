<?php

declare(strict_types=1);

namespace App\Application\Command\MailTelegram;

use App\Application\Service\MailTelegram\Forwarder\MailTelegramMessageForwarder;
use App\Domain\Entity\MailTelegram\MailTelegram;
use App\Domain\Repository\MailTelegram\MailTelegramRepositoryInterface;
use App\Infrastructure\Imap\Exception\ImapException;
use App\Infrastructure\TelegramBot\Exception\TelegramBotException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:mail-telegram-message-forwarder',
    description: 'Forward messages from mail to telegram',
)]
class MailTelegramMessageForwarderCommand extends Command
{
    private const COMMAND_ERROR_MESSAGE = 'Error on process mail telegram message forwarder command';

    public function __construct(
        private int $retriesCount,
        private LoggerInterface $logger,
        private MailTelegramRepositoryInterface $mailTelegramRepository,
        private MailTelegramMessageForwarder $mailTelegramMessageForwarder
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $processedMailTelegrams = 0;
            $mailTelegrams = $this->mailTelegramRepository->findAll();

            $output->writeln('<info>' . sprintf('Will be processed %s mail telegrams', count($mailTelegrams)) . '</info>');

            foreach ($mailTelegrams as $mailTelegram) {
                $this->processForwardWithRetries($mailTelegram);

                ++$processedMailTelegrams;
            }
        } catch (Exception $exception) {
            $this->logger->error(self::COMMAND_ERROR_MESSAGE, [
                'method' => __METHOD__,
                'exceptionMessage' => $exception->getMessage(),
                'exception' => (string) $exception,
            ]);
            $output->writeln('<error>' . self::COMMAND_ERROR_MESSAGE . ': ' . $exception->getMessage() . '</error>');

            return Command::FAILURE;
        } finally {
            $output->writeln('<info>' . sprintf('Processed %s mail telegrams', $processedMailTelegrams) . '</info>');
        }

        return Command::SUCCESS;
    }

    /**
     * @throws Exception
     */
    private function processForwardWithRetries(MailTelegram $mailTelegram): void
    {
        $currentAttempt = 0;

        while ($currentAttempt < $this->retriesCount) {
            try {
                $this->mailTelegramMessageForwarder->forward($mailTelegram);

                return;
            } catch (TelegramBotException $exception) {
                $this->logger->warning('Error on telegram sending while forwarding messages', [
                    'method' => __METHOD__,
                    'exceptionMessage' => $exception->getMessage(),
                    'exception' => (string) $exception,
                ]);

                ++$currentAttempt;
            } catch (ImapException $exception) {
                $this->logger->warning('Error on imap while forwarding messages', [
                    'method' => __METHOD__,
                    'exceptionMessage' => $exception->getMessage(),
                    'exception' => (string) $exception,
                ]);

                ++$currentAttempt;
            } catch (Exception $exception) {
                $this->logger->error('Error while forwarding messages', [
                    'method' => __METHOD__,
                    'exceptionMessage' => $exception->getMessage(),
                    'exception' => (string) $exception,
                ]);

                throw $exception;
            }
        }
    }
}
