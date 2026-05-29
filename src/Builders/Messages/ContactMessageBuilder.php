<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Messages;

use Vishwaraj\WhatsAppCloud\Builders\AbstractMessageBuilder;
use Vishwaraj\WhatsAppCloud\DTO\Messages\ContactData;
use Vishwaraj\WhatsAppCloud\DTO\Messages\ContactMessageData;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;
use Vishwaraj\WhatsAppCloud\Payloads\Messages\ContactMessagePayload;

class ContactMessageBuilder extends AbstractMessageBuilder
{
    private array $contacts = [];

    public function addContact(ContactData $contact): static
    {
        $this->contacts[] = $contact;
        return $this;
    }

    public function contacts(array $contacts): static
    {
        $this->contacts = $contacts;
        return $this;
    }

    public function send(): MessageResponse
    {
        $data     = new ContactMessageData(to: $this->to, contacts: $this->contacts, replyToMessageId: $this->replyTo);
        $response = $this->client->post("{$this->client->getPhoneNumberId()}/messages", (new ContactMessagePayload($data))->toArray());
        return MessageResponse::fromArray($response->body());
    }
}
