<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeacherApprovedToStudentAppsSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_apps_sessions', function (Blueprint $table) {
            $table->boolean('teacher_approved')->after('teacher_shared')->default(0);
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
            $table->dropColumn('teacher_approved');
        });
    }
}
