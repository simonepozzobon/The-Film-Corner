<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralTextTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_text_translations', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('general_text_id')->unsigned();
          $table->text('description');
          $table->string('locale')->index();

          $table->unique(['general_text_id','locale']);
          $table->foreign('general_text_id')->references('id')->on('general_texts')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_text_translations');
    }
}
