<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('videos', function (Blueprint $table) {
          $table->increments('id');
          $table->string('thumb');
          $table->string('src');
          $table->timestamps();
      });

      Schema::create('videoables', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('video_id')->unsigned();
          $table->integer('videoable_id')->unsigned();
          $table->string('videoable_type');
          $table->index('video_id');
          $table->index('videoable_id');
          $table->index('videoable_type');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('videos');
      Schema::dropIfExists('videoables');
    }
}
