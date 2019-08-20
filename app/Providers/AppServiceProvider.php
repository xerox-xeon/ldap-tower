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
//        $this->app->bind('HomeService', function ($app) {
//            return new \App\Http\Services\HomeService($app);
//        });

        $this->app->bind('HomeService', \App\Http\Services\HomeService::class);


    }
}
