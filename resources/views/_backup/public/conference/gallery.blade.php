@extends('layouts.conference', ['active' => 'gallery'])
@section('title', 'Gallery')
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
<div class="conference-container">
  <div class="row">
      @foreach ($images as $key => $img)
        <div class="col-md-4 pb">
          <img class="img-fluid" src="{{ Storage::disk('local')->url($img->thumb) }}">
        </div>
      @endforeach
  </div>
</div>
@endsection
