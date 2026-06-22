<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\MailManager;
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
            return new BrevoTransport($config['api_key']);
        });
    }
}
