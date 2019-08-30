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
    public function boot()
    {
        view()->share('errors', '');
        view()->share('request_params', '');
        view()->share('login_success', '');
    }

    public function register()
    {
        //
//        $this->app->bind('HomeService', function ($app) {
//            return new \App\Http\Services\HomeService($app);
//        });

        $this->app->bind('HomeService', \App\Http\Services\HomeService::class);
        $this->app->bind('AccountService', \App\Http\Services\AccountService::class);


    }
}
