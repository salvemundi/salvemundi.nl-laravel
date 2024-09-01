<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\FirstPayment\Traits\PaymentMethodString;
use Laravel\Cashier\Order\OrderItemPreprocessorCollection;
use Laravel\Cashier\Plan\DefaultIntervalGenerator;
use Money\Currency;
use Money\Money;
use Laravel\Cashier\Plan\Contracts\Plan as PlanImplements;
use Laravel\Cashier\Coupon\CouponOrderItemPreprocessor as ProcessCoupons;
use Laravel\Cashier\Order\PersistOrderItemsPreprocessor as PersistOrderItems;
use Laravel\Cashier\Plan\Plan as CashierPlan;

class Plan extends Model implements PlanImplements
{
    use PaymentMethodString;

    protected $fillable = [
        'name', 'amount', 'interval', 'description', 'currency','firstPaymentDescription','firstPaymentCurrency','firstPaymentAmount','firstPaymentMethod'
    ];

    public function buildCashierPlan(): CashierPlan
    {
        $plan = new CashierPlan($this->name);

        return $plan->setAmount(mollie_array_to_money(['value' => $this->amount, 'currency' => $this->attributes['firstPaymentCurrency']]))
            ->setInterval($this->interval)
            ->setDescription($this->attributes['description'])
            ->setFirstPaymentMethod($this->attributes['firstPaymentMethod'])
            ->setFirstPaymentAmount(mollie_array_to_money(['value' => $this->attributes['firstPaymentAmount'], 'currency' => 'EUR']))
            ->setFirstPaymentDescription($this->attributes['firstPaymentDescription']);
    }

    protected $table = 'products';

    public function getCurrency()
    {
        return $this->attributes['currency'];
    }

    public function getCode()
    {
        return $this->attributes['currency'];


    }

    public function amount()
    {
        $currency = new Currency($this->getCode());
        return new Money($this->attributes['amount'] * 100, $currency);
    }

    /**
     * @param \Money\Money $amount
     * @return \Laravel\Cashier\Plan\Contracts\Plan
     */
    public function setAmount(Money $amount)
    {
        $this->attributes['amount'] = $amount->getAmount() / 100;
        return $this;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->attributes['description'];

    }
    public function setDescription(string $description)
    {
        $this->attributes['description'] = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function interval()
    {
        Log::info($this->attributes['interval']);

        return is_array($this->attributes['interval']) ? new $this->attributes['interval']['generator']($this->attributes['interval']) : new DefaultIntervalGenerator($this->attributes['interval']);

    }
    public function setInterval($interval)
    {
        $this->attributes['interval'] = is_array($interval) ? new $interval['generator']($interval) : new DefaultIntervalGenerator($interval);

        return $this;
    }
    /**
     * @return string
     */
    public function name()
    {
        return $this->attributes['name'];
    }

    /**
     * The amount the customer is charged for a mandate payment.
     *
     * @return \Money\Money
     */
    public function firstPaymentAmount()
    {
        $currency = new Currency($this->getCode());
        return new Money($this->attributes['firstPaymentAmount'] * 100, $currency);
    }

    /**
     * @param \Money\Money $firstPaymentAmount
     * @return Plan
     */
    public function setFirstPaymentAmount(Money $firstPaymentAmount)
    {
        $this->attributes['firstPaymentAmount'] = $firstPaymentAmount->getAmount() / 100;
        return $this;
    }
    /**
     * @return string
     */
    public function firstPaymentMethod()
    {
        return $this->attributes['firstPaymentMethod'];
    }

    /**
     * @param string $firstPaymentMethod
     * @return Plan
     */
    public function setFirstPaymentMethod($firstPaymentMethod)
    {
        $this->attributes['firstPaymentMethod'] = $firstPaymentMethod;
        return $this;
    }

    /**
     * The description for the mandate payment order item.
     *
     * @return string
     */
    public function firstPaymentDescription()
    {

        return $this->attributes['firstPaymentDescription'];
    }

    /**
     * @param string $firstPaymentDescription
     * @return Plan
     */
    public function setFirstPaymentDescription(string $firstPaymentDescription)
    {
        $this->firstPaymentDescription = "ello";
        return $this;
    }

    /**
     * @return string
     */
    public function firstPaymentRedirectUrl()
    {
        return route('home');
    }

    /**
     * @param string $redirectUrl
     * @return Plan
     */
    public function setFirstPaymentRedirectUrl(string $redirectUrl)
    {
        $this->attributes['first_payment_redirect_url'] = $redirectUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function firstPaymentWebhookUrl()
    {
        return env("NGROK_LINK") ? env("NGROK_LINK") . "/webhooks/mollie" : route('webhooks.mollie');
    }

    /**
     * @param string $webhookUrl
     * @return Plan
     */
    public function setFirstPaymentWebhookUrl(string $webhookUrl)
    {
        $this->attributes['first_payment_webhook_url'] = $webhookUrl;
        return $this;
    }

    /**
     * @return \Laravel\Cashier\Order\OrderItemPreprocessorCollection
     */
    public function orderItemPreprocessors()
    {
        // $coll = new OrderItemPreprocessorCollection();
        // return $coll::fromArray([ProcessCoupons::class,PersistOrderItems::class]);
    }

    /**
     * @param \Laravel\Cashier\Order\OrderItemPreprocessorCollection $preprocessors
     * @return \Laravel\Cashier\Plan\Contracts\Plan
     */
    public function setOrderItemPreprocessors(OrderItemPreprocessorCollection $preprocessors)
    {
        $this->orderItemPreprocessors = $preprocessors;
        return $this;
    }
}