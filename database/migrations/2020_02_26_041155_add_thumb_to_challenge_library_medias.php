<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbToChallengeLibraryMedias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table(
            'challenge_library_medias', function (Blueprint $table) {
                $table->string('thumb')->after('url')->nullable();
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
            'challenge_library_medias', function (Blueprint $table) {
                $table->dropColumn('thumb');
            }
        );
    }
}
