<?php

namespace App\Http\Controllers\Api;

use App\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    public function get_news()
    {
        $news = News::all();

        $news = $news->transform(function($value, $key) {
            $value->link = $value->slug;
            $value->link_text = 'Read more';
            return $value;
        })->all();

        return [
            'success' => true,
            'news' => $news
        ];
    }
}
