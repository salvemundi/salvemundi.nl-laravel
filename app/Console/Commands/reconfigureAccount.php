<?php

namespace App\Console\Commands;

use App\Http\Controllers\MollieWebhookController;
use Illuminate\Console\Command;
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
        $webhookController = new MollieWebhookController(new GetMolliePayment(new MollieApiClient()));
        $webhookController->handle(null, $this->argument('transactionId'));
    }
}
