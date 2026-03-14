<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

class FilamentMenuServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Registrar nuestra vista personalizada en el hook del menú
        Filament::registerRenderHook(
            'user-menu.start',
            fn (): string => 
view('vendor.filament.components.user-menu')->render()
        );
    }

    public function register(): void
    {
        //
    }
}
