@extends('layouts.teacher')
@section('title', 'Welcome')
@section('content')
  <div id="app" class="container">
    @include('components.apps.heading_simple', ['title' => GeneralText::field('welcome')])
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
          short_introduction="{{ GeneralText::field('short_indtroduction') }}"
          first_word="{{ GeneralText::field('first_word') }}"
          second_word="{{ GeneralText::field('second_word') }}"
          third_word="{{ GeneralText::field('third_word') }}"
          your_answer="{{ GeneralText::field('your_answer') }}"
          texts="{{ $texts }}"
        />
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box orange">
          <div class="box-header">
            {{ GeneralText::field('get_started') }}
          </div>
          <div class="box-body">
            {!! GeneralText::field('welcome_get_started') !!}
          </div>
          <div class="box-btns">
            <a href="{{ route('teacher') }}" class="btn btn-lg btn-orange"><i class="fa fa-hand-o-right"></i> {{ GeneralText::field('start') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/first-visit.js') }}"></script>
@endsection
