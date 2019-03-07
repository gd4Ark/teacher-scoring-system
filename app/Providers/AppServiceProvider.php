<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){

        view()->composer('layouts.aside', function ($view) {
            $view->with('navList',require_once __DIR__ . '/../../resources/data/navList.php');
        });
    }
}
