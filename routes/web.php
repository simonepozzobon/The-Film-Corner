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
    $posts = Post::where('category_id', '=', 1)->latest()->limit(5)->get();
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

Route::get('/map', 'MapController@index')->name('map.index');


// Feedback controller
Route::post('/feedback', 'Main\FooterController@store')->name('send.feedback');


Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

// Admin Panel Routes
Route::prefix('admin')->group(function () {

  // Auth
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
  Route::get('/', 'AdminController@index')->name('admin');

  // Web menu routes
  Route::resource('posts', 'Admin\PostController');
  Route::resource('media', 'Admin\MediaController', ['except' => ['show', 'create']]);
  Route::resource('categories', 'Admin\CategoryController', ['except' => ['show', 'create'] ]);
  Route::resource('tags', 'Admin\TagController', ['except' => ['show', 'create'] ]);

  // Apps menu settings
  Route::prefix('app')->group(function () {
    Route::resource('app_1', 'Admin\App\App1Controller');
  });

  // Maps settings
  Route::prefix('map')->group( function() {
    Route::prefix('api')->group(function() {
      Route::get('/{id}/edit', 'Admin\PointController@edit')->name('api.map.edit');
      Route::put('/{id}', 'Admin\PointController@update')->name('api.map.update');
      Route::post('/', 'Admin\PointController@store')->name('api.map.store');
      Route::delete('/{id}', 'Admin\PointController@destroy')->name('api.map.delete');
      Route::get('/', 'Admin\PointController@index')->name('api.map.index');
    });

    // ...admin/map/ to show index
    Route::get('/', function() {
      return view('admin.map.index');
    });
  });

  // Users menu routes
  Route::get('/admins', 'Admin\AdminController@index')->name('admin.admins.index');
  Route::resource('teachers', 'Admin\TeacherController', ['except' => ['create']]);
  Route::post('teachers/{teacher}', 'Admin\TeacherController@storeStudent')->name('teacher.store.student');
  Route::resource('students', 'Admin\StudentController', ['except' => ['create']]);
  Route::resource('users', 'Admin\UserController', ['except' => ['create']]);
  Route::resource('schools', 'Admin\SchoolController', ['except' => ['create']]);

  // Settings menu routes
  Route::resource('partners', 'Admin\PartnerController', ['except' => ['create'] ]);

});

// Teacher Panel Teacher
Route::prefix('teacher')->group(function() {
  // Auth
  Route::get('/login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
  Route::post('/login', 'Auth\TeacherLoginController@login')->name('teacher.login.submit');
  Route::get('/logout', 'Auth\TeacherLoginController@logout')->name('teacher.logout');
  Route::get('/', 'TeacherController@index')->name('teacher');

  // Apps
  Route::get('/app', 'AppController@firstApp')->name('app.first');
});


// Student Panel Routes
Route::prefix('student')->group(function() {
  // Auth
  Route::get('/login', 'Auth\StudentLoginController@showLoginForm')->name('student.login');
  Route::post('/login', 'Auth\StudentLoginController@login')->name('student.login.submit');
  Route::get('/logout', 'Auth\StudentLoginController@logout');
  Route::get('/', 'StudentController@index')->name('student');
});

Route::prefix('test')->group(function () {
  Route::prefix('api')->group(function () {
    Route::get('/{id}', 'TestController@show')->name('api.categories.show');
    Route::delete('/{id}', 'TestController@destroy')->name('api.categories.delete');
    Route::post('/', 'TestController@store')->name('api.categories.store');
    Route::get('/', 'TestController@index')->name('api.categories.index');
  });
  Route::get('/', function() { return view('test'); });
});
