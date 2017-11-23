<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWelcomeForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('welcome_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('word_1')->nullable();
            $table->string('word_2')->nullable();
            $table->string('word_3')->nullable();
            $table->text('answer')->nullable();
            $table->morphs('userable');
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
        Schema::dropIfExists('welcome_forms');
    }
}
