<?php

namespace App\Http\Controllers\Admin;

use App\Caption;
use App\CaptionTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CaptionController extends Controller
{
    public function index()
    {
        return view('admin.captions.index');
    }

    public function get_captions()
    {
        $captions = Caption::all();

        foreach ($captions as $key => $caption) {
            $model = $caption->mediable_type;
            $mediable = $model::find($caption->mediable_id);
            if ($model != 'App\Audio') {
                $mediable->img = Storage::disk('local')->url($mediable->img);
            } else {
                $mediable->img = '';
            }
            $caption->media = $mediable;
        }

        return response($captions);
    }


    /*
     * POST route /admin/apps/captions/store_caption
     * Request: [id, type, title, description]
     * id = id of the mediable
     * type = String [audio, video, image]
     * title = String
     * description = String
     */

    public function store_caption(Request $request)
    {
        $caption = new Caption();
        $caption->mediable_id = $request->id;
        switch ($request->type) {
            case 'audio':
                $caption->mediable_type = 'App\Audio';
                break;
            case 'video':
                $caption->mediable_type = 'App\Video';
                break;
            case 'image':
                $caption->mediable_type = 'App\Media';
                break;
        }

        $caption->save();

        $t = new CaptionTranslation();
        $t->caption_id = $caption->id;
        $t->title = $request->title;
        $t->description = $request->description;
        $t->locale = 'en';
        $t->save();

        return response($caption);
    }
}
