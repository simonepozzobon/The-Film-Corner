<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>



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

            session = {
              'app_id': id,
              'token': response.token
            };

            sessions.push(session);
            // Vecchio sistema con i cookies
            $.cookie('tfc-sessions', JSON.stringify(sessions));
            // Nuovo sistema per la sessione
            $('body').trigger('session-loaded', session);
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
            'frames'  : frames
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Film Specific - Framing - App 3 - Juxtaposition
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
            'timelines' : $('[ng-controller="DemoMediaTimelineController"]').scope().timelines
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
            'video'   : $('#video source').attr('src'),
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

          $('#div1 li img').each(function() {
            var src = $(this).attr('src');
            imgL.push(src);
          });
          $('#div2 li img').each(function() {
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

        // Film Specific - Sound - App 7 - What's Going On
        case 7:
          var data = {
            '_token'  : $('input[name=_token]').val(),
            'app_id'  : id,
            'token'   : token,
            'title'   : $('input[name="title"]').val(),
            'notes'   : $('#notes').val(),
            'audio'   : $.parseJSON($.cookie('tfc-audio'))
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
            'audio'   : $.parseJSON($.cookie('tfc-audio')),
            'video'   : $('video source').attr('src')
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
            'audio-src'   : $.parseJSON($.cookie('tfc-audio-src')),
            'audio-vol'   : $.parseJSON($.cookie('tfc-audio-vol')),
            'image'       : $('#image').attr('src')
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
          if (localStorage.getItem('app-10-videos')) {
            var videos = $.parseJSON(localStorage.getItem('app-10-videos'));
          }

          var data = {
            '_token'      : $('input[name=_token]').val(),
            'app_id'      : id,
            'token'       : token,
            'title'       : $('input[name="title"]').val(),
            'main_video'  : $('#video-main source').attr('src'),
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
            'title'     : $('input[name="title"]').val(),
            'timelines' : $('[ng-controller="DemoMediaTimelineController"]').scope().timelines
          };

          console.log('--------');
          console.log(data);
          console.log('--------');
          break;

        // Creative Studio - Warm Up - App 13 - Character Builder
        case 13:
          var json_data = $.parseJSON($.cookie('tfc-canvas'));
          var rendered = null;

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


        /*
         *
         * DEPRECATED
         *
        */

        // Film Specific - Framing - App 3 - Frame Counter
        // case 3:
        //   var data = {
        //     '_token'  : $('input[name=_token]').val(),
        //     'app_id'  : id,
        //     'token'   : token,
        //     'title'   : $('input[name="title"]').val(),
        //     'markers' : markers
        //   };
        //
        //   console.log('--------');
        //   console.log(data);
        //   console.log('--------');
        //   break;

        // // Film Specific - Sound - App 10 - Stop and Go
        // case 10:
        //   var data = {
        //     '_token'  : $('input[name=_token]').val(),
        //     'app_id'  : id,
        //     'token'   : token,
        //     'title'   : $('input[name="title"]').val(),
        //     'notes'   : $('#notes').val(),
        //     'video'   : $('video source').attr('src')
        //   };
        //
        //   console.log('--------');
        //   console.log(data);
        //   console.log('--------');
        //
        //   break;

        // Film Specific - Editing - App 7 - attractions-viceversa
        // case 7:
        //
        //   var imgL = [];
        //   var imgR = [];
        //
        //   $('#div1 img').each(function() {
        //     var src = $(this).attr('src');
        //     imgL.push(src);
        //   });
        //   $('#div2 img').each(function() {
        //     var src = $(this).attr('src');
        //     imgR.push(src);
        //   });
        //
        //   var data = {
        //     '_token'  : $('input[name=_token]').val(),
        //     'app_id'  : id,
        //     'token'   : token,
        //     'title'   : $('input[name="title"]').val(),
        //     'emotion' : $('input[name="emotion"]').val(),
        //     'notes'   : $('#notes').val(),
        //     'imgL'    : imgL,
        //     'imgR'    : imgR
        //   };
        //
        //   console.log('--------');
        //   console.log(data);
        //   console.log('--------');
        //   break;

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
        // Vecchio sistema con i cookies
        $.cookie('tfc-sessions', JSON.stringify(sessions));
        console.log('session loaded');
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

{{-- NOTIFICATIONS --}}
<script type="text/javascript">
  $('.markasread').on('click', function(e) {
    var notification_id = $(this).data('notif-id');
    $.get('/teacher/notifications/markasread/'+notification_id);
  });

  $('.delete-notif').on('click', function(e) {
    var notification_id = $(this).data('notif-id');
    $.ajax({
      method: 'POST',
      url: '/teacher/notifications/delete',
      data: {
          '_token' : '{{ csrf_token() }}',
          'id' : notification_id,
      },
      success: function(response) {
        console.log(response);
        $('*[data-notif-id="'+notification_id+'"]').remove();
      },
      error: function(errors) {
        console.error(errors);
      }
    });
  });

  var notifications = new Array();
  var $notif_menu = $('#notifications .dropdown-menu');
  var $main_menu = $('#main-menu');

  $notif_menu.find('.dropdown-item').each(function(){
      var item = $(this).data('notif-id');
      notifications.push(item);
  });

  var menu_height = $main_menu.outerHeight();

  var getNotifications = function() {
      $.get('/teacher/notifications/get', function(response) {
          $.each(response, function(k, item) {
              // escludo tutto quello che non va bene
              if (item.id) {
                var check = $.inArray(item.id, notifications);
                if (check == -1) {
                  notifications.push(item.id);
                  var session = item.data.session
                  var section_slug = session.app.category.section.slug;
                  var category_slug = session.app.category.slug;
                  var app_slug = session.app.slug;
                  var token = session.token;
                  var message = 'You have a new notification from '+session.student.name+' - '+session.app.title+' - '+session.app.category.name;

                  var data = '<a class="dropdown-item markasread" data-notif-id="'+item.id+'" href="/teacher/'+section_slug+'/'+category_slug+'/'+app_slug+'/'+token+'">'+message+'</a>';
                  $notif_menu.append(data);
                  var data = ''
                  data += '<div class="alert alert-success alert-dismissible fade show fixed-top w-25 ml-auto" role="alert" style="top: calc('+menu_height+'px + 1.5rem); right: 1.5rem;">';
                  data +=   '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                  data +=     '<span aria-hidden="true">&times;</span>';
                  data +=   '</button>';
                  data +=   '<div class="d-flex justify-content-between">';
                  data +=     '<h1 class="pr-3 d-inline-block" style="padding-top: 0.5rem; font-size: 3rem"><i class="fa fa-globe"></i></h1>';
                  data +=     '<div class"d-inline-block" style="margin-top: 0.9rem;">'+message+'</div>';
                  data +=   '</div>';
                  data += '</div>'
                  $main_menu.append(data);
                  console.log(item);
                }
              }
          });
      });
  };

  setInterval(getNotifications, 10000);
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
@endif
