@extends('layouts.main')
@section('title', 'Filmography')
@section('content')
<div class="container">
  <div class="row mt">
    <div class="col">
      <div class="conference-container">
        <h1 class="mt">FILMOGRAPHY</h1>
        <ul>
          @foreach ($filmographies as $key => $filmography)
            <li>{{ $filmography->title }} - {{ $filmography->description }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
