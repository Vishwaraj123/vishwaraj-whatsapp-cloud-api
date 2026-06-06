<?php

use Vishwaraj\WhatsAppCloud\DTO\Messages\TextMessageData;
use Vishwaraj\WhatsAppCloud\Payloads\Messages\TextMessagePayload;

it('builds a basic text payload', function () {
    $data    = new TextMessageData(to: '919999999999', body: 'Hello World');
    $payload = (new TextMessagePayload($data))->toArray();

    expect($payload)->toMatchArray([
        'messaging_product' => 'whatsapp',
        'recipient_type'    => 'individual',
        'to'                => '919999999999',
        'type'              => 'text',
        'text'              => ['preview_url' => false, 'body' => 'Hello World'],
    ]);
});

it('includes context when replying', function () {
    $data    = new TextMessageData(to: '919999999999', body: 'Reply', replyToMessageId: 'wamid.abc');
    $payload = (new TextMessagePayload($data))->toArray();

    expect($payload)->toHaveKey('context')
        ->and($payload['context'])->toBe(['message_id' => 'wamid.abc']);
});

it('enables preview_url when set', function () {
    $data    = new TextMessageData(to: '919999999999', body: 'Check https://example.com', previewUrl: true);
    $payload = (new TextMessagePayload($data))->toArray();

    expect($payload['text']['preview_url'])->toBeTrue();
});
