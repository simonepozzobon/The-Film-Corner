<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacher_id');
            $table->integer('app_id');
            $table->string('title')->default('no name');
            $table->boolean('empty')->default(1);
            $table->string('token')->unique();
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
        Schema::dropIfExists('teacher_sessions');
    }
}
