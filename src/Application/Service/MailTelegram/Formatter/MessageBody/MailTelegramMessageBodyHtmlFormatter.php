<?php

declare(strict_types=1);

namespace App\Application\Service\MailTelegram\Formatter\MessageBody;

use App\Infrastructure\Imap\DTO\MailDTO;
use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

class MailTelegramMessageBodyHtmlFormatter implements MailTelegramMessageBodyFormatterInterface
{
    private const HTML_TAG_BODY = 'body';
    private const BODY_FIRST_ELEMENT_INDEX = 0;

    public function __construct(
        private HtmlSanitizerInterface $htmlSanitizer,
        private HtmlSanitizerInterface $htmlTagSymbolsSanitizer,
    ) {
    }

    public function supports(MailDTO $mailDTO): bool
    {
        return $mailDTO->getTextHtml() !== null;
    }

    public function format(MailDTO $mailDTO): string
    {
        $sanitizedTextHtml = $this->htmlSanitizer->sanitize($mailDTO->getTextHtml());

        $DOMDocument = $this
            ->getDOMDocument($sanitizedTextHtml);
        $DOMDocumentBody = $DOMDocument
            ->getElementsByTagName(self::HTML_TAG_BODY)
            ->item(self::BODY_FIRST_ELEMENT_INDEX);

        return $DOMDocumentBody instanceof DOMNode
            ? $this->extractTextRecursively($DOMDocumentBody)
            : '';
    }

    public function getDOMDocument(string $sanitizedTextHtml): DOMDocument
    {
        $DOM = new DOMDocument();
        @$DOM->loadHTML('<meta charset="utf-8">' . $sanitizedTextHtml);

        return $DOM;
    }

    public function extractTextRecursively(DOMNode $DOMNode): string
    {
        $text = '';

        foreach ($DOMNode->childNodes as $childNode) {
            if ($childNode instanceof DOMText) {
                $trimmedText = trim($childNode->nodeValue);

                $text .= $this->htmlTagSymbolsSanitizer->sanitize($trimmedText) . PHP_EOL;
            } elseif ($childNode instanceof DOMElement) {
                $text .= trim($this->extractTextRecursively($childNode));
            }
        }

        return $text;
    }
}
