<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table('details', function (Blueprint $table) {
            $table->dropColumn('tech_info');
            $table->dropColumn('abstract');
            $table->dropColumn('historical_context');
            $table->dropColumn('foods');
        });

        Schema::connection('tfc_propaganda')->create('detail_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('detail_id')->unsigned();
            $table->longText('tech_info');
            $table->longText('abstract');
            $table->longText('historical_context');
            $table->longText('foods');
            $table->string('locale')->index();

            $table->unique(['detail_id','locale']);
            $table->foreign('detail_id')->references('id')->on('details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('tfc_propaganda')->dropIfExists('detail_translations');

        Schema::connection('tfc_propaganda')->table('details', function (Blueprint $table) {
            $table->longText('tech_info')->nullable()->after('clip_id');
            $table->longText('abstract')->nullable()->after('tech_info');
            $table->longText('historical_context')->nullable()->after('abstract');
            $table->longText('foods')->nullable()->after('historical_context');
        });
    }
}
