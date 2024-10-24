<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpgradeToCashierV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('amount_refunded')->after('total_due')->default(0);
            $table->unsignedInteger('amount_charged_back')->after('amount_refunded')->default(0);
        });

        Schema::create('refunds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('owner_type');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('original_order_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('mollie_refund_id');
            $table->string('mollie_refund_status');
            $table->integer('total');
            $table->string('currency', 3);
            $table->timestamps();
        });

        Schema::create('refund_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('refund_id');
            $table->unsignedBigInteger('original_order_item_id')->nullable();
            $table->string('owner_type');
            $table->unsignedBigInteger('owner_id');
            $table->string('description');
            $table->text('description_extra_lines')->nullable();
            $table->string('currency', 3);
            $table->unsignedInteger('quantity');
            $table->integer('unit_price');
            $table->decimal('tax_percentage', 6, 4);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('mollie_payment_id');
            $table->string('mollie_payment_status');
            $table->string('mollie_mandate_id')->nullable();
            $table->string('owner_type');
            $table->unsignedBigInteger('owner_id');
            $table->string('currency', 3);
            $table->unsignedInteger('amount')->default(0);
            $table->unsignedInteger('amount_refunded')->default(0);
            $table->unsignedInteger('amount_charged_back')->default(0);
            $table->text('first_payment_actions')->nullable();
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
        // Requires "doctrine/dbal" in composer.json
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->dropColumn(['amount_refunded', 'amount_charged_back']);
        // });

        Schema::dropIfExists('refunds');
        Schema::dropIfExists('refund_items');
        Schema::dropIfExists('payments');
    }
}