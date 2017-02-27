<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Media;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
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

        $users = User::all();
        $media = Media::all();
        $categories = Category::all();
        return view('admin.posts.create')
                      ->with('users', $users)
                      ->with('medias', $media)
                      ->with('categories', $categories);
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
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $post->media_id = $request->input('media_id');
        $post->user_id = $request->input('user_id');

        $post->save();

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
<<<<<<< Updated upstream
        $post = Post::findOrFail($id);
        return view('admin.posts.show')->with('post', $post);
=======
        //disabled for now
>>>>>>> Stashed changes
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
        $users = User::all();
        $media = Media::all();
        $categories = Category::all();

        return view('admin.posts.edit')
                      ->with('post', $post)
                      ->with('users', $users)
                      ->with('medias', $media)
                      ->with('categories', $categories);
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
        $post->title = $request->get('title');
        $post->content = $request->get('content');
        $post->category_id = $request->get('category_id');
        $post->media_id = $request->get('media_id');
        $post->user_id = $request->get('user_id');
        $post->save();

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
