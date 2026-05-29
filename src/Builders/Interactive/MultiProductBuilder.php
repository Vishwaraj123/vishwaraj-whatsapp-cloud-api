<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

class MultiProductBuilder extends AbstractInteractiveBuilder
{
    private string $catalogId = '';
    private array  $sections  = [];

    public function catalogId(string $id): static { $this->catalogId = $id; return $this; }

    /** @param string[] $productIds  SKU / retailer IDs */
    public function section(string $title, array $productIds): static
    {
        $this->sections[] = [
            'title'         => $title,
            'product_items' => array_map(fn ($id) => ['product_retailer_id' => $id], $productIds),
        ];
        return $this;
    }

    public function send(): MessageResponse
    {
        return $this->post($this->buildBasePayload('product_list', [
            'catalog_id' => $this->catalogId,
            'sections'   => $this->sections,
        ]));
    }
}
