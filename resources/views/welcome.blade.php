<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Frontend</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        {{-- Bootstrap --}}
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

        <link rel="stylesheet" href="/css/style.css">
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

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #252525;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
        </style>

    </head>
    <body>
        <section class="hero home">
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="logo">
                  <img src="/img/logo.png">
                </div>
                <div class="title m-b-md">
                    The Film Corner
                </div>

                <div class="links">
                  <a href="#">The Project</a>
                  <a href="#">Partners</a>
                  <a href="#">Login</a>
                  <a href="#">Apps</a>
                  <a href="#">Resources</a>
                  <a href="#">Login</a>
                </div>
            </div>
        </div>
        <svg class="arrows">
							<path class="a1" d="M0 0 L15 16 L30 0"></path>
							<path class="a2" d="M0 10 L15 26 L30 10"></path>
							<path class="a3" d="M0 20 L15 36 L30 20"></path>
				</svg>
        <section>
          <div class="title sp-center">
            News
          </div>
          @if (count($posts)===0)
            <h1>No posts to show</h1>
          @endif
          <div class="grid">
            @foreach ($posts as $post)
              <div class="grid-item">
                <div class="overlay"></div>
                <img class="" src="{{ Storage::disk('local')->url($post->featuredImage->url) }}">
                <div class="grid-caption">
                  <h1>{{ $post->title }}</h1>
                  <p>{{ $post->content }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </section>

        {{-- Script --}}
        <script src="js/app.js"></script>
        <script src="https://unpkg.com/packery@2/dist/packery.pkgd.min.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>
