<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table(
            'clips', function (Blueprint $table) {
                $table->dropColumn('tech_info');
                $table->dropColumn('abstract');
                $table->dropColumn('historical_context');
                $table->dropColumn('foods');
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('clip_id')->unsigned();
                $table->longText('tech_info')->nullable();
                $table->longText('abstract')->nullable();
                $table->longText('historical_context')->nullable();
                $table->longText('foods')->nullable();
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
        Schema::connection('tfc_propaganda')->dropIfExists('details');
        Schema::connection('tfc_propaganda')->table(
            'clips', function (Blueprint $table) {
                $table->longText('tech_info');
                $table->longText('abstract');
                $table->longText('historical_context');
                $table->longText('foods');
            }
        );
    }
}
