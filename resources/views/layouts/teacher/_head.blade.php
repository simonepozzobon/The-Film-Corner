<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Film Corner - @yield('title')</title>

    {{-- Main Stylesheet --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- reCaptcha google --}}
    {{-- <script src='//www.google.com/recaptcha/api.js'></script> --}}

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
          font-weight: 200;
          height: 100%;
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

      .feedback-popup {
        position: fixed;
        z-index: 2;
        margin-left: -1rem;
        top: 25%;
        transform: translateY(-50%);
      }

      .frame {
        box-shadow: 0px -2px 19px 0px rgba(50, 50, 50, 0.125);
      }
    </style>
    @yield('stylesheets')
</head>
