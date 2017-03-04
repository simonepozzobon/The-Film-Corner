<head>
  <meta charset="utf-8">
  <meta name="description" content="Admin Template">
  <meta name="author" content="Simone Pozzobon">

  <title>Admin Panel - @yield('title')</title>

  {{-- Normalize Css --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  {{-- Bootstrap --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  {{-- <link rel="stylesheet" href="{{ asset('admin-assets/css/material.min.css') }}"> --}}
  {{-- Image Picker --}}
  <link rel="stylesheet" href="{{ asset('admin-assets/css/image-picker.css') }}">
  {{-- Custom Style --}}
  <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">

  {{-- Google Analytics --}}
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92981271-1', 'auto');
  ga('send', 'pageview');

</script>

  @yield('stylesheets')

</head>
