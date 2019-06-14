<!DOCTYPE html>
<html>
  @include('layouts.user._head')
  <body>
    @include('layouts.user._menu')
    <br><br>

    <div class="container">
      <br>
      @yield('content')
    </div>
    @include('layouts.user._footer')
    @include('layouts.user._scripts')
  </body>
</html>
