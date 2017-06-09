<nav id="main-menu" class="navbar navbar-toggleable-md navbar-light bg-faded fixed-top">
  {{-- Mobile --}}
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#menu-main" aria-controls="menu-main" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- Logo --}}
  <a href="{{ url('/') }}" class="navbar-brand mr-4"><img src="/img/logo.png" height="50"></a>
  <a href="#" class="navbar-brand mr-4"><img src="/img/creative-europe-media.png" height="50" alt=""></a>

  {{-- Desktop --}}
  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav justify-content-end">
      <li class="nav-item">
        <a href="{{ url('/student') }}" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/student') }}" class="nav-link"><i class="fa fa-film" aria-hidden="true"></i> Apps</a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/student') }}" class="nav-link"><i class="fa fa-share-alt" aria-hidden="true"></i> Network</a>
      </li>
    </ul>
  </div>
</nav>
