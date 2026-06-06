<?php

use Vishwaraj\WhatsAppCloud\DTO\Responses\MessageResponse;

it('extracts messageId from response', function () {
    $response = MessageResponse::fromArray([
        'messaging_product' => 'whatsapp',
        'contacts'          => [['input' => '919999999999', 'wa_id' => '919999999999']],
        'messages'          => [['id' => 'wamid.abc123']],
    ]);

    expect($response->messageId())->toBe('wamid.abc123')
        ->and($response->waId())->toBe('919999999999');
});

it('returns null when messages array is empty', function () {
    $response = MessageResponse::fromArray([
        'messaging_product' => 'whatsapp',
        'contacts'          => [],
        'messages'          => [],
    ]);

    expect($response->messageId())->toBeNull()
        ->and($response->waId())->toBeNull();
});
