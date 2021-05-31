<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'schools',
            function (Blueprint $table) {
                $table->dropColumn('address');
                $table->dropColumn('city');
                $table->dropColumn('postal_code');
                // $table->text('description')->nullable();
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
        Schema::table(
            'schools',
            function (Blueprint $table) {
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('postal_code')->nullable();
                // $table->dropColumn('description');
            }
        );
    }
}
