<?php

namespace App\Jobs;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AzureController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use MichaelLedin\LaravelJob\FromParameters;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class DisableAzure implements ShouldQueue, FromParameters
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $collection;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $users)
    {
        $this->collection = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userColl = $this->collection;
        foreach($userColl as $userObject) {
            if ($userObject instanceof User) {
                AzureController::accountEnabled(false, $userObject);
            } else {
                throw new ModelNotFoundException("Given collection is not of type user!");
            }
        }
    }

    public static function fromParameters(...$parameters): DisableAzure
    {
        return new self($parameters[0]);
    }
}
