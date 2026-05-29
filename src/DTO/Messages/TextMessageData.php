<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Messages;

final class TextMessageData
{
    public function __construct(
        public readonly string  $to,
        public readonly string  $body,
        public readonly bool    $previewUrl = false,
        public readonly ?string $replyToMessageId = null,
        public readonly string  $messagingProduct = 'whatsapp',
        public readonly string  $recipientType = 'individual',
    ) {}
}
