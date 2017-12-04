@extends('layouts.teacher')
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
          user="{{ Auth::guard('teacher')->user() }}"
          user_type="{{ get_class(Auth::guard('teacher')->user()) }}"
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
            {!! GeneralText::field('welcome_get_started') !!}
          </div>
          <div class="box-btns">
            <a href="{{ route('teacher') }}" class="btn btn-lg btn-orange"><i class="fa fa-hand-o-right"></i> Start</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/first-visit.js') }}"></script>
@endsection
