<?php
namespace App;
use App\Models\Plan;
use Laravel\Cashier\Exceptions\PlanNotFoundException;
use Laravel\Cashier\Plan\Contracts\PlanRepository;
use Illuminate\Support\Facades\Log;
class DatabasePlanRepository implements PlanRepository
{
    /**
     * @param string $name
     * @return null|\Laravel\Cashier\Plan\Contracts\Plan
     */
    public static function find(string $name)
    {
        Log::info($name);
        if($name ==  'contributionCommissie') {
            return Plan::where('name', '1 membership')->first();
        } else {
            return Plan::where('name', '2 membership')->first();
        }
    }

    /**
     * @param string $name
     * @return \Laravel\Cashier\Plan\Contracts\Plan
     * @throws PlanNotFoundException
     */
    public static function findOrFail(string $name)
    {
        Log::info($name);
        if ($name ==  'contributionCommissie') {
            if(Plan::where('name', '1 membership')->first() != null) {
                return Plan::where('name', '1 membership')->first();
            }
        } else {
            if(Plan::where('name', '2 membership')->first() != null) {
                return Plan::where('name', '2 membership')->first();
            }
        }
        throw new PlanNotFoundException;
    }
}