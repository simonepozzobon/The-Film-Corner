<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaCouplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_couples', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('left_id')->unsigned();
            $table->integer('right_id')->unsigned();
            $table->timestamps();

            $table->foreign('left_id')->references('id')->on('medias')->onDelete('cascade');
            $table->foreign('right_id')->references('id')->on('medias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_couples');
    }
}
