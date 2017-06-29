<!DOCTYPE html>
@if (!isset($type))
  {{ $type = '' }}
@endif
<html>
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    @yield('section')
    @include('layouts.teacher._head')
  </head>
  <style media="screen">
    body {
      background: url('{{ asset('img/helpers/back.png') }}') repeat repeat;
    }
  </style>
  <body>
    @include('layouts.teacher._menu')
    @yield('content')
    @include('layouts.teacher._scripts', ['type' => $type])
  </body>
</html>
