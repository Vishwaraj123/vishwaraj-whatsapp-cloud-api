<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

class CatalogMessageBuilder extends AbstractInteractiveBuilder
{
    private ?string $thumbnail = null;

    public function thumbnail(string $productRetailerId): static
    {
        $this->thumbnail = $productRetailerId;
        return $this;
    }

    public function send(): MessageResponse
    {
        $params = [];
        if ($this->thumbnail) {
            $params['thumbnail_product_retailer_id'] = $this->thumbnail;
        }

        return $this->post($this->buildBasePayload('catalog_message', [
            'name'       => 'catalog_message',
            'parameters' => $params,
        ]));
    }
}
