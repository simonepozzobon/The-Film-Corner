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
        {!! $app->description !!}
      </div>
    </div>
  </div>
