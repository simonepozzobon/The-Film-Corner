<?php

namespace App\Http\Controllers\Debug;

use App\App;
use App\Video;
use App\MultiSubcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MediaLibraryController extends Controller
{
    public function media_library_fix() {
        $apps = App::all();
        $ids = [ 1, 2 ]; // enable search by app_id

        foreach ($apps as $key => $app) {
            if (in_array($app->id, $ids)) {
                $medias = $app->medias()->get(); // prendo tutte le immagini
                $libraries = $app->mediaCategory()->get();
                $librariesIds = $this->get_libraries_ids($libraries);

                foreach ($librariesIds as $key => $id) {
                    foreach ($medias as $key => $media) {
                        // verifica se l'immagine è già salvata nel db
                        $check = MultiSubcategory::where([
                                ['media_subcategory_id', '=', $id],
                                ['mediable_id', '=', $media->id],
                                ['mediable_type', '=', 'App\\Media']
                            ])->first();
                        if (!$check) {
                            // se non è salvata la salva
                            $obj = new MultiSubcategory();
                            $obj->media_subcategory_id = $id;
                            $obj->mediable_id = $media->id;
                            $obj->mediable_type = 'App\\Media';
                            $obj->save();
                        }
                    }
                }

                dump('app title -> '.$app->title);
                dump($librariesIds);
                dump($medias);
            }
        }
    }

    public function get_libraries_ids($libraries) {
        $librariesIds = [];

        if ($libraries->count() > 0) {
            foreach ($libraries as $key => $library) {
                array_push($librariesIds, $library->id);
            }
        }

        return $librariesIds;
    }

    public function fix_offscreen() {
        $app = App::find(5);
        $category = 2; // General, App, Example => App
        $app_category = $app->category()->first();
        $pavilion = $app_category->section()->first();

        $path = "apps/library/film-specific/editing/offscreen/video/app";
        $files = Storage::disk('local')->files('/public/'.$path);

        $thumb = '';
        $src = '';
        foreach ($files as $key => $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($ext == 'mp4') {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $src = $file;
                $thumb = $path.'/'.$filename.'-thumb.jpg';

                $video = new Video();
                $video->category_id = 2;
                $video->title = $filename;
                $video->img = $thumb;
                $video->src = $src;
                $video->duration = 0;
                $video->save();

                $app->videos()->save($video);
                $app_category->videos()->save($video);
                $pavilion->videos()->save($video);

                echo 'Video Salvato -> '.$video->title;
            }
        }
    }

    public function active_parallel_action_video_library() {
        $app = App::find(11);
        $category = 2; // General, App, Example => App
        $app_category = $app->category()->first();
        $pavilion = $app_category->section()->first();

        $app->videos()->detach();

        // preparo la creazione della nuova
        $media_origin = App::find(4); // sound Atmosphere, video muti
        $videos = $media_origin->videos()->where('category_id', '=', 2)->get();

        // Salvo i nuovi video
        foreach ($videos as $key => $video) {
            $app->videos()->save($video);
            $app_category->videos()->save($video);
            $pavilion->videos()->save($video);
        }

        echo 'Fatto!';
    }
}
