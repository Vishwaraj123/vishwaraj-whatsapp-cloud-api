<?php

namespace Vishwaraj\WhatsAppCloud\Payloads\Messages;

use Vishwaraj\WhatsAppCloud\DTO\Messages\ReactionMessageData;

class ReactionMessagePayload
{
    public function __construct(private readonly ReactionMessageData $data) {}

    public function toArray(): array
    {
        return [
            'messaging_product' => $this->data->messagingProduct,
            'recipient_type'    => $this->data->recipientType,
            'to'                => $this->data->to,
            'type'              => 'reaction',
            'reaction'          => [
                'message_id' => $this->data->messageId,
                'emoji'      => $this->data->emoji,
            ],
        ];
    }
}
