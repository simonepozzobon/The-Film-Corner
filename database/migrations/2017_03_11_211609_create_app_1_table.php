<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApp1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_1', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->nullable()->default(0);
            $table->string('name');
            $table->text('description');
            $table->string('frame');
            $table->integer('first_x')->nullable()->default(0);
            $table->integer('first_y')->nullable()->default(0);
            $table->integer('first_w')->nullable()->default(0);
            $table->integer('first_h')->nullable()->default(0);
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
        Schema::dropIfExists('app_1');
    }
}
