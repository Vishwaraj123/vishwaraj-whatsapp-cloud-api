<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Messages;

final class ContactData
{
    public function __construct(
        public readonly string  $formattedName,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $middleName = null,
        public readonly ?string $suffix = null,
        public readonly ?string $prefix = null,
        public readonly ?string $birthday = null,
        public readonly array   $phones = [],
        public readonly array   $emails = [],
        public readonly array   $addresses = [],
        public readonly array   $urls = [],
        public readonly ?array  $org = null,
    ) {}
}
