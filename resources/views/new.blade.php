@extends('layouts.main')
@section('title')
  The Film Corner
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <style media="screen">
    #news-container .carousel-item {
      min-height: 300px;
      max-height: 500px;
    }
    #newsCarouselIndicator .carousel-control-prev,
    #newsCarouselIndicator .carousel-control-next{
      width: 2% ;
    }
  </style>
@endsection
@section('content')
  <main>
  {{-- Main Hero Cover --}}
  @include('components.home.svg')
  {{-- PLACE FOR PARTNERS MODAL --}}
  @foreach ($partners as $key => $partner)
    <script id="js-modal-template-{{ $partner->id_tag }}" type="text/template">
      <div class="modal-text-class">
        <h2 class="modal-text-title">{{ $partner->name }}</h2>
        <div class="modal-text-inner">
          <p>{!! $partner->description !!}</p>
        </div>
      </div>
    </script>
    <script id="js-modal-location-{{ $partner->id_tag }}" type="text/template">
      <div class="modal-location">
        <p>{{ $partner->location }}</p>
      </div>
    </script>
    <script id="js-modal-link-{{ $partner->id_tag }}" type="text/template">
      <div class="modal-link">
        <p><a href="{{ $partner->url }}" target="_blank">{{ $partner->url }}</a></p>
      </div>
    </script>
  @endforeach
  {{-- END OF PARTNER MODAL --}}
  <div class="container">
    {{-- News --}} {{-- HIDDEN FOR NOW --}}
    @if (isset($posts))
      <div class="row">
      <div class="col">
        <section id="news">
          <div id="news-title" class="title sp-center pt-5 pb-5">
            News
          </div>
          <div id="news-container" class="tween-content-container">
            <div id="newsCarouselIndicator" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                @foreach ($posts as $key => $post)
                  <li data-target="#newsCarouselIndicator" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                @endforeach
              </ol>
              <div class="carousel-inner" role="listbox">
                @foreach ($posts as $key => $post)
                  <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                      <div class="row">
                        <div class="col-md-10 offset-md-1">
                          <div class="container-fluid" style="background-color: {{ $post->colors[0] }}; color: #252525">
                            <div class="row" style="background-color: {{ $post->colors[1] }}; color: #252525">
                              <div class="col align-text-bottom">
                                <h3 class="p-2">{{ $post->title }}</h3>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col p-5">
                                <div class="row">
                                  <div class="col-4">
                                    <img src="{{ asset('img/helpers/poster.png') }}" class="img-fluid">
                                  </div>
                                  <div class="col-8">
                                    <p class="pl-2">
                                      {!! $post->content !!}
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                @endforeach
              </div>
              <a class="carousel-control-prev" href="#newsCarouselIndicator" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#newsCarouselIndicator" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        </section>
      </div>
    </div>
    @endif
    {{-- Conference --}}
    <section id="conference">
      <div class="row pt-5">
        <div class="col-md-10 offset-md-1">
          <div class="container-fluid" style="background-color: {{ $colors[1][0] }}; color: #252525">
            <div class="row" style="background-color: {{ $colors[1][1] }}; color: #252525">
              <div class="col align-text-bottom">
                <h2 class="p-4">International Conference</h2>
              </div>
            </div>
            <div class="row">
              <div class="col p-5">
                <div class="row">
                  <div class="col-md-4">
                    <img src="{{ asset('img/icons/conference.svg') }}" class="img-fluid w-100" >
                  </div>
                  <div class="col-md-8">
                    <p class="text-justify pb-5">
                      The conference is part of The Film Corner project aimed to the creation of an online interactive platform for film education addressed to European schools.
                    </p>
                    <h3 class="text-center">When and Where</h3>
                    <hr>
                    <h5>2017, Thu, November 9th</h5>
                    <p class="text-justify">
                      5pm Italian time - MIC-Interactive Film Museum, viale Fulvio Testi, 121, Milan, Italy
                    </p>
                    <h5>2017, Fri, November 10th</h5>
                    <p class="text-justify pb-5">
                      9 a.m. - 6 p.m. Italian time, Cinema Oberdan, Viale Vittorio Veneto, 2, Milan, Italy
                    </p>
                    <a href="{{ route('conference') }}" class="btn btn-secondary btn-block" style="background-color: {{ $colors[1][1] }}; color: #252525; border: none;">Apply</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    {{-- Partners --}}
    <section id="partners">
      <div class="row pt-5">
        <div class="col-md-10 offset-md-1">
          <div class="container-fluid" style="background-color: {{ $colors[2][0] }}; color: #252525">
            <div class="row" style="background-color: {{ $colors[2][1] }}; color: #252525">
              <div class="col align-text-bottom">
                <h2 class="p-4">Partners</h2>
              </div>
            </div>
            <div class="row">
              <div class="col p-5">
                <div class="row">
                  <div class="col-md-4">
                    <img src="{{ asset('img/icons/share.svg') }}" class="img-fluid w-100" >
                  </div>
                  <div class="col-md-8">
                    <p class="text-justify">
                      The project involves 5 institutions in 4 EU countries: <b class="sp-bold">Fondazione Cineteca Italiana</b> in Milan, Italy (lead partner); <b class="sp-bold">The Film Space</b>, an innovative Film Literacy provider (London, UK); <b class="sp-bold">The Nerve Centre</b>, a Creative Learning Centre Derry, Northern Ireland; the <b class="sp-bold">National Cinèmatheque of Serbia</b> (Belgrade, Serbia) one of the oldest cinèmatheques in the world and the <b class="sp-bold">University of Milano Bicocca</b>,  Dipartimento di Scienze Umane per la Formazione “Riccardo Massa” (Milan, Italy).
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr class="m-5">
      <div class="row mt-5">
        <div id="partner-12" class="col-md-4 offset-md-4">
          <a href="https://eacea.ec.europa.eu/about-eacea" target="_blank"><img class="eu__img"src="/img/home/eu-flag.jpg"></a>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-4 offset-md-4">
          <hr>
        </div>
      </div>
      <div class="row pt-5">
        <div class="offset-md-1"></div>
        @foreach ($partners as $partner)
          <div id="container-{{ $partner->id_tag }}" class="col-md-2 text-center">
            <div class="tween-card card">
              <img src="{{ Storage::disk('local')->url($partner->logo_url) }}" id="partner-{{ $partner->id_tag }}" class="card-img-top" alt="{{ $partner->name }}">
              <div class="card-block">
                {{-- Modal Trigger --}}
                <a href="" class="btn" data-toggle="modal" data-target="#{{ $partner->id_tag }}">More info</a>

                {{-- Modal --}}
                <div class="modal fade" id="{{ $partner->id_tag }}" tabindex="-1" role="dialog" aria-labelledby="{{ $partner->id_tag }}Label" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="{{ $partner->id_tag }}Label">{{ $partner->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="text-left mb-4">
                          <span class="badge badge-default text-left">Milan, Italy</span><br>
                          <a href="#" target="_blank">Link to the website</a>
                        </div>
                        <div class="text-left">
                          {!! $partner->description !!}
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </section>
  </div>
</main>

@endsection
@section('scripts')
  <script type="text/javascript">
    var h = $('#logo-img').height();
    setHeight(h);

    $(window).resize(function() {
      var h = $('#logo-img').height();
      setHeight(h);
    });

    function setHeight(a) {
      $('.main-wrapper').height(a);
    };
  </script>
  <script src="{{ asset('js/city.js') }}"></script>
@endsection
