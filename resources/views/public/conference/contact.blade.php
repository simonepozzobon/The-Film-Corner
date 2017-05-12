@extends('layouts.conference')
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
  <div class="block-subtitle mt-5">
    <h4>Contacts and Informations</h4>
  </div>
  <div class="block-text mb-5">
    <p class="text-justify">
      Fondazione Cineteca Italiana<br>
      Viale Fulvio Testi, 121<br>
      20126 Milan<br>
      Tel. +39 02 87 24 21 14<br>
      <br>
      Press office:<br>
      Cristiana Ferrari<br>
      <a href="mailto:thefilmcorner@cinetecamilano.it">thefilmcorner@cinetecamilano.it</a>
      <a href="mailto:ufficiostampa@cinetecamilano.it">ufficiostampa@cinetecamilano.it</a>
    </p>
  </div>
@endsection
