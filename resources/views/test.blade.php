@extends('layouts.main')
@section('title', 'test')
@section('content')
  <script src="//localhost:6001/socket.io/socket.io.js"></script>

  <div id="app" class="container pt-5 mt-5">
    <h1>
      Chat {{ $model }}
    </h1>
    <div class="row">
      <div class="col">
        <tfc-chat title="Chat" type="{{ $model }}" user="{{ $user->id }}" contacts="{{ $contacts }}">
        </tfc-chat>
      </div>
    </div>
    <div class="row">
      <div class="col">

      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/socket-test.js') }}"></script>
@endsection
