<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Messages;

use Vishwaraj\WhatsAppCloud\Enums\MediaType;

final class MediaMessageData
{
    public function __construct(
        public readonly string    $to,
        public readonly MediaType $mediaType,
        public readonly ?string   $mediaId = null,
        public readonly ?string   $link = null,
        public readonly ?string   $caption = null,
        public readonly ?string   $filename = null,
        public readonly ?string   $replyToMessageId = null,
        public readonly string    $messagingProduct = 'whatsapp',
        public readonly string    $recipientType = 'individual',
    ) {}
}
