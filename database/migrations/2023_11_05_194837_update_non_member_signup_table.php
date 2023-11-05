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
        Schema::table('non_member_activity_signup', function ($table) {
            $table->string('email')->nullable()->change();
            $table->uuid('groupId')->nullable();
            $table->unsignedBigInteger('transactionId')->nullable();
            $table->foreign('transactionId')->references('id')->on('transaction')->onDelete('cascade');
            $table->unsignedBigInteger('associationId')->nullable();
            $table->foreign('associationId')->references('id')->on('activity_association')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_member_activity_signup', function ($table) {
            $table->string('email')->change();
            $table->dropColumn('groupId');
            $table->dropForeign(['transactionId']);
            $table->dropColumn('transactionId');
            $table->dropForeign(['associationId']);
            $table->dropColumn('associationId');
        });
    }
};
