<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTranslationToLibraryMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table('library_medias', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::connection('tfc_propaganda')->create('library_media_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('library_media_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['library_media_id', 'locale']);
            $table->foreign('library_media_id')->references('id')->on('library_medias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('tfc_propaganda')->dropIfExists('library_media_translations');
        Schema::connection('tfc_propaganda')->table('library_medias', function (Blueprint $table) {
            $table->string('title')->after('id')->nullable();
        });
    }
}
