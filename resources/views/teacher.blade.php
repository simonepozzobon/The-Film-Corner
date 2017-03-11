@extends('layouts.teacher')
@section('title', 'Teacher Panel')
@section('page-title', 'Teacher Panel')
@section('content')
  <div class="clearfix">
    <span class="alert alert-info d-block">Welcome back {{ $teacher->name }}</span>
    <a href="{{ route('app.first') }}" class="btn btn-primary btn-lg btn-block">First App</a>
  </div>
@endsection
