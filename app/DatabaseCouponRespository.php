<?php
namespace App;
use App\Models\Coupon;
use Laravel\Cashier\Coupon\FixedDiscountHandler;
use Laravel\Cashier\Exceptions\CouponNotFoundException;
use Laravel\Cashier\Coupon\Contracts\CouponRepository;
use Illuminate\Support\Facades\Log;
class DatabaseCouponRespository implements CouponRepository
{
    /**
     * @param string $name
     */
    public function find(string $name): ?\Laravel\Cashier\Coupon\Coupon
    {
        $coupon = Coupon::where('name', $name)->first();

        if (is_null($coupon)) {
            return null;
        }

        if($coupon->isOneTimeUse && $coupon->hasBeenUsed) {
            return null;
        }

        return $this->buildCoupon($coupon);
    }

    /**
     * @param string $name
     * @throws CouponNotFoundException
     */
    public function findOrFail(string $name): ?\Laravel\Cashier\Coupon\Coupon
    {
        if (($coupon = Coupon::where('name', $name)->first()) != null) {
            if($coupon->isOneTimeUse && $coupon->hasBeenUsed) {
                return null;
            }
            return $this->buildCoupon($coupon);
        } else {
            throw new CouponNotFoundException();
        }
    }

    protected function buildCoupon(Coupon $coupon): \Laravel\Cashier\Coupon\Coupon
    {
        $couponArr = [
            'context' => [
                'description' => $coupon->description,
                'discount' => [
                    'currency' => $coupon->currency,
                    'value' => $coupon->value
                ]
            ]
        ];

        $coupon = new \Laravel\Cashier\Coupon\Coupon($coupon->name, $coupon->handler(), $couponArr['context']);

        return $coupon->withTimes($coupon->times());
    }
}