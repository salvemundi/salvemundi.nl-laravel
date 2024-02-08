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
        });

        Schema::table('merch', function (Blueprint $table) {
            $table->boolean('isPreOrder')->default(false);
            $table->boolean('preOrderNeedsPayment')->default(false);
            $table->tinyInteger('amountPreOrdersBeforeNotification')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_merch_transaction', function (Blueprint $table) {
            $table->dropColumn('isPreOrder');
        });

        Schema::table('merch', function (Blueprint $table) {
            $table->dropColumn('isPreOrder');
            $table->dropColumn('preOrderNeedsPayment');
            $table->dropColumn('amountPreOrdersBeforeNotification');
        });
    }
};
