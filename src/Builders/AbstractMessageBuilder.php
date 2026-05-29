<?php

namespace Vishwaraj\WhatsAppCloud\Builders;

use Vishwaraj\WhatsAppCloud\Client\WhatsAppClient;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

abstract class AbstractMessageBuilder
{
    protected string  $to            = '';
    protected ?string $replyTo       = null;
    protected string  $recipientType = 'individual';

    public function __construct(protected readonly WhatsAppClient $client) {}

    public function to(string $phone): static
    {
        $this->to = $phone;
        return $this;
    }

    public function replyTo(string $messageId): static
    {
        $this->replyTo = $messageId;
        return $this;
    }

    abstract public function send(): MessageResponse;
}
