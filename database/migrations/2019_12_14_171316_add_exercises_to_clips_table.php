<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExercisesToClipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table(
            'clips',
            function (Blueprint $table) {
                $table->boolean('exercise_1')->default(0)->after('age_id');
                $table->boolean('exercise_2')->default(0)->after('exercise_1');
                $table->boolean('exercise_3')->default(0)->after('exercise_2');
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
        Schema::connection('tfc_propaganda')->table(
            'clips',
            function (Blueprint $table) {
                $table->dropColumn('exercise_1');
                $table->dropColumn('exercise_2');
                $table->dropColumn('exercise_3');
            }
        );
    }
}
