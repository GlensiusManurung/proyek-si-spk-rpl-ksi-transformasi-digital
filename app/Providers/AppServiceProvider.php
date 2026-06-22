<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\MailManager;
use Brevo\Core\Client\Configuration;
use Brevo\TransactionalEmails\TransactionalEmailsClient;
use GuzzleHttp\Client;
use App\Mail\BrevoTransport;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        $this->app->make(MailManager::class)->extend('brevo', function ($config) {
            $configuration = Configuration::getDefaultConfiguration()
                ->setApiKey('api-key', $config['api_key']);
            
            $apiInstance = new TransactionalEmailsClient(
                new Client(),
                $configuration
            );
            
            return new BrevoTransport($apiInstance);
        });
    }
}
