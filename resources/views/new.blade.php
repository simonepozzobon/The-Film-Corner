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
    <div class="row mt">
      <div class="col">
        <div class="box blue">
          <div class="box-header">
            APPLY TO THE NEXT THE FILM CORNER TESTING PROGRAM - DEADLINE EXTENDED
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/time.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8 pb-3">
                <p class="pt-3">
                  “The Film Corner Reloaded – A cultural approach” stems from “The Film Corner. Online and offline activities for film literacy” already financed by the European Commission in the frame of the Creative Europe Programme. The project is managed by Fondazione Cineteca Italiana (Italy) in partnership with Jugslovenska Kinoteka (Serbia), The Film Space (UK), The Nerve Centre (Northern Ireland), University of Milano-Bicocca (Italy) and with two brand new partners that joined us for this second edition: The Georgian National Film Centre (Georgia) and Kino Otok (Slovenia).
                  <br><br>
                </p>
                <p>
                  The project has officially started in december 2018 and it will finish in december 2020. During those 2 years, a third section of the platform will be developed, it will be dedicated to an interdisciplinary and cross-curricular approach to film education centered on the main topic of film and its relationships with other topics. This new section will join the already existing sections of the platform: “Film Specific” and the “Creative Studio”.
                  <br><br>
                </p>
                <p>
                  Through The Film Corner project our purpose is not only to create a useful interactive didactical resource; we would also like to share this platform with teachers and schools in other countries.
                  <br><br>
                </p>
                <p>
                  That’s why only for this edition of the project we have a special proposal addressed to teachers: you can participate in the testing phase with your school!
                  <br><br>
                </p>
                <p>
                  You have time until JUNE 30th to submit and to receive a free account to browse the platform. Follow the instructions in the card below and get to know The Film corner platform!
                  <br><br>
                </p>
                <img src="/img/home/img-2.jpg" alt="" class="img-fluid">
                <div class="d-flex justify-content-center mt">
                  <a href="https://cinetecamilano.it/the-film-corner?utm_source=test&utm_medium=news" target="_blank" class="btn btn-blue">Application Form</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box yellow">
          <div class="box-header">
            THE SECOND EDITION OF THE FILM CORNER HAS STARTED!
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/ciak.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8 pb-3">
                <p class="py-3">
                  Good news for our teachers, students and followers: The Film Corner project has received a second
                  grant by the European Commission in order to keep on researching around film education!<br><br>
                  “The Film Corner Reloaded – A cultural approach” stems from “The Film Corner. Online and
                  offline activities for film literacy” already financed by the European Commission in the frame of
                  the Creative Europe Programme. The project is managed by Fondazione Cineteca Italiana (Italy) in
                  partnership with Jugslovenska Kinoteka (Serbia), The Film Space (UK), The Nerve Centre
                  (Northern Ireland), University of Milano-Bicocca (Italy) and with two brand new partners that
                  joined us for this second edition: The Georgian National Film Centre (Georgia) and Kino Otok
                  (Slovenia).<br><br>
                  The project has officially started in december 2018 and it will finish in december 2020. During
                  those 2 years, a third section of the platform will be developed, it will be dedicated to an
                  interdisciplinary and cross-curricular approach to film education centered on the main topic of film
                  and its relationships with other topics. This new section will join the already existing sections of the
                  platform: “Film Specific” and the “Creative Studio”.
                  <br><br>
                </p>
                <h4>APPLY FOR THE NEXT INTERNATIONAL TESTING PROGRAM OF THE FILM CORNER
                PLATFORM!</h4>
                <p>
                  Through The Film Corner project our purpose is not only to create a useful interactive didactical
                  resource; we would also like to share this platform with teachers and schools in other countries.<br><br>
                  That’s why only for this edition of the project we have a special proposal addressed to teachers:
                  you can participate in the testing phase with your school!<br><br>
                  Follow the instructions in the card below and get to know The Film corner platform!<br><br>
                </p>
                <img src="/img/CARD_5_TFC_2019-1.jpg" alt="" class="img-fluid">
                <div class="d-flex justify-content-center mt">
                  <a href="https://cinetecamilano.it/the-film-corner?utm_source=test&utm_medium=news" target="_blank" class="btn btn-yellow">Application Form</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box green">
          <div class="box-header">
            #MyCornerContest
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/oscar.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8 pb-3">
                <p class="py-3">
                  We are pleased to announce that the short film “Serendipity”, directed by Beatrice Delli Paoli, Gaia De Tata, Jennifer Esposito, Valentina Fedelfio e Greta Fontana, students of the 4A class of IS Giovanni Falcone in Gallarate (Varese), is the winner of My Corner Contest, the international short film competition launched in April 2018, as part of the #TheFilmCorner project. Congratulations to the young directors!
                </p>
                <div class="embed-responsive embed-responsive-16by9">
                  <video id="my-video" class="video-js" controls preload="auto" width="640" height="264"
                    poster="https://thefilmcorner.eu/storage/apps/mycorner-contest/make-your-own-film/88/5b19ac803e721-thumb.jpg" height="264" width="640" preload="auto" id="video-5b19a2f626b43" lang="it-it" role="region" aria-label="Video Player">
                    <source src="https://thefilmcorner.eu/storage/apps/mycorner-contest/make-your-own-film/88/5b19ac803e721.mp4" type='video/mp4'>
                    <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a web browser that
                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                  </video>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box orange">
          <div class="box-header">
            The Film Corner will be present at the 75th Venice International Film Festival!
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/ciak.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                <p>
                  On Sunday, September 2nd at 2 pm at the Italian Pavilion, the project upgrade The Film Corner Reloaded – A cultural approach will be presented at the festivalgoers.<br>
                  In fact the platform will be implemented, with the aim of developing the new section dedicated to an interdisciplinary approach to film education.<br>
                  Moreover, thanks to the partnership with MAF Media, The Film Corner will also become a video-on-demand web platform for schools, with many film titles, even premières. An innovative teaching tool that allow to break down costs, distances, time and ... piracy!<br>
                  <br>
                  Our speakers: Matteo Pavesi (Fondazione Cineteca Italiana Director), Silvia Pareti, Simone Moraldi (Fondazione Cineteca Italiana Special Project Manager) and Fabio Giarrusso (MAF Media - New Business Development).
                  <br>
                  For further information and participation requests write to <a href="mailto:ufficiostampa@cinetecamilano.it">ufficiostampa@cinetecamilano.it</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box blue">
          <div class="box-header">
            {{ GeneralText::field('contest_news_title') }}
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/oscar.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                <div class="h-100 align-middle">
                  <div class="">
                    <p class="mb">
                      {!! GeneralText::field('contest_news') !!}
                    </p>
                    <div class="d-flex justify-content-center">
                      <a href="{{ asset('downloads/contest/My_Corner_Contest_Rules_of_Partecipation.pdf') }}" target="_blank" class="btn btn-blue"><i class="fa fa-book"></i> {{ GeneralText::field('contest_news_btn') }}</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt">
      <div class="col">
        <div class="box yellow">
          <div class="box-header">
            Greetings from The Film Corner International Conference
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/people.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                <div class="h-100 align-middle">
                  <div class="">
                    <p class="mb">
                      Thank you everyone for having taken part in The Film Corner International Conference!<br>
                      We think it has been a great opportunity to discuss together on the themes of Film Literacy and finally to show to the public The Film Corner Project.
                    </p>
                    <p class="text-center mb">
                      For anyone who has missed it,
                      <br>
                      here is the gallery.
                    </p>
                    <div class="d-flex justify-content-center">
                      <a href="{{ route('conference.gallery') }}" class="btn btn-yellow"><i class="fa fa-picture-o"></i> Gallery</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- News --}}
    <div class="row mt">
      <div class="col">
        <div class="box green">
          <div class="box-header">
            The Film Corner at #Venezia74
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/ciak.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                <p>
                  The Film Corner will be present at the 74th Venice International Film Festival!<br>
                  <br>
                  On Sunday, September 3rd at 11 am at the Italian Pavilion, the Film Corner International Conference will be presented at the festivalgoers.<br>
                  the Film Corner International Conference will take place in 2017 on November 9th and 10th in Milan, as part of the X edition of the Piccolo Grande Cinema Festival, addressed to young audiences and organised by Cineteca Italiana, which is the leading organisation of the project.<br>
                  The conference is open to the public and addressed to professionals and trainers of film education, media education, information and communication technology as well as gaming professionals.<br>
                  <br>
                  Our speakers: Matteo Pavesi (Fondazione Cineteca Italiana Director), Silvia Pareti, Simone Moraldi (Fondazione Cineteca Italiana Special Project Manager) and Gianni Canova (film critic).<br>
                  <br>
                  For further information and participation requests write to <a href="mailto:ufficiostampa@cinetecamilano.it">ufficiostampa@cinetecamilano.it</a>
                </p>
                <div class="d-flex justify-content-center">
                  <a href="{{ route('conference') }}" class="btn btn-green"><i class="fa fa-check"></i> Apply</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box mt orange">
          <div class="box-header">
            Deadline extended
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/time.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                <p>
                  Dear visitors,<br>
                  welcome to the website of the European project The Film Corner. Online and offline activities for film literacy, promoted by Fondazione Cineteca Italiana and supported by the Creative Europe Program of the European Union.<br>
                  <br>
                  As you could read on the website, the project is aimed at the design, development and testing of an interactive digital platform for film literacy addressed to students between 12 and 17 years old.<br>
                  <br>
                  The Film Corner International Conference will take place in Milan on 9th and 10th November 2017. Participation is completely free and the deadline for enrolment is 10th October.<br>
                  Click <a href="{{ route('conference') }}">here</a> for all the information and follow us on our <a href="https://www.facebook.com/TheFilmCorner/" target="_blank">facebook</a> page.<br>
                </p>
                <div class="d-flex justify-content-center">
                  <a href="{{ route('conference') }}" class="btn btn-orange"><i class="fa fa-check"></i> Apply</a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="box blue mt">
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
                    <p>
                      <h5>2017, Thu, November 9th</h5>
                      5pm Italian time - MIC-Interactive Film Museum, viale Fulvio Testi, 121, Milan, Italy
                      <h5>2017, Fri, November 10th</h5>
                      9 a.m. - 6 p.m. Italian time, Cinema Oberdan, Viale Vittorio Veneto, 2, Milan, Italy
                    </p>
                    <div class="d-flex justify-content-center">
                      <a href="{{ route('conference') }}" class="btn btn-blue"><i class="fa fa-check"></i> Apply</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="project" class="box yellow mt">
          <div class="box-header">
            {{ GeneralText::field('the_project') }}
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <img src="{{ asset('img/icons/camera.svg') }}" class="img-fluid w-100" >
              </div>
              <div class="col-md-8">
                {!! GeneralText::field('the_project_description') !!}
              </div>
            </div>
          </div>
        </div>
        <div class="box green mt">
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
                <a href="" data-toggle="modal" data-target="#{{ $partner->id_tag }}">
                  <img src="{{ Storage::disk('local')->url($partner->logo_url) }}" id="partner-{{ $partner->id_tag }}" class="img-fluid" alt="{{ $partner->name }}">
                </a>
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
  <link href="https://vjs.zencdn.net/7.3.0/video-js.css" rel="stylesheet">
  <script src="https://vjs.zencdn.net/7.3.0/video.js"></script>

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
