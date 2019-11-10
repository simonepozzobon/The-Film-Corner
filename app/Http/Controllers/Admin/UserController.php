<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;

class UserController extends Controller
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
      $users = User::all();
      return view('admin.users.index')->with('users', $users);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreUser $request)
  {
      $user = new User;
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->password = $request->input('password');
      $user->save();
      $request->session()->flash('success', 'New user created!');
      return redirect('/admin/users');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
      //disabled for now
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
      $user = User::findOrFail($user->id);
      return view('admin.users.edit')->with('user', $user);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateUser $request, User $user)
  {
      $user = User::findOrFail($user->id);
      $user->name = $request->get('name');
      $user->email = $request->get('email');
      $user->password = $request->get('password');
      $user->save();
      $request->session()->flash('success', 'User saveed!');
      return redirect('/admin/users');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    $user = User::findOrFail($user->id);
    $user->delete();
    session()->flash('success', 'User deleted!');
    return redirect('/admin/users');
  }
}
