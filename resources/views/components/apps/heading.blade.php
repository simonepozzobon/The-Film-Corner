  <div class="row mt">
    <div class="col">
      <div class="title-wrapper bg-faded">
        <div class="icons-left"></div>
        <div class="title">
          {{ $app_category->name }}
        </div>
        <div class="icons-right">
          <div class="icon">
            <a id="read-more-icon"><i class="fa fa-plus"></i></a>
          </div>
        </div>
      </div>
      <div id="" class="title-description">
        <div id="short-description" class="short-description">
          {{ substr(strip_tags($app_category->description), 0, 200) }}{{ strlen(strip_tags($app_category->description)) > 200 ? '...' : "" }}
        </div>
        <div id="long-description" class="long-description d-none">
          {!! $app_category->description !!}
        </div>
        <div class="btns">
          <a href="" id="read-more-btn" class="text-default text-muted" data-id="{{ $app_category->slug }}">Read More</a>
        </div>
      </div>
      <script type="text/javascript">
        var button = document.getElementById('read-more-btn'),
            icon = document.getElementById('read-more-icon'),
            shortDesc = document.getElementById('short-description'),
            longDesc = document.getElementById('long-description'),
            opened = false;

        button.addEventListener('click', toggleDescription, false);
        icon.addEventListener('click', toggleDescription, false);

        function toggleDescription(event)
        {
            event.preventDefault();
            if (!opened)
            {
                longDesc.classList.remove('d-none');
                shortDesc.classList.add('d-none');
                button.innerHTML = 'Read Less'
            }

            else
            {
                shortDesc.classList.remove('d-none');
                longDesc.classList.add('d-none');
                button.innerHTML = 'Read More';
            }

            opened = !opened;
        }
      </script>
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
