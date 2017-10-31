<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  @include('layouts.main._head')
  <body>
    <div class="wrapper">
      @include('layouts.main._menu')
      <main>
        <div class="container">
          <div class="row">
            <div class="col mt-5">
              <section>
                <div class="row pt-5">
                  <div id="international-conference" class="tween-content-container block-wrapper col">
                    <div id="conference-title" class="title text-center pb-3">
                      The International Conference
                    </div>
                    <nav class="navbar navbar-light bg-faded rounded navbar-toggleable-md">
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
                          <li class="nav-item {{ $active == 'application' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('conference.application') }}">Online Application</a>
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
                        </ul>
                      </div>
                    </nav>
                    @yield('content')
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </main>
      <div class="p-5">

      </div>
      @include('layouts.main._footer')
      @include('layouts.main._scripts')
    </div>
  </body>
</html>
