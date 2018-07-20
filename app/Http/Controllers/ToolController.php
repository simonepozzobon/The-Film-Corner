<?php

namespace App\Http\Controllers;

use App\App;
use App\Audio;
use App\Media;
use App\Video;
use App\Partner;
use App\AudioUtil;
use App\Filmography;
use App\MediaCategory;
use App\MediaSubCategory;
use App\PartnerTranslation;
use Illuminate\Http\Request;
use App\FilmographyTranslation;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{

    public function convert_library()
    {
        $category = MediaCategory::where('name', 'App')->first();
        $app = App::find(7);
        $app_category = $app->category()->first();
        $pavilion = $app_category->section()->first();

        $audios = $app->audios()->where('category_id', 2)->get();
        foreach ($audios as $key => $audio) {
            $destFolder = 'apps/library/'.$pavilion->slug.'/'.$app_category->slug.'/'.$app->slug.'/audio/app/mp3/';

            $src = storage_path('app/public/'.$audio->src);
            $filename = basename($src);
            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);

            $checkFolder = $destFolder.$withoutExt.'.mp3';
            echo 'controlla se esiste il file -> '.$checkFolder.'<br>';
            $check = Audio::where('src', '=', $checkFolder)->first();
            echo 'controllo -> <br>'.$check.'<br>';

            if (!$check || $check == null) {
                $mp3 = AudioUtil::convert_to_mp3($src, $withoutExt, $destFolder);

                $a = new Audio();
                $a->category_id = 2;
                $a->title = $audio->title;
                $a->src = $mp3;
                $a->duration = $audio->duration;
                $a->save();

                $app->audios()->detach($audio);
                $app_category->audios()->detach($audio);
                $pavilion->audios()->detach($audio);

                $app->audios()->save($a);
                $app_category->audios()->save($a);
                $pavilion->audios()->save($a);

                dump([
                    'destFolder' => $destFolder,
                    'filename' => $filename,
                    'src' => $audio->src,
                    'mp3' => $mp3,
                ]);
                echo '<br><hr>';
            } else {
                echo '<b>questo file è già stato convertito!</b><br><hr>';
            }


        }

        echo '<h2>completato!!!</h2>';
    }

    public function put_audio_on_whats_going_on()
    {
        $category = MediaCategory::where('name', 'App')->first();
        $audios = Audio::where('category_id', $category->id)->get();
        $app = App::find(7);
        $app_category = $app->category()->first();
        $pavilion = $app_category->section()->first();

        // Remove old audio
        echo 'Sto per rimuovere '.$audios->count().' file audio <br> ';
        $app->audios()->where('category_id', '=', 2)->detach();
        foreach ($app->audios()->get() as $audio) {
            $app_category->audios()->detach($audio);
            $pavilion->audios()->detach($audio);
        }
        echo '<hr><h2>Old audio library deleted!</h2><hr> <br> ';

        foreach ($audios as $key => $audio) {
            $app->audios()->save($audio);
            $app_category->audios()->save($audio);
            $pavilion->audios()->save($audio);
            echo 'Audio salvato nella libreria -> '.$audio->src.' <br> ';
        }

    }


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

    public function soundstudio_video_library()
    {
        $app = App::find(12);
        $category = 2; // General, App, Example => App
        $app_category = $app->category()->first();
        $pavilion = $app_category->section()->first();

        // preparo la creazione della nuova
        $media_origin = App::find(8); // sound Atmosphere, video muti
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
