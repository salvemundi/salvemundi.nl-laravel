<?php

namespace App\Listeners;

use App\Enums\paymentStatus;
use App\Http\Controllers\AzureController;
use App\Mail\SendMailInschrijving;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Events\FirstPaymentPaid;


class CreateAccountListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FirstPaymentPaid  $event
     * @return void
     */
    public function handle(FirstPaymentPaid $event)
    {
        $userMandate = $event->payment;
        $userObject = User::where('mollie_mandate_id',$userMandate)->first();
        $registration = $userObject->inschrijving;
        $Password  = AzureController::createAzureUser($userObject->inschrijving);
         Mail::to($registration->email)
             ->send(new SendMailInschrijving($registration->firstName, $registration->lastName, $registration->insertion, paymentStatus::paid, $Password));
    }
}
