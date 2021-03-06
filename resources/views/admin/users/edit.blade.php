@extends('layouts.admin')

@section('title')
  Edit User - {{ $user->name }}
@endsection
@section('page-title')
  Edit User - {{ $user->name }}
@endsection

@section('content')
      <form action="/admin/users/{{ $user->id }}" method="POST">
        <div class="form-group">
          <label for="name">Name</label>
          <input name="name" value="{{ $user->name }}" type="text"class="form-control" id="name" placeholder="Name of the user">
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input name="email" value="{{ $user->email }}" class="form-control" id="content" placeholder="user@email.com">
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input name="password" value="{{ $user->password }}" type="password" class="form-control" id="password" placeholder="password">
        </div>
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <button type="submit" class="btn btn-success" value="Submit">Save</button>

      </form>
@endsection
