<?php

use Illuminate\Database\Seeder;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('apps')->truncate();
      DB::table('apps')->insert([
        [
          'title' => 'Frame Crop',
          'slug' => 'frame-crop',
          'description' => 'Starting from an explorable 3d VR establishing shot, choose some details and angles of the elements of the diegesis and create a narration through the stills you have made adding intertitles and dialogue.',
          'app_category_id' => 1
        ],
        [
          'title' => 'Juxtapposition',
          'slug' => 'juxtapposition',
          'description' => 'This app proposes to the user couples of stills (frames, pictures, paintings) that the user has to juxtapose and confront in order to find similarities or differences in the two images.',
          'app_category_id' => 1
        ],
        [
          'title' => 'Frame Counter',
          'slug' => 'frame-counter',
          'description' => 'This app should make it possible to count, describe and sort frames of a clip, stating how many frames are there in a clip, what kind of frames are they and to confront clips among them. This could be used as an easyfilm analysis clip.',
          'app_category_id' => 1
        ],
        [
          'title' => 'Intercut - Cross Cutting',
          'slug' => 'intercut-cross-cutting',
          'description' => 'This app should make it possible to take 2 sequences from different libraries and edit them as an intercut.',
          'app_category_id' => 2
        ],
        [
          'title' => 'Offscreen',
          'slug' => 'offscreen',
          'description' => 'Starting from a clip that tells something happening on screen, the user can imagine what is happening off screen in order To create a cause-effect pattern.',
          'app_category_id' => 2
        ],
        [
          'title' => 'Attractions',
          'slug' => 'attractions',
          'description' => 'This app should make it possible to pick and combine in different combination single images and frames and associate each combination and series of combination to a feeling or emotion.',
          'app_category_id' => 2
        ],
        [
          'title' => 'Attractions Viceversa',
          'slug' => 'attractions-viceversa',
          'description' => '',
          'app_category_id' => 2
        ],
        [
          'title' => 'What\'s Going On?',
          'slug' => 'whats-going-on',
          'description' => 'given an audio setting, students have to imagine what is happening on screen.',
          'app_category_id' => 3
        ],
        [
          'title' => 'Creative Subtitling',
          'slug' => 'creative-subtitling',
          'description' => 'Invent dialogue of a silent film scene.',
          'app_category_id' => 3
        ],
        [
          'title' => 'Creative Subtitling II',
          'slug' => 'creative-subtitling-II',
          'description' => '',
          'app_category_id' => 3
        ],
        [
          'title' => 'Sound Scanner',
          'slug' => 'sound-scanner',
          'description' => '',
          'app_category_id' => 3
        ],
        [
          'title' => 'Character Analysis',
          'slug' => 'character-analysis',
          'description' => 'Starting from a clip, analyse the characters into its basic characteristics (location; objects; physical/psychological characteristics) and display your analysis through written text.',
          'app_category_id' => 4
        ],
      ]);
    }
}
