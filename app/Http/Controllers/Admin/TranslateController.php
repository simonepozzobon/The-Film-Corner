<?php

namespace App\Http\Controllers\Admin;

use App\App;
use App\Language;
use App\AppKeyword;
use App\AppKeywordTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranslateController extends Controller
{

    public function get_languages()
    {
      $locales = Language::all();
      $locales = $locales->pluck('short');
      return response($locales, 200);
    }

    public function index()
    {
        $apps = App::all();
        $apps = $apps->transform(function($app, $key) {
          $app->model = get_class($app);
          return $app;
        });
        return view('admin.translate.index', compact('apps'));
    }

    public function save(Request $r)
    {
        $model = $re;

        return response()->json($translate, 200);
    }

    public function translate()
    {
        $items = AppKeyword::all();
        foreach ($items as $key => $item) {
            $t = new AppKeywordTranslation;
            $t->app_keyword_id = $item->id;
            $t->name = $item->name;
            $t->description = $item->description;
            $t->locale = 'en';
            $t->save();
        }

        return redirect()->route('admin');
    }
}
