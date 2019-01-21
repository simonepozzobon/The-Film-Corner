<?php

namespace App\Http\Controllers\Debug;

use App\App;
use App\MultiSubcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
