<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('student_sessions', function (Blueprint $table) {
             $table->increments('id');
             $table->integer('student_id');
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
         Schema::dropIfExists('student_sessions');
     }
}
