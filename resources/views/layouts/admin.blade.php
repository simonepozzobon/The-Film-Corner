<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.admin._head')
    <body>
        {{-- @include('layouts.admin._menu') --}}
        @yield('content')
        @include('layouts.admin._scripts')
    </body>
</html>
