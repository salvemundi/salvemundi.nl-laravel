<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Order\OrderItemPreprocessorCollection;
use Money\Currency;
use Money\Money;
use Laravel\Cashier\Plan\Contracts\Plan as PlanImplements;


class Plan extends Model implements PlanImplements
{
    protected $fillable = [
        'name', 'amount', 'interval', 'description', 'currency','firstPaymentDescription','firstPaymentAmount'
    ];

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
        return $this->attributes['interval'];

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

    }

    /**
     * @return string
     */
    public function firstPaymentMethod()
    {


    }

    /**
     * @param string $firstPaymentMethod
     * @return Plan
     */
    public function setFirstPaymentMethod(?string $firstPaymentMethod)
    {

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

    }

    /**
     * @return string
     */
    public function firstPaymentWebhookUrl()
    {
        return route('webhooks.mollie');

    }

    /**
     * @param string $webhookUrl
     * @return Plan
     */
    public function setFirstPaymentWebhookUrl(string $webhookUrl)
    {
    }

    /**
     * @return \Laravel\Cashier\Order\OrderItemPreprocessorCollection
     */
    public function orderItemPreprocessors()
    {

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