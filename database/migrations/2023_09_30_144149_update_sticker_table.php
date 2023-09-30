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
        Schema::table('sticker', function ($table) {
            $table->dropForeign('sticker_userid_foreign');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sticker', function ($table) {
            $table->dropForeign('sticker_userid_foreign');
            $table->foreign('userId')->references('id')->on('users')->change();
        });
    }
};
