<!DOCTYPE html>
@if (!isset($type))
  {{ $type = '' }}
@endif
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>


    @yield('section')
    @include('layouts.student._head')
  </head>
  <body>
    @include('layouts.student._menu')

    <div id="fullscreen-messages">
      <message></message>
    </div>

    @if ($type == 'app')
      <main>
        @yield('content')
      </main>
    @else
      @yield('content')
    @endif

    @php
      if (!isset($footer)) {
        $footer = '';
      }
    @endphp
    @include('layouts.student._footer', ['footer' => $footer])
    @include('layouts.student._scripts', ['type' => $type])
    <script src="{{ mix('js/message.js') }}"></script>
  </body>
</html>
