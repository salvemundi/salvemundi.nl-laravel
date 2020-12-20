<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\paymentStatus;
class IntroductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('introduction', function (Blueprint $table) {

            $table->increments('id');
            $table->string('firstName', 32);
            $table->string('insertion', 32)->nullable();
            $table->string('lastName', 45);
            $table->date('birthday');
            $table->string('email', 65)->unique();
            $table->string('phoneNumber', 15);
            $table->integer('paymentId')->unsigned()->nullable();
            $table->foreign('paymentId')->references('id')->on('transcation');
            $table->softDeletes();
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
        Schema::dropIfExists('introduction');
    }
}
