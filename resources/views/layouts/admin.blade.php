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
    <div class="copyright text-center mt-5">
      © Copyright 2017 Simone Pozzobon
    </div>

    {{-- Bootstrap --}}
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="{{ asset('admin-assets/js/image-picker.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/custom.js') }}"></script>

    @yield('scripts')
  </body>
</html>
