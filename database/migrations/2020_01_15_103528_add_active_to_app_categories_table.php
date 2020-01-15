<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveToAppCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_categories', function (Blueprint $table) {
            $table->boolean('active')->default(1)->after('slug');
        });

        Schema::table('apps', function (Blueprint $table) {
            $table->boolean('active')->default(1)->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_categories', function (Blueprint $table) {
            $table->dropColumn('active');
        });
        
        Schema::table('apps', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}
