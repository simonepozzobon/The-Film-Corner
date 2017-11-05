<nav id="main-menu" class="navbar navbar-toggleable-md navbar-light bg-faded fixed-top">
  {{-- Mobile --}}
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#menu-main" aria-controls="menu-main" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  {{-- Logo --}}
  <div class="navbar-brand">
    <a href="{{ url('/') }}" class="mr-4"><img src="/img/logo.png" height="30"></a>
    <a href="#" class="mr-4"><img src="/img/creative-europe-media.png" height="30" alt=""></a>
  </div>

  {{-- Desktop --}}
  <div class="collapse navbar-collapse justify-content-end" id="menu-main">
    <ul class="navbar-nav justify-content-end">
      <li class="nav-item">
        <span class="nav-link"> Hello, {{ Auth::guard('teacher')->user()->name }}</span>
      </li>
      <li class="nav-item">
        <a href="{{ url('/teacher') }}" class="nav-link text-success">
          <h6><i class="fa fa-film" aria-hidden="true"></i> Apps</h6>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('teacher.network.index') }}" class="nav-link text-warning">
          <h6><i class="fa fa-share-alt" aria-hidden="true"></i> Network</h6>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('teacher.settings.index') }}" class="nav-link text-primary">
          <h6><i class="fa fa-cog" aria-hidden="true"></i> Panel</h6>
        </a>
      </li>
    </ul>
    <div id="notifications" class="dropdown pl-2" style="padding-top: 0.35rem !important;">
      @php
        $count = count(Auth::guard('teacher')->user()->unreadNotifications()->get())
      @endphp
      @if ($count > 0)
        <a href="#" id="dropdownMenuLink" class="text-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <h6 class="d-inline-block">
            <i class="fa fa-globe"></i> Notifications
          </h6>
        </a>
      @else
        <a href="#" id="dropdownMenuLink" class="text-muted" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <h6 class="d-inline-block">
            <i class="fa fa-globe"></i> Notifications
          </h6>
        </a>
      @endif
      <div class="dropdown-menu dropdown-menu-right px-2" aria-labelledby="dropdownMenuLink">
        <h4 class="dropdown-header">Notifications</h4>
        <hr>
        @foreach (Auth::guard('teacher')->user()->unreadNotifications()->get() as $key => $notification)
          @php
            $section_slug = $notification->data['session']['app']['category']['section']['slug'];
            $category_slug = $notification->data['session']['app']['category']['slug'];
            $app_slug = $notification->data['session']['app']['slug'];
            $token = $notification->data['session']['token'];
          @endphp
          <a class="dropdown-item markasread" data-notif-id="{{ $notification->id }}" href="{{ url('/') }}/teacher/{{ $section_slug }}/{{ $category_slug }}/{{ $app_slug }}/{{ $token }}">
            You have a new notification from {{ $notification->data['session']['student']['name'] }} - {{ $notification->data['session']['app']['title'] }} - {{ $notification->data['session']['app']['category']['name'] }}
          </a>
        @endforeach
      </div>
    </div>
  </div>
</nav>
