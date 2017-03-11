<?php

use App\Post;
use App\Partner;

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

// need to create a controller for these maybe Main or FrontendController
Route::get('/', function () {
    $posts = Post::latest()->limit(5)->get();
    $partners = Partner::all();
    return view('new')
                ->with('posts', $posts)
                ->with('partners', $partners);
});

Route::get('blog/{slug}', 'Blog\BlogController@getSingle')->where('slug', '[\w\d\-\_]+')->name('blog.post');

Route::get('/posts', function () {
  $posts = Post::with('author')->get();
  return view('blog.list')->with('posts', $posts);
});

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
  Route::get('/logout', 'Auth\AdminLoginController@logout');
  Route::get('/', 'AdminController@index')->name('admin');

  // Dashboard

  // Post menu routes
  Route::resource('posts', 'Admin\PostController');
  Route::resource('media', 'Admin\MediaController', ['except' => ['show', 'create']]);
  Route::resource('categories', 'Admin\CategoryController', ['except' => ['show', 'create'] ]);
  Route::resource('tags', 'Admin\TagController', ['except' => ['show', 'create'] ]);

  // Users menu routes
  Route::get('/admins', 'Admin\AdminController@index')->name('admin.admins.index');
  Route::resource('teachers', 'Admin\TeacherController', ['except' => ['create']]);
  Route::post('teachers/{teacher}', 'Admin\TeacherController@storeStudent')->name('teacher.store.student');
  Route::resource('students', 'Admin\StudentController', ['except' => ['create']]);
  Route::resource('users', 'Admin\UserController', ['except' => ['create']]);
  Route::resource('schools', 'Admin\SchoolController', ['except' => ['create']]);
  Route::resource('partners', 'Admin\PartnerController', ['except' => ['create'] ]);

});

// Teacher Panel Teacher
Route::prefix('teacher')->group(function() {
  // Auth
  Route::get('/login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
  Route::post('/login', 'Auth\TeacherLoginController@login')->name('teacher.login.submit');
  Route::get('/logout', 'Auth\TeacherLoginController@logout');
  Route::get('/', 'TeacherController@index')->name('teacher');
});


// Student Panel Routes
Route::prefix('student')->group(function() {
  // Auth
  Route::get('/login', 'Auth\StudentLoginController@showLoginForm')->name('student.login');
  Route::post('/login', 'Auth\StudentLoginController@login')->name('student.login.submit');
  Route::get('/logout', 'Auth\StudentLoginController@logout');
  Route::get('/', 'StudentController@index')->name('student');
});
