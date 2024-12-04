<?php

namespace App\Providers;

use App\Services\OutgoingMailService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OutgoingMailService::class, function ($app) {
            $subTypeId = request()->route('outgoing_mail');
            return new OutgoingMailService($subTypeId);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
