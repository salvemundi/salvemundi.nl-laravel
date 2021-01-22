<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('index')->nullable();
            $table->text('description')->nullable();
            $table->double('amount',8,2);
            $table->string('interval')->default('1 year');
            $table->string('currency')->default('EUR');
            $table->text('firstPaymentDescription')->nullable();
            $table->double('firstPaymentAmount')->default(0.01);
            $table->string('firstPaymentCurrency')->default('EUR');
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
        Schema::dropIfExists('products');
    }
}
