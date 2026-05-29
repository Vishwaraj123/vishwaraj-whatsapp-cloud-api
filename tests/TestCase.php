<?php

namespace Vishwaraj\WhatsAppCloud\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Vishwaraj\WhatsAppCloud\WhatsAppCloudServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [WhatsAppCloudServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'WhatsAppCloud' => \Vishwaraj\WhatsAppCloud\Facades\WhatsAppCloud::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('whatsapp-cloud-api.access_token',    'test-token');
        $app['config']->set('whatsapp-cloud-api.phone_number_id', '123456789');
        $app['config']->set('whatsapp-cloud-api.waba_id',         'waba-123');
        $app['config']->set('whatsapp-cloud-api.business_id',     'biz-123');
        $app['config']->set('whatsapp-cloud-api.api_version',     'v22.0');
    }
}
