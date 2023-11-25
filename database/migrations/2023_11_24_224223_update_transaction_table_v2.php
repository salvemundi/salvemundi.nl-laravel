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
        Schema::table('transaction', function(Blueprint $table)
        {
            $table->unsignedBigInteger('productId')->nullable()->change();
            $table->unsignedBigInteger('merchId')->nullable();
            $table->foreign('merchId')->references('id')->on('merch');
            $table->double('amount',8,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction', function(Blueprint $table)
        {
            $table->unsignedBigInteger('productId')->change();
            $table->dropForeign('merchId');
            $table->dropColumn('merchId');
            $table->dropColumn('amount');
        });
    }
};
