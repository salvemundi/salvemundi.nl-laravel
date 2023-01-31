<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIntroductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('introduction', function (Blueprint $table) {
        $table->unsignedBigInteger('paymentId')->nullable()->index();
        $table->foreign('paymentId')->references('id')->on('transaction');
        $table->string('firstNameParent')->nullable();
        $table->string('lastNameParent')->nullable();
        $table->string('addressParent')->nullable();
        $table->string('medicalIssues')->nullable();
        $table->string('specials')->nullable();
        $table->string('phoneNumberParent')->nullable();
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
