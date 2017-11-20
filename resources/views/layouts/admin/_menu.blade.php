<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a href="{{ route('admin') }}" class="navbar-brand"><img src="/img/logo.png" height="50" style="max-width: 40vw;"></a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    @if (Auth::guard('admin')->check())
      <ul class="navbar-nav mr-auto my-2">
        <li class="nav-item active">
          <a href="{{ url('/') }}" target="_blank" class="nav-link">Visit Website</a>
        </li>
      </ul>
      <ul class="navbar-nav my-2">
        <li id="video-menu" class="nav-item mr-sm-2">
          <a href="{{ route('admin.video') }}" class="nav-link">Video</a>
        </li>
        <li id="video-audio" class="nav-item mr-sm-2">
          <a href="{{ route('admin.audio') }}" class="nav-link">Audio</a>
        </li>
        <li class="nav-item mr-sm-2">
          <a href="{{ route('admin.image') }}" class="nav-link">Images</a>
        </li>
        <li class="nav-item mr-sm-2">
          <a href="{{ route('admin.conference.gallery.index') }}" class="nav-link">Conference</a>
        </li>
      </ul>
    @endif
  </div>

</nav>
