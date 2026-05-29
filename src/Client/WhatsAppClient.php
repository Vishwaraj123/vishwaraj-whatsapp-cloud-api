<?php

namespace Vishwaraj\WhatsAppCloud\Client;

use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Facades\Http;
use Vishwaraj\WhatsAppCloud\Exceptions\WhatsAppApiException;
use Vishwaraj\WhatsAppCloud\Exceptions\AuthenticationException;
use Vishwaraj\WhatsAppCloud\Exceptions\RateLimitException;

class WhatsAppClient
{
    public function __construct(
        private string $accessToken,
        private string $phoneNumberId,
        private string $wabaId,
        private string $businessId,
        private string $apiVersion,
        private string $baseUrl,
        private int    $timeout,
    ) {}

    public function withPhoneNumber(string $phoneNumberId): static
    {
        $clone = clone $this;
        $clone->phoneNumberId = $phoneNumberId;
        return $clone;
    }

    public function withToken(string $token): static
    {
        $clone = clone $this;
        $clone->accessToken = $token;
        return $clone;
    }

    public function withVersion(string $version): static
    {
        $clone = clone $this;
        $clone->apiVersion = $version;
        return $clone;
    }

    public function getPhoneNumberId(): string { return $this->phoneNumberId; }
    public function getWabaId(): string        { return $this->wabaId; }
    public function getBusinessId(): string    { return $this->businessId; }
    public function getApiVersion(): string    { return $this->apiVersion; }
    public function getAccessToken(): string   { return $this->accessToken; }

    public function post(string $endpoint, array $payload): ApiResponse
    {
        $response = Http::withToken($this->accessToken)
            ->timeout($this->timeout)
            ->post($this->buildUrl($endpoint), $payload);

        return $this->parseResponse($response);
    }

    public function get(string $endpoint, array $query = []): ApiResponse
    {
        $response = Http::withToken($this->accessToken)
            ->timeout($this->timeout)
            ->get($this->buildUrl($endpoint), $query);

        return $this->parseResponse($response);
    }

    public function delete(string $endpoint, array $payload = []): ApiResponse
    {
        $response = Http::withToken($this->accessToken)
            ->timeout($this->timeout)
            ->delete($this->buildUrl($endpoint), $payload);

        return $this->parseResponse($response);
    }

    public function postMultipart(string $endpoint, array $fields): ApiResponse
    {
        $builder = Http::withToken($this->accessToken)->timeout($this->timeout);

        foreach ($fields as $field) {
            if ($field['type'] === 'file') {
                $builder = $builder->attach($field['name'], $field['contents'], $field['filename']);
            } else {
                $builder = $builder->attach($field['name'], $field['contents']);
            }
        }

        $response = $builder->post($this->buildUrl($endpoint));

        return $this->parseResponse($response);
    }

    private function buildUrl(string $endpoint): string
    {
        return rtrim($this->baseUrl, '/') . '/' . $this->apiVersion . '/' . ltrim($endpoint, '/');
    }

    private function parseResponse(HttpResponse $response): ApiResponse
    {
        $data = $response->json() ?? [];

        if ($response->status() === 401) {
            throw new AuthenticationException(
                $data['error']['message'] ?? 'Unauthorized',
                $data['error']['code'] ?? 401,
            );
        }

        if ($response->status() === 429) {
            throw new RateLimitException('Rate limit exceeded', 429);
        }

        if ($response->failed()) {
            throw new WhatsAppApiException(
                $data['error']['message'] ?? 'API request failed',
                $data['error']['code'] ?? $response->status(),
                $data['error']['error_data']['details'] ?? null,
            );
        }

        return new ApiResponse($response->status(), $data);
    }
}
