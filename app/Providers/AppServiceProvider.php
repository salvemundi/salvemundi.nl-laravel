<?php

namespace App\Providers;

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
        //
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
