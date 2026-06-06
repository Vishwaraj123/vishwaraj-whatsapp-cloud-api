<?php

namespace Vishwaraj\WhatsAppCloud\Payloads\Templates;

use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateSendData;
use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateComponentData;
use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateParameterData;

class TemplateSendPayload
{
    public function __construct(private readonly TemplateSendData $data) {}

    public function toArray(): array
    {
        $payload = [
            'messaging_product' => $this->data->messagingProduct,
            'recipient_type'    => $this->data->recipientType,
            'to'                => $this->data->to,
            'type'              => 'template',
            'template'          => [
                'name'       => $this->data->name,
                'language'   => ['code' => $this->data->languageCode],
                'components' => array_map([$this, 'serializeComponent'], $this->data->components),
            ],
        ];

        if ($this->data->replyToMessageId) {
            $payload['context'] = ['message_id' => $this->data->replyToMessageId];
        }

        return $payload;
    }

    private function serializeComponent(TemplateComponentData $c): array
    {
        $comp = ['type' => $c->type->value];

        if ($c->subType !== null) $comp['sub_type'] = $c->subType;
        if ($c->index   !== null) $comp['index']    = (string) $c->index;

        if (!empty($c->parameters)) {
            $comp['parameters'] = array_map([$this, 'serializeParameter'], $c->parameters);
        }

        return $comp;
    }

    private function serializeParameter(TemplateParameterData $p): array
    {
        $param = ['type' => $p->type];
        $value = $p->value;

        match ($p->type) {
            'text'                      => $param['text']      = $value,
            'payload'                   => $param['payload']   = $value,
            'action'                    => $param['action']    = $value,
            'currency'                  => $param['currency']  = $value,
            'date_time'                 => $param['date_time'] = $value,
            'image', 'video', 'document' => $param[$p->type]  = $value,
            default                     => null,
        };

        return $param;
    }
}
