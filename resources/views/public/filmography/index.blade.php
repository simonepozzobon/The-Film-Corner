@extends('layouts.main')
@section('title', 'Filmography')
@section('content')
<div class="container">
  <div class="row mt">
    <div class="col">
      <div class="conference-container">
        <h1 class="mt">Filmography</h1>
        <ul>
          @foreach (\Filmography::get_all() as $key => $filmography)
            <li>{{ $filmography->title }} - {{ $filmography->description }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
