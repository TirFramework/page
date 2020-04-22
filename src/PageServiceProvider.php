<?php

namespace Tir\Page;


use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/Routes/public.php');

        $this->loadRoutesFrom(__DIR__.'/Routes/admin.php');

        $this->loadMigrationsFrom(__DIR__ .'/Database/Migrations');

        $this->loadViewsFrom(__DIR__.'/Resources/Views', 'page');

        $this->loadTranslationsFrom(__DIR__.'/Resources/Lang/', 'page');

    }
}
