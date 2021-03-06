<?php

namespace App\Providers;

use App\Services\ModulesService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });
        $this->app->singleton(ModulesService::class, function ($app) {
            return new ModulesService();
        });
    }
}
