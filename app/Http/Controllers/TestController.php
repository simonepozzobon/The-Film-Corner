<?php

namespace App\Http\Controllers;

use Auth;
use App\Category;
use Illuminate\Http\Request;
// use App\Http\Requests;

class TestController extends Controller
{   /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth:admin', ['except' => 'logout']);
     }
    public function index()
    {
      $category = Category::all();
      return response()->json($category);
    }

    public function store(Request $request)
    {
      $category = new Category;
      $category->name = $request->input('name');
      $category->save();
      return response()->json(array( 'success' => true ));
    }

    public function destroy($id)
    {
      $category = Category::findOrFail($id);
      $category->delete();
      return response()->json(['success' => true]);
    }

    public function show($id) {
      return $id;
    }
}
