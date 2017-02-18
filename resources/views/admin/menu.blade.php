<nav class="navbar fixed-top navbar-toggleable-md bg-faded mtr-8dp">
  {{-- Mobile --}}
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- Logo --}}
  <a class="navbar-brand" href="{{ url('admin') }}">Admin</a>
  {{-- Desktop --}}
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Post
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="{{ url('admin/posts') }}">All Post</a>
          <a class="dropdown-item" href="{{ url('admin/posts/create') }}">Add Post</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<br><br>
