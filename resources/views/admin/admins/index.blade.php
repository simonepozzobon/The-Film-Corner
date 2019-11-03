@extends('layouts.admin')
@section('title')
 Super Admin
@endsection
@section('page-title')
  Admin List
@endsection
@section('content')
  <table class="table table-hover">
    <thead>
      <th>Id</th>
      <th>Name</th>
      <th>Email</th>
      <th>Created At</th>
      <th>Updated At</th>
    </thead>
    <tbody>
      @foreach ($admins as $admin)
        <tr>
          <td>{{ $admin->id }}</td>
          <td>{{ $admin->name }}</td>
          <td>{{ $admin->email }}</td>
          <td>{{ $admin->created_at }}</td>
          <td>{{ $admin->updated_at }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
