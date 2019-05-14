<div id="teacher-chat" class="fixed-bottom" style="width: 25rem; left: inherit; right: 1.5rem !important;">
    <tfc-chat
        fromtype="student"
        fromid="{{ Auth::guard('student')->ID() }}"
        totype="teacher"
        toid="{{ Auth::guard('student')->user()->teacher->id }}"
        toname="{{ Auth::guard('student')->user()->teacher->name }}"
        token="{{ $app_session->token }}">
    </tfc-chat>
</div>
