<?php

namespace Vishwaraj\WhatsAppCloud\Services;

use Vishwaraj\WhatsAppCloud\Client\WhatsAppClient;
use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateDefinitionData;
use Vishwaraj\WhatsAppCloud\DTO\Responses\TemplateResponse;
use Vishwaraj\WhatsAppCloud\Payloads\Templates\TemplateDefinitionPayload;

class TemplateManagementService
{
    public function __construct(private readonly WhatsAppClient $client) {}

    public function create(TemplateDefinitionData $template): TemplateResponse
    {
        $payload  = (new TemplateDefinitionPayload($template))->toArray();
        $response = $this->client->post("{$this->client->getWabaId()}/message_templates", $payload);
        return TemplateResponse::fromArray($response->body());
    }

    public function update(string $templateId, TemplateDefinitionData $template): bool
    {
        $payload  = (new TemplateDefinitionPayload($template))->toArray();
        $response = $this->client->post($templateId, $payload);
        return (bool) $response->get('success', false);
    }

    /** Delete all languages of a template by name. */
    public function delete(string $name): bool
    {
        $response = $this->client->delete("{$this->client->getWabaId()}/message_templates", [
            'name' => $name,
        ]);
        return (bool) $response->get('success', false);
    }

    /** Delete a specific template language by ID + name. */
    public function deleteById(string $templateId, string $name): bool
    {
        $response = $this->client->delete("{$this->client->getWabaId()}/message_templates", [
            'hsm_id' => $templateId,
            'name'   => $name,
        ]);
        return (bool) $response->get('success', false);
    }

    public function get(string $templateId, array $fields = []): array
    {
        $query    = $fields ? ['fields' => implode(',', $fields)] : [];
        $response = $this->client->get($templateId, $query);
        return $response->body();
    }

    public function find(string $name, array $fields = []): array
    {
        $query    = array_merge(['name' => $name], $fields ? ['fields' => implode(',', $fields)] : []);
        $response = $this->client->get("{$this->client->getWabaId()}/message_templates", $query);
        return $response->get('data', []);
    }

    public function list(array $fields = []): array
    {
        $query    = $fields ? ['fields' => implode(',', $fields)] : [];
        $response = $this->client->get("{$this->client->getWabaId()}/message_templates", $query);
        return $response->get('data', []);
    }

    public function namespace(): string
    {
        $response = $this->client->get($this->client->getWabaId(), ['fields' => 'message_template_namespace']);
        return (string) $response->get('message_template_namespace', '');
    }
}
