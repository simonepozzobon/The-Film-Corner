<?php

use App\Post;

// use Symfony\Component\Debug\Debug;
// Debug::enable();

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

// Posts Loop
Route::get('/posts', function () {
  $posts = Post::with('author')->get();
  return view('blog.list')->with('posts', $posts);
});

// Single Post
Route::get('/post/{id}', function ($id) {
  $post = Post::findOrFail($id); // Prende i post con id
  return view('blog.post')->with('post', $post); // ritorno la view con il post
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

// Admin Panel Routes
Route::prefix('admin')->group(function () {

  // Auth
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/', 'AdminController@index')->name('admin');

  // Dashboard
  Route::resource('posts', 'PostController');
  Route::resource('users', 'UserController', ['except' => ['create']]);
  Route::resource('media', 'MediaController', ['except' => ['show', 'create']]);
  Route::resource('categories', 'CategoryController', ['except' => ['show', 'create'] ]);

});
