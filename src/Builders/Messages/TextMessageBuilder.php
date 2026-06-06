<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Messages;

use Vishwaraj\WhatsAppCloud\Builders\AbstractMessageBuilder;
use Vishwaraj\WhatsAppCloud\DTO\Messages\TextMessageData;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;
use Vishwaraj\WhatsAppCloud\Payloads\Messages\TextMessagePayload;

class TextMessageBuilder extends AbstractMessageBuilder
{
    private string $body       = '';
    private bool   $previewUrl = false;

    public function body(string $body): static
    {
        $this->body = $body;
        return $this;
    }

    public function previewUrl(bool $enable = true): static
    {
        $this->previewUrl = $enable;
        return $this;
    }

    public function send(): MessageResponse
    {
        $data = new TextMessageData(
            to:               $this->to,
            body:             $this->body,
            previewUrl:       $this->previewUrl,
            replyToMessageId: $this->replyTo,
        );

        $payload  = (new TextMessagePayload($data))->toArray();
        $response = $this->client->post("{$this->client->getPhoneNumberId()}/messages", $payload);
        return MessageResponse::fromArray($response->body());
    }
}
