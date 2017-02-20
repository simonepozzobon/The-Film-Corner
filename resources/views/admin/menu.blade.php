<nav class="navbar fixed-top navbar-toggleable-md bg-faded mtr-8dp">
  {{-- Mobile --}}
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- Logo --}}
  <a class="navbar-brand" href="{{ url('admin') }}">Admin Panel</a>
  {{-- Desktop --}}
  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <li class="nav-link">
      <a href="{{ url('admin/posts') }}">Posts</a>
    </li>

    <li class="nav-link disabled">Pages</li>
    <li class="nav-link">
      <a href="{{ url('admin/media') }}">Media</a>
    </li>
    <li class="nav-link">
      <a href="{{ url('admin/users') }}">Users</a>
    </li>
    <li class="nav-link disabled">Logout</li>

  </div>
</nav>
<br><br>
