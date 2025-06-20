<?php

namespace App\Application\Service\MailTelegram\Formatter\Sanitizer;

use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

class HtmlTagSymbolsSanitizer implements HtmlSanitizerInterface
{
    public function sanitize(string $input): string
    {
        return $this->sanitizeInternal($input);
    }

    public function sanitizeFor(string $element, string $input): string
    {
        return $this->sanitizeInternal($input);
    }

    private function sanitizeInternal(string $input): string
    {
        return str_replace(['<', '>'], ['(', ')'], $input);
    }
}
