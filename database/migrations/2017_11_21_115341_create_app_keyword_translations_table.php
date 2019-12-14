<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppKeywordTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_keyword_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_keyword_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['app_keyword_id','locale']);
            $table->foreign('app_keyword_id')->references('id')->on('app_keywords')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_keyword_translations');
    }
}
