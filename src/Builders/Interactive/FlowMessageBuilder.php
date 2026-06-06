<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

class FlowMessageBuilder extends AbstractInteractiveBuilder
{
    private string  $flowToken  = '';
    private ?string $flowId     = null;
    private ?string $flowName   = null;
    private string  $flowCta    = 'Open';
    private string  $flowAction = 'navigate';
    private string  $mode       = 'published';
    private ?string $screenId   = null;
    private array   $screenData = [];

    public function flowToken(string $t): static  { $this->flowToken  = $t;    return $this; }
    public function flowId(string $id): static    { $this->flowId     = $id;   return $this; }
    public function flowName(string $n): static   { $this->flowName   = $n;    return $this; }
    public function cta(string $cta): static      { $this->flowCta    = $cta;  return $this; }
    public function draft(): static               { $this->mode       = 'draft'; return $this; }
    public function screen(string $id): static    { $this->screenId   = $id;   return $this; }
    public function screenData(array $d): static  { $this->screenData = $d;    return $this; }

    public function send(): MessageResponse
    {
        $params = [
            'flow_message_version' => '3',
            'flow_action'          => $this->flowAction,
            'flow_token'           => $this->flowToken,
            'flow_cta'             => $this->flowCta,
            'mode'                 => $this->mode,
        ];

        if ($this->flowId)   $params['flow_id']   = $this->flowId;
        if ($this->flowName) $params['flow_name']  = $this->flowName;

        if ($this->screenId) {
            $payload = ['screen' => $this->screenId];
            if ($this->screenData) {
                $payload['data'] = $this->screenData;
            }
            $params['flow_action_payload'] = $payload;
        }

        return $this->post($this->buildBasePayload('flow', [
            'name'       => 'flow',
            'parameters' => $params,
        ]));
    }
}
