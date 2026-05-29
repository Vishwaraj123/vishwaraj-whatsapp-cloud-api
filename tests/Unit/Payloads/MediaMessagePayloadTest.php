<?php

use Vishwaraj\WhatsAppCloud\DTO\Messages\MediaMessageData;
use Vishwaraj\WhatsAppCloud\Enums\MediaType;
use Vishwaraj\WhatsAppCloud\Payloads\Messages\MediaMessagePayload;

it('builds an image payload from url', function () {
    $data    = new MediaMessageData(to: '919999999999', mediaType: MediaType::Image, link: 'https://example.com/img.jpg', caption: 'A photo');
    $payload = (new MediaMessagePayload($data))->toArray();

    expect($payload['type'])->toBe('image')
        ->and($payload['image'])->toMatchArray(['link' => 'https://example.com/img.jpg', 'caption' => 'A photo']);
});

it('builds a document payload from media id with filename', function () {
    $data    = new MediaMessageData(to: '919999999999', mediaType: MediaType::Document, mediaId: 'media-123', filename: 'invoice.pdf');
    $payload = (new MediaMessagePayload($data))->toArray();

    expect($payload['type'])->toBe('document')
        ->and($payload['document'])->toMatchArray(['id' => 'media-123', 'filename' => 'invoice.pdf']);
});

it('prefers id over link', function () {
    $data    = new MediaMessageData(to: '919999999999', mediaType: MediaType::Image, mediaId: 'media-456', link: 'https://example.com/img.jpg');
    $payload = (new MediaMessagePayload($data))->toArray();

    expect($payload['image'])->toHaveKey('id')
        ->and($payload['image'])->not->toHaveKey('link');
});
