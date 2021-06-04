<?php

namespace App\Http\Controllers\Api;

use App\Filmography;
use App\News;
use App\School;
use App\HomeText;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    public function get_news()
    {
        $news = News::all();

        $news = $news->transform(
            function ($value, $key) {
                $value->link = $value->slug;
                return $value;
            }
        )->all();

        return [
            'success' => true,
            'news' => $news
        ];
    }

    public function get_single_news($slug)
    {
        $news = News::where('slug', $slug)->first();
        return [
            'success' => true,
            'news' => $news
        ];
    }

    public function get_schools()
    {
        $schools = School::get()->groupBy('country');

        return response()->json(
            [
                'schools' => $schools
            ]
        );
    }

    public function get_filmography()
    {
        $filmography = Filmography::get();
        return response()->json(
            [
                'filmography' => $filmography
            ]
        );
    }

    public function get_project()
    {
        $text = HomeText::find(1);
        return response()
            ->json(
                [
                    'text' => $text
                ]
            );
    }
    public function get_conference()
    {
        $text = HomeText::find(2);
        return response()
            ->json(
                [
                    'text' => $text
                ]
            );
    }
}
