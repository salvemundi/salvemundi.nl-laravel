<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\SendMailInschrijvingTransactie;
use App\Models\Coupon;
use App\Models\NonUserActivityParticipant;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Order\Order;
use Laravel\Cashier\SubscriptionBuilder\RedirectToCheckoutResponse;
use Mollie\Laravel\Facades\Mollie;
use App\Enums\paymentType;
use App\Models\Inschrijving;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions;

/// I AM NOT PROUD OF THIS CONTROLLER, IF YOU CAN DO IT BETTER PLEASE PR :)

class MolliePaymentController extends Controller
{
    public static function processRegistration($orderObject, $productIndex, $route = null, $coupon = null,User $userObject = null, $email = null, $nameNotMember = null, $groupSignupPrice = null, $groupId = null): RedirectResponse
    {
        if($productIndex == paymentType::contribution){
            $checkIfUserExists = User::where([
                ['FirstName', $orderObject->firstName],
                ['LastName', $orderObject->lastName]
            ])->first();

            $newUser = new User;
            $firstName = str_replace(' ', '.', $orderObject->firstName);
            $lastName = str_replace(' ', '.', $orderObject->lastName);
            if($orderObject->insertion == null || $orderObject->insertion == "") {
                $newUser->DisplayName = $orderObject->firstName." ".$orderObject->lastName;
                if($checkIfUserExists == null){
                    $newUser->email = $firstName.".".$lastName."@lid.salvemundi.nl";
                } else {
                    $birthDayDay =  rand(1, 31);
                    $newUser->email = $firstName.".".$lastName.$birthDayDay."@lid.salvemundi.nl";
                }
            } else {
                $newUser->DisplayName = $orderObject->firstName." ".$orderObject->insertion." ".$orderObject->lastName;
                $insertion = str_replace(' ', '.', $orderObject->insertion);
                if($checkIfUserExists == null){
                    $newUser->email = $firstName.".".$insertion.".".$lastName."@lid.salvemundi.nl";
                } else {
                    $birthDayDay = date("d", strtotime($orderObject->birthday));
                    $newUser->email = $firstName.".".$insertion.".".$lastName.$birthDayDay."@lid.salvemundi.nl";
                }
            }
            $newUser->FirstName = $orderObject->firstName;
            $newUser->LastName = $orderObject->lastName;
            $newUser->phoneNumber = $orderObject->phoneNumber;

            $newUser->ImgPath = "images/logo.svg";
            $newUser->birthday = $orderObject->birthday ? date("Y-m-d", strtotime($orderObject->birthday)) : null;
            $newUser->save();
            $newUser->inschrijving()->save($orderObject);
            $newUser->save();

            $getProductObject = Product::where('index', paymentType::contribution)->first();
            $transaction = new Transaction();
            $transaction->amount = $getProductObject->amount;
            $transaction->product()->associate($getProductObject);
            $transaction->save();
            $newUser->payment()->attach($transaction);
            $newUser->save();
            $orderObject->payment()->associate($transaction);
            $orderObject->save();
            if($coupon != null){
                $couponObject = Coupon::where('name',$coupon)->first();
                $transaction->coupon()->associate($couponObject);
                $transaction->save();
                $createPayment = MolliePaymentController::preparePayment($productIndex, $newUser, null, $coupon);
            } else{
                $createPayment = MolliePaymentController::preparePayment($productIndex, $newUser);
            }
            $transaction->transactionId = $createPayment->payment()->id;
            $transaction->save();
            return $createPayment;
        } else{
            if($route === null) {
                $route = env("APP_URL");
            }
            $createPayment = MolliePaymentController::preparePayment($orderObject->id, $userObject, $route, null, $email, $nameNotMember, false, $groupSignupPrice);
            if($createPayment === null) {
                if($route === null) {
                    return redirect('/');
                } else {
                    return redirect($route);
                }
            } else {
                $getProductObject = Product::find($orderObject->id);
                if($getProductObject == null)
                {
                    $getProductObject = Product::where('index', $productIndex)->first();
                }
                $transaction = new Transaction();
                if($email != null && $nameNotMember != null){
                    $transaction->name = $nameNotMember;
                    $transaction->email = $email;
                    $transaction->amount = $getProductObject->amount_non_member;
                } else {
                    $transaction->amount = $getProductObject->amount;
                }


                $transaction->transactionId = $createPayment->id;

                $transaction->product()->associate($getProductObject);
                $transaction->save();
                if($getProductObject->isGroupSignup) {
                    foreach(NonUserActivityParticipant::where('groupId', $groupId)->get() as $participant) {
                        $participant->transaction()->associate($transaction)->save();
                    }
                }
                if($userObject != null){
                    $userObject->payment()->attach($transaction);
                    $userObject->save();
                }
                return redirect()->away($createPayment->getCheckoutUrl(), 303);
            }
        }
        return redirect('/');
    }

    private static function preparePayment($productIndex,User $userObject = null, $route = null, $coupon = null, $email = null, $nameNotMember = null, $isSubscription = true, $groupSignupPrice = null)
    {
        $product = Product::where('index', $productIndex)->first();
        if($product == null)
        {
            $product = Product::find($productIndex);
        }
        if($isSubscription)
        {
            $plan = paymentType::fromValue(2);
            $name = ucfirst(strval($plan)) . ' membership';
            if ($coupon != null){
                return $userObject->newSubscription($name,'contribution')->withCoupon($coupon)->create();
            } else{
                return $userObject->newSubscription($name,'contribution')->create();
            }
        }
        if($route == null) {
            $route = route('home');
        }
        // redirect customer to Mollie checkout page
        if($email == null || $email == "" && $nameNotMember == null || $nameNotMember == "") {
            if($product->amount == 0) {
                return null;
            }
            $formattedPrice = number_format($groupSignupPrice ?:$product->amount, 2, '.', '');
        } else {
            $formattedPrice = number_format($groupSignupPrice ?: $product->amount_non_member, 2, '.', '');
            if($product->amount_non_member == 0) {
                return null;
            }
        }

        $priceToString = strval($formattedPrice);
        return Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => "$priceToString"
            ],
            "description" => "$product->name",
            "redirectUrl" => "$route",
            "metadata" => [
                "userId" => $userObject ? $userObject->id : "null",
                "email" => $email ?: "null",
                "notContribution" => "true"
            ],
            "webhookUrl" => env('NGROK_LINK') ? env('NGROK_LINK')."/webhooks/mollie" : route('webhooks.mollie'),
        ]);
    }

    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('intro');
    }

    private static function createSubscription($plan,$coupon = null)
    {
        $user = Auth::user();
        $plan = paymentType::fromValue($plan);
        $name = ucfirst(strval($plan)) . ' membership';
        if(!$user->subscribed($name, $plan->key)) {

            $getProductObject = Product::where('index',$plan)->first();
            $transaction = new Transaction();
            $transaction->product()->associate($getProductObject);
            $transaction->amount = $getProductObject->amount;
            $transaction->save();
            $transaction->contribution()->attach($user);
            $transaction->save();
            if($coupon != null || $coupon != "") {
                $couponObject = Coupon::where('name',$coupon)->first();
                $transaction->coupon()->associate($couponObject);
                $transaction->save();
                $result = $user->newSubscription($name, $plan->key)->withCoupon($coupon)->create();
            } else {
                $result = $user->newSubscription($name, $plan->key)->create();
            }

            $transaction->transactionId = $result->payment()->id;
            $transaction->save();

            if(is_a($result, RedirectToCheckoutResponse::class)) {
                return $result;
            }
            return back()->with('message', 'Welcome to the ' . $plan . ' plan');
        }
        return back()->with('message', 'You are already on the ' . $plan . ' plan');
    }

    public static function handleContributionPaymentFirstTime(Request $request)
    {
        $user = Auth::user();
        try {
            if ($user->commission()->exists()) {
                return MolliePaymentController::createSubscription(paymentType::contributionCommissie, $request->input('coupon'));
            } else {
                return MolliePaymentController::createSubscription(paymentType::contribution, $request->input('coupon'));
            }
        }
        catch (\Exception $e){
            if ($user->commission()->exists()) {
                return MolliePaymentController::createSubscription(paymentType::contributionCommissie);
            } else {
                return MolliePaymentController::createSubscription(paymentType::contribution);
            }
        }
    }

    public function cancelSubscription(Request $request): Application|Redirector|RedirectResponse
    {
        $user = Auth::user();
        $plan = paymentType::fromValue(3);
        $name = ucfirst(strval($plan)) . ' membership';
        if($user->subscribed($name, $plan->key))
        {
            $user->subscription($name,$plan->key)->cancel();
        }
        return redirect('/mijnAccount');
    }
}
