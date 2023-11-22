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
        Schema::create('merch_color', function (Blueprint $table) {
            $table->id();
            $table->string('colour');
            $table->timestamps();
        });

        Schema::create('merch', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('imgPath')->nullable();
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('merch_color_rel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('merch_color')->cascadeOnDelete();
            $table->unsignedBigInteger('merch_id');
            $table->foreign('merch_id')->references('id')->on('merch');
            $table->timestamps();
        });

        Schema::create('merch_sizes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('size')->default(0);
            $table->tinyInteger('merch_gender')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('merch_sizes_rel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merch_id');
            $table->foreign('merch_id')->references('id')->on('merch');
            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')->references('id')->on('merch_sizes')->cascadeOnDelete();
            $table->integer('amount')->default(0);
            $table->timestamps();
        });

        Schema::create('user_merch_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('merch_id');
            $table->foreign('merch_id')->references('id')->on('merch');
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transaction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_merch_transaction');
        Schema::dropIfExists('merch_sizes_rel');
        Schema::dropIfExists('merch_sizes');
        Schema::dropIfExists('merch_color');
        Schema::dropIfExists('merch');
    }
};
