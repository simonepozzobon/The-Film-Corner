<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserableToSharedSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shared_sessions', function (Blueprint $table) {
            $table->morphs('userable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shared_sessions', function (Blueprint $table) {
            $table->dropColumn('userable_id');
            $table->dropColumn('userable_type');
        });
    }
}
