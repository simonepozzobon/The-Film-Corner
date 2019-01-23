<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@if ($type == 'app')
    <script src="{{ mix('js/loader.js') }}"></script>
@endif
<script src="{{ mix('js/notifications.js') }}"></script>
<script src="{{ mix('js/feedback-toolbar.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>



{{-- Sessione --}}
@if ($type == 'app')
<script>
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
          url:  '/guest/session/new',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          },
          data: data,
          success: function (response) {
            var sessions = [];

            if ($.cookie('tfc-sessions')) {
              sessions = [];
            }

            session = {
              'app_id': id,
              'token': response.token
            };

            sessions.push(session);

            var jsonSession = JSON.stringify(sessions)

            // Vecchio sistema con i cookies
            $.cookie('tfc-sessions', jsonSession);

            localStorage.setItem('tfc-actual-session', jsonSession);
            window.$session = session

            // Nuovo sistema per la sessione
            $('body').trigger('session-loaded', session);
            localStorage.setItem('tfc-sessions', JSON.stringify(sessions));
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

        // Film Specific - Framing - App 1 - Frame Composer
        case 1:
          var json_data = $.parseJSON($.cookie('tfc-canvas'));
          var rendered = null;

          if (localStorage.getItem('app-1-image')) {
            rendered = localStorage.getItem('app-1-image');
          }

          var data = {
            '_token'    : $('input[name=_token]').val(),
            'app_id'    : id,
            'token'     : token,
            'title'     : $('input[name="title"]').val(),
            'notes'     : $('#notes').val(),
            'rendered'  : rendered,
            'canvas'    : json_data
          };

          console.log('--------');
          console.log(data);
          console.log('--------');

          break;

        // Film Specific - Framing - App 2 - Frame Crop
        case 2:

          var src = null;
          if (localStorage.getItem('app-2-image')) {
            src = localStorage.getItem('app-2-image');
          }

          var frames = [];
          $('#rendered .box').each(function(k){
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
            'frames'  : frames,
            'src'     : src
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Framing - App 3 - types-of-images
        case 3:
          var images = [
            $('#img-left').attr('src'),
            $('#img-right').attr('src'),
          ];
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val(),
            'images'  : images
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Editing - App 4 - Intercut Cross-Cutting
        case 4:
          var data = {
            '_token'    : $('input[name=_token]').val(),
            'app_id'    : id,
            'token'     : token,
            'title'     : $('input[name="title"]').val(),
            'notes'     : $('#notes').val(),
            'video': localStorage.getItem('app-4-video'),
            'timelines': localStorage.getItem('app-4-timelines')
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
            'video'   : localStorage.getItem('app-5-video'),
            'notes'   : $('#notes').val()
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Editing - App 6 - Attractions
        case 6:


          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val(),
            'videoL'  : localStorage.getItem('app-6-video-left'),
            'videoR'  : localStorage.getItem('app-6-video-right')
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Sound - App 7 - What's Going On
        case 7:
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val(),
            'audio'   : localStorage.getItem('app-7-audio')
          };

          console.log('--------');
          console.log(data);
          console.log('--------');

          break;

        // Film Specific - Sound - App 8 - Sound Atmospheres
        case 8:
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val(),
            'audio'   : localStorage.getItem('app-8-audio'),
            'video'   : localStorage.getItem('app-8-video')
          };

          console.log('--------');
          console.log(data);
          console.log('--------');

          break;

        // Film Specific - Sound - App 9 - Soundscapes
        case 9:
          var data = {
            '_token'      : $('input[name=_token]').val(),
            'app_id'      : id,
            'token'       : token,
            'title'       : $('input[name="title"]').val(),
            'notes'       : $('#notes').val(),
            'audio-src'   : localStorage.getItem('app-9-audio'),
            'audio-vol'   : localStorage.getItem('app-9-vol'),
            'image'       : localStorage.getItem('app-9-img'),
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

        // Creative Studio - Warm Up - App 10 - Active Offscreen
        case 10:
          if (localStorage.getItem('app-10-video-uploaded')) {
            var videos = $.parseJSON(localStorage.getItem('app-10-video-uploaded'));
          }

          var data = {
            '_token'      : $('input[name=_token]').val(),
            'app_id'      : id,
            'token'       : token,
            'title'       : $('input[name="title"]').val(),
            'main_video'  : localStorage.getItem('app-10-video'),
            'videos'      : videos
          };

          console.log('--------');
          console.log(data);
          console.log('--------');

          break;

        // Creative Studio - Warm Up - App 11 - Active Intercut Cross-Cutting
        case 11:
          var data = {
            '_token'    : $('input[name=_token]').val(),
            'app_id'    : id,
            'token'     : token,
            'notes'     : $('#notes').val(),
            'title'     : $('input[name="title"]').val(),
            'video': localStorage.getItem('app-11-video'),
            'timelines': localStorage.getItem('app-11-timelines')
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Creative Studio - Warm Up - App 12 - Sound Studio
        case 12:
          var data = {
            '_token'    : $('input[name=_token]').val(),
            'app_id'    : id,
            'token'     : token,
            'title'     : $('input[name="title"]').val(),
            'notes'     : $('#notes').val(),
            'video'     : $('[ng-controller="DemoMediaTimelineController"]').scope().videoData.player.src(),
            'timelines' : $('[ng-controller="DemoMediaTimelineController"]').scope().timelines
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Creative Studio - Warm Up - App 13 - Character Builder
        case 13:
          var json_data = null;
          var rendered = null;

          if (localStorage.getItem('app-13-json')) {
            json_data = localStorage.getItem('app-13-json');
          }

          if (localStorage.getItem('app-13-image')) {
            rendered = localStorage.getItem('app-13-image');
          }

          var data = {
            '_token'    : $('input[name=_token]').val(),
            'app_id'    : id,
            'token'     : token,
            'title'     : $('input[name="title"]').val(),
            'notes'     : $('#notes').val(),
            'rendered'  : rendered,
            'canvas'    : json_data
          };

          console.log('--------');
          console.log(data);
          console.log('--------');

          break;

        // Creative Studio - Warm Up - App 14 - Storytelling
        case 14:
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val(),
            'slot_1'  : $('#slot-1-in').val(),
            'slot_2'  : $('#slot-2-in').val(),
            'slot_3'  : $('#slot-3-in').val(),
            'slot_4'  : $('#slot-4-in').val(),
          };

          console.log('--------');
          console.log(data);
          console.log('--------');

          break;

        // Creative Studio - Warm Up - App 15 - Storyboard
        case 15:
          var stories = [];
          $('.story').each(function(k){
            var story = {
              'content': $(this).find('textarea').val(),
              'img': $(this).find('img').attr('src'),
              'order': k,
            };
            stories.push(story);
          });

          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'stories'  : stories
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Creative Studio - My Corner Contest - App 16 - Lumiere Minute
        case 16:
          if (localStorage.getItem('app-16-video')) {
            var video = $.parseJSON(localStorage.getItem('app-16-video'));
          }

          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'video'   : video
          };


          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Creative Studio - My Corner Contest - App 17 - Make Your Own Film
        case 17:
          if (localStorage.getItem('app-17-video')) {
            var video = $.parseJSON(localStorage.getItem('app-17-video'));
          }

          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'video'   : video
          };


          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

      }

      $.ajax({
        type: 'post',
        url:  '/guest/session/update',
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

    this.openSession = function (token, app_id)
    {
        var sessions = [];

        if ($.cookie('tfc-sessions')) {
            sessions = [];
        }

        session = {
            'app_id': app_id,
            'token': token
        };

        sessions.push(session);
        var jsonSession = JSON.stringify(sessions)

        // Vecchio sistema con i cookies
        $.cookie('tfc-sessions', jsonSession);

        localStorage.setItem('tfc-actual-session', jsonSession);

        console.log('session loaded');
    }
  };
</script>
@endif
@yield('scripts')


 {{-- SEND FEEDBACK --}}
<script>
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
<script>
  var btn = $('#help-btn');
    btn.on('click', function() {
      // Agggiungo la classe
      btn.toggleClass('panel-active');
      $('#help').toggleClass('panel-active');
      $('#app').toggleClass('panel-active');
      $('#save-btn').toggleClass('panel-active');
      $('#close-btn').toggleClass('panel-active');
      $('#approve-btn').toggleClass('panel-active');
      $('#comment-btn').toggleClass('panel-active');

      if (btn.hasClass('panel-active')) {
        $('#help-icon').removeClass('fa-question');
        $('#help-icon').addClass('fa-arrow-left');
      } else {
        $('#help-icon').removeClass('fa-arrow-left');
        $('#help-icon').addClass('fa-question');
      }
  });
</script>
{{-- <script src="{{ mix('js/scroll.js') }}"></script> --}}
@endif
