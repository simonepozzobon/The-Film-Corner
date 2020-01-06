<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('app_id');
            $table->boolean('teacher_shared')->default(0);
            $table->boolean('teacher_approved')->default(0);
            $table->boolean('is_empty')->default(1);
            $table->boolean('is_shared')->default(0);
            $table->string('title');
            $table->string('token');
            $table->json('content');
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
        Schema::dropIfExists('sessions');
    }
}
