<?php

use Illuminate\Database\Seeder;

class AppKeywordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('app_keywords')->truncate();
      DB::table('app_keywords')->insert([
        [
          'name' => 'Editing',
          'description' => 'The term video editing can refer to: The process of manipulating video images. Once the province of expensive machines called video editors, video editing software is now available for personal computers and workstations. Video editing includes cutting segments (trimming), re-sequencing clips, and adding transitions and other Special Effects.',
          'app_category_id' => 2
        ],
        [
          'name' => 'Frame',
          'description' => 'The frame is composed of picture elements just like a chess board. Each horizontal set of picture elements is known as a line. The picture elements in a line are transmitted as sine signals where a pair of dots, one dark and one light can be represented by a single sine. The product of the number of lines and the number of maximum sine signals per line is known as the total resolution of the frame. The higher the resolution the more faithful the displayed image is to the original image. But higher resolution introduces technical problems and extra cost. So a compromise should be reached in system designs both for satisfactory image quality and affordable price.',
          'app_category_id' => 2
        ],
        [
          'name' => 'Split Edit',
          'description' => 'A split edit, is a transition from one shot to another in film or video, where transition of the audio and video happen at different times.[1][2] This is often done to enhance the aesthetics or flow of the film, allowing the audience to see context—either before or after—of speaking rather than simply the speaking itself. Without split edit, a conversation between two people can feel like a tennis match. Split edits are also used to hide transitions between scenes. They can be very effective in editing dialog scenes shot with a single camera using multiple takes. The ability to cut the picture/video separately from the sound/audio allows the sound from the various takes to flow smoothly, even though the picture cuts are at different places. In longer shots, this allows the editor to use the picture from one take with the sound from another take if the dialog reading is better. Traditionally, split edits have been described as overlapping the sound, not to be confused with overlapping dialogue, where the latter involves laying one sound track over another sound track. With proliferation of computer-based non-linear editing different variants of split edit received their own names based on how the video being edited is presented on the timeline. A variant of split edit when the audio from preceding scene overlaps the video from the following scene is known as L cut. If the audio from the following scene overlaps the video from the preceding scene, then this cut is known as J cut. In 2011 Barry Salt investigated 33 American films made between 1936 and 2014 and noted that "the use of J-edits does seem to have increased in recent times, to a proportion roughly equal to that of L-edits" although because of the small sample of films studied he was careful not to conclude this to become the trend.',
          'app_category_id' => 2
        ]
      ]);
    }
}
