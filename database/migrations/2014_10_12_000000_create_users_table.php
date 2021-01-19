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
            // Should not be nullable, botching sumthing here :DDDDd !!!11!11!1!!1!1!!
            $table->string('AzureID')->nullable();
            $table->string('DisplayName');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('PhoneNumber')->nullable();
            $table->string('email')->nullable();
            $table->string('ImgPath')->nullable();
            $table->integer('visibility')->default(1);
            $table->string('mollie_customer_id')->nullable();
            $table->string('mollie_mandate_id')->nullable();
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
