<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table('exercises', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('description');
        });

        Schema::connection('tfc_propaganda')->create('exercise_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exercise_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['exercise_id', 'locale']);
            $table->foreign('exercise_id')->references('id')->on('exercises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('tfc_propaganda')->table('exercises', function (Blueprint $table) {
            $table->string('title')->after('id')->nullable();
            $table->text('description')->after('title')->nullable();
        });
        Schema::connection('tfc_propaganda')->dropIfExists('exercise_translations');
    }
}
