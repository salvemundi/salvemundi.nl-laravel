<?php

namespace App\Providers;
use App\DatabaseCouponRespository;
use App\DatabasePlanRepository;
use App\Http\Responses\LogoutResponse;
use App\Models\AdminSetting;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Commissie;
use Laravel\Cashier\Coupon\Contracts\CouponRepository;
use Laravel\Cashier\Plan\Contracts\PlanRepository;
use Laravel\Pulse\Facades\Pulse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
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
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Pulse::user(fn ($user) => [
            'name' => $user->getDisplayName(),
            'extra' => $user->email
        ]);
        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
        });

        try {
            view()->share(['Commissies'=> Commissie::all(),'introSetting' => AdminSetting::where('settingName','intro')->first(),'introConfirmSetting' => AdminSetting::where('settingName','introConfirm')->first()]);
        }
        catch (\Exception $e)
        {

        }

    }
}
