@extends('layouts.main')
@section('title')
  The Film Corner
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
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
    {{-- @if (isset($posts))
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
    @endif --}}
    {{-- News --}}
    <div class="row mt">
      <div class="col">
        <div class="box yellow">
          <div class="box-header">
            The Film Corner at #Venezia74
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/ciak.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                The Film Corner will be present at the 74th Venice International Film Festival!<br>
                <br>
                On Sunday, September 3rd at 11 am at the Italian Pavilion, the Film Corner International Conference will be presented at the festivalgoers.<br>
                the Film Corner International Conference will take place in 2017 on November 9th and 10th in Milan, as part of the X edition of the Piccolo Grande Cinema Festival, addressed to young audiences and organised by Cineteca Italiana, which is the leading organisation of the project.<br>
                The conference is open to the public and addressed to professionals and trainers of film education, media education, information and communication technology as well as gaming professionals.<br>
                <br>
                Our speakers: Matteo Pavesi (Fondazione Cineteca Italiana Director), Silvia Pareti, Simone Moraldi (Fondazione Cineteca Italiana Special Project Manager) and Gianni Canova (film critic).<br>
                <br>
                For further information and participation requests write to <a href="mailto:ufficiostampa@cinetecamilano.it">ufficiostampa@cinetecamilano.it</a>
              </div>
            </div>
          </div>
          <div class="box-btns">
            <a href="{{ route('conference') }}" class="btn btn-yellow"><i class="fa fa-check"></i> Apply</a>
          </div>
        </div>
        <div class="box mt green">
          <div class="box-header">
            Deadline extended
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/time.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                Dear visitors,<br>
                welcome to the website of the European project The Film Corner. Online and offline activities for film literacy, promoted by Fondazione Cineteca Italiana and supported by the Creative Europe Program of the European Union.<br>
                <br>
                As you could read on the website, the project is aimed at the design, development and testing of an interactive digital platform for film literacy addressed to students between 12 and 17 years old.<br>
                <br>
                The Film Corner International Conference will take place in Milan on 9th and 10th November 2017. Participation is completely free and the deadline for enrolment is 10th October.<br>
                Click <a href="{{ route('conference') }}">here</a> for all the information and follow us on our <a href="https://www.facebook.com/TheFilmCorner/" target="_blank">facebook</a> page.<br>
              </div>
            </div>
          </div>
          <div class="box-btns">
            <a href="{{ route('conference') }}" class="btn btn-green"><i class="fa fa-check"></i> Apply</a>
          </div>
        </div>
        <div class="box orange mt">
          <div class="box-header">
            International Conference
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/conference.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col">
                    The conference is part of The Film Corner project aimed to the creation of an online interactive platform for film education addressed to European schools.
                  </div>
                </div>
                <div class="row pt">
                  <div class="col">
                    <h3 class="text-center">When and Where</h3>
                    <hr>
                    <h5>2017, Thu, November 9th</h5>
                    5pm Italian time - MIC-Interactive Film Museum, viale Fulvio Testi, 121, Milan, Italy
                    <h5>2017, Fri, November 10th</h5>
                    9 a.m. - 6 p.m. Italian time, Cinema Oberdan, Viale Vittorio Veneto, 2, Milan, Italy
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box-btns">
            <a href="{{ route('conference') }}" class="btn btn-orange"><i class="fa fa-check"></i> Apply</a>
          </div>
        </div>
        <div class="box blue mt">
          <div class="box-header">
            The Project
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/camera.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                “THE FILM CORNER. Online and offline activities for Film Literacy” project is aimed to the design, release and testing of an online digital virtual user-centered platform for Film Literacy, taking advantage of the opportunities offered by web 2.0 and crossmedia innovative approach in the digital era in order to raise the average film literacy level of EU young audiences. The general aim of the project is to contribute to draw an easy-going model for Film Literacy that could improve Film Literacy skills among the audience in order to foster Audience Development and Engagement towards film as an art form, with a particular focus on young and non-core audience.<br>
                The platform consists of an interactive narrative-based environmental layout with game-based didactical resources integrated as apps the user can interact with. Didactical resources will be both based on generic Film Literacy skills and on a set of EU national and non-national films. The platform is to be developed in at least 4 EU languages including english, french, italian and serbian.<br>
                In november 2017, an international conference will take place in the frame of the 10th edition of “Piccolo Grande Cinema” Festival, a film festival dedicated to young audience promoted by Fondazione Cineteca Italiana. During the international conference the platform blueprint will be officially presented and some panels discussing several issues concerning Film Literacy, cross-media and Audience Development and engagement will be discussed. A call for papers will be issued and keynote speakers, including representants from other film literacy project financed in the frame of the Creative Europe Programme will be invited.<br>
                <ul class="pt">
                  <li>PROJECT TITLE: The Film Corner. New online and offline activities for Film Literacy</li>
                  <li>CONTRACT REFERENCE: 2016-2127/001-001-577573-CREA-1-2016-1-IT-MED-AUDEV</li>
                  <li>LEADING INSTITUTION: Fondazione Cineteca Italiana, Milan, Italy</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="box yellow mt">
          <div class="box-header">
            Partners
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/share.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                The project involves 5 institutions in 4 EU countries: <b class="sp-bold">Fondazione Cineteca Italiana</b> in Milan, Italy (lead partner); <b class="sp-bold">The Film Space</b>, an innovative Film Literacy provider (London, UK); <b class="sp-bold">The Nerve Centre</b>, a Creative Learning Centre Derry, Northern Ireland; the <b class="sp-bold">National Cinèmatheque of Serbia</b> (Belgrade, Serbia) one of the oldest cinèmatheques in the world and the <b class="sp-bold">University of Milano Bicocca</b>,  Dipartimento di Scienze Umane per la Formazione “Riccardo Massa” (Milan, Italy).
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- Partners --}}
    <section id="partners">
      <hr class="m-5">
      <div class="row ">
        <div id="partner-12" class="col-md-4 offset-md-4">
          <a href="https://eacea.ec.europa.eu/about-eacea" target="_blank">
            <img class="img-fluid"src="/img/home/eu-flag.jpg">
          </a>
        </div>
      </div>
      <div class="row mt">
        <div class="offset-md-1"></div>
        @foreach ($partners as $partner)
          <div id="container-{{ $partner->id_tag }}" class="col-md-2 text-center">
            <div class="row">
              <div class="col">
                <img src="{{ Storage::disk('local')->url($partner->logo_url) }}" id="partner-{{ $partner->id_tag }}" class="img-fluid" alt="{{ $partner->name }}">
              </div>
            </div>
            <div class="row">
              <div class="col">
                <a href="" class="btn" data-toggle="modal" data-target="#{{ $partner->id_tag }}">More info</a>
              </div>
            </div>
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
