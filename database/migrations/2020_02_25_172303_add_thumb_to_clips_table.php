<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbToClipsTable extends Migration
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
                $table->string('thumb')->after('video')->nullable();
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
            'clips', function (Blueprint $table) {
                $table->dropColumn('thumb');
            }
        );
    }
}
