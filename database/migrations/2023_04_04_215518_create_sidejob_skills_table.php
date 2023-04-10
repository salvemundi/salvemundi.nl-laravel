<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSidejobSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_job_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('skill_jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('jobId');
            $table->foreign('jobId')->references('id')->on('side_job_bank')->onDelete('cascade');
            $table->unsignedBigInteger('skillId');
            $table->foreign('skillId')->references('id')->on('side_job_skills')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skill_jobs');
        Schema::dropIfExists('side_job_skills');
    }
}
