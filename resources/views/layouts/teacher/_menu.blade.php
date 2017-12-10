<div id="main-menu-container">
  <main-menu-component
    notifications="{{ Auth::guard('teacher')->user()->unreadNotifications()->get() }}"
    user="{{ Auth::guard('teacher')->user() }}"
    user_type="{{ get_class(Auth::guard('teacher')->user()) }}"
  />
</div>
<div id="feedback-toolbar" style="position: sticky; top: 0; right: 0; z-index: 1030">
  <feedback-toolbar
    user="{{ Auth::guard('teacher')->user() }}"
    user_type="{{ get_class(Auth::guard('teacher')->user()) }}"
  />
</div>
