@extends('layouts.teacher', ['type' => 'app'])
@section('stylesheets')
  <link rel="stylesheet" href="http://vjs.zencdn.net/5.8.8/video-js.css" >
  <link rel="stylesheet" href="{{ asset('plugins/videojs-markers/videojs.markers.css') }}">
@endsection
@section('content')
  @include('components.apps.sidebar-menu', ['app' => $app, ])
  <div class="p-5">
  </div>
  <div class="row row-custom">
    <div id="help" class="col-6 container-fluid px-5 d-inline-block float-left">
        <div class="container-fluid pl-5">
          <div class="row">
            <div class="col" style="background-color: #a6dbe2; color: #252525">
              <h3 class="px-2 pt-4 pb-2">Examples</h3>
            </div>
          </div>
          <div class="row pb-5">
            <div class="col py-5" style="background-color: #d9f5fc; color: #252525">
              <p class="pl-2">
                Examples of pictures and clips related to each app with a short explanations
              </p>
            </div>
          </div>
          <div class="row" style="background-color: #e9c845; color: #252525">
            <div class="col">
              <h3 class="px-2 pt-4 pb-2">References</h3>
            </div>
          </div>
          <div class="row mb-5" style="background-color: #f5db5e; color: #252525">
            <div class="col py-5">
              <p class="pl-2">
                <ul>
                  <li>lista 1</li>
                  <li>lista 2</li>
                  <li>altro elemento</li>
                </ul>
              </p>
            </div>
          </div>
          <div class="row pb-5">
            @foreach ($app_category->keywords as $key => $keyword)
              <h5><span class="badge badge-default mb-2 mr-2" data-toggle="modal" data-target="#keywordModal-{{ $keyword->id }}">{{ $keyword->name }}</span></h5>
              <div class="modal fade" id="keywordModal-{{ $keyword->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{ $keyword->name }}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="modal-body">
                      {{ $keyword->description }}
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
    </div>
    <div id="app" class="col-12 px-5 d-inline-block float-left">
      <div class="row" style="background-color: {{ $app->colors[1] }}; color: #252525">
        <div class="col">
          <div class="d-flex justify-content-start">
            <div class="mr-auto"><h3 class="ml-2 pt-4 pb-1">{{ $app->title }}</h3></div>
          </div>
        </div>
      </div>
      <div class="row" style="background-color: {{ $app->colors[0] }}; color: #252525">
        <div class="col">
          <div class="clearfix p-5">
            <div class="row">
              <div class="col-md-6">
                <div class="embed-responsive embed-responsive-16by9">
                  <video id="video" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264">
                      <source src="{{ asset('img/test-app/oceans.mp4') }}" type="video/mp4">
                  </video>
                </div>
                <canvas class="d-none"></canvas>
              </div>
              <div class="col-md-6">
                <div class="frame container bg-faded d-none p-3">
                  <h3 class="text-center pb-4">Notes</h3>
                  <div class="form-group pb-2">
                    <textarea id="markerText" name="name" rows="8" class="form-control"></textarea>
                  </div>
                  <button id="markerSave" type="button" name="button" class="btn btn-primary justify-content-center">Save</button>
                </div>
              </div>
            </div>
            <div class="row py-4">
              <div class="col d-flex justify-content-around">
                {{-- Control Bar --}}
                <div class="btn-group">
                  <button id="comment" type="button" name="button" class="btn btn-secondary">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add Note
                  </button>
                  <button id="play" type="button" name="button" class="btn btn-secondary">
                    <i class="fa fa-play" aria-hidden="true"></i>
                  </button>
                  <button id="pause" type="button" name="button" class="btn btn-secondary">
                    <i class="fa fa-pause" aria-hidden="true"></i>
                  </button>
                  <button id="stop" type="button" name="button" class="btn btn-secondary">
                    <i class="fa fa-stop" aria-hidden="true"></i>
                  </button>
                  <button id="rewind" type="button" name="button" class="btn btn-secondary">
                    <i class="fa fa-backward" aria-hidden="true"></i>
                  </button>
                  <button id="forward" type="button" name="button" class="btn btn-secondary">
                    <i class="fa fa-forward" aria-hidden="true"></i>
                  </button>
                </div>

              </div>
            </div>
            <div class="row">
              <div class="frame col bg-faded">
                <div class="container p-4">
                  <table id="timetable" class="table table-hover">
                    <thead>
                      <th>Img</th>
                      <th>Time</th>
                      <th>Description</th>
                      <th></th>
                    </thead>
                    <tbody>
                      <tr id="no-markers">
                        <td colspan="3" class="text-center">
                          <span class="alert alert-warning d-block">No Markers Yet</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('scripts')
  <script src="{{ asset('plugins/videojs/video.js') }}"></script>
  <script src="{{ asset('plugins/videojs-markers/videojs-markers.js') }}">

  </script>

  <script type="text/javascript">
    var AppSession = new TfcSessions();
    AppSession.initSession({{ $app->id }});

    var player = videojs('video', {
      controlBar: {
        playToggle: false,
        volumeMenuButton: false,
        fullscreenToggle: false,
      }
    });

    player.muted(true);

    player.markers({
      markers: [
         {time: 9.5, text: "this"},
         {time: 16,  text: "is"},
         {time: 23.6,text: "so"},
         {time: 28,  text: "cool"}
      ]
    });

    var markers = [];

    // Set Snapshot vars
    var video = document.querySelector('video');
    var canvas = document.querySelector('canvas');
    var ctx = canvas.getContext('2d');
    var w, h, ratio;

    video.addEventListener('loadedmetadata', function() {
        ratio = video.videoWidth / video.videoHeight;

        w = video.videoWidth - 100;
        h = parseInt(w / ratio, 10);
        canvas.width = w;
        canvas.height = h;
    }, false);

    // Notes action
    $('#comment').on('click', function() {
      player.pause();
      var playerTime = player.currentTime();
      $('#markerText').parent('.form-group').parent('.container').removeClass('d-none');
      $('#markerSave').on('click', function() {
        // Get Notes
        var notes = $('#markerText').val();

        // Add Marker
        player.markers.add([{
          time: playerTime
        }]);

        // Format time for marker table
        var totalSeconds = player.currentTime();
        hours = Math.floor(totalSeconds / 3600);
        totalSeconds %= 3600;
        minutes = Math.floor(totalSeconds / 60);
        seconds = Math.round(totalSeconds % 60);
        var timeCode = '\n 0'+hours+':'+('0'+minutes).slice(-2)+':'+ ('0'+seconds).slice(-2);

        // Take snapshot
        ctx.fillRect(0, 0, w, h);
        ctx.drawImage(video, 0, 0, w, h);

        // Marker Array Update
        var marker = {
          img   : canvas.toDataURL("image/jpeg"),
          time  : timeCode,
          text  : notes,
        };
        markers.push(marker);

        // Update Marker Table
        var data = '';
        data += '<tr class="marker">';
        data += '<td><img src="'+canvas.toDataURL("image/jpeg")+'" class="img-fluid" width="57"></td>'
        data += '<td>'+timeCode+'</td>';
        data += '<td>'+notes+'</td>';
        data += '<td><button id="markerDelete" onclick="deleteMarker(this)" type="button" name="button" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>';
        data += '</tr>';

        // Count marker
        var count = countMarker();
        if (count > 0) {
          $('#no-markers').remove();
        }

        $('#timetable').append(data);

        // Reset Marker Notes
        $('#markerText').val('');

        // Hide Marker Notes
        $('#markerText').parent('.form-group').parent('.container').addClass('d-none');


        // Logging
        console.log('---------');
        console.log(markers);
        console.log('---------');
      });
    });

    $('#play').on('click', function() {
      player.play();
    });

    $('#pause').on('click', function() {
      player.pause();
    });

    $('#stop').on('click', function() {
      player.pause().currentTime(0);

    });

    $('#rewind').on('click', function() {
      var time = player.currentTime();
      player.currentTime(time-5);
    });

    $('#forward').on('click', function() {
      var time = player.currentTime();
      player.currentTime(time+5);
    });

    function notable()
    {
      if (player.currentTime() > 0) {
        $('#comment').removeClasse('disabled');
      } else {
        $('#comment').addClass('disabled');
      }
    }

    // Count Markers
    function countMarker() {
      var count = 0;
      $('.marker').each(function() {
        count = count + 1;
      });
      return count;
    }

    // Delete
    function deleteMarker(obj) {
      // $(obj).parent('.marker').remove();
      // console.log(obj);
      // // Check count markers if 0 add warning
      // var count = countMarker();
      // if (count == 0) {
      //   var data = '';
      //   data += '<tr id="no-markers">';
      //   data += '<td colspan="3" class="text-center"><span class="alert alert-warning d-block">No Markers Yet</span></td>';
      //   data += '</tr>';
      //   $('#timetable').append(data);
      // }
    }
  </script>
@endsection
