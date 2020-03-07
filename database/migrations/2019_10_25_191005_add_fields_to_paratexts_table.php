<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToParatextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->table(
            'paratext_types', function (Blueprint $table) {
                $table->string('title')->after('id');
                $table->boolean('has_media')->after('title')->default(1);
                $table->dropColumn('has_image');
            }
        );

        Schema::connection('tfc_propaganda')->table(
            'paratexts', function (Blueprint $table) {
                $table->dropColumn('img');
                $table->string('media_type')->after('content')->nullable();
                $table->string('media')->after('media_type')->nullable();
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
            'paratext_types', function (Blueprint $table) {
                $table->dropColumn('title');
                $table->dropColumn('has_media');
                $table->boolean('has_image')->after('type')->default(1);
            }
        );

        Schema::connection('tfc_propaganda')->table(
            'paratexts', function (Blueprint $table) {
                $table->string('img')->nullable();
                $table->dropColumn('media_type');
                $table->dropColumn('media');
            }
        );
    }
}
