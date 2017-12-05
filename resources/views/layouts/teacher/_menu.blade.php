<div id="main-menu-container">
  <main-menu-component
    notifications="{{ Auth::guard('teacher')->user()->unreadNotifications()->get() }}"
    user="{{ Auth::guard('teacher')->user() }}"
    user_type="{{ get_class(Auth::guard('teacher')->user()) }}"
  ></main-menu-component>
</div>
