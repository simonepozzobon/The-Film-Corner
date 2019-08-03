<?php

namespace App\Http\Controllers\Api\Admin;

use App\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
