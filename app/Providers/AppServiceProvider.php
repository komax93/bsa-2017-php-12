<?php

namespace App\Providers;

use App\Services\Contract\RentalService as RentalServiceContract;
use App\Services\Contract\ReturnService as ReturnServiceContract;
use App\Services\RentalService;
use App\Services\ReturnService;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

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
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

        $this->app->bind(RentalServiceContract::class, RentalService::class);
        $this->app->bind(ReturnServiceContract::class, ReturnService::class);
    }
}
