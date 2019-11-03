<?php

namespace App\Http\Controllers\Admin\Apps;

use App\App;
use App\AppSection;
use App\AppCategory;
use App\MediaSubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
  public function getRelations(string $type, $id)
  {
      switch ($type) {
        case 'pavilion':
            $section = AppSection::find($id);
            $categories = $section->appCategories()->get();
            $apps = collect();

            foreach ($categories as $key => $category) {
              $items = $category->apps()->get();
              foreach ($items as $key => $app) {
                $apps->push($app);
              }
            }

            $data = [
              'categories' => $categories,
              'apps' => $apps
            ];

            return response()->json($data, 200);
          break;

        case 'category':
            $category = AppCategory::find($id);
            $section = $category->section()->first();
            $apps = $category->apps()->get();

            $data = [
              'pavilion' => $section,
              'apps' => $apps
            ];

            return response()->json($data, 200);
          break;

        case 'app':
            $app = App::find($id);
            $category = $app->category()->first();
            $section = $app->category()->first();

            $data = [
              'category' => $category,
              'pavilion' => $section
            ];

            return response()->json($data, 200);
          break;
      }
  }

  public function getSubCategories($id)
  {
    $sub_categories = MediaSubCategory::where('app_id', '=', $id)->get();

    return response()->json($sub_categories, 200);
  }
}
