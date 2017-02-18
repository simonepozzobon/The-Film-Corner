<nav class="navbar navbar-inverse">
  <div class="navbar-header">
    <a class="navbar-brand" href="{{ url('admin') }}">Admin</a>
  </div>
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        Post
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <li><a href="{{ url('admin/posts') }}">All Post</a></li>
        <li><a href="{{ url('admin/posts/create') }}">Add Post</a></li>
      </ul>
    </li>
  </ul>
</nav>
