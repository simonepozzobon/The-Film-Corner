<script src="{{ asset('js/jquery-3.2.0.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="{{ asset('js/tether.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>


{{-- Sessione --}}
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

      switch (id) {
        // Film Specific - Framing - App 1 - Frame Crop
        case 1:
          var frames = [];
          $('.frames').each(function(k){
            var frame = {
              'text': $(this).find('textarea').val(),
              'order': k,
              'base64': $(this).find('img').attr('src')
            };
            frames.push(frame);
          });

          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'frames'  : frames
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Framing - App 2 - Juxtaposition
        case 2:
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val()
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Framing - App 3 - Frame Counter
        case 3:
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'markers' : markers
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Editing - App 5 - Offscreen
        case 5:
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val()
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Editing - App 6 - Attractions
        case 6:

          var imgL = [];
          var imgR = [];

          $('#div1 img').each(function() {
            var src = $(this).attr('src');
            imgL.push(src);
          });
          $('#div2 img').each(function() {
            var src = $(this).attr('src');
            imgR.push(src);
          });

          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val(),
            'imgL'    : imgL,
            'imgR'    : imgR
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Editing - App 7 - attractions-viceversa
        case 7:

          var imgL = [];
          var imgR = [];

          $('#div1 img').each(function() {
            var src = $(this).attr('src');
            imgL.push(src);
          });
          $('#div2 img').each(function() {
            var src = $(this).attr('src');
            imgR.push(src);
          });

          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'emotion' : $('input[name="emotion"]').val(),
            'notes'   : $('#notes').val(),
            'imgL'    : imgL,
            'imgR'    : imgR
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        /*
         *
         * CREATIVE STUDIO - PADIGLIONE 2
         *
        */

        // Creative Studio - Warm Up - App 12 - Active Offscreen
        case 12:
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
          };

          console.log('--------');
          console.log(data);
          console.log('--------');

          break;

        // Creative Studio - Warm Up - App 16 - Character Builder
        case 16:
          var json_data = $.parseJSON($.cookie('tfc-canvas'));

          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val(),
            'canvas'  : json_data
          };

          console.log('--------');
          console.log(data);
          console.log('--------');

          break;

        // Creative Studio - Warm Up - App 17 - Storytelling
        case 17:
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val(),
            'slot-1'  : $('#slot-1-in').val(),
            'slot-2'  : $('#slot-2-in').val(),
            'slot-3'  : $('#slot-3-in').val(),
            'slot-4'  : $('#slot-4-in').val(),
          };

          console.log('--------');
          console.log(data);
          console.log('--------');

          break;
      }

      $.ajax({
        type: 'post',
        url:  '/teacher/session/update',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: data,
        success: function (response) {
          console.log(response);
          $('.form-control-danger').removeClass('form-control-danger');
          $('.has-danger').removeClass('has-danger');
          $('.form-control-feedback').remove();
          $('#saveSession').modal('hide');
        },
        error: function (errors) {
          console.log(errors);
            $('.form-control-danger').removeClass('form-control-danger');
            $('.has-danger').removeClass('has-danger');
            $('.form-control-feedback').remove();
            if (errors.responseJSON) {
              $.each(errors.responseJSON.errors, function(k, v) {
                var elem = $('input[name='+k+']');
                elem.addClass('form-control-danger');
                elem.parent().addClass('has-danger');
                elem.parent().append('<div class="form-control-feedback">Error</div>');

              });
            } else {
              console.log(errors.responseText);
            }

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

@if ($type == 'app')
<script type="text/javascript">
  var btn = $('#help-btn');
    btn.on('click', function() {
      // Agggiungo la classe
      btn.toggleClass('panel-active');
      $('#help').toggleClass('panel-active');
      $('#app').toggleClass('panel-active');
      $('#save-btn').toggleClass('panel-active');
      $('#close-btn').toggleClass('panel-active');

      if (btn.hasClass('panel-active')) {
        $('#help-icon').removeClass('fa-question');
        $('#help-icon').addClass('fa-arrow-left');
      } else {
        $('#help-icon').removeClass('fa-arrow-left');
        $('#help-icon').addClass('fa-question');
      }

  });
</script>
@endif
