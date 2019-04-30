<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderToAppSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_sections', function (Blueprint $table) {
            $table->integer('order')->after('id');
            $table->boolean('active')->after('order')->default(1);
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
            $table->dropColumn('order');
            $table->dropColumn('active');
        });
    }
}
