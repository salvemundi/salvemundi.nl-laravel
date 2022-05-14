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
        // return Plan::where('name', $name)->first();
    }

    /**
     * @param string $name
     * @return \Laravel\Cashier\Plan\Contracts\Plan
     * @throws PlanNotFoundException
     */
    public static function findOrFail(string $name)
    {
        // if (($result = Plan::where('name', $name)->first()) != null) {
        //     return $result;
        // } else {
        //     throw new PlanNotFoundException;
        // }
    }
}