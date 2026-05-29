<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Messages;

final class ReactionMessageData
{
    public function __construct(
        public readonly string $to,
        public readonly string $messageId,
        public readonly string $emoji,
        public readonly string $messagingProduct = 'whatsapp',
        public readonly string $recipientType = 'individual',
    ) {}
}
