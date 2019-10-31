<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColorToPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table(
            'periods', function (Blueprint $table) {
                $table->string('year')->nullable();
                $table->string('color')->nullable();
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
            'periods', function (Blueprint $table) {
                $table->dropColumn('year');
                $table->dropColumn('color');
            }
        );
    }
}
