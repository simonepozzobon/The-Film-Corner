<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_category_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['app_category_id','locale']);
            $table->foreign('app_category_id')->references('id')->on('app_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_category_translations');
    }
}
