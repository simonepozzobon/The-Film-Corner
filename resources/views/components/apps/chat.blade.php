<div id="teacher-chat" class="fixed-bottom" style="width: 25rem; left: inherit; right: 1.5rem !important;">
  <tfc-chat
      fromtype="teacher"
      fromid="{{ Auth::guard('teacher')->ID() }}"
      totype="student"
      toid="{{ $app_session->student->id }}"
      toname="{{ $app_session->student->name }}">
  </tfc-chat>
</div>
