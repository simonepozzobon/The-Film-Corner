<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  {{-- Mobile --}}
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- Logo --}}
  <a href="{{ url('/admin') }}" class="navbar-brand"><img src="/img/logo.png" height="50" style="max-width: 40vw;"></a>
  <div class="collapse navbar-collapse justify-content-start" id="">
    @if (Auth::guard('teacher')->check())
      <li class="nav-link">
        <a href="{{ url('/') }}" target="_blank">Visit Website</a>
      </li>
    @endif
  </div>
  {{-- Desktop --}}
  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">

    @if (Auth::guard('teacher')->check())
      <li class="nav-link dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="nav-link"><a href="{{ route('admin.admins.index') }}">Admins</a></li>
          <li class="nav-link "><a href="{{ route('teachers.index') }}">Teachers</a></li>
          <li class="nav-link"><a href="{{ route('students.index') }}">Students</a></li>
          <li class="nav-link"><a href="{{ route('users.index') }}">Users</a></li>
          <div class="dropdown-divider"></div>
          <li class="nav-link"><a href="{{ route('schools.index') }}">Schools</a></li>
          <li class="nav-link"><a href="{{ route('partners.index') }}">Partners</a></li>
        </ul>
      </li>
      <li class="nav-link dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $teacher->name }} <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="nav-link">Edit Account<li>
          <div class="dropdown-divider"></div>
          <li class="nav-link"><a href="{{ url('admin/logout') }}">Logout</a></li>
        </ul>
      </li>
    @endif

  </div>
</nav>
