<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImgToAppCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_sections', function (Blueprint $table) {
            $table->string('img')->nullable();
        });

        Schema::table('app_categories', function (Blueprint $table) {
            $table->string('img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_sections', function (Blueprint $table) {
            $table->dropColumn('img');
        });
        
        Schema::table('app_categories', function (Blueprint $table) {
            $table->dropColumn('img');
        });
    }
}
