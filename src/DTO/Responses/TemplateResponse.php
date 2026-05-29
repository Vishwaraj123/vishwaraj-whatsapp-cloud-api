<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Responses;

final class TemplateResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly string $category,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id:       $data['id'],
            status:   $data['status'],
            category: $data['category'],
        );
    }
}
