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
    @include('layouts.teacher._head')

  </head>
  <body>
    @include('layouts.teacher._menu')

    @yield('content')

    @php
      if (!isset($footer)) {
        $footer = '';
      }
    @endphp
    @include('layouts.teacher._footer', ['footer' => $footer])
    @include('layouts.teacher._scripts', ['type' => $type])
  </body>
</html>
