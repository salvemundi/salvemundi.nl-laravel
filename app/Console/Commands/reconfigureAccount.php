<?php

namespace App\Console\Commands;

use App\Http\Controllers\MollieWebhookController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Laravel\Cashier\Mollie\GetMolliePayment;
use Mollie\Api\MollieApiClient;

class reconfigureAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samu:reconfigure-account {transactionId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reconfigure the account of a user by recreating the account in office and re linking it with a valid transaction';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $mollieApiClient = new MollieApiClient();
        $mollieApiClient->setApiKey(env('MOLLIE_KEY'));

        $webhookController = new MollieWebhookController(new GetMolliePayment($mollieApiClient));
        $webhookController->handle(new Request(), $this->argument('transactionId'));
    }
}
