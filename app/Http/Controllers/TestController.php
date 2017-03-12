<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
      $admin = Category::all();
      return response()->json($admin);
    }
}
