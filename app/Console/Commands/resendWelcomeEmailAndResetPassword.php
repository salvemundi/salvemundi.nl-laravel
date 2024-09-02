<?php

namespace App\Console\Commands;

use App\Enums\paymentStatus;
use App\Http\Controllers\AzureController;
use App\Mail\SendMailInschrijving;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Microsoft\Graph\Model;

class resendWelcomeEmailAndResetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samu:resend-welcome-email {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resend the welcome email and reset the password for a user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = User::find($this->argument('userId'));
        if ($user == null) {
            $this->error('User not found' . PHP_EOL);
            return;
        }
        if ($user->hasActiveSubscription() && isset($user->AzureID)) {
            $password = Str::random(41);
            $graphInstance = AzureController::connectToAzure();
            // reset password using graph api
            $graphInstance->createRequest("POST", "/users/" . $user->AzureID . "/authentication/methods/28c10230-6103-485e-b985-444c60001490/resetPassword")
                ->addHeaders(array("Content-Type" => "application/json"))
                ->setReturnType(Model\User::class)
                ->attachBody(json_encode(array("password" => $password, "forceChangePasswordNextSignIn" => true)))
                ->execute();
            Mail::to($user->inschrijving->email)
                ->send(new SendMailInschrijving($user->FirstName, $user->LastName, $user->insertion, paymentStatus::paid, $password, $user->email));
            $this->info('Welcome email and password reset sent to user ' . $user->id . ", " . $user->getDisplayName() . PHP_EOL);
        } else {
            $this->error('User does not have an active subscription or AzureID is not set' . PHP_EOL);
        }
    }
}