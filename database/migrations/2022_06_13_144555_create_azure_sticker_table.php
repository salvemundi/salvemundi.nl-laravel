<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAzureStickerTable extends Migration
{
    protected $connection = 'mysql2';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remove for later
        Schema::connection('mysql2')->create('sticker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            // $table->foreign('userId')->references('id')->on('users');
            $table->decimal('latitude', 20, 10);
            $table->decimal('longitude', 20, 10);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('azure_sticker');
    }
}
