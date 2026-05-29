<?php

use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateSendData;
use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateComponentData;
use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateParameterData;
use Vishwaraj\WhatsAppCloud\Enums\ComponentType;
use Vishwaraj\WhatsAppCloud\Payloads\Templates\TemplateSendPayload;

it('builds a basic template payload', function () {
    $data    = new TemplateSendData(to: '919999999999', name: 'hello_world', languageCode: 'en_US');
    $payload = (new TemplateSendPayload($data))->toArray();

    expect($payload['type'])->toBe('template')
        ->and($payload['template']['name'])->toBe('hello_world')
        ->and($payload['template']['language'])->toBe(['code' => 'en_US'])
        ->and($payload['template']['components'])->toBeEmpty();
});

it('serializes body text parameters', function () {
    $component = new TemplateComponentData(
        type:       ComponentType::Body,
        parameters: [TemplateParameterData::text('John'), TemplateParameterData::text('SAVE25')],
    );
    $data    = new TemplateSendData(to: '919999999999', name: 'promo', languageCode: 'en_US', components: [$component]);
    $payload = (new TemplateSendPayload($data))->toArray();

    $comp = $payload['template']['components'][0];
    expect($comp['type'])->toBe('body')
        ->and($comp['parameters'][0])->toBe(['type' => 'text', 'text' => 'John'])
        ->and($comp['parameters'][1])->toBe(['type' => 'text', 'text' => 'SAVE25']);
});

it('serializes quick_reply button component', function () {
    $component = new TemplateComponentData(
        type:       ComponentType::Button,
        parameters: [TemplateParameterData::payload('YES_PAYLOAD')],
        subType:    'quick_reply',
        index:      0,
    );
    $data    = new TemplateSendData(to: '919999999999', name: 'confirm', languageCode: 'en_US', components: [$component]);
    $payload = (new TemplateSendPayload($data))->toArray();

    $comp = $payload['template']['components'][0];
    expect($comp['sub_type'])->toBe('quick_reply')
        ->and($comp['index'])->toBe('0')
        ->and($comp['parameters'][0])->toBe(['type' => 'payload', 'payload' => 'YES_PAYLOAD']);
});

it('serializes header image parameter', function () {
    $component = new TemplateComponentData(
        type:       ComponentType::Header,
        parameters: [TemplateParameterData::image('https://example.com/img.jpg')],
    );
    $data    = new TemplateSendData(to: '919999999999', name: 'media_promo', languageCode: 'en_US', components: [$component]);
    $payload = (new TemplateSendPayload($data))->toArray();

    $comp = $payload['template']['components'][0];
    expect($comp['parameters'][0])->toBe(['type' => 'image', 'image' => ['link' => 'https://example.com/img.jpg']]);
});
