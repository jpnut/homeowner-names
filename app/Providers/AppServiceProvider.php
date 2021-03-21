<?php

namespace App\Providers;

use App\Contracts\HomeownerNameParser as HomeownerNameParserContract;
use App\HomeownerNameParser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HomeownerNameParserContract::class, function ($app) {
            return new HomeownerNameParser;
        });
    }
}
