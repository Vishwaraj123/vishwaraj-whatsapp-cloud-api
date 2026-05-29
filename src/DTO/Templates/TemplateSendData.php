<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Templates;

final class TemplateSendData
{
    public function __construct(
        public readonly string  $to,
        public readonly string  $name,
        public readonly string  $languageCode,
        public readonly array   $components = [],
        public readonly ?string $replyToMessageId = null,
        public readonly string  $messagingProduct = 'whatsapp',
        public readonly string  $recipientType = 'individual',
    ) {}
}
