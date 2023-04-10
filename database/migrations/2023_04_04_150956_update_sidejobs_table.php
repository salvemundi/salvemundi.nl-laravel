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
            $table->float('minAmountOfHoursPerWeek')->nullable();
            $table->float('maxAmountOfHoursPerWeek')->nullable();
            $table->float('minSalaryEuroBruto')->nullable();
            $table->float('maxSalaryEuroBruto')->nullable();
            $table->string('linkToJobOffer')->nullable();
            $table->string('emailContact')->nullable();
            $table->string('phoneNumberContact')->nullable();
            $table->string('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->myDropColumnIfExists('side_job_bank', 'city');
        $this->myDropColumnIfExists('side_job_bank', 'minAmountOfHoursPerWeek');
        $this->myDropColumnIfExists('side_job_bank', 'maxAmountOfHoursPerWeek');
        $this->myDropColumnIfExists('side_job_bank', 'minSalaryEuroBruto');
        $this->myDropColumnIfExists('side_job_bank', 'maxSalaryEuroBruto');
        $this->myDropColumnIfExists('side_job_bank', 'linkToJobOffer');
        $this->myDropColumnIfExists('side_job_bank', 'emailContact');
        $this->myDropColumnIfExists('side_job_bank', 'phoneNumberContact');
        $this->myDropColumnIfExists('side_job_bank', 'position');

    }

    private function myDropColumnIfExists($myTable, $column)
    {
        if (Schema::hasColumn($myTable, $column)) //check the column
        {
            Schema::table($myTable, function (Blueprint $table) use ($column) {
                $table->dropColumn($column); //drop it
            });
        }

    }
}
