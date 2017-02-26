<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefinePostsPostCategoryConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('post_category', function(Blueprint $table) {
          $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
          $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::table('posts_category', function (Blueprint $table) {
           $table->dropForeign('posts_id_foreign');
       });
     }
}
