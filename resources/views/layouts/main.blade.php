<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  @include('layouts.main._head')
  <body>
    @yield('content')
    @include('layouts.main._footer')
    @include('layouts.main._scripts')
  </body>
</html>
