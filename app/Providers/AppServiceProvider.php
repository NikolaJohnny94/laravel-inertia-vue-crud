<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Utils\UserUtils;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserUtils::class, function ($app) {
            return new UserUtils($app->make(Request::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
