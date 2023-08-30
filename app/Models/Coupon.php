<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Coupon\Contracts\AcceptsCoupons;
use Laravel\Cashier\Coupon\Contracts\CouponHandler;
use Laravel\Cashier\Coupon\FixedDiscountHandler;
use Laravel\Cashier\Coupon\RedeemedCoupon;
use Laravel\Cashier\Exceptions\CouponException;
use Laravel\Cashier\Order\OrderItemCollection;

class Coupon extends Model
{
    use HasFactory;

    protected $table = "coupons";
    protected $fillable = ['name','isOneTimeuse','hasBeenUsed','description','currency','value'];

    protected $times = 1;
    protected $handler;
    protected $context;

    public function __construct(array $context = [])
    {
        $this->context = $context;
        $this->handler = new FixedDiscountHandler();
        $this->handler->withContext($context);
    }
    /**
     * @return CouponHandler
     */
    public function handler()
    {
        return $this->handler;
    }
}
