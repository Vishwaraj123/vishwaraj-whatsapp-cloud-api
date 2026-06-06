<?php

namespace Vishwaraj\WhatsAppCloud;

use Illuminate\Support\ServiceProvider;
use Vishwaraj\WhatsAppCloud\Client\WhatsAppClient;

class WhatsAppCloudServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../resources/config/whatsapp-cloud-api.php',
            'whatsapp-cloud-api'
        );

        $this->app->singleton(WhatsAppClient::class, function ($app) {
            return new WhatsAppClient(
                accessToken:   config('whatsapp-cloud-api.access_token', ''),
                phoneNumberId: config('whatsapp-cloud-api.phone_number_id', ''),
                wabaId:        config('whatsapp-cloud-api.waba_id', ''),
                businessId:    config('whatsapp-cloud-api.business_id', ''),
                apiVersion:    config('whatsapp-cloud-api.api_version', 'v22.0'),
                baseUrl:       config('whatsapp-cloud-api.base_url', 'https://graph.facebook.com'),
                timeout:       (int) config('whatsapp-cloud-api.timeout', 60),
            );
        });

        $this->app->singleton(WhatsAppCloudManager::class, function ($app) {
            return new WhatsAppCloudManager($app->make(WhatsAppClient::class));
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/config/whatsapp-cloud-api.php' => config_path('whatsapp-cloud-api.php'),
            ], 'whatsapp-cloud-api-config');
        }
    }
}
