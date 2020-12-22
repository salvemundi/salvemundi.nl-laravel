<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('AzureID');
            $table->string('DisplayName');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('PhoneNumber')->nullable();
            $table->string('email')->nullable();
            $table->string('ImgPath')->nullable();
            $table->unsignedBigInteger('paymentId');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
