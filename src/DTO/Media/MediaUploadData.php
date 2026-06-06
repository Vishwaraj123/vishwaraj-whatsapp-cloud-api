<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Media;

final class MediaUploadData
{
    public function __construct(
        public readonly string $filePath,
        public readonly string $mimeType,
        public readonly string $messagingProduct = 'whatsapp',
    ) {}
}
