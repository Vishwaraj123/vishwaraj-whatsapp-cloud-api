<?php

namespace Vishwaraj\WhatsAppCloud\Services;

use Vishwaraj\WhatsAppCloud\Client\WhatsAppClient;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MediaInfoResponse;
use Vishwaraj\WhatsAppCloud\DTO\Responses\MediaUploadResponse;
use Vishwaraj\WhatsAppCloud\Exceptions\MediaException;
use Illuminate\Support\Facades\Http;

class MediaService
{
    public function __construct(private readonly WhatsAppClient $client) {}

    public function upload(string $filePath): MediaUploadResponse
    {
        if (! file_exists($filePath)) {
            throw new MediaException("File not found: {$filePath}");
        }

        $filename = basename($filePath);
        $contents = file_get_contents($filePath);

        $fields = [
            ['name' => 'messaging_product', 'contents' => 'whatsapp', 'type' => 'text'],
            ['name' => 'file', 'contents' => $contents, 'filename' => $filename, 'type' => 'file'],
        ];

        $response = $this->client->postMultipart(
            "{$this->client->getPhoneNumberId()}/media",
            $fields,
        );

        return MediaUploadResponse::fromArray($response->body());
    }

    public function get(string $mediaId): MediaInfoResponse
    {
        $response = $this->client->get($mediaId);
        return MediaInfoResponse::fromArray($response->body());
    }

    public function delete(string $mediaId): bool
    {
        $response = $this->client->delete($mediaId);
        return (bool) $response->get('success', false);
    }

    /**
     * Download media content.
     * If $savePath is given, saves to file and returns the path.
     * Otherwise returns raw binary content.
     */
    public function download(string $mediaId, ?string $savePath = null): string
    {
        $info = $this->get($mediaId);

        $content = Http::withToken($this->client->getAccessToken())
            ->get($info->url)
            ->body();

        if ($savePath) {
            file_put_contents($savePath, $content);
            return $savePath;
        }

        return $content;
    }

    public function downloadUrl(string $mediaId): string
    {
        return $this->get($mediaId)->url;
    }
}
