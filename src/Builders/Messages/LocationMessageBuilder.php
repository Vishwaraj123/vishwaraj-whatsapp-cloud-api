<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Messages;

use Vishwaraj\WhatsAppCloud\Builders\AbstractMessageBuilder;
use Vishwaraj\WhatsAppCloud\DTO\Messages\LocationMessageData;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;
use Vishwaraj\WhatsAppCloud\Payloads\Messages\LocationMessagePayload;

class LocationMessageBuilder extends AbstractMessageBuilder
{
    private float   $latitude  = 0.0;
    private float   $longitude = 0.0;
    private ?string $name      = null;
    private ?string $address   = null;

    public function latitude(float $lat): static   { $this->latitude  = $lat;     return $this; }
    public function longitude(float $lng): static  { $this->longitude = $lng;     return $this; }
    public function name(string $name): static     { $this->name      = $name;    return $this; }
    public function address(string $addr): static  { $this->address   = $addr;    return $this; }

    public function coordinates(float $lat, float $lng): static
    {
        $this->latitude  = $lat;
        $this->longitude = $lng;
        return $this;
    }

    public function send(): MessageResponse
    {
        $data     = new LocationMessageData(to: $this->to, latitude: $this->latitude, longitude: $this->longitude, name: $this->name, address: $this->address, replyToMessageId: $this->replyTo);
        $response = $this->client->post("{$this->client->getPhoneNumberId()}/messages", (new LocationMessagePayload($data))->toArray());
        return MessageResponse::fromArray($response->body());
    }
}
