<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

class OrderStatusBuilder extends AbstractInteractiveBuilder
{
    private string  $referenceId = '';
    private string  $status      = 'processing';
    private ?string $description = null;

    public function referenceId(string $id): static     { $this->referenceId = $id;     return $this; }
    public function status(string $status): static      { $this->status      = $status; return $this; }
    public function description(string $desc): static   { $this->description = $desc;   return $this; }

    public function send(): MessageResponse
    {
        $order = array_filter(['status' => $this->status, 'description' => $this->description]);

        return $this->post($this->buildBasePayload('order_status', [
            'name'       => 'review_order',
            'parameters' => ['reference_id' => $this->referenceId, 'order' => $order],
        ]));
    }
}
