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
        Schema::create('merch', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('imgPath')->nullable();
            $table->double('price');
            $table->string('currency')->default('EUR');
            $table->timestamps();
        });

        Schema::create('merch_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        Schema::create('merch_amounts', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->unsignedBigInteger('merchId');
            $table->foreign('merchId')->references('id')->on('merch')->cascadeOnDelete();
            $table->unsignedBigInteger('merchSizeID');
            $table->foreign('merchSizeID')->references('id')->on('merch_sizes')->cascadeOnDelete();
            $table->double('priceDifferential');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merch');
        Schema::dropIfExists('merch_sizes');
        Schema::dropIfExists('merch_amounts');
    }
};
