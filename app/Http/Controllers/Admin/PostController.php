<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\User;
use Purifier;
use App\Admin;
use App\Media;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;

class PostController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth:admin', ['except' => 'logout']);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $posts = Post::all();

      return view('admin.posts.index')
                    ->with('posts', $posts);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      $admins = Admin::all();
      $media = Media::all();
      $categories = Category::all();
      $tags = Tag::all();
      return view('admin.posts.create')
                    ->with('admins', $admins)
                    ->with('medias', $media)
                    ->with('categories', $categories)
                    ->with('tags', $tags);
  }



  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePost $request)
  {
      $post = new Post;
      $post->title = $request->input('title');
      $post->content = Purifier::clean($request->input('content'), 'youtube');
      $post->category_id = $request->input('category_id');
      $post->media_id = $request->input('media_id');
      $post->user_id = $request->input('user_id');

      $post->save();


      if (isset($request->tags)) {
        // where to link -> name of the array -> sync($request->nameOfTheArray, false);
        $post->tags()->sync($request->tags, false);
      }


      return redirect('/admin/posts')->with('status', 'New post created!');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      $post = Post::findOrFail($id);
      return view('admin.posts.show')->with('post', $post);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $post = Post::findOrFail($id);
      $admins = Admin::all();
      $media = Media::all();
      $categories = Category::all();
      $tags = Tag::all();
      $tagsForThisPost = json_encode($post->tags->pluck('id'));

      return view('admin.posts.edit')
                    ->with('post', $post)
                    ->with('admins', $admins)
                    ->with('medias', $media)
                    ->with('categories', $categories)
                    ->with('tags', $tags)
                    ->with('tagsForThisPost', $tagsForThisPost);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePost $request, $id) //verificare Request > va cambiato con UpdatePost
  {
      $post = Post::findOrFail($id);
      $post->title = $request->input('title');
      $post->content = Purifier::clean($request->get('content'), 'youtube');
      $post->category_id = $request->input('category_id');
      $post->media_id = $request->input('media_id');
      $post->user_id = $request->input('user_id');
      $post->save();

      if (isset($request->tags)) {
        $post->tags()->sync($request->tags);
      } else {
        $post->tags()->sync(array());
      }


      return redirect('/admin/posts')->with('status', 'Post saved!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      $post = Post::findOrFail($id);
      $post->delete();
      return redirect('/admin/posts')->with('status', 'Post deleted!');
  }
}
