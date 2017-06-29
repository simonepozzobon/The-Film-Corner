{{-- <script src="//code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" crossorigin="anonymous"></script> --}}

<script src="{{ asset('js/jquery-3.2.0.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="{{ asset('js/tether.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

{{-- Script --}}
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}

@if ($type == 'app')
<script type="text/javascript">
  var TfcSessions = function () {
    this.initSession = function (id)
    {

        var data = {
          '_token'  : $('input[name=_token]').val(),
          'app_id'  : id,
        };

        // Genero la sessione
        $.ajax({
          type: 'post',
          url:  '/teacher/session/new',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          },
          data: data,
          success: function (response) {
            var sessions = [];

            if ($.cookie('tfc-sessions')) {
              sessions = [];
            }

            var session = {
              'app_id': id,
              'token': response.token
            };

            sessions.push(session);
            $.cookie('tfc-sessions', JSON.stringify(sessions));
            console.log($.parseJSON($.cookie('tfc-sessions')));
          },
          error: function (xhr, status) {
              console.log(xhr);
              console.log(status);
          }
        });


    }

    this.updateSession = function (id)
    {
      var sessions = $.parseJSON($.cookie('tfc-sessions'));
      var count = Object.keys(sessions).length;
      var token = null;

      for (var i = 0; i < count; i++) {
        if (sessions[i].app_id == id) {
          token = sessions[i].token;
        }
      }

      var frames = [];
      $('.frames').each(function(k){
        var frame = {
          'text': $(this).find('textarea').val(),
          'order': k,
          'base64': $(this).find('img').attr('src')
        };
        frames.push(frame);
      });

      console.log(frames);

      var data = {
        '_token'  : $('input[name=_token]').val(),
        'app_id'  : id,
        'token'   : token,
        'title'   : $('input[name="title"]').val(),
        'frames'  : frames
      };

      $.ajax({
        type: 'post',
        url:  '/teacher/session/update',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: data,
        success: function (response) {
          console.log(response);
          $('#saveSession').modal('hide');
        },
        error: function (xhr, status) {
            console.log(xhr);
            console.log(status);
        }
      });
    }
  };
</script>
@endif
@yield('scripts')


 {{-- SEND FEEDBACK --}}
<script type="text/javascript">
  var url = "";

  // send function
  $('#fdbck-send').on('click', function(e) {
    alert('cliccato');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

    e.preventDefault();

    var formData = {
      name:     $('#fdbck-name').val(),
      msg:      $('#fdbck-msg').val(),
    }

    var type = "POST";
    var my_url = url;

    $.ajax({
      type:     type,
      url:      my_url,
      data:     formData,
      dataType: 'json',
      success:  function (data)
        {
          console.log(data);
        },
      error:    function (data)
        {
          console.log(data);
        }
    })

  });

</script>
