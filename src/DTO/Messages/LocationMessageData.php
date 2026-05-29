<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Messages;

final class LocationMessageData
{
    public function __construct(
        public readonly string  $to,
        public readonly float   $latitude,
        public readonly float   $longitude,
        public readonly ?string $name = null,
        public readonly ?string $address = null,
        public readonly ?string $replyToMessageId = null,
        public readonly string  $messagingProduct = 'whatsapp',
        public readonly string  $recipientType = 'individual',
    ) {}
}
