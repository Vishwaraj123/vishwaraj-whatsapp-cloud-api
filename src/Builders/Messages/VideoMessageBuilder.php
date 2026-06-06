<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Messages;

use Vishwaraj\WhatsAppCloud\DTO\Messages\MediaMessageData;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;
use Vishwaraj\WhatsAppCloud\Enums\MediaType;
use Vishwaraj\WhatsAppCloud\Payloads\Messages\MediaMessagePayload;

class VideoMessageBuilder extends AbstractMediaBuilder
{
    public function send(): MessageResponse
    {
        $data     = new MediaMessageData(to: $this->to, mediaType: MediaType::Video, mediaId: $this->mediaId, link: $this->link, caption: $this->caption, replyToMessageId: $this->replyTo);
        $response = $this->client->post("{$this->client->getPhoneNumberId()}/messages", (new MediaMessagePayload($data))->toArray());
        return MessageResponse::fromArray($response->body());
    }
}
