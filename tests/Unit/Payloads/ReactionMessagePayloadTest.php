<?php

use Vishwaraj\WhatsAppCloud\DTO\Messages\ReactionMessageData;
use Vishwaraj\WhatsAppCloud\Payloads\Messages\ReactionMessagePayload;

it('builds a reaction payload', function () {
    $data    = new ReactionMessageData(to: '919999999999', messageId: 'wamid.abc', emoji: '👍');
    $payload = (new ReactionMessagePayload($data))->toArray();

    expect($payload['type'])->toBe('reaction')
        ->and($payload['reaction'])->toMatchArray(['message_id' => 'wamid.abc', 'emoji' => '👍']);
});

it('builds a remove-reaction payload with empty emoji', function () {
    $data    = new ReactionMessageData(to: '919999999999', messageId: 'wamid.abc', emoji: '');
    $payload = (new ReactionMessagePayload($data))->toArray();

    expect($payload['reaction']['emoji'])->toBe('');
});
