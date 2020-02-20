<?php

namespace App\Http\Controllers\Api\Admin;

use App\Propaganda\Clip;
use App\Propaganda\ClipTranslation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class TranslationController extends Controller
{
    public function store_title(Request $request)
    {
        $id = $request->id;
        $translations = json_decode($request->translations);

        $clip = Clip::find($id);

        foreach ($translations as $key => $translation) {
            $current = $clip->translateOrNew($translation->locale);
            $current->clip_id = $clip->id;
            $current->title = $translation->value;
            $current->save();
        }

        return response()->json([
          'clip' => $clip,
          'translations' => $translations
        ]);
    }
}
