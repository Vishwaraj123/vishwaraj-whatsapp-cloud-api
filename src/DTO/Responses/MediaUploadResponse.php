<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Responses;

final class MediaUploadResponse
{
    public function __construct(
        public readonly string $id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(id: $data['id']);
    }
}
