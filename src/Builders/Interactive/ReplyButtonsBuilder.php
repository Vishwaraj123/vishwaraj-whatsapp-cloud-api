<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

class ReplyButtonsBuilder extends AbstractInteractiveBuilder
{
    private array $buttons = [];

    public function addButton(string $id, string $title): static
    {
        $this->buttons[] = ['type' => 'reply', 'reply' => ['id' => $id, 'title' => $title]];
        return $this;
    }

    public function send(): MessageResponse
    {
        return $this->post($this->buildBasePayload('button', ['buttons' => $this->buttons]));
    }
}
