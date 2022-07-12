<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('description')->unique();
            $table->timestamps();
        });

        Schema::create('permissions_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('permission_id')->nullable()->index();
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->timestamps();
        });

        Schema::create('permissions_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable()->index();
            $table->foreign('group_id')->references('id')->on('groups');
            $table->unsignedBigInteger('permission_id')->nullable()->index();
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions_users');
        Schema::dropIfExists('permissions_groups');
        Schema::dropIfExists('permissions');
    }
}
