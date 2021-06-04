<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'home_texts',
            function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
            }
        );

        Schema::create(
            'home_text_translations',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('home_text_id')->unsigned();
                $table->string('content');
                $table->string('locale')->index();

                $table->unique(['home_text_id', 'locale']);
                $table->foreign('home_text_id')->references('id')->on('home_texts');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_text_translations');
        Schema::dropIfExists('home_texts');
    }
}
