<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestAppSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_app_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guest_id');
            $table->integer('app_id');
            $table->string('title')->default('Untitled');
            $table->boolean('is_empty')->default(1);
            $table->string('token');
            $table->json('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guest_app_sessions');
    }
}
