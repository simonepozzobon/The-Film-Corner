<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audios', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('category_id');
          $table->string('title');
          $table->string('src');
          $table->float('duration', 8, 4);
          $table->timestamps();
        });

        Schema::create('audioables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('audio_id')->unsigned();
            $table->integer('audioable_id')->unsigned();
            $table->string('audioable_type');
            $table->index('audio_id');
            $table->index('audioable_id');
            $table->index('audioable_type');
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
        Schema::dropIfExists('audios');
        Schema::dropIfExists('audioables');
    }
}
