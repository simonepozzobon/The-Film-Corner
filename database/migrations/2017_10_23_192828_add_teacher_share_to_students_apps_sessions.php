<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeacherShareToStudentsAppsSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_apps_sessions', function (Blueprint $table) {
            $table->boolean('teacher_shared')->default(0)->after('is_empty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_apps_sessions', function (Blueprint $table) {
            $table->dropColumn('teacher_shared');
        });
    }
}
