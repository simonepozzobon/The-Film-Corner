  <div class="row mt">
    <div class="col">
      <div class="title-wrapper bg-faded">
        <div class="title">
          {{ $app_category->name }}
        </div>
        <div class="icon-right">
            <i class="fa fa-plus"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt hidden-md-down">
    <div class="col">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ $route }}">Studios</a></li>
        <li class="breadcrumb-item"><a href="{{ $route }}/{{ $app_category->section->slug }}">{{ $app_category->section->name }}</a></li>
        <li class="breadcrumb-item active">{{ $app_category->name }}</li>
      </ol>
    </div>
  </div>
