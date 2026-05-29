<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Messages;

use Vishwaraj\WhatsAppCloud\Builders\AbstractMessageBuilder;
use Vishwaraj\WhatsAppCloud\Client\WhatsAppClient;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;
use Vishwaraj\WhatsAppCloud\Services\MediaService;

abstract class AbstractMediaBuilder extends AbstractMessageBuilder
{
    protected ?string $mediaId  = null;
    protected ?string $link     = null;
    protected ?string $caption  = null;
    protected ?string $filename = null;

    public function __construct(
        WhatsAppClient              $client,
        protected readonly MediaService $mediaService,
    ) {
        parent::__construct($client);
    }

    public function fromMediaId(string $id): static
    {
        $this->mediaId = $id;
        return $this;
    }

    public function fromUrl(string $url): static
    {
        $this->link = $url;
        return $this;
    }

    public function fromPath(string $path): static
    {
        $uploaded      = $this->mediaService->upload($path);
        $this->mediaId = $uploaded->id;
        return $this;
    }

    public function caption(string $caption): static
    {
        $this->caption = $caption;
        return $this;
    }

    public function filename(string $filename): static
    {
        $this->filename = $filename;
        return $this;
    }

    abstract public function send(): MessageResponse;
}
