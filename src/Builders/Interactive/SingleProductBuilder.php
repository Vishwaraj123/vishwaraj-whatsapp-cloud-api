<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

class SingleProductBuilder extends AbstractInteractiveBuilder
{
    private string $catalogId         = '';
    private string $productRetailerId = '';

    public function catalogId(string $id): static  { $this->catalogId         = $id; return $this; }
    public function productId(string $id): static  { $this->productRetailerId = $id; return $this; }

    public function send(): MessageResponse
    {
        return $this->post($this->buildBasePayload('product', [
            'catalog_id'          => $this->catalogId,
            'product_retailer_id' => $this->productRetailerId,
        ]));
    }
}
