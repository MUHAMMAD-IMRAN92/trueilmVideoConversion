<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;


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
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::if('allpermission', function ($permission) {
            return auth()->check() && auth()->user()->anycheckPermission($permission);
        });

        Blade::if('permission', function ($permission) {
            return auth()->check() && auth()->user()->checkPermission($permission);
        });


        Gate::define('hasPermission', function ($user, $permission) {
            
            return auth()->check() && auth()->user()->checkPermission($permission);
        });

       

    }
}
