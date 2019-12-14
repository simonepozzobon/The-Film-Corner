<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAppsSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_apps_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('app_id');
            $table->string('title')->default('Untitled');
            $table->boolean('is_empty')->default(1);
            $table->string('token');
            $table->json('content')->nullable();
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
        Schema::dropIfExists('student_apps_sessions');
    }
}
