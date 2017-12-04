<div id="main-menu-container">
  <main-menu-component
    notifications="{{ Auth::guard('student')->user()->unreadNotifications()->get() }}"
    user="{{ Auth::guard('student')->user() }}"
    user_type="{{ get_class(Auth::guard('student')->user()) }}"
  />
</div>
