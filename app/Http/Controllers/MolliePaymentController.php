<?php

namespace App\Http\Controllers;

use App\Mail\SendMailInschrijvingTransactie;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\SubscriptionBuilder\RedirectToCheckoutResponse;
use Mollie\Laravel\Facades\Mollie;
use App\Enums\paymentType;

class MolliePaymentController extends Controller
{
    public static function processRegistration($orderObject, $productIndex): RedirectResponse
    {
        if($productIndex == paymentType::registration){
            $newUser = new User;
            //$newUser->AzureID = $fetchedUser->getId();
            $newUser->DisplayName = $orderObject->firstName." ".$orderObject->lastName;
            $newUser->FirstName = $orderObject->firstName;
            $newUser->LastName = $orderObject->lastName;
            $newUser->phoneNumber = $orderObject->phoneNumber;
            $newUser->email = $orderObject->firstName.".".$orderObject->lastName."@lid.salvemundi.nl";
            $newUser->ImgPath = "images/SalveMundi-Vector.svg";
            $newUser->save();
            $newUser->inschrijving()->save($orderObject);
            $newUser->save();
            $createPayment = MolliePaymentController::preparePayment($productIndex, $newUser);
            $getProductObject = Product::where('index', paymentType::registration)->first();
            $transaction = new Transaction();
            $getLatestOrder = DB::table('orders')->latest()->first();
            $transaction->transactionId = $getLatestOrder->mollie_payment_id;
            $transaction->product()->associate($getProductObject);
            $transaction->save();
            $orderObject->payment()->associate($transaction);
            $orderObject->save();
            return $createPayment;
        } else{
            $createPayment = MolliePaymentController::preparePayment($productIndex);
            $getProductObject = Product::where('index', $productIndex)->first();
            $transaction = new Transaction();
            $transaction->transactionId = $createPayment->id;
            $transaction->product()->associate($getProductObject);
            $transaction->save();

            $orderObject->payment()->associate($transaction);
            $orderObject->save();
            return redirect()->away($createPayment->getCheckoutUrl(), 303);
        }
        return redirect('/');
    }
    private static function preparePayment($productIndex, $userObject = null)
    {
        $product = Product::where('index', $productIndex)->first();
        if($userObject != null)
        {
            //s$product = Product::find('id',$productIndex)->first();
            return $userObject->newSubscription('main','registration')->create();
        }
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

    public static function createSubscription(string $plan,$id)
    {
        $user = User::where('AzureID',$id)->first();

        $name = ucfirst($plan) . ' membership';

        if(!$user->subscribed($name, $plan)) {

            $result = $user->newSubscription($name, $plan)->create();

            if(is_a($result, RedirectToCheckoutResponse::class)) {
                return $result; // Redirect to Mollie checkout
            }
            return back()->with('status', 'Welcome to the ' . $plan . ' plan');
        }
        return back()->with('status', 'You are already on the ' . $plan . ' plan');
    }

    /**
     * After the customer has completed the transaction,
     * you can fetch, check and process the payment.
     * This logic typically goes into the controller handling the inbound webhook request.
     * See the webhook docs in /docs and on mollie.com for more information.
     */


}
;