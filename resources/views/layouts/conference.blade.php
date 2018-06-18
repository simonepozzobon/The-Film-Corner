<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  @include('layouts.main._head')
  <style media="screen">
    #international-conference .active > .nav-link{
        color: rgba(37, 37, 37, 0.7);
    }
  </style>
  <body>
    @include('layouts.main._menu')
    <div class="container">
      <div class="row mt">
        <div class="col">
          <div class="title-wrapper bg-faded">
            <div class="title">
              The International Conference
            </div>
          </div>
          <div class="row mt">
            <div id="international-conference" class="tween-content-container block-wrapper col">
              <nav class="navbar navbar-light bg-faded navbar-toggleable-md">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#containerNavbarCenter" aria-controls="containerNavbarCenter" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-md-center" id="containerNavbarCenter">
                  <ul class="navbar-nav">
                    <li class="nav-item {{ $active == 'home' ? 'active' : '' }}">
                      <a class="nav-link" href="{{ route('conference') }}">General Info <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item {{ $active == 'about' ? 'active' : '' }}">
                      <a class="nav-link" href="{{ route('conference.about') }}">About</a>
                    </li>
                    <li class="nav-item {{ $active == 'schedule' ? 'active' : '' }}">
                      <a class="nav-link" href="{{ route('conference.schedule') }}">Schedule Draft</a>
                    </li>
                    <li class="nav-item {{ $active == 'accomodation' ? 'active' : '' }}">
                      <a class="nav-link" href="{{ route('conference.accomodation') }}">Accomodation</a>
                    </li>
                    <li class="nav-item {{ $active == 'download' ? 'active' : '' }}">
                      <a class="nav-link" href="{{ route('conference.download') }}">Download & Press</a>
                    </li>
                    <li class="nav-item {{ $active == 'contact' ? 'active' : '' }}">
                      <a class="nav-link" href="{{ route('conference.contact') }}">Contact & Info</a>
                    </li>
                    <li class="nav-item {{ $active == 'gallery' ? 'active' : '' }}">
                      <a class="nav-link" href="{{ route('conference.gallery') }}">Gallery</a>
                    </li>
                  </ul>
                </div>
              </nav>
            </div>
          </div>
          <div class="row mt">
            <div class="col">
              @yield('content')
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('layouts.main._footer')
    @include('layouts.main._scripts')
  </body>
</html>
