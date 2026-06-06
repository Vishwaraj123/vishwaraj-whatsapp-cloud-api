<?php

namespace Vishwaraj\WhatsAppCloud\DTO\Responses;

final class MessageResponse
{
    public function __construct(
        public readonly string $messagingProduct,
        public readonly array  $contacts,
        public readonly array  $messages,
    ) {}

    public function messageId(): ?string
    {
        return $this->messages[0]['id'] ?? null;
    }

    public function waId(): ?string
    {
        return $this->contacts[0]['wa_id'] ?? null;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            messagingProduct: $data['messaging_product'] ?? 'whatsapp',
            contacts:         $data['contacts'] ?? [],
            messages:         $data['messages'] ?? [],
        );
    }
}
