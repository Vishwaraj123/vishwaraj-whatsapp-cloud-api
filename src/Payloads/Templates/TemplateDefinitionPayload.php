<?php

namespace Vishwaraj\WhatsAppCloud\Payloads\Templates;

use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateDefinitionData;

class TemplateDefinitionPayload
{
    public function __construct(private readonly TemplateDefinitionData $data) {}

    public function toArray(): array
    {
        $payload = [
            'name'       => $this->data->name,
            'language'   => $this->data->language,
            'category'   => $this->data->category->value,
            'components' => $this->data->components,
        ];

        if ($this->data->allowCategoryChange) {
            $payload['allow_category_change'] = true;
        }

        return $payload;
    }
}
