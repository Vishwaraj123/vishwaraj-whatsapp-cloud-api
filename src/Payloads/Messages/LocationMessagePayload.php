<?php

namespace Vishwaraj\WhatsAppCloud\Payloads\Messages;

use Vishwaraj\WhatsAppCloud\DTO\Messages\LocationMessageData;

class LocationMessagePayload
{
    public function __construct(private readonly LocationMessageData $data) {}

    public function toArray(): array
    {
        $location = [
            'latitude'  => $this->data->latitude,
            'longitude' => $this->data->longitude,
        ];

        if ($this->data->name)    $location['name']    = $this->data->name;
        if ($this->data->address) $location['address'] = $this->data->address;

        $payload = [
            'messaging_product' => $this->data->messagingProduct,
            'recipient_type'    => $this->data->recipientType,
            'to'                => $this->data->to,
            'type'              => 'location',
            'location'          => $location,
        ];

        if ($this->data->replyToMessageId) {
            $payload['context'] = ['message_id' => $this->data->replyToMessageId];
        }

        return $payload;
    }
}
