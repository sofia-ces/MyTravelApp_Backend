<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Auth\LoginServiceInterface;
use App\Services\Auth\LoginService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(LoginServiceInterface::class, LoginService::class);
    }

    public function boot()
    {
        //
    }
}