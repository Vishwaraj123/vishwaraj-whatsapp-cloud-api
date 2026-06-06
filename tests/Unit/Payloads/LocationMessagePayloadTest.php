<?php

use Vishwaraj\WhatsAppCloud\DTO\Messages\LocationMessageData;
use Vishwaraj\WhatsAppCloud\Payloads\Messages\LocationMessagePayload;

it('builds a location payload', function () {
    $data    = new LocationMessageData(to: '919999999999', latitude: 18.52, longitude: 73.85, name: 'Pune', address: 'Pune, India');
    $payload = (new LocationMessagePayload($data))->toArray();

    expect($payload['type'])->toBe('location')
        ->and($payload['location'])->toMatchArray([
            'latitude'  => 18.52,
            'longitude' => 73.85,
            'name'      => 'Pune',
            'address'   => 'Pune, India',
        ]);
});

it('omits name and address when not set', function () {
    $data    = new LocationMessageData(to: '919999999999', latitude: 18.52, longitude: 73.85);
    $payload = (new LocationMessagePayload($data))->toArray();

    expect($payload['location'])->not->toHaveKey('name')
        ->and($payload['location'])->not->toHaveKey('address');
});
