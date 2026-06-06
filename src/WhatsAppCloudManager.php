<?php

namespace Vishwaraj\WhatsAppCloud;

use Vishwaraj\WhatsAppCloud\Builders\Interactive\InteractiveBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Messages\AudioMessageBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Messages\ContactMessageBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Messages\DocumentMessageBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Messages\ImageMessageBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Messages\LocationMessageBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Messages\ReactionMessageBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Messages\StickerMessageBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Messages\TextMessageBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Messages\VideoMessageBuilder;
use Vishwaraj\WhatsAppCloud\Builders\Templates\TemplateSendBuilder;
use Vishwaraj\WhatsAppCloud\Client\WhatsAppClient;
use Vishwaraj\WhatsAppCloud\Services\MediaService;
use Vishwaraj\WhatsAppCloud\Services\TemplateManagementService;

class WhatsAppCloudManager
{
    private MediaService              $mediaService;
    private TemplateManagementService $templateService;

    public function __construct(private WhatsAppClient $client)
    {
        $this->mediaService    = new MediaService($client);
        $this->templateService = new TemplateManagementService($client);
    }

    // ── Context modifiers ─────────────────────────────────────────────────────

    public function usingPhoneNumber(string $phoneNumberId): static
    {
        $clone                  = clone $this;
        $clone->client          = $this->client->withPhoneNumber($phoneNumberId);
        $clone->mediaService    = new MediaService($clone->client);
        $clone->templateService = new TemplateManagementService($clone->client);
        return $clone;
    }

    public function usingToken(string $token): static
    {
        $clone                  = clone $this;
        $clone->client          = $this->client->withToken($token);
        $clone->mediaService    = new MediaService($clone->client);
        $clone->templateService = new TemplateManagementService($clone->client);
        return $clone;
    }

    public function usingVersion(string $version): static
    {
        $clone         = clone $this;
        $clone->client = $this->client->withVersion($version);
        return $clone;
    }

    // ── Message builders ──────────────────────────────────────────────────────

    public function text(): TextMessageBuilder
    {
        return new TextMessageBuilder($this->client);
    }

    public function image(): ImageMessageBuilder
    {
        return new ImageMessageBuilder($this->client, $this->mediaService);
    }

    public function video(): VideoMessageBuilder
    {
        return new VideoMessageBuilder($this->client, $this->mediaService);
    }

    public function audio(): AudioMessageBuilder
    {
        return new AudioMessageBuilder($this->client, $this->mediaService);
    }

    public function document(): DocumentMessageBuilder
    {
        return new DocumentMessageBuilder($this->client, $this->mediaService);
    }

    public function sticker(): StickerMessageBuilder
    {
        return new StickerMessageBuilder($this->client, $this->mediaService);
    }

    public function location(): LocationMessageBuilder
    {
        return new LocationMessageBuilder($this->client);
    }

    public function contact(): ContactMessageBuilder
    {
        return new ContactMessageBuilder($this->client);
    }

    public function reaction(): ReactionMessageBuilder
    {
        return new ReactionMessageBuilder($this->client);
    }

    // ── Interactive ────────────────────────────────────────────────────────────

    public function interactive(): InteractiveBuilder
    {
        return new InteractiveBuilder($this->client, $this->mediaService);
    }

    // ── Templates ─────────────────────────────────────────────────────────────

    public function template(): TemplateSendBuilder
    {
        return new TemplateSendBuilder($this->client);
    }

    public function templates(): TemplateManagementService
    {
        return $this->templateService;
    }

    // ── Media ──────────────────────────────────────────────────────────────────

    public function media(): MediaService
    {
        return $this->mediaService;
    }

    // ── Utilities ─────────────────────────────────────────────────────────────

    public function markRead(string $messageId): bool
    {
        $response = $this->client->post("{$this->client->getPhoneNumberId()}/messages", [
            'messaging_product' => 'whatsapp',
            'status'            => 'read',
            'message_id'        => $messageId,
        ]);
        return (bool) $response->get('success', false);
    }

    public function sendTypingIndicator(string $messageId): bool
    {
        $response = $this->client->post("{$this->client->getPhoneNumberId()}/messages", [
            'messaging_product' => 'whatsapp',
            'status'            => 'read',
            'message_id'        => $messageId,
            'typing_indicator'  => ['type' => 'text'],
        ]);
        return (bool) $response->get('success', false);
    }
}
