<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('tfc_propaganda')->create(
            'clips', function (Blueprint $table) {
                $table->increments('id');
                $table->string('video');
                $table->string('title');
                $table->string('year');
                $table->string('nationality');
                $table->integer('period_id')->unsigned();
                $table->integer('genre_id')->unsigned();
                $table->integer('format_id')->unsigned();
                $table->integer('age_id')->unsigned();
                $table->longText('tech_info');
                $table->longText('abstract');
                $table->longText('historical_context');
                $table->longText('foods');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'directors', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'topics', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'periods', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('order');
                $table->string('title');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'genres', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'formats', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'peoples', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'ages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'clip_director', function (Blueprint $table) {
                $table->integer('clip_id');
                $table->integer('director_id');
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'clip_topic', function (Blueprint $table) {
                $table->integer('clip_id');
                $table->integer('topic_id');
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'clip_people', function (Blueprint $table) {
                $table->integer('clip_id');
                $table->integer('people_id');
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'paratexts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('paratext_type_id')->unsigned();
                $table->string('img')->nullable();
                $table->longText('content');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'paratext_types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('type');
                $table->boolean('has_image')->default(false);
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'clip_paratext', function (Blueprint $table) {
                $table->integer('clip_id');
                $table->integer('paratext_id');
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'hashtags', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'clip_hashtag', function (Blueprint $table) {
                $table->integer('clip_id');
                $table->integer('hashtag_id');
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'exercises', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->longText('description');
                $table->boolean('has_library')->default(false);
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'libraries', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('clip_id')->unsigned();
                $table->integer('exercise_id')->unsigned();
                $table->integer('library_type_id')->unsigned();
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'library_types', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->timestamps();
            }
        );
        Schema::connection('tfc_propaganda')->create(
            'library_medias', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->string('url');
                $table->integer('library_type_id')->unsigned();
                $table->integer('library_id')->unsigned();
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'challenges', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->longText('description');
                $table->boolean('has_library')->default(false);
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'challenge_libraries', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('challenge_id')->unsigned();
                $table->string('title');
                $table->longText('description');
                $table->timestamps();
            }
        );

        Schema::connection('tfc_propaganda')->create(
            'challenge_library_medias', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('challenge_library_id')->unsigned();
                $table->integer('library_type_id')->unsigned();
                $table->string('title');
                $table->string('url');
                $table->timestamps();
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
        Schema::connection('tfc_propaganda')->dropIfExists('clips');
        Schema::connection('tfc_propaganda')->dropIfExists('directors');
        Schema::connection('tfc_propaganda')->dropIfExists('topics');
        Schema::connection('tfc_propaganda')->dropIfExists('periods');
        Schema::connection('tfc_propaganda')->dropIfExists('genres');
        Schema::connection('tfc_propaganda')->dropIfExists('formats');
        Schema::connection('tfc_propaganda')->dropIfExists('peoples');
        Schema::connection('tfc_propaganda')->dropIfExists('ages');
        Schema::connection('tfc_propaganda')->dropIfExists('clip_director');
        Schema::connection('tfc_propaganda')->dropIfExists('clip_topic');
        Schema::connection('tfc_propaganda')->dropIfExists('clip_people');
        Schema::connection('tfc_propaganda')->dropIfExists('paratexts');
        Schema::connection('tfc_propaganda')->dropIfExists('paratext_types');
        Schema::connection('tfc_propaganda')->dropIfExists('clip_paratext');
        Schema::connection('tfc_propaganda')->dropIfExists('hashtags');
        Schema::connection('tfc_propaganda')->dropIfExists('clip_hashtag');
        Schema::connection('tfc_propaganda')->dropIfExists('exercises');
        Schema::connection('tfc_propaganda')->dropIfExists('libraries');
        Schema::connection('tfc_propaganda')->dropIfExists('library_types');
        Schema::connection('tfc_propaganda')->dropIfExists('library_medias');
        Schema::connection('tfc_propaganda')->dropIfExists('challenges');
        Schema::connection('tfc_propaganda')->dropIfExists('challenge_libraries');
        Schema::connection('tfc_propaganda')->dropIfExists('challenge_library_medias');
    }
}
