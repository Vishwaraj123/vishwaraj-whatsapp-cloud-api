<?php

use Illuminate\Support\Facades\Http;
use Vishwaraj\WhatsAppCloud\Tests\TestCase;
use Vishwaraj\WhatsAppCloud\Facades\WhatsAppCloud;

uses(TestCase::class);

it('sends a text message and returns MessageResponse', function () {
    Http::fake([
        '*' => Http::response([
            'messaging_product' => 'whatsapp',
            'contacts'          => [['input' => '919999999999', 'wa_id' => '919999999999']],
            'messages'          => [['id' => 'wamid.test1']],
        ], 200),
    ]);

    $response = WhatsAppCloud::text()
        ->to('919999999999')
        ->body('Hello')
        ->send();

    expect($response->messageId())->toBe('wamid.test1');
});

it('sends a text message with preview url enabled', function () {
    Http::fake([
        '*' => Http::response([
            'messaging_product' => 'whatsapp',
            'contacts'          => [['input' => '919999999999', 'wa_id' => '919999999999']],
            'messages'          => [['id' => 'wamid.test2']],
        ], 200),
    ]);

    $response = WhatsAppCloud::text()
        ->to('919999999999')
        ->body('Check https://example.com')
        ->previewUrl()
        ->send();

    expect($response->messageId())->toBe('wamid.test2');

    Http::assertSent(function ($request) {
        $body = $request->data();
        return $body['text']['preview_url'] === true;
    });
});

it('sends a reply to a previous message', function () {
    Http::fake([
        '*' => Http::response([
            'messaging_product' => 'whatsapp',
            'contacts'          => [['input' => '919999999999', 'wa_id' => '919999999999']],
            'messages'          => [['id' => 'wamid.test3']],
        ], 200),
    ]);

    WhatsAppCloud::text()
        ->to('919999999999')
        ->body('Reply here')
        ->replyTo('wamid.original')
        ->send();

    Http::assertSent(function ($request) {
        $body = $request->data();
        return isset($body['context']) && $body['context']['message_id'] === 'wamid.original';
    });
});
