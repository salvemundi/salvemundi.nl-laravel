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
        Schema::create('committee_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->string('colorClass')->nullable();
            $table->timestamps();
        });
        Schema::create('activity_committee_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activityId');
            $table->foreign('activityId')->references('id')->on('products');
            $table->unsignedBigInteger('tagId');
            $table->foreign('tagId')->references('id')->on('committee_tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_committee_tag');
        Schema::dropIfExists('committee_tags');
    }
};
