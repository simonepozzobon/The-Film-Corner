<?php

namespace App\Http\Controllers\Blog;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function getSingle ($slug)
    {
      $post = Post::where('slug', '=', $slug)->first();
      return view('blog.post')->with('post', $post);
    }
}
