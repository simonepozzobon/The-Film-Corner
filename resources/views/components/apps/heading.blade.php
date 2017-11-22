  <div class="row mt">
    <div class="col">
      <div class="title-wrapper bg-faded">
        <div class="title">
          {{ $app_category->name }}
        </div>
        <div class="icon-right">
            <i class="fa fa-plus" data-toggle="collapse" href="#app-info" aria-expanded="false" aria-controls="app-info"></i>
        </div>
      </div>
      <div id="app-info" class="title-description collapse">
        {!! $app_category->description !!}
      </div>
    </div>
  </div>
  <div class="row mt hidden-md-down">
    <div class="col">
      <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ $route }}">Studios</a></li>
          <li class="breadcrumb-item"><a href="{{ $route }}/{{ $app_category->section->slug }}">{{ $app_category->section->name }}</a></li>
          <li class="breadcrumb-item active">{{ $app_category->name }}</li>
        </ol>
        <div class="btns">
          @if (isset($apps))
            @foreach ($apps as $key => $app)
              <a href="#{{ $app->slug }}" class="btn btn-{{ $app->colors }}">{{ $app->title }}</a>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
