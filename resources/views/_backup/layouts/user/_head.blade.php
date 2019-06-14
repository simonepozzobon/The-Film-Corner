<head>
  <meta charset="utf-8">
  <meta name="description" content="Admin Template">
  <meta name="author" content="Simone Pozzobon">

  <title>Admin Panel - @yield('title')</title>

  {{-- Normalize Css --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  {{-- Bootstrap --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  {{-- Image Picker --}}
  <link rel="stylesheet" href="{{ asset('user-assets/css/image-picker.css') }}">
  {{-- Custom Style --}}
  <link rel="stylesheet" href="{{ asset('user-assets/css/style.css') }}">

  @yield('stylesheets')

</head>
