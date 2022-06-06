<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class getUsersThatNeedToPay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $currentDate = Carbon::now();
        $results = DB::select('select id,owner_id from subscriptions where cycle_ends_at <= ' . $currentDate->format('Ymd'));

        foreach($results as $result) {
            DB::delete('delete from subscriptions where id = ' . $result->id);
            DB::update('update users set mollie_mandate_id = NULL, mollie_customer_id = NULL where id = '. $result->owner_id);
        }

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}