<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_merch_transaction', function (Blueprint $table) {
            $table->boolean('isPreOrder')->default(false);
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transaction');
        });

        Schema::table('merch', function (Blueprint $table) {
            $table->boolean('isPreOrder')->default(false);
            $table->boolean('preOrderNeedsPayment')->default(false);
            $table->tinyInteger('amountPreOrdersBeforeNotification')->default(0);
            $table->tinyInteger('type')->default(0);
        });

        Schema::table('merch_sizes', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_merch_transaction', function (Blueprint $table) {
            $table->dropColumn('isPreOrder');
            $table->dropForeign('user_merch_transaction_transaction_id_foreign');
            $table->dropColumn('transaction_id');
        });

        Schema::table('merch', function (Blueprint $table) {
            $table->dropColumn('isPreOrder');
            $table->dropColumn('preOrderNeedsPayment');
            $table->dropColumn('amountPreOrdersBeforeNotification');
            $table->dropColumn('type');
        });

        Schema::table('merch_sizes', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
