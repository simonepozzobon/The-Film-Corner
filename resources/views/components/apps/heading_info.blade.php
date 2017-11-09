  <div class="row mt">
    <div class="col">
      <div class="title-wrapper bg-faded">
        <div class="title">
          {{ $app->title }}
        </div>
        <div class="icon-right">
          <i class="fa fa-plus" data-toggle="collapse" href="#app-info" aria-expanded="false" aria-controls="app-info"></i>
        </div>
      </div>
      <div id="app-info" class="title-description collapse">
        <div class="heading">
          Info
        </div>
        <div class="content">
          {!! $app->description !!}
        </div>
        @if ($app->examples()['count'] > 0)
          <div class="heading">
            Examples
          </div>
          <div class="content">
              @foreach ($app->examples() as $key => $examples)
                @if ($key == 'videos')
                  @foreach ($examples as $key => $example)
                    <div class="video-example embed-responsive embed-responsive-16by9">
                      <video class="embed-responsive-item" controls>
                        <source src="{{ Storage::disk('local')->url($example->src) }}" type="video/mp4">
                      </video>
                    </div>
                  @endforeach
                @elseif ($key == 'images')
                  @foreach ($examples as $key => $example)
                    <div class="image-example">
                      <img src="{{ Storage::disk('local')->url($example->src) }}" alt="" class="img-fluid">
                    </div>
                  @endforeach
                @elseif ($key == 'audios')
                  @foreach ($examples as $key => $example)
                    <div class="audio-example embed-responsive">
                      <audio class="embed-responsive-item" controls>
                        <source src="{{ Storage::disk('local')->url($example->src) }}" type="audio/wav">
                      </audio>
                    </div>
                  @endforeach
                @endif
              @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
