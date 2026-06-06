<?php

use Illuminate\Support\Facades\Http;
use Vishwaraj\WhatsAppCloud\Tests\TestCase;
use Vishwaraj\WhatsAppCloud\Facades\WhatsAppCloud;

uses(TestCase::class);

it('sends reply buttons message', function () {
    Http::fake(['*' => Http::response(fakeMessageResponse('wamid.rb1'), 200)]);

    $response = WhatsAppCloud::interactive()
        ->replyButtons()
        ->to('919999999999')
        ->body('Choose an option')
        ->addButton('btn_yes', 'Yes')
        ->addButton('btn_no', 'No')
        ->send();

    expect($response->messageId())->toBe('wamid.rb1');

    Http::assertSent(function ($req) {
        $data = $req->data();
        return $data['type'] === 'interactive'
            && $data['interactive']['type'] === 'button'
            && count($data['interactive']['action']['buttons']) === 2;
    });
});

it('sends a list message', function () {
    Http::fake(['*' => Http::response(fakeMessageResponse('wamid.list1'), 200)]);

    WhatsAppCloud::interactive()
        ->list()
        ->to('919999999999')
        ->body('Pick one')
        ->buttonLabel('Open List')
        ->section('Section 1', [
            ['id' => 'row_1', 'title' => 'Option A', 'description' => 'Desc A'],
        ])
        ->send();

    Http::assertSent(function ($req) {
        $data = $req->data();
        return $data['interactive']['type'] === 'list'
            && $data['interactive']['action']['button'] === 'Open List'
            && count($data['interactive']['action']['sections']) === 1;
    });
});

it('sends a flow message in draft mode', function () {
    Http::fake(['*' => Http::response(fakeMessageResponse('wamid.flow1'), 200)]);

    WhatsAppCloud::interactive()
        ->flow()
        ->to('919999999999')
        ->body('Open flow')
        ->flowId('flow-123')
        ->flowToken('tok-abc')
        ->cta('Start')
        ->draft()
        ->screen('WELCOME')
        ->send();

    Http::assertSent(function ($req) {
        $params = $req->data()['interactive']['action']['parameters'];
        return $params['mode'] === 'draft'
            && $params['flow_id'] === 'flow-123'
            && $params['flow_cta'] === 'Start';
    });
});

// ── Helper ────────────────────────────────────────────────────────────────────

function fakeMessageResponse(string $id): array
{
    return [
        'messaging_product' => 'whatsapp',
        'contacts'          => [['input' => '919999999999', 'wa_id' => '919999999999']],
        'messages'          => [['id' => $id]],
    ];
}
