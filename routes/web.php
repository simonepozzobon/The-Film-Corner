<?php

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

use App\Post;


Route::get('/', function () {
    return view('welcome');
});

// Admin panel view
Route::get('/admin/', function () {
  return view('admin');
});

// Admin Panel Routes
Route::group(['prefix' => 'admin'], function () {
  Route::resource('posts', 'PostController');
  Route::resource('users', 'UserController');
});

// Posts Loop
Route::get('/posts/', function () {
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
