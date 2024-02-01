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
        Schema::table('merch', function (Blueprint $table) {
            $table->boolean('isPreOrder')->default(false);
            $table->tinyInteger('amountPreOrdersBeforeNotification')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merch', function (Blueprint $table) {
            $table->dropColumn('isPreOrder');
            $table->dropColumn('amountPreOrdersBeforeNotification');
        });
    }
};
