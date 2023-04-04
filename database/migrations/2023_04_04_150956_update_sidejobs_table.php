<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSidejobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('side_job_bank', function (Blueprint $table) {
            $table->string('city')->nullable();
            $table->tinyInteger('minAmountOfHoursPerWeek')->nullable();
            $table->tinyInteger('maxAmountOfHoursPerWeek')->nullable();
            $table->integer('minSalaryEuroBruto')->nullable();
            $table->integer('maxSalaryEuroBruto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
