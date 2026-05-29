<?php

use Vishwaraj\WhatsAppCloud\DTO\Templates\TemplateParameterData;

it('creates a text parameter', function () {
    $p = TemplateParameterData::text('Hello');
    expect($p->type)->toBe('text')->and($p->value)->toBe('Hello');
});

it('creates a currency parameter', function () {
    $p = TemplateParameterData::currency('$100', 'USD', 100000);
    expect($p->type)->toBe('currency')
        ->and($p->value['code'])->toBe('USD')
        ->and($p->value['amount_1000'])->toBe(100000);
});

it('creates an image parameter with link', function () {
    $p = TemplateParameterData::image('https://example.com/img.jpg');
    expect($p->type)->toBe('image')->and($p->value)->toBe(['link' => 'https://example.com/img.jpg']);
});

it('creates an image parameter with id', function () {
    $p = TemplateParameterData::imageId('media-123');
    expect($p->type)->toBe('image')->and($p->value)->toBe(['id' => 'media-123']);
});

it('creates a payload parameter', function () {
    $p = TemplateParameterData::payload('YES');
    expect($p->type)->toBe('payload')->and($p->value)->toBe('YES');
});

it('creates an action parameter', function () {
    $p = TemplateParameterData::action(['flow_token' => 'tok-123']);
    expect($p->type)->toBe('action')->and($p->value)->toBe(['flow_token' => 'tok-123']);
});
