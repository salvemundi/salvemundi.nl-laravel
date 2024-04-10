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
            $table->integer('amountPreOrdersBeforeNotification')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merch', function (Blueprint $table) {
            $table->tinyInteger('amountPreOrdersBeforeNotification')->change();
        });
    }
};
