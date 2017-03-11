<!DOCTYPE html>
<html>
  @include('layouts.teacher._head')
  <body>
    @include('layouts.teacher._menu')
    <div class="container mt-3">
      <div class="clearfix mb-4">
        <h1 class="bg-faded p-3">@yield('page-title')</h1>
      </div>

      @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
          <strong>Success:</strong> {{ session()->get('success') }}
        </div>
      @endif

      @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <strong>Errors:</strong>
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
        </div>
      @endif

      @if (session('status'))
        <div class="alert alert-info">
          {{ session('status') }}
        </div>
      @endif

      @if (session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
      @endif

      @yield('content')
    </div>
    @include('layouts.teacher._footer')
    @include('layouts.teacher._scripts')
  </body>
</html>
