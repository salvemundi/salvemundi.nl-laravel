<?php

namespace App\Providers;
use App\DatabasePlanRepository;
use Illuminate\Support\ServiceProvider;
use App\Models\Commissie;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\Laravel\Cashier\Plan\Contracts\PlanRepository::class, DatabasePlanRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('Commissies', Commissie::all());
    }
}
