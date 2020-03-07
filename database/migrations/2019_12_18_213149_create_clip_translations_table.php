<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClipTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table('clips', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::connection('tfc_propaganda')->create('clip_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clip_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();

            $table->unique(['clip_id','locale']);
            $table->foreign('clip_id')->references('id')->on('clips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('tfc_propaganda')->dropIfExists('clip_translations');
        Schema::connection('tfc_propaganda')->table('clips', function (Blueprint $table) {
            $table->string('title')->after('video')->nullable();
        });
    }
}
