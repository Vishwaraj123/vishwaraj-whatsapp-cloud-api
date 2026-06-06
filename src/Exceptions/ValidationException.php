<?php

namespace Vishwaraj\WhatsAppCloud\Exceptions;

class ValidationException extends WhatsAppException
{
    public function __construct(string $message, private readonly array $errors = [])
    {
        parent::__construct($message);
    }

    public function getErrors(): array { return $this->errors; }
}
