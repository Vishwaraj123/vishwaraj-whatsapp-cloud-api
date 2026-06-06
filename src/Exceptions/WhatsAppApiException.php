<?php

namespace Vishwaraj\WhatsAppCloud\Exceptions;

class WhatsAppApiException extends WhatsAppException
{
    public function __construct(
        string $message,
        int $code = 0,
        private readonly ?string $details = null,
    ) {
        parent::__construct($message, $code);
    }

    public function getDetails(): ?string { return $this->details; }
}
