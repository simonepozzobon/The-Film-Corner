<?php

use App\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    $posts = Post::with('author')->get();
    return view('welcome')->with('posts', $posts);
});

// Admin Panel Routes
Route::group(['prefix' => 'admin'], function () {
  Route::resource('posts', 'PostController');
  Route::resource('users', 'UserController', ['except' => ['create']]);
  Route::resource('media', 'MediaController', ['except' => ['show', 'create']]);
  Route::resource('categories', 'CategoryController', ['except' => ['show', 'create'] ]);
});



// Posts Loop
Route::get('/posts', function () {
  $posts = Post::with('author')->get(); // Prende tutti i post integrandoli con l'autore vd. app/Post.php
  return view('blog.list')->with('posts', $posts); // Ritorno la view con i post
});

// Single Post
Route::get('/post/{id}', function ($id) {
  $post = Post::findOrFail($id); // Prende i post con id
  return view('blog.post')->with('post', $post); // ritorno la view con il post
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/admin', 'Admincontroller@index');
