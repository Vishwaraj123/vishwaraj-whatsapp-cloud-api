<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Messages;

final class ContactMessageData
{
    public function __construct(
        public readonly string  $to,
        public readonly array   $contacts,
        public readonly ?string $replyToMessageId = null,
        public readonly string  $messagingProduct = 'whatsapp',
        public readonly string  $recipientType = 'individual',
    ) {}
}
