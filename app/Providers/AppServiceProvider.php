<?php

namespace App\Providers;
use App\DatabaseCouponRespository;
use App\DatabasePlanRepository;
use App\Models\AdminSetting;
use Illuminate\Support\ServiceProvider;
use App\Models\Commissie;
use Laravel\Cashier\Coupon\Contracts\CouponRepository;
use Laravel\Cashier\Plan\Contracts\PlanRepository;
use mysql_xdevapi\Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PlanRepository::class, DatabasePlanRepository::class);
        $this->app->bind(CouponRepository::class, DatabaseCouponRespository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            view()->share(['Commissies'=> Commissie::all(),'introSetting' => AdminSetting::where('settingName','intro')->first(),'introConfirmSetting' => AdminSetting::where('settingName','introConfirm')->first()]);
        }
        catch (\Exception $e)
        {

        }

    }
}
