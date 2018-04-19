<?php

namespace App\Http\Controllers;

use App\App;
use App\Media;
use App\Video;
use App\Partner;
use App\PartnerTranslation;
use App\MediaSubCategory;
use App\Filmography;
use App\FilmographyTranslation;
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

    public function translate_filmography()
    {
        $filmographies = Filmography::all();
        foreach ($filmographies as $key => $filmography) {
            $t = new FilmographyTranslation();
            $t->filmography_id = $filmography->id;
            $t->title = $filmography->title;
            $t->description = $filmography->description;
            $t->locale = 'en';
            $t->save();
            echo 'filomgraphy '.$filmography->id.' saved <br>';
        }
        echo 'Completato';
    }

    public function translate_partner()
    {
        $partners = Partner::all();
        foreach ($partners as $key => $partner) {
            $t = new PartnerTranslation();
            $t->partner_id = $partner->id;
            $t->name = $partner->name;
            $t->location = $partner->location;
            $t->description = $partner->description;
            $t->locale = 'en';
            $t->save();
            echo 'partner '.$partner->id.' saved <br>';
        }
        echo 'Completato';
    }

    public function remove_video_from_sound_atmosphere()
    {
        $sound_atmosphere = App::find(8);

        $app_category = $sound_atmosphere->category()->first();
        $pavilion = $app_category->section()->first();

        $videos = $sound_atmosphere->videos()->where('category_id', '=', 2)->get();

        foreach ($videos as $key => $video) {
            echo 'Deleting '.$video->id;
            $id = $video->id;
            $app_category->videos()->where([
                ['category_id', '=', 2],
                ['video_id', '=', $id],
            ])->detach();
            $pavilion->videos()->where([
                ['category_id', '=', 2],
                ['video_id', '=', $id],
            ])->detach();
            echo 'Deleted!';
        }

        echo 'Deleting the app videos';
        $sound_atmosphere->videos()->where('category_id', '=', 2)->detach();
        echo 'Deleted!';

        $sound_studio = App::find(12);

        $app_category = $sound_studio->category()->first();
        $pavilion = $app_category->section()->first();

        $videos = $sound_studio->videos()->where('category_id', '=', 2)->get();

        foreach ($videos as $key => $video) {
            echo 'Deleting '.$video->id;
            $id = $video->id;
            $app_category->videos()->where([
                ['category_id', '=', 2],
                ['video_id', '=', $id],
            ])->detach();
            $pavilion->videos()->where([
                ['category_id', '=', 2],
                ['video_id', '=', $id],
            ])->detach();
            echo 'Deleted!';
        }

        echo 'Deleting the app videos';
        $sound_studio->videos()->where('category_id', '=', 2)->detach();
        echo 'Deleted!';

        // $videos = Video::where('')
    }

}
