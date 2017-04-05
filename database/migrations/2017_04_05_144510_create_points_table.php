<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->float('lat', 9, 6);
            $table->float('long', 9, 6);
            $table->string('place_name')->nullable();
            $table->string('genre')->nullable();
            $table->string('director')->nullable();
            $table->string('actors')->nullable();
            $table->string('video_link')->nullable();
            $table->text('sinossi')->nullable();
            $table->integer('city_id')->nullable();
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
        Schema::dropIfExists('points');
    }
}
