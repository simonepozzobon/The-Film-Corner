<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Film Corner - @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,400,600,700" rel="stylesheet" type="text/css">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    {{-- Monsterrat Google Font --}}
    <link href="https://fonts.googleapis.com/css?family=Montserrat:900i" rel="stylesheet">

    {{-- Main Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Google Analytics --}}
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-92981271-1', 'auto');
      ga('send', 'pageview');

    </script>

    <style media="screen">

    html, body {
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
        background-position: center center;
        background-attachment: fixed;
        background-size: cover;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
    </style>
    @yield('stylesheets')
</head>
