@extends('layouts.conference', ['active' => 'schedule'])
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
  <div class="row">
    <div class="col">
      <div class="block-subtitle mt-5">
        <h4>Schedule Draft</h4>
      </div>
    </div>
  </div>
  <div class="block-text">
    <div class="row">
      <div class="col">
        <h5>2017, November, 9th</h5>
      </div>
    </div>
    <div class="row pt-3">
      <div class="col-sm-2 offset-sm-1">
        <b>17:00</b>
      </div>
      <div class="col-sm-9">
        Visit to MIC
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <b>18:30</b>
      </div>
      <div class="col-sm-9">
        Networking cocktail
      </div>
    </div>
    <div class="row pt-3">
      <div class="col">
        <h5>2017, november, 10th</h5>
      </div>
    </div>
    <div class="row pt-3">
      <div class="col-sm-2 offset-sm-1">
        <b>9:30 to 9:45</b>
      </div>
      <div class="col-sm-9">
        Registration and welcome coffee
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <b>9:45 to 10:30</b>
      </div>
      <div class="col-sm-9">
        Institutional greetings
        <ul>
          <li>EACEA, European Commission</li>
          <li>MIBACT-Ministry of Culture</li>
          <li>USR, MIUR-Ministry of Education</li>
          <li>Regione Lombardia</li>
          <li>Comune di Milano</li>
          <li>Fondazione Cineteca Italiana</li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <b>10:30 to 11:30</b>
      </div>
      <div class="col-sm-9">
        Introduction to The Film Corner platform
        <ul>
          <li>Fondazione Cineteca Italiana</li>
          <li>Jugoslovenska Kinoteka</li>
          <li>University of Milano-Bicocca</li>
          <li>The Nerve Centre</li>
          <li>The Film space</li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <b>11:30 to 11:45</b>
      </div>
      <div class="col-sm-9">
        Coffee break
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <b>11:45 to 13:30</b>
      </div>
      <div class="col-sm-9">
        Film education and audience development in the digital era
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <b>13:30 to 14:30</b>
      </div>
      <div class="col-sm-9">
        Lunch break
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <b>14:30 to 16:00</b>
      </div>
      <div class="col-sm-9">
        Best practices: a European panorama
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <b>16:00 to 16:15</b>
      </div>
      <div class="col-sm-9">
        Coffee break
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2 offset-sm-1">
        <b>16:15 to 17:30</b>
      </div>
      <div class="col-sm-9">
        The role of cinémathèques in film education and audience development in the digital era
      </div>
    </div>
  </div>
@endsection
