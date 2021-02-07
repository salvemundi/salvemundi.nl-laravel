<?php

namespace App\Http\Controllers;

use App\Mail\SendMailInschrijvingTransactie;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Order\Order;
use Laravel\Cashier\SubscriptionBuilder\RedirectToCheckoutResponse;
use Mollie\Laravel\Facades\Mollie;
use App\Enums\paymentType;
use App\Models\AzureUser;
use App\Models\Inschrijving;
use Illuminate\Http\Request;

/// I AM NOT PROUD OF THIS CONTROLLER, IF YOU CAN DO IT BETTER PLEASE PR :)

class MolliePaymentController extends Controller
{
    public static function processRegistration($orderObject, $productIndex, $route = null): RedirectResponse
    {
        if($productIndex == paymentType::contribution){
            $checkIfUserExists = User::where([
                ['FirstName', $orderObject->firstName],
                ['LastName', $orderObject->lastName]
                ])->first();

            $newUser = new User;
            //$newUser->AzureID = $fetchedUser->getId();
            $newUser->DisplayName = $orderObject->firstName." ".$orderObject->lastName;
            $newUser->FirstName = $orderObject->firstName;
            $newUser->LastName = $orderObject->lastName;
            $newUser->phoneNumber = $orderObject->phoneNumber;
            if($checkIfUserExists == null){
                $newUser->email = $orderObject->firstName.".".$orderObject->lastName."@lid.salvemundi.nl";
            } else {
                $birthDayDay = date("d", strtotime($orderObject->birthday));
                $newUser->email = $orderObject->firstName.".".$orderObject->lastName.$birthDayDay."@lid.salvemundi.nl";
            }
            $newUser->ImgPath = "images/SalveMundi-Vector.svg";
            $newUser->save();
            $newUser->inschrijving()->save($orderObject);
            $newUser->save();
            $createPayment = MolliePaymentController::preparePayment($productIndex, $newUser);
            $getProductObject = Product::where('index', paymentType::contribution)->first();
            $transaction = new Transaction();
            $transaction->product()->associate($getProductObject);
            $transaction->save();
            $orderObject->payment()->associate($transaction);
            $orderObject->save();
            return $createPayment;
        } else{
            $createPayment = MolliePaymentController::preparePayment($productIndex, null, $route);
            $getProductObject = Product::where('index', $productIndex)->first();
            if($getProductObject == null)
            {
                $product = Product::find($productIndex);
            }
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

    private static function preparePayment($productIndex, $userObject = null, $route = null)
    {
        $product = Product::where('index', $productIndex)->first();
        if($product == null)
        {
            $product = Product::find($productIndex);
        }
        if($userObject != null)
        {
            return $userObject->newSubscription('main','registration')->create();
        }
        if($route == null) {
            $route = route('home');
        } else {
            $route = route($route);
        }
        // redirect customer to Mollie checkout page
        $formattedPrice = number_format($product->amount, 2, '.', '');
        $priceToString = strval($formattedPrice);
        return Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => "$priceToString"
            ],
            "description" => "$product->description",
            "redirectUrl" => $route,
            "webhookUrl" => route('webhooks.mollie'),
        ]);
    }

    public function index()
    {
        return view('intro');
    }

    private static function createSubscription($plan,$id)
    {
        $user = User::where('AzureID',$id)->first();
        $azureUser = AzureUser::where('AzureID',$id)->first();
        $plan = paymentType::fromValue($plan);
        $name = ucfirst($plan) . ' membership';
        Log::info($plan);
        if(!$user->subscribed($name, $plan->key)) {

            $getProductObject = Product::where('index',$plan)->first();

            $result = $user->newSubscription($name, $plan->key)->create();
            $transaction = new Transaction();
            $transaction->product()->associate($getProductObject);
            $transaction->save();
            $transaction->contribution()->attach($azureUser);
            $transaction->save();

            if(is_a($result, RedirectToCheckoutResponse::class)) {
                return $result;
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
    public static function handleContributionPaymentFirstTime(Request $request)
    {
        return MolliePaymentController::createSubscription(paymentType::contribution, session('id'));
    }

    public function cancelSubscription(Request $request)
    {
        $userId = $request->input('userId');
        $userObject = User::where('AzureID', $userId);
        $plan = paymentType::fromValue(3);
        $name = ucfirst($plan) . ' membership';
        if($userObject->subscribed($name, $plan->key))
        {
            $userObject->subscription($name,$plan->key)->cancel();
        }
        return redirect('/myAccount');
    }
}
