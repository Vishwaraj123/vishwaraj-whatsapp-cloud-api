<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

class CtaUrlBuilder extends AbstractInteractiveBuilder
{
    private string $displayText = '';
    private string $url         = '';

    public function displayText(string $text): static { $this->displayText = $text; return $this; }
    public function url(string $url): static          { $this->url = $url; return $this; }

    public function send(): MessageResponse
    {
        return $this->post($this->buildBasePayload('cta_url', [
            'name'       => 'cta_url',
            'parameters' => [
                'display_text' => $this->displayText,
                'url'          => $this->url,
            ],
        ]));
    }
}
