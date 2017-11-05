<nav id="main-menu" class="navbar navbar-toggleable-md navbar-light bg-faded fixed-top">
  {{-- Mobile --}}
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#menu-main" aria-controls="menu-main" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- Logo --}}
  <div class="navbar-brand">
    <a href="{{ url('/') }}" class="mr-4"><img src="/img/logo.png" height="30"></a>
    <a href="#" class="mr-4"><img src="/img/creative-europe-media.png" height="30" alt=""></a>
  </div>

  {{-- Desktop --}}
  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav justify-content-end">
      <li class="nav-item">
        <span class="nav-link"> Hello, {{ Auth::guard('student')->user()->name }}</span>
      </li>
      <li class="nav-item">
        <a href="{{ url('/student') }}" class="nav-link"><i class="fa fa-film" aria-hidden="true"></i> Apps</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('student.network.index') }}" class="nav-link"><i class="fa fa-share-alt" aria-hidden="true"></i> Network</a>
      </li>
      {{-- <li class="nav-item">
        <a href="{{ route('student.settings.index') }}" class="nav-link"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
      </li> --}}
    </ul>
  </div>
</nav>
