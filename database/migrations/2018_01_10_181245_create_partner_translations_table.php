<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('partner_id')->unsigned();
            $table->string('name');
            $table->string('location');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['partner_id','locale']);
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_translations');
    }
}
