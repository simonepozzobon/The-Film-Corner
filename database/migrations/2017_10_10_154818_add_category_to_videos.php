<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('videos', function (Blueprint $table) {
           $table->integer('category_id')->default(1)->after('id');
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::table('videos', function (Blueprint $table) {
           $table->dropColumn('category_id');
       });
     }
}
