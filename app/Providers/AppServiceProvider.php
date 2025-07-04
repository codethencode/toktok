<?php

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Pushover\PushoverChannel;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use NotificationChannels\Pushover\Pushover;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    $this->app->bind(Pushover::class, function () {
        return new Pushover(
            new Client(), // <- le client HTTP requis
            config('services.pushover.token'),
            config('services.pushover.user_key')
        );
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Carbon::setLocale('fr');
        App::setLocale('fr');
        Notification::extend('pushover', function ($app) {
        return $app->make(PushoverChannel::class);
        });
    }
}
