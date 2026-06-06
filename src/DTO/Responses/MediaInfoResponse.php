<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Responses;

final class MediaInfoResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $url,
        public readonly string $mimeType,
        public readonly string $sha256,
        public readonly string $fileSize,
        public readonly string $messagingProduct,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id:               $data['id'],
            url:              $data['url'],
            mimeType:         $data['mime_type'],
            sha256:           $data['sha256'],
            fileSize:         $data['file_size'],
            messagingProduct: $data['messaging_product'],
        );
    }
}
