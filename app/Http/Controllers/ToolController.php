<?php

namespace App\Http\Controllers;

use App\App;
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

}
