<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLibraryTypeIdToExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table(
            'exercises', function (Blueprint $table) {
                $table->integer('library_type_id')->after('has_library')->unsigned()->default(1);
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
            'exercises', function (Blueprint $table) {
                $table->dropColumn('library_type_id');
            }
        );
    }
}
