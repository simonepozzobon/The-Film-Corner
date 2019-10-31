<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaMorphTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::dropIfExists('medias');
       Schema::create('medias', function (Blueprint $table) {
           $table->increments('id');
           $table->string('src');
           $table->string('thumb');
           $table->string('landscape');
           $table->string('portrait');
           $table->timestamps();
       });

       Schema::create('mediaables', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('media_id')->unsigned();
           $table->integer('mediaable_id')->unsigned();
           $table->string('mediaable_type');
           $table->index('media_id');
           $table->index('mediaable_id');
           $table->index('mediaable_type');
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::dropIfExists('medias');
       Schema::dropIfExists('mediaables');
     }
}
