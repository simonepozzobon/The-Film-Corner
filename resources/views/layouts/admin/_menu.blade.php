<nav class="navbar fixed-top navbar-toggleable-md bg-faded">
  {{-- Mobile --}}
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- Logo --}}
  <a href="{{ url('/admin') }}" class="navbar-brand mr-4"><img src="/img/logo.png" height="50"></a>
  <div class="collapse navbar-collapse justify-content-start" id="">
    @if (Auth::guard('admin')->check())
      <li class="nav-link">Super Admin Panel</li>
      <li class="nav-link">
        <a href="{{ url('/') }}">Visit Website</a>
      </li>
    @endif
  </div>
  {{-- Desktop --}}
  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">

    @if (Auth::guard('admin')->check())
      <li class="nav-link dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Posts <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="nav-link"><a href="{{ url('admin/posts') }}">Posts</a></li>
          <li class="nav-link "><a href="{{ url('admin/media') }}">Media</a></li>
          <div class="dropdown-divider"></div>
          <li class="nav-link"><a href="{{ url('admin/categories') }}">Categories</a></li>
        </ul>
      </li>

      <li class="nav-link disabled">Pages</li>

      <li class="nav-link dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="nav-link"><a href="{{ url('admin/admins/') }}">Admins</a></li>
          <li class="nav-link "><a href="{{ url('admin/teachers/') }}">Teachers</a></li>
          <li class="nav-link"><a href="#">Students</a></li>
          <li class="nav-link"><a href="{{ url('admin/users') }}">Users</a></li>
          <div class="dropdown-divider"></div>
          <li class="nav-link"><a href="#">Schools</a></li>
        </ul>
      </li>
      <li class="nav-link">

      </li>
      <li class="nav-link"><a href="{{ url('admin/logout') }}">Logout</a></li>
    @endif

  </div>
</nav>
