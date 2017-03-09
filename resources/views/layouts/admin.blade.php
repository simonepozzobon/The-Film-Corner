<!DOCTYPE html>
<html>
  @include('layouts.admin._head')
  <body>
    @include('layouts.admin._menu')
    <div class="container mt-5">
      <div class="clearfix mt-5 mb-5">
        <h1>@yield('page-title')<h1>
      </div>

      @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
          {{ session()->get('success') }}
        </div>
      @endif

      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif
      <div class="mt-4">
      </div>
      @yield('content')
    </div>
    @include('layouts.admin._footer')
    @include('layouts.admin._scripts')
  </body>
</html>
