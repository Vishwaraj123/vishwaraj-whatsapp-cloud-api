<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

class OrderDetailsBuilder extends AbstractInteractiveBuilder
{
    private string $referenceId          = '';
    private string $type                 = 'digital-goods';
    private string $paymentType          = 'upi';
    private string $paymentConfiguration = '';
    private string $currency             = 'INR';
    private int    $totalValue           = 0;
    private int    $totalOffset          = 100;
    private array  $orderItems           = [];
    private array  $orderMeta            = [];

    public function referenceId(string $id): static        { $this->referenceId          = $id;   return $this; }
    public function type(string $type): static             { $this->type                 = $type; return $this; }
    public function paymentType(string $t): static         { $this->paymentType          = $t;    return $this; }
    public function paymentConfig(string $c): static       { $this->paymentConfiguration = $c;    return $this; }
    public function currency(string $currency): static     { $this->currency             = $currency; return $this; }
    public function total(int $value, int $offset = 100): static
    {
        $this->totalValue  = $value;
        $this->totalOffset = $offset;
        return $this;
    }

    public function addItem(string $retailerId, string $name, int $amount, int $quantity = 1, ?int $saleAmount = null, int $offset = 100): static
    {
        $item = [
            'retailer_id' => $retailerId,
            'name'        => $name,
            'amount'      => ['value' => $amount, 'offset' => $offset],
            'quantity'    => $quantity,
        ];
        if ($saleAmount !== null) {
            $item['sale_amount'] = ['value' => $saleAmount, 'offset' => $offset];
        }
        $this->orderItems[] = $item;
        return $this;
    }

    public function orderMeta(array $meta): static { $this->orderMeta = $meta; return $this; }

    public function send(): MessageResponse
    {
        $order = array_merge(['status' => 'pending', 'items' => $this->orderItems], $this->orderMeta);

        return $this->post($this->buildBasePayload('order_details', [
            'reference_id'          => $this->referenceId,
            'type'                  => $this->type,
            'payment_type'          => $this->paymentType,
            'payment_configuration' => $this->paymentConfiguration,
            'currency'              => $this->currency,
            'total_amount'          => ['value' => $this->totalValue, 'offset' => $this->totalOffset],
            'order'                 => $order,
        ]));
    }
}
