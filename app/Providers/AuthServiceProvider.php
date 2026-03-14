<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as 
ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::provider('credenciales', function ($app, array $config) {
            return new \App\Providers\CredencialAuthProvider();
        });
    }
}
