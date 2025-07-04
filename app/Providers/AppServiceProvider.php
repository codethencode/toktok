<?php

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Pushover\PushoverChannel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
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
