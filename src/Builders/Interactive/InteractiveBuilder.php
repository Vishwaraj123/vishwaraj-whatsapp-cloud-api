<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Interactive;

use Vishwaraj\WhatsAppCloud\Client\WhatsAppClient;
use Vishwaraj\WhatsAppCloud\Services\MediaService;

class InteractiveBuilder
{
    public function __construct(
        private readonly WhatsAppClient $client,
        private readonly MediaService   $mediaService,
    ) {}

    public function replyButtons(): ReplyButtonsBuilder      { return new ReplyButtonsBuilder($this->client); }
    public function list(): ListMessageBuilder               { return new ListMessageBuilder($this->client); }
    public function product(): SingleProductBuilder          { return new SingleProductBuilder($this->client); }
    public function productList(): MultiProductBuilder       { return new MultiProductBuilder($this->client); }
    public function flow(): FlowMessageBuilder               { return new FlowMessageBuilder($this->client); }
    public function ctaUrl(): CtaUrlBuilder                  { return new CtaUrlBuilder($this->client); }
    public function catalog(): CatalogMessageBuilder         { return new CatalogMessageBuilder($this->client); }
    public function orderDetails(): OrderDetailsBuilder      { return new OrderDetailsBuilder($this->client); }
    public function orderStatus(): OrderStatusBuilder        { return new OrderStatusBuilder($this->client); }
}
