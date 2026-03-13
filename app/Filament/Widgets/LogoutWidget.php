<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Session;

class LogoutWidget extends Widget
{
    protected static string $view = 'filament.widgets.logout-widget';

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}