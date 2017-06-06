<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    @yield('section')
    @include('layouts.student._head')
  </head>
  <style media="screen">
    body {
      background: url('{{ asset('img/helpers/back.png') }}') repeat repeat;
    }
  </style>
  <body>
    @include('layouts.student._menu')
    @yield('content')
    @include('layouts.student._scripts')
  </body>
</html>
