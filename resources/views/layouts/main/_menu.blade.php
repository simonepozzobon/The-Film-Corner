<nav id="main-menu" class="navbar navbar-toggleable-md navbar-light bg-faded fixed-top">
  {{-- Mobile --}}
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="menu-main" aria-expanded="false" aria-label="Toggle navigation">
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
          <a href="{{ url('/') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/') }}#project" class="nav-link">The Project</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('conference') }}" class="nav-link">Conference</a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/') }}#partners" class="nav-link">Partners</a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Login
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="loginDropdown">
          <a class="dropdown-item" href="{{ route('teacher.login') }}">Teacher Login</a>
          <a class="dropdown-item" href="{{ route('student.login') }}">Student Login</a>
          <a class="dropdown-item disabled" href="#">Guest Login</a>
        </div>
      </li>
      </ul>
    </div>
</nav>
