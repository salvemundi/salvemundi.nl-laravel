<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\StudyProfile;

class CreateSideJobBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_job_bank', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->tinyInteger('studyProfile')->unsigned()->default(StudyProfile::None);
            $table->text('description');
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
        Schema::dropIfExists('side_job_bank');
    }
}
