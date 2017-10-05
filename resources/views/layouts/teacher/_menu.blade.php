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
        <span class="nav-link"> Hello, {{ Auth::guard('teacher')->user()->name }}</span>
      </li>
      <li class="nav-item">
        <a href="{{ url('/teacher') }}" class="nav-link"><i class="fa fa-film" aria-hidden="true"></i> Apps</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('teacher.network.index') }}" class="nav-link"><i class="fa fa-share-alt" aria-hidden="true"></i> Network</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('teacher.settings.index') }}" class="nav-link"><i class="fa fa-cog" aria-hidden="true"></i> Panel</a>
      </li>
    </ul>
    <div class="dropdown mt-2">
      @php
        $count = count(Auth::guard('teacher')->user()->unreadNotifications()->get())
      @endphp
      <span class="badge {{ $count > 0 ? 'badge-danger' : 'badge-default' }}" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $count }}</span>
      <div class="dropdown-menu dropdown-menu-right px-2" aria-labelledby="dropdownMenuLink">
        <h4 class="dropdown-header">Notifications</h4>
        <hr>
        @foreach (Auth::guard('teacher')->user()->unreadNotifications()->get() as $key => $notification)
          <a class="dropdown-item" href="#">You have a new notification from {{ $notification->data['session']['student']['name'] }} - {{ $notification->data['session']['app']['title'] }} - {{ $notification->data['session']['app']['category']['name'] }}</a>
        @endforeach
      </div>
    </div>
  </div>
</nav>
