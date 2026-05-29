<?php

use Illuminate\Support\Facades\Http;
use Vishwaraj\WhatsAppCloud\Tests\TestCase;
use Vishwaraj\WhatsAppCloud\Facades\WhatsAppCloud;

uses(TestCase::class);

it('sends a simple template message', function () {
    Http::fake(['*' => Http::response([
        'messaging_product' => 'whatsapp',
        'contacts'          => [['input' => '919999999999', 'wa_id' => '919999999999']],
        'messages'          => [['id' => 'wamid.tmpl1']],
    ], 200)]);

    $response = WhatsAppCloud::template()
        ->to('919999999999')
        ->name('hello_world')
        ->language('en_US')
        ->send();

    expect($response->messageId())->toBe('wamid.tmpl1');

    Http::assertSent(function ($req) {
        $tmpl = $req->data()['template'];
        return $tmpl['name'] === 'hello_world'
            && $tmpl['language']['code'] === 'en_US';
    });
});

it('sends template with body variables', function () {
    Http::fake(['*' => Http::response([
        'messaging_product' => 'whatsapp',
        'contacts'          => [],
        'messages'          => [['id' => 'wamid.tmpl2']],
    ], 200)]);

    WhatsAppCloud::template()
        ->to('919999999999')
        ->name('promo')
        ->language('en_US')
        ->body(['John', 'SAVE25', '25%'])
        ->send();

    Http::assertSent(function ($req) {
        $comps = $req->data()['template']['components'];
        return $comps[0]['type'] === 'body'
            && count($comps[0]['parameters']) === 3
            && $comps[0]['parameters'][0]['text'] === 'John';
    });
});

it('sends template with header image url', function () {
    Http::fake(['*' => Http::response([
        'messaging_product' => 'whatsapp',
        'contacts'          => [],
        'messages'          => [['id' => 'wamid.tmpl3']],
    ], 200)]);

    WhatsAppCloud::template()
        ->to('919999999999')
        ->name('media_promo')
        ->language('en_US')
        ->headerImageUrl('https://example.com/banner.jpg')
        ->body(['Mark'])
        ->send();

    Http::assertSent(function ($req) {
        $comps = $req->data()['template']['components'];
        $header = collect($comps)->firstWhere('type', 'header');
        return $header !== null
            && $header['parameters'][0]['type'] === 'image'
            && $header['parameters'][0]['image']['link'] === 'https://example.com/banner.jpg';
    });
});

it('sends template with quick reply button', function () {
    Http::fake(['*' => Http::response([
        'messaging_product' => 'whatsapp',
        'contacts'          => [],
        'messages'          => [['id' => 'wamid.tmpl4']],
    ], 200)]);

    WhatsAppCloud::template()
        ->to('919999999999')
        ->name('issue_resolution')
        ->language('en_US')
        ->body(['Mr. Jones'])
        ->quickReplyButton(0, 'YES')
        ->quickReplyButton(1, 'NO')
        ->send();

    Http::assertSent(function ($req) {
        $comps  = $req->data()['template']['components'];
        $buttons = array_filter($comps, fn ($c) => $c['type'] === 'button');
        return count($buttons) === 2;
    });
});
