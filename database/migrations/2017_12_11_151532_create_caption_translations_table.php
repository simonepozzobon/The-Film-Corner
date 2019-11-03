<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caption_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('caption_id')->unsigned();
            $table->string('title')->nullable();
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['caption_id','locale']);
            $table->foreign('caption_id')->references('id')->on('captions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caption_translations');
    }
}
