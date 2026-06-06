<?php

namespace Vishwaraj\WhatsAppCloud\Client;

class ApiResponse
{
    public function __construct(
        private readonly int   $statusCode,
        private readonly array $body,
    ) {}

    public function statusCode(): int  { return $this->statusCode; }
    public function body(): array      { return $this->body; }
    public function isSuccess(): bool  { return $this->statusCode >= 200 && $this->statusCode < 300; }

    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->body, $key, $default);
    }
}
