<?php

namespace App\Http\Controllers\Admin;

use App\Audio;
use App\Video;
use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    public function get_paths($type, $id)
    {
        switch ($type) {
            case 'audio':
                $item = Audio::where('id', $id)->with('app', 'app.category', 'app.category.pavilion')->first();
                break;

            case 'video':
                $item = Video::where('id', $id)->with('app', 'app.category', 'app.category.pavilion')->first();
                break;

            case 'image':
                $item = Media::where('id', $id)->with('category', 'apps', 'appCategories', 'appSection', 'mediaSubCategories')->first();
                // $item->library = $item->library();
                break;
        }

        return response($item);
    }
}
