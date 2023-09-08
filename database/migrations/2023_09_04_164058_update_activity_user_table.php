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
        Schema::table('activity_user', function ($table) {
            $table->dropForeign(['activityId']);
            $table->dropForeign(['userId']);
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('activityId')->references('id')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
