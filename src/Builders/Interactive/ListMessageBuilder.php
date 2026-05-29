<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

class ListMessageBuilder extends AbstractInteractiveBuilder
{
    private string $buttonLabel = 'Select';
    private array  $sections    = [];

    public function buttonLabel(string $label): static { $this->buttonLabel = $label; return $this; }

    /** @param array $rows  [['id'=>'...','title'=>'...','description'=>'...'], ...] */
    public function section(string $title, array $rows): static
    {
        $this->sections[] = ['title' => $title, 'rows' => $rows];
        return $this;
    }

    public function send(): MessageResponse
    {
        return $this->post($this->buildBasePayload('list', [
            'button'   => $this->buttonLabel,
            'sections' => $this->sections,
        ]));
    }
}
