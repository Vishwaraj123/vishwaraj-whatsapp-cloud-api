<?php

namespace Vishwaraj\WhatsAppCloud\Payloads\Messages;

use Vishwaraj\WhatsAppCloud\DTO\Messages\ContactData;
use Vishwaraj\WhatsAppCloud\DTO\Messages\ContactMessageData;

class ContactMessagePayload
{
    public function __construct(private readonly ContactMessageData $data) {}

    public function toArray(): array
    {
        $payload = [
            'messaging_product' => $this->data->messagingProduct,
            'recipient_type'    => $this->data->recipientType,
            'to'                => $this->data->to,
            'type'              => 'contacts',
            'contacts'          => array_map([$this, 'serializeContact'], $this->data->contacts),
        ];

        if ($this->data->replyToMessageId) {
            $payload['context'] = ['message_id' => $this->data->replyToMessageId];
        }

        return $payload;
    }

    private function serializeContact(ContactData $c): array
    {
        $contact = [
            'name' => array_filter([
                'formatted_name' => $c->formattedName,
                'first_name'     => $c->firstName,
                'last_name'      => $c->lastName,
                'middle_name'    => $c->middleName,
                'suffix'         => $c->suffix,
                'prefix'         => $c->prefix,
            ]),
        ];

        if ($c->birthday)  $contact['birthday']  = $c->birthday;
        if ($c->phones)    $contact['phones']     = $c->phones;
        if ($c->emails)    $contact['emails']     = $c->emails;
        if ($c->addresses) $contact['addresses']  = $c->addresses;
        if ($c->urls)      $contact['urls']       = $c->urls;
        if ($c->org)       $contact['org']        = $c->org;

        return $contact;
    }
}
