<?php

namespace App\Providers;

use App\Services\LetterService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LetterService::class, function ($app) {
            $subTypeId = request()->route('outgoing_mail');
            return new LetterService($subTypeId);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
