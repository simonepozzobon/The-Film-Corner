<?php

namespace App\Http\Controllers\Admin;

use App\AppKeyword;
use App\AppCategory;
use Illuminate\Http\Request;
use App\AppKeywordTranslation;
use App\Http\Controllers\Controller;

class GlossaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => 'logout']);
    }

    public function index()
    {
        $words = AppKeyword::with('category')->get();
        $categories = AppCategory::all();

        return view('admin.keywords.index', compact('words', 'categories'));
    }

    public function store(Request $r)
    {
        $word = new AppKeyword;
        $word->app_category_id = $r->category;
        $word->save();

        $word_t = new AppKeywordTranslation;
        $word_t->app_keyword_id = $word->id;
        $word_t->name = $r->name;
        $word_t->description = $r->description;
        $word_t->locale = 'en';
        $word_t->save();

        return response()->json($word_t, 200);
    }
}
