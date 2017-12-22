<div id="main-menu-container">
  <main-menu-component
    notifications="{{ Auth::guard('guest')->user()->unreadNotifications()->get() }}"
    user="{{ Auth::guard('guest')->user() }}"
    user_type="{{ get_class(Auth::guard('guest')->user()) }}"
  />
</div>
<div id="feedback-toolbar" style="position: fixed; bottom: 0; left: 0; z-index: 1030">
  <feedback-toolbar
    user="{{ Auth::guard('guest')->user() }}"
    user_type="{{ get_class(Auth::guard('guest')->user()) }}"
  />
</div>
