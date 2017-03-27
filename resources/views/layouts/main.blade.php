<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  @include('layouts.main._head')
  <body>
    @include('layouts.main._menu')
    @yield('content')
    @include('layouts.main._footer')
    @include('layouts.main._scripts')
  </body>
</html>
