<div id="main-menu-container">
  <main-menu-component
    notifications="{{ Auth::guard('student')->user()->unreadNotifications()->get() }}"
    user="{{ Auth::guard('student')->user() }}"
    user_type="{{ get_class(Auth::guard('student')->user()) }}"
    locale="{{ App::getLocale() }}"
  />
</div>
<div id="feedback-toolbar" style="position: fixed; bottom: 0; left: 0; z-index: 1030">
  <feedback-toolbar
    user="{{ Auth::guard('student')->user() }}"
    user_type="{{ get_class(Auth::guard('student')->user()) }}"
  />
</div>
