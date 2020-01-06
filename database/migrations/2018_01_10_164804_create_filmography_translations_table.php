<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmographyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filmography_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filmography_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['filmography_id','locale']);
            $table->foreign('filmography_id')->references('id')->on('filmographies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filmography_translations');
    }
}
