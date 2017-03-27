<nav class="navbar navbar-toggleable-md navbar-light bg-faded fixed-top">
  {{-- Mobile --}}
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#menu-main" aria-controls="menu-main" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- Logo --}}
  <a href="{{ url('/') }}" class="navbar-brand mr-4"><img src="/img/logo.png" height="50"></a>

  {{-- Desktop --}}
  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav justify-content-end">
      <li class="nav-item">
        <a href="#project" class="nav-link">The Project</a>
      </li>
      <li class="nav-item">
        <a href="#conference" class="nav-link">Conference</a>
      </li>
      <li class="nav-item">
        <a href="#partners" class="nav-link">Partners</a>
      </li>
      <li class="nav-item">
        <a href="#apps" class="nav-link">Apps</a>
      </li>
      <li class="nav-item">
        <a href="#login" class="nav-link">Login</a>
      </li>
    </ul>
  </div>
</nav>
