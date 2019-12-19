<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParatextTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table('paratexts', function (Blueprint $table) {
            $table->dropColumn('content');
        });

        Schema::connection('tfc_propaganda')->create('paratext_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paratext_id')->unsigned();
            $table->longText('content');
            $table->string('locale')->index();

            $table->unique(['paratext_id','locale']);
            $table->foreign('paratext_id')->references('id')->on('paratexts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('tfc_propaganda')->dropIfExists('paratext_translations');

        Schema::connection('tfc_propaganda')->table('paratexts', function (Blueprint $table) {
            $table->longText('content')->after('paratext_type_id');
        });
    }
}
