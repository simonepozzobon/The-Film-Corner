<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->create(
            'medias', function (Blueprint $table) {
                $table->increments('id');
                $table->string('media_type');
                $table->string('name');
                $table->string('src');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'mediables', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('media_id')->unsigned();
                $table->morphs('mediable');
                $table->timestamps();
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
        Schema::connection('tfc_propaganda')->dropIfExists('medias');
        Schema::connection('tfc_propaganda')->dropIfExists('mediables');
    }
}
