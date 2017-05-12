@extends('layouts.conference', ['active' => 'home'])
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
<div class="block-container">
  <div class="block-text">
    <p class="text-justify">
      The conference is part of The Film Corner project aimed to the creation of an online interactive platform for film education addressed to European schools.
    </p>
  </div>
  <div class="block-subtitle mt-5">
    <h4>Where and When</h4>
  </div>
  <div class="block-text">
    <p class="text-justify">
      2017, Thu, November 9th, 5pm Italian time, MIC-Interactive Film Museum, viale Fulvio Testi, 121, Milan, Italy
      <br>
      2017, Fri, November, 10th, 9 am-6 pm Italian time, Cinema Oberdan, Viale Vittorio Veneto, 2, Milan, Italy
    </p>
  </div>
  <div class="block-subtitle mt-5">
    <h4>The Film Corner An Introduction</h4>
  </div>
  <div class="block-text">
    <p class="text-justify">
      <i>The Film Corner. Online and offline activities for Film Literacy</i> project aims to  design, release and test an online platform for film education, exploiting the opportunities available through web 2.0 and thus developing innovative crossmedia approaches to teaching appropriate to the digital era in order to raise the levels of film literacy of young audiences across the European Union.
      <br><br>
      The project involves 5 European institutions in 4 EU countries: Fondazione Cineteca Italiana (Milan, Italy) as coordinator; The Film Space (London, UK); The Nerve Centre (Derry, Northern Ireland); Jugoslovenska Kinoteka, the National Cinèmatheque of Serbia (Serbia, Belgrade); University of Milano Bicocca-Dipartimento di Scienze Umane per la Formazione Riccardo Massa (Milan, Italy).
      The platform includes <b>interactive didactical resources</b> with which the users can engage and thus develop their film literacy skills. The pedagogical resources will focus on film education skills explored through a number of EU national and non-national films.
      <br><br>
      The Film Corner. Online and offline activities for Film Literacy project is co-financed by the European Union in the context of the Creative Europe Programme of the European Union.
    </p>
  </div>
  <div class="block-subtitle mt-5">
    <h4>Registration and Deadline</h4>
  </div>
  <div class="block-text">
    <p class="text-justify">
      There are 180 places available for the conference and it is <b>free of charge</b>. If you’d like to join us, you can register using the form below <b>until 2017, july, 30th</b>. Keep updated through our social media accounts on Facebook and Twitter. Further details will be announced on the official website of The Film Corner.
    </p>
  </div>
</div>
@endsection
