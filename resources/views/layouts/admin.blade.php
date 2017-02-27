<!DOCTYPE html>
<html>
  @include('layouts.admin._head')
  <body>
    @include('layouts.admin._menu')
    <br><br>

    <div class="container">
      <br>
      @yield('content')
    </div>
    @include('layouts.admin._footer')
    @include('layouts.admin_scripts')
  </body>
</html>
