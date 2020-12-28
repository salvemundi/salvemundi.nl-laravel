<?php

namespace App\Http\Controllers;

use App\Enums\paymentType;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentController extends Controller
{
    public static function processRegistration($orderObject, $productIndex): RedirectResponse
    {
        $createPayment = MolliePaymentController::preparePayment($productIndex);
        $transaction = new Transaction();
        $transaction->transactionId = $createPayment->id;
        $transaction->product()->associate(Product::where('index', $productIndex));
        $transaction->save();

        $orderObject->payment()->associate($transaction);
        $orderObject->save();
        if($productIndex == 2)
        {
            AzureController::createAzureUser($orderObject);
        }
        return redirect()->away($createPayment->getCheckoutUrl(), 303);
    }
    private static function preparePayment($productIndex)
    {
        $product = Product::where('index', $productIndex)->first();
        // redirect customer to Mollie checkout page
        $formattedPrice = number_format($product->price, 2, '.', '');
        $priceToString = strval($formattedPrice);
        return Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => "$priceToString" // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "$product->description",
            "redirectUrl" => route('intro'),
            "webhookUrl" => route('webhooks.mollie'),
        ]);
        //return redirect()->away($payment->getCheckoutUrl(), 303);
    }

    public function index()
    {
        return view('intro');
    }

    /**
     * After the customer has completed the transaction,
     * you can fetch, check and process the payment.
     * This logic typically goes into the controller handling the inbound webhook request.
     * See the webhook docs in /docs and on mollie.com for more information.
     */
}
;