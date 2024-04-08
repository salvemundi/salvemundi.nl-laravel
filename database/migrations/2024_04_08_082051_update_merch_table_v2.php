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
            $table->longText('note')->nullable();
        });

        Schema::table('merch', function (Blueprint $table) {
            $table->boolean('canSetNote')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_merch_transaction', function (Blueprint $table) {
            $table->dropColumn('note');
        });
        Schema::table('merch', function (Blueprint $table) {
            $table->dropColumn('canSetNote');
        });
    }
};
