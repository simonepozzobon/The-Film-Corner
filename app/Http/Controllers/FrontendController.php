<?php

namespace App\Http\Controllers;

use App\Post;
use App\Partner;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home_page()
    {
        $posts = Post::where('category_id', '=', 1)->latest()->limit(5)->get();
        $partners = Partner::all();
        $colors = [
            0 => ['#f5db5e', '#e9c845'],
            1 => ['#d8ef8f', '#b7cc5e'],
            2 => ['#f4c490', '#e8a360'],
            3 => ['#d9f5fc', '#a6dbe2'],
        ];

        $counter = 0;
        foreach ($posts as $key => $post) {
            $post->colors = $colors[$counter];
            $counter++;

            if ($counter % 4 == 0) {
                $counter = 0;
            }
        }
        return view('new', compact('posts', 'partners', 'colors'));
    }

    public function set_locale($lang)
    {
        \App::setLocale($lang);
        session(['my_locale' => $lang]);
        
        return redirect()->back();
    }
}
