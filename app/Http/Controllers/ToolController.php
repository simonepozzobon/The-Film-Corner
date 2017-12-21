<?php

namespace App\Http\Controllers;

use App\App;
use App\Media;
use App\Video;
use App\MediaSubCategory;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function flush_media()
    {
        $app = App::find(14);
        $categories = $app->mediaCategory()->get();

        // Pulisco le immagini precedenti
        foreach ($categories as $key => $category) {
            $medias = $category->medias()->detach();
        }

        // conto le librerie presenti
        $library_count = $categories->count() - 1;

        // prendo le immagini dell'applicazione (solo quelle per il lavoro no esempi o generiche)
        $medias = $app->medias()->where('category_id', '=', 2)->get();
        foreach ($medias as $key => $media) {
            $index = rand(0, $library_count);
            $categories[$index]->medias()->save($media);
        }

        dd($categories);
    }

    public function soundstudio_library()
    {
        $app = App::find(12);
        $category = 2; // General, App, Example => App
        $app_category = $app->category()->first();
        $pavilion = $app_category->section()->first();

        // Rimuovo la vecchia libreria
        $app->videos()->where('category_id', '=', 2)->detach();
        $app->audios()->where('category_id', '=', 2)->detach();

        // preparo la creazione della nuova
        $media_origin = App::find(8); // sound Atmosphere, video muti
        $videos = $media_origin->videos()->where('category_id', '=', 2)->get();
        $audios = $media_origin->audios()->where('category_id', '=', 2)->get();

        // Salvo i nuovi video
        foreach ($videos as $key => $video) {
            $app->videos()->save($video);
            $app_category->videos()->save($video);
            $pavilion->videos()->save($video);
        }

        // Salvo i nuovi audio
        foreach ($audios as $key => $audio) {
            $app->audios()->save($audio);
            $app_category->audios()->save($audio);
            $pavilion->audios()->save($audio);
        }

        echo ('Fatto');
    }

}
