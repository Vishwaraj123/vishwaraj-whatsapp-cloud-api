<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\Client\WhatsAppClient;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

abstract class AbstractInteractiveBuilder
{
    protected string  $to         = '';
    protected ?string $replyTo    = null;
    protected ?array  $header     = null;
    protected ?string $bodyText   = null;
    protected ?string $footerText = null;

    public function __construct(protected readonly WhatsAppClient $client) {}

    public function to(string $phone): static      { $this->to         = $phone; return $this; }
    public function replyTo(string $id): static    { $this->replyTo    = $id;    return $this; }
    public function body(string $text): static     { $this->bodyText   = $text;  return $this; }
    public function footer(string $text): static   { $this->footerText = $text;  return $this; }

    public function headerText(string $text): static
    {
        $this->header = ['type' => 'text', 'text' => $text];
        return $this;
    }

    public function headerImage(string $urlOrId): static
    {
        $key          = str_starts_with($urlOrId, 'http') ? 'link' : 'id';
        $this->header = ['type' => 'image', 'image' => [$key => $urlOrId]];
        return $this;
    }

    public function headerVideo(string $urlOrId): static
    {
        $key          = str_starts_with($urlOrId, 'http') ? 'link' : 'id';
        $this->header = ['type' => 'video', 'video' => [$key => $urlOrId]];
        return $this;
    }

    public function headerDocument(string $urlOrId): static
    {
        $key          = str_starts_with($urlOrId, 'http') ? 'link' : 'id';
        $this->header = ['type' => 'document', 'document' => [$key => $urlOrId]];
        return $this;
    }

    abstract public function send(): MessageResponse;

    protected function buildBasePayload(string $interactiveType, array $action): array
    {
        $interactive = ['type' => $interactiveType];

        if ($this->header)     $interactive['header'] = $this->header;
        if ($this->bodyText)   $interactive['body']   = ['text' => $this->bodyText];
        if ($this->footerText) $interactive['footer'] = ['text' => $this->footerText];

        $interactive['action'] = $action;

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type'    => 'individual',
            'to'                => $this->to,
            'type'              => 'interactive',
            'interactive'       => $interactive,
        ];

        if ($this->replyTo) {
            $payload['context'] = ['message_id' => $this->replyTo];
        }

        return $payload;
    }

    protected function post(array $payload): MessageResponse
    {
        $response = $this->client->post("{$this->client->getPhoneNumberId()}/messages", $payload);
        return MessageResponse::fromArray($response->body());
    }
}
