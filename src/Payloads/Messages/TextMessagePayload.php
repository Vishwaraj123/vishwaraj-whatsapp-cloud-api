<?php

namespace Vishwaraj\WhatsAppCloud\Payloads\Messages;

use Vishwaraj\WhatsAppCloud\DTO\Messages\TextMessageData;

class TextMessagePayload
{
    public function __construct(private readonly TextMessageData $data) {}

    public function toArray(): array
    {
        $payload = [
            'messaging_product' => $this->data->messagingProduct,
            'recipient_type'    => $this->data->recipientType,
            'to'                => $this->data->to,
            'type'              => 'text',
            'text'              => [
                'preview_url' => $this->data->previewUrl,
                'body'        => $this->data->body,
            ],
        ];

        if ($this->data->replyToMessageId) {
            $payload['context'] = ['message_id' => $this->data->replyToMessageId];
        }

        return $payload;
    }
}
