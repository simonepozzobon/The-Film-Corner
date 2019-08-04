<?php

namespace App\Http\Controllers\Api\Admin;

use App\News;
use App\Utility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class NewsController extends Controller
{
    public function get_all()
    {
        $items = News::all();
        return [
            'success' => true,
            'items' => $items
        ];
    }

    public function upload_img(Request $request)
    {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        $img = $file->storeAs('public/news', $filename);
        $path = Storage::disk('local')->url($img);
        return [
            'success' => true,
            'name' => $filename,
            'image' => $path
        ];
    }

    public function save(Request $request)
    {
        if (isset($request->id)) {
            $news = News::find($request->id);
        } else {
            $news = new News();
        }

        $news->title = $request->title;
        $news->content = $request->content;
        $news->slug = $request->slug;

        if (isset($request->file)) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $img = $file->storeAs('public/news', $filename);
            $thumb = $file->storeAs('public/news', 'thumb_'.$filename);

            $path = storage_path('app/public/news');
            Image::make($path.'/thumb_'.$filename)->fit(500, 500, function ($constraint) {
                $constraint->upsize();
            })->save();

            $news->img = Storage::disk('local')->url($img);
            $news->thumb = Storage::disk('local')->url($thumb);
        }

        $news->save();
        $news->refresh();

        return [
            'success' => true,
            'news' => $news
        ];
    }
}
