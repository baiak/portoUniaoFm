<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\RadioSetting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    //Injete em TODAS as views do sistema
    View::composer('*', function ($view) {
        //cache simples para não consultar o banco toda hora
        $settings = \Illuminate\Support\Facades\Cache::remember('radio_settings', 3600, function () {
            return \App\Models\RadioSetting::first();
        });
        $view->with('settings', $settings);
    });
    }
}
