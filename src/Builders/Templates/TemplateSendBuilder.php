<?php

namespace Vishwaraj\WhatsAppCloud\Builders\Templates;

use Vishwaraj\WhatsAppCloud\Builders\AbstractMessageBuilder;
use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateSendData;
use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateComponentData;
use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateParameterData;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;
use Vishwaraj\WhatsAppCloud\Enums\ComponentType;
use Vishwaraj\WhatsAppCloud\Payloads\Templates\TemplateSendPayload;

class TemplateSendBuilder extends AbstractMessageBuilder
{
    private string $name         = '';
    private string $languageCode = 'en_US';
    private array  $components   = [];

    public function name(string $name): static         { $this->name         = $name; return $this; }
    public function language(string $code): static     { $this->languageCode = $code; return $this; }

    /** Text variable substitutions for the body component. */
    public function body(array $variables): static
    {
        $this->components[] = new TemplateComponentData(
            type:       ComponentType::Body,
            parameters: array_map(fn ($v) => TemplateParameterData::text((string) $v), $variables),
        );
        return $this;
    }

    /** Text variable substitutions for the header component. */
    public function header(array $variables): static
    {
        $this->components[] = new TemplateComponentData(
            type:       ComponentType::Header,
            parameters: array_map(fn ($v) => TemplateParameterData::text((string) $v), $variables),
        );
        return $this;
    }

    public function headerImageUrl(string $url): static
    {
        $this->components[] = new TemplateComponentData(ComponentType::Header, [TemplateParameterData::image($url)]);
        return $this;
    }

    public function headerImageId(string $id): static
    {
        $this->components[] = new TemplateComponentData(ComponentType::Header, [TemplateParameterData::imageId($id)]);
        return $this;
    }

    public function headerVideoUrl(string $url): static
    {
        $this->components[] = new TemplateComponentData(ComponentType::Header, [TemplateParameterData::video($url)]);
        return $this;
    }

    public function headerDocumentUrl(string $url, ?string $filename = null): static
    {
        $this->components[] = new TemplateComponentData(ComponentType::Header, [TemplateParameterData::document($url, $filename)]);
        return $this;
    }

    public function quickReplyButton(int $index, string $payload): static
    {
        $this->components[] = new TemplateComponentData(ComponentType::Button, [TemplateParameterData::payload($payload)], 'quick_reply', $index);
        return $this;
    }

    public function urlButton(int $index, string $suffix): static
    {
        $this->components[] = new TemplateComponentData(ComponentType::Button, [TemplateParameterData::text($suffix)], 'url', $index);
        return $this;
    }

    public function flowButton(int $index, string $flowToken, array $actionData = []): static
    {
        $action = ['flow_token' => $flowToken];
        if ($actionData) {
            $action['flow_action_data'] = $actionData;
        }
        $this->components[] = new TemplateComponentData(ComponentType::Button, [TemplateParameterData::action($action)], 'flow', $index);
        return $this;
    }

    public function catalogButton(int $index, string $thumbnailProductRetailerId): static
    {
        $this->components[] = new TemplateComponentData(
            ComponentType::Button,
            [TemplateParameterData::action(['thumbnail_product_retailer_id' => $thumbnailProductRetailerId])],
            'CATALOG',
            $index,
        );
        return $this;
    }

    public function addComponent(TemplateComponentData $component): static
    {
        $this->components[] = $component;
        return $this;
    }

    public function send(): MessageResponse
    {
        $data     = new TemplateSendData(to: $this->to, name: $this->name, languageCode: $this->languageCode, components: $this->components, replyToMessageId: $this->replyTo);
        $response = $this->client->post("{$this->client->getPhoneNumberId()}/messages", (new TemplateSendPayload($data))->toArray());
        return MessageResponse::fromArray($response->body());
    }
}
