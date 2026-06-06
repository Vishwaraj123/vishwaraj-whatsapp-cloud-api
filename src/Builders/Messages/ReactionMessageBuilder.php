<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Messages;

use Vishwaraj\WhatsAppCloud\Builders\AbstractMessageBuilder;
use Vishwaraj\WhatsAppCloud\DTO\Messages\ReactionMessageData;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;
use Vishwaraj\WhatsAppCloud\Payloads\Messages\ReactionMessagePayload;

class ReactionMessageBuilder extends AbstractMessageBuilder
{
    private string $messageId = '';
    private string $emoji     = '';

    public function messageId(string $id): static   { $this->messageId = $id;    return $this; }
    public function emoji(string $emoji): static     { $this->emoji     = $emoji; return $this; }
    public function remove(): static                 { $this->emoji     = '';     return $this; }

    public function send(): MessageResponse
    {
        $data     = new ReactionMessageData(to: $this->to, messageId: $this->messageId, emoji: $this->emoji);
        $response = $this->client->post("{$this->client->getPhoneNumberId()}/messages", (new ReactionMessagePayload($data))->toArray());
        return MessageResponse::fromArray($response->body());
    }
}
