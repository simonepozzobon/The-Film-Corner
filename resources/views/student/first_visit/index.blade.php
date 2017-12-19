@extends('layouts.student')
@section('title', 'Welcome')
@section('content')
  <div id="app" class="container">
    @include('components.apps.heading_simple', ['title' => 'Welcome'])
    <div class="row mt">
      <div class="col">
        @php
          $text = [
            'part_1' => GeneralText::field('welcome_part_1'),
            'part_2' => GeneralText::field('welcome_part_2'),
            'part_3' => GeneralText::field('welcome_part_3'),
          ];
          $texts = json_encode($text)
        @endphp
        <welcome-form
          user="{{ Auth::guard('student')->user() }}"
          user_type="{{ get_class(Auth::guard('student')->user()) }}"
          form="{{ $form }}"
          texts="{{ $texts }}"
        />
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box orange">
          <div class="box-header">
            Get Started
          </div>
          <div class="box-body">
            The Film Corner is divided into 2 sections, called STUDIOS, each one dedicated to an aspect of Film Education:<br>
            <ul>
              <li>
                Studio 1 is dedicated to film language and aesthetics, meaning the grammar of films,
                the way in which they build their own speech and tell a story. This section is subdivided in
                three educational projects: the first one dedicated to framing, the second to editing, the third one to sound.
              </li>
              <li>
                Studio 2 is dedicated to filmmaking and creativity and it is also subdivided in three educational projects:
                the first one includes some “warming-up” exercises, the second is about writing for cinema and the third one
                is a space in which you’ll be invited to experiment the creation of a short movie, using even something as handy as a mobile phone.
              </li>
            </ul>
            These aspects are so different that they are even dedicated two separate spaces within our platform. However,
            they have something in common: they are both based on the knowledge of cinematographic language and grammar.
            In fact, it is impossible to either analyze or create a film without knowing its language and aesthetics.
            This is the reason why we invite you to visit STUDIO 1 before visiting STUDIO 2.<br>
            <p class="text-center">
              <strong class="">Enjoy your trip in The Film Corner! See you outside!</strong>
            </p>
          </div>
          <div class="box-btns">
            <a href="{{ route('student') }}" class="btn btn-lg btn-orange"><i class="fa fa-hand-o-right"></i> Start</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/first-visit.js') }}"></script>
@endsection
