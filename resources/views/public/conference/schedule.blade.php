@extends('layouts.conference')
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
  <div class="block-subtitle mt-5">
    <h4>Schedule Draft</h4>
  </div>
  <div class="block-text">
    <p class="text-justify">
      <b>2017, November, 9th</b>
      <ul>
        <li>17:00 - visit to MIC</li>
        <li>18:30 - networking cocktail</li>
      </ul>
    </p>
    <p class="text-justify">
      <b>2017, november, 10th</b>
      <ul>
        <li>9:30 to 9:45 - registration and welcome coffee</li>
        <li>9:45 to 10:30 - institutional greetings<br>
          <ul>
            <li>EACEA, European Commission</li>
            <li>MIBACT-Ministry of Culture</li>
            <li>USR, MIUR-Ministry of Education</li>
            <li>Regione Lombardia</li>
            <li>Comune di Milano</li>
            <li>Fondazione Cineteca Italiana</li>
          </ul>
        </li>
        <li>10:30 to 11:30 - Introduction to The Film Corner platform<br>
          <ul>
            <li>Fondazione Cineteca Italiana</li>
            <li>Jugoslovenska Kinoteka</li>
            <li>University of Milano-Bicocca</li>
            <li>The Nerve Centre</li>
            <li>The Film space</li>
          </ul>
        </li>
        <li>11:30 to 11:45 - coffee break</li>
        <li>11:45 to 13:30 - Film education and audience development in the digital era</li>
        <li>13:30 to 14:30 - lunch break</li>
        <li>14:30 to 16:00 - Best practices: a European panorama</li>
        <li>16:00 to 16:15 - coffee break</li>
        <li>16:15 to 17:30 - the role of cinémathèques in film education and audience development in the digital era</li>
      </ul>
    </p>
  </div>
@endsection
