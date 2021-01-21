<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('insertion')->nullable();
            $table->string('lastName');
            $table->date('birthday');
            $table->string('email');
            $table->string('phoneNumber');
            $table->unsignedBigInteger('userId')->nullable();
            $table->foreign('userId')->references('id')->on('users');
            $table->unsignedBigInteger('officeId')->nullable();
            $table->foreign('officeId')->references('id')->on('users');
            $table->unsignedBigInteger('paymentId')->nullable()->index();
            $table->foreign('paymentId')->references('id')->on('transaction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register');
    }
}
