<?php

namespace Vishwaraj\WhatsAppCloud\Payloads\Messages;

use Vishwaraj\WhatsAppCloud\DTO\Messages\MediaMessageData;

class MediaMessagePayload
{
    public function __construct(private readonly MediaMessageData $data) {}

    public function toArray(): array
    {
        $type = $this->data->mediaType->value;

        $mediaObject = [];
        if ($this->data->mediaId) {
            $mediaObject['id'] = $this->data->mediaId;
        } elseif ($this->data->link) {
            $mediaObject['link'] = $this->data->link;
        }

        if ($this->data->caption)  $mediaObject['caption']  = $this->data->caption;
        if ($this->data->filename) $mediaObject['filename'] = $this->data->filename;

        $payload = [
            'messaging_product' => $this->data->messagingProduct,
            'recipient_type'    => $this->data->recipientType,
            'to'                => $this->data->to,
            'type'              => $type,
            $type               => $mediaObject,
        ];

        if ($this->data->replyToMessageId) {
            $payload['context'] = ['message_id' => $this->data->replyToMessageId];
        }

        return $payload;
    }
}
