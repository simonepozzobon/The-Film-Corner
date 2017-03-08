@extends('layouts.main')
@section('title')
  The Film Corner
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/revealer.css') }}">
@endsection
@section('content')
  {{-- Main Hero Cover --}}
  <div id="el-1">
    <section id="top" class="hero home">
      <div class="flex-center position-ref full-height">
        <div class="content">
          <div class="logo">
            <img src="/img/logo.png">
          </div>
          <div class="title m-b-md">
              The Film Corner
          </div>
          <div class="links">
            <a href="#project">The Project</a>
            <a href="#news">News</a>
            <a href="#partners">Partners</a>
            <a href="#apps">Apps</a>
            <a href="#resources">Resources</a>
            @if (Auth::user())
              <a href="#">Your Account</a>
            @endif
            @if (Auth::guard('admin')->check())
              <a href="{{ route('admin') }}">Admin Panel</a>
            @endif
            @if (Auth::guard('teacher')->check())
              <a href="#">Teacher Area</a>
            @endif
            @if (Auth::guard('student')->check())
              <a href="#">Student Area</a>
            @endif
            @if (Auth::guest())
              <a href="#login">Login</a>
            @endif
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="container">
    {{-- News --}}
    <div class="row">
      <div class="col">
        <section id="news">
          <div id="news-title" class="title sp-center pt-5 pb-5">
            News
          </div>
          <div id="news-container" class="tween-content-container">
          <div id="carouselNewsIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselNewsIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselNewsIndicators" data-slide-to="1"></li>
              <li data-target="#carouselNewsIndicators" data-slide-to="2"></li>
              <li data-target="#carouselNewsIndicators" data-slide-to="3"></li>
              <li data-target="#carouselNewsIndicators" data-slide-to="4"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="row mb-4">
              @foreach ($posts as $key=>$post)
                <div class="carousel-item {{ $key===1 ? 'active' : ''  }}">
                    <div class="col-md-8 offset-md-2">
                      <div class="news-title">
                        <h2>{{ $post->title }}</h2>
                      </div>
                      <div class="news-subtitle">
                        <h4>Posted {{ $post->updated_at->diffForHumans() }}</h4>
                      </div>
                      <p class="lead">{{ substr(strip_tags($post->content), 0, 500) }}{{ strlen(strip_tags($post->content)) > 500 ? '...' : "" }}</p>
                      <div class="clearfix">
                        <div class="tags">
                           <span>Tags:
                             @foreach ($post->tags as $tag)
                             <span class="badge badge-default">{{ $tag->name }}</span>
                             @endforeach
                           </span>
                        </div>
                      </div>
                      <a class="btn btn-info mt-4" href="/post/{{ $post->id }}">Read more</a>
                      <hr>
                    </div>
                  </div>
              @endforeach
              </div>
              <a class="carousel-control-prev" href="#carouselNewsIndicators" role="button" data-slide="prev">
                <svg id="left" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><title>left</title><path d="M18.67,16.54v-.72H1.08l7.64-7.6-.5-.54L.11,15.75a.35.35,0,0,0,0,.5l.18.18v.11H.4l7.78,7.78.5-.5L1.41,16.54Zm11.17-.72H32v.72H29.84Zm-4.79,0h2.41v.72H25Zm-4.58,0h2.16v.72H20.47Z"/></svg>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselNewsIndicators" role="button" data-slide="next">
                <svg id="right" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><title>right</title><path d="M31.75,15.59v-.11h-.11L23.85,7.68l-.51.51,7.29,7.29H13.35v.72H31l-7.65,7.61.51.51,8.08-8.08a.35.35,0,0,0,0-.51Zm-22.37.05h2.16v.72H9.38Zm-4.8,0H7v.72H4.58ZM0,15.64H2.16v.72H0Z"/></svg>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
          </div>
        </section>
      </div>
    </div>
    {{-- Project --}}
    <div class="row">
      <div class="col">
        <section id="project">
          <div id="project-trigger"></div>
          <div id="project-title" class="title sp-center pt-5 pb-5">
            The Project
          </div>
          <div class="row">
            <div id="project-container" class="tween-content-container block-wrapper col-md-8 offset-md-2">
              <div class="block-container">
                <div class="block-title">
                  <h2>The Film Corner</h2>
                </div>
                <div class="block-subtitle">
                  <h4>On and off activities for Film Literacy</h4>
                </div>
                <div class="block-text">
                  <p class="text-justify">
                    Project is aimed to the <b>design, release</b> and <b>testing</b> of an <b>online digital virtual user-centered platform for Film Literacy</b>, taking advantage of the opportunities offered by <b>web 2.0 and crossmedia innovative approach</b> in the digital era in order to <b>raise the average film literacy level of EU young audiences</b>. The general aim of the project is to contribute to draw an <b>easy-going model for Film Literacy that could improve Film Literacy</b> skills among the audience in order to foster Audience Development and Engagement towards film as an art form, with a particular focus on young and non-core audience.
                    <br>
                    The project involves 5 European institutions in 4 EU countries: <b>Fondazione Cineteca Italiana</b> in Milan, Italy (leading partner); <b>The Film Space</b>, an innovative Film Literacy provider (Manchester, UK); <b>The Nerve Centre</b>, a Creative Learning Centre Derry, Northern Ireland; the <b>National Cinèmatheque of Serbia</b> (Belgrade, Serbia) one of the eldest cinèmatheques in the world and the <b>University of Milano Bicocca</b>,  Dipartimento di Scienze Umane per la Formazione “Riccardo Massa” (Milan, Italy).
                    <br>
                    The platform consists of an <b>interactive narrative-based environmental layout with game-based didactical resources</b> integrated as <b>apps</b> the user can interact with. Didactical resources will be both based on generic Film Literacy skills and on a set of EU national and non-national films. The platform is to be developed in at least 4 EU languages including english, french, italian and serbian.
                    <br>
                    In the first part of the project, the partner institutions will share their expertise and best practices in order to draw a <b>shared methodological didactical approach</b>. On the basis of this methodological framework the platform and its content will be designed. The platform designed will be then technically realised by professional providers.
                    <br>
                    The second part of the project is dedicated to <b>testing</b>: the platform will be tested on students (<b>target age: 12-16</b>) and teachers of the schools involved with the guidance of the tutors from the partner institutions. Offline knowledge transfer activities will be held with teachers and students aimed to understand how it can be used for pedagogical purposes in class. Students and teachers will fulfil questionnaires of evaluation and data will be further used for <b>Evaluation and Quality Assurance</b>. During the whole duration of the project, <b>dissemination and communication</b> take place. This activity is carried on on the basis of a previously drafted dissemination strategy plan.
                    <br>
                    In november 2017, an <b>international conference</b> will take place in the frame of the 10th edition of “Piccolo Grande Cinema” Festival, a film festival dedicated to young audience promoted by Fondazione Cineteca Italiana. During the international conference the platform blueprint will be officially presented and some panels discussing several issues concerning Film Literacy, crossmedia and Audience Development and engagement will be discussed. A call for papers will be issued and keynote speakers, including representants from other film literacy project financed in the frame of the Creative Europe Programme will be invited.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    {{-- Partners --}}
    <div class="row mb-5">
      <div class="col">
        <section id="partners">
          <div id="partners-trigger"></div>
          <div id="partners-title" class="title sp-center pt-5 pb-5">
            Partners
          </div>
          <div id="partners-container" class="tween-content-container block-wrapper">
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
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </section>
      </div>
    </div>
    {{-- Apps --}}
    <div class="row">
      <div class="col">
        <section id="apps">
          <div id="trigger-apps"></div>
          <div id="title-apps" class="title sp-center pt-5">
            Apps
          </div>
          <div id="container-13" class="col-md-6 offset-md-3">
            <svg id="apps-animation" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500">
              <title>Apps</title>
              <style>.pen{z-index: 1;} .screen{z-index: 2;}</style>
              <path class="screen"  d="M125.29,240.67a8.46,8.46,0,0,0-8.5,8.5,2.83,2.83,0,1,0,5.67,0,2.52,2.52,0,0,1,1.06-2.12,3.06,3.06,0,0,1,2.12-1.06,2.79,2.79,0,0,0,2.83-2.83A3.4,3.4,0,0,0,125.29,240.67ZM313.67,246a2.52,2.52,0,0,1,2.12,1.06,3.06,3.06,0,0,1,1.06,2.12,2.83,2.83,0,0,0,5.67,0,8.46,8.46,0,0,0-8.5-8.5,2.79,2.79,0,0,0-2.83,2.83A2.66,2.66,0,0,0,313.67,246Zm0,102.33a8.46,8.46,0,0,0,8.5-8.5,2.83,2.83,0,0,0-5.67,0,2.52,2.52,0,0,1-1.06,2.12,3.06,3.06,0,0,1-2.12,1.06,2.79,2.79,0,0,0-2.83,2.83C311.19,346.89,312.25,348.31,313.67,348.31ZM125.29,343a2.52,2.52,0,0,1-2.12-1.06,3.06,3.06,0,0,1-1.06-2.12,2.83,2.83,0,1,0-5.67,0,8.46,8.46,0,0,0,8.5,8.5,2.79,2.79,0,0,0,2.83-2.83A2.24,2.24,0,0,0,125.29,343ZM400.77,226.15H361.82A2.79,2.79,0,0,0,359,229v12.39a2.79,2.79,0,0,0,2.83,2.83h38.95a2.79,2.79,0,0,0,2.83-2.83V228.63A2.74,2.74,0,0,0,400.77,226.15Zm-2.48,12H364.66v-7.08h33.64Zm2.48,11.33H361.82a2.79,2.79,0,0,0-2.83,2.83v12.39a2.79,2.79,0,0,0,2.83,2.83h38.95a2.79,2.79,0,0,0,2.83-2.83V252.35A3,3,0,0,0,400.77,249.52Zm-2.48,12.39H364.66v-7.08h33.64Zm2.48,59.84H361.82a2.79,2.79,0,0,0-2.83,2.83V337a2.79,2.79,0,0,0,2.83,2.83h38.95A2.79,2.79,0,0,0,403.6,337V324.23A2.74,2.74,0,0,0,400.77,321.75Zm-2.48,12H364.66v-7.08h33.64Zm2.48,11.33H361.82A2.79,2.79,0,0,0,359,348v12.39a2.79,2.79,0,0,0,2.83,2.83h38.95a2.79,2.79,0,0,0,2.83-2.83V348A2.79,2.79,0,0,0,400.77,345.12Zm-2.48,12.39H364.66v-7.08h33.64Zm1.42-63A18.41,18.41,0,1,0,381.3,312.9,18.51,18.51,0,0,0,399.71,294.49Zm-31.51,0a13.1,13.1,0,1,1,13.1,13.1A13.3,13.3,0,0,1,368.2,294.49Zm-67.28-96.67H146.54l-40.72.35H90.24a11.79,11.79,0,0,0-11.68,11.68V379.11A11.79,11.79,0,0,0,90.24,390.8h325.4a11.79,11.79,0,0,0,11.68-11.68v-80c7.44-1.77,11.33-10.62,14.87-19.47,3.54-8.5,6.73-16.64,12.75-16.64,5.67,0,9.21,8.14,12.75,16.64.71,1.77,1.42,3.54,2.12,5a2.7,2.7,0,0,0,5-2.12,21.63,21.63,0,0,1-2.48-5c-3.89-9.56-8.14-19.83-17.7-19.83-9.21,0-13.46,9.91-17.35,19.83-2.83,7.08-5.67,13.81-9.91,15.93V209.86a11.79,11.79,0,0,0-11.68-11.68H349.78ZM422,297v82.15a6.35,6.35,0,0,1-6.37,6.37H90.24a6.35,6.35,0,0,1-6.37-6.37V209.86a6.35,6.35,0,0,1,6.37-6.37h325.4a6.35,6.35,0,0,1,6.37,6.37Zm-97.73-70.82H114.67A11.79,11.79,0,0,0,103,237.83v113a11.79,11.79,0,0,0,11.68,11.68H324.29A11.79,11.79,0,0,0,336,350.79v-113A11.79,11.79,0,0,0,324.29,226.15Zm6.37,124.64a6.35,6.35,0,0,1-6.37,6.37H114.67a6.35,6.35,0,0,1-6.37-6.37v-113a6.35,6.35,0,0,1,6.37-6.37H324.29a6.35,6.35,0,0,1,6.37,6.37Z"/>
              <path class="blink1"  d="M29.69,216.59a2.75,2.75,0,1,0-3.89,3.89l5,4.6a2.57,2.57,0,0,0,3.54,0,2.78,2.78,0,0,0,0-3.89Zm12,19.47,5,5a2.57,2.57,0,0,0,3.54,0,2.78,2.78,0,0,0,0-3.89l-4.6-5a2.75,2.75,0,0,0-3.89,3.89Zm-11-3.89-5,5a2.78,2.78,0,0,0,0,3.89,2.57,2.57,0,0,0,3.54,0l5-5a2.78,2.78,0,0,0,0-3.89A3.2,3.2,0,0,0,30.75,232.17ZM43.5,225.8a2.7,2.7,0,0,0,1.77-.71l5-5a2.75,2.75,0,0,0-3.89-3.89l-5,5a2.78,2.78,0,0,0,0,3.89A3,3,0,0,0,43.5,225.8Z"/>
              <path class="blink2"  d="M199.65,407.79a2.75,2.75,0,1,0-3.89,3.89l5,5a2.57,2.57,0,0,0,3.54,0,2.78,2.78,0,0,0,0-3.89Zm15.93,15.93a2.75,2.75,0,1,0-3.89,3.89l5,5a2.57,2.57,0,0,0,3.54,0,2.78,2.78,0,0,0,0-3.89Zm-14.87,0-5,5a2.78,2.78,0,0,0,0,3.89,2.57,2.57,0,0,0,3.54,0l5-5a2.78,2.78,0,0,0,0-3.89A2.36,2.36,0,0,0,200.71,423.73Zm15.93-15.93-5,5a2.78,2.78,0,0,0,0,3.89,2.57,2.57,0,0,0,3.54,0l5-5a2.78,2.78,0,0,0,0-3.89A2.36,2.36,0,0,0,216.65,407.79Z"/>
              <path class="blink3"  d="M449.28,202.43l5,5a2.57,2.57,0,0,0,3.54,0,2.78,2.78,0,0,0,0-3.89l-5-5a2.78,2.78,0,0,0-3.89,0A3.22,3.22,0,0,0,449.28,202.43Zm19.83,12a2.75,2.75,0,1,0-3.89,3.89l5,5a2.57,2.57,0,0,0,3.54,0,2.78,2.78,0,0,0,0-3.89Zm-14.87,0-5,5a2.78,2.78,0,0,0,0,3.89,2.57,2.57,0,0,0,3.54,0l5-5a2.78,2.78,0,0,0,0-3.89A2.36,2.36,0,0,0,454.24,214.46Zm13.1-6.37a2.7,2.7,0,0,0,1.77-.71l5-5a2.75,2.75,0,0,0-3.89-3.89l-5,5a2.78,2.78,0,0,0,0,3.89A2.6,2.6,0,0,0,467.34,208.09Z"/>
              <path class="circle1" d="M288.88,402.13a13.46,13.46,0,1,0,13.46,13.46C302.69,408.5,296.32,402.13,288.88,402.13Zm0,22a8.14,8.14,0,1,1,8.14-8.14A8,8,0,0,1,288.88,424.08Z"/>
              <path class="circle2" d="M183,153.21a13.46,13.46,0,1,0,13.46-13.46A13.45,13.45,0,0,0,183,153.21Zm21.6,0a8.14,8.14,0,1,1-8.14-8.14A8,8,0,0,1,204.61,153.21Z"/>
              <path class="pen"     d="M325.35,130.19a3.89,3.89,0,1,1-3.89,3.89A3.72,3.72,0,0,1,325.35,130.19ZM299.15,144a169.54,169.54,0,0,0,23.37-40v21.25a8.83,8.83,0,0,0-6.37,8.85,9.21,9.21,0,1,0,18.41,0,9.6,9.6,0,0,0-6.37-8.85V104c5.31,12,13.1,27.26,24.08,40l-11,20.18H310.13Zm50.63,54.17-1.06-7.44L348,187.2c-.71-3.19-1.06-6.37-1.77-9.56a7.39,7.39,0,0,0,2.83-5.67,6.88,6.88,0,0,0-2.83-5.67l11.68-20.89a3,3,0,0,0,0-2.48c0-.35-.35-.35-.35-.71-15.58-17.35-25.14-40.72-29.39-53.11v-.35c0-.35-.35-.35-.35-.71l-.35-.35a1.24,1.24,0,0,0-.71-.35h-.35c-.35,0-.71-.35-1.06-.35a1.3,1.3,0,0,0-1.06.35h-.35c-.35,0-.35.35-.71.35l-.35.35a1.24,1.24,0,0,0-.35.71v.35c-4.25,12.39-13.46,35.41-29.39,52.76-.35.35-.35.35-.35.71a3,3,0,0,0,0,2.48L304.46,166a7.39,7.39,0,0,0-2.83,5.67,6.88,6.88,0,0,0,2.83,5.67c-.71,3.19-1.06,6.37-1.77,9.56l-.71,3.54-1.06,7.44h5.31l1.06-6.37.71-3.54c.35-2.83,1.06-5.67,1.42-8.5h31.51a70.9,70.9,0,0,1,1.42,8.5l.71,3.54,1.06,6.37Zm-42.49-26.56a2.42,2.42,0,0,1,2.48-2.48h31.51a2.48,2.48,0,1,1,0,5H309.77A2.42,2.42,0,0,1,307.29,171.62Z"/>
            </svg>
            <svg class="lines" viewBox="0 0 500 500" style="background-color:#ffffff00" xmlns="http://www.w3.org/2000/svg">
              <g stroke="#252525" stroke-width="2" fill="none">
                  <path class="line1"   d="M51.29,285.64a2.83,2.83,0,1,0-5.67,0v46.74a2.83,2.83,0,1,0,5.67,0Zm-2.83,59.49A2.79,2.79,0,0,0,45.63,348v15.23a2.83,2.83,0,1,0,5.67,0V348A2.79,2.79,0,0,0,48.46,345.12Z"/>
                  <path class="line2"   d="M448.57,114.26a2.79,2.79,0,0,0,2.83-2.83V65a2.79,2.79,0,0,0-2.83-2.83A2.61,2.61,0,0,0,445.74,65v46.74A2.53,2.53,0,0,0,448.57,114.26Zm0,30.81a2.79,2.79,0,0,0,2.83-2.83V127a2.79,2.79,0,0,0-2.83-2.83,2.61,2.61,0,0,0-2.83,2.83v15.23A2.79,2.79,0,0,0,448.57,145.06Z"/>
                  <path class="line3"   d="M127.42,426.92H76.78a2.83,2.83,0,0,0,0,5.67h50.63a2.79,2.79,0,0,0,2.83-2.83C129.9,428,128.84,426.92,127.42,426.92Zm-67.28,0H43.5a2.83,2.83,0,0,0,0,5.67H59.79a2.79,2.79,0,0,0,2.83-2.83A2.53,2.53,0,0,0,60.14,426.92Zm-16.64-12H78.91a2.83,2.83,0,0,0,0-5.67H43.5A2.79,2.79,0,0,0,40.67,412C41,413.46,42.08,414.88,43.5,414.88Zm62,0a2.83,2.83,0,0,0,0-5.67H94.13a2.83,2.83,0,0,0,0,5.67Z"/>
                  <path class="line4"   d="M408.56,420.19a2.79,2.79,0,0,0-2.83-2.83H355.1a2.83,2.83,0,0,0,0,5.67h50.63C407.5,422.67,408.56,421.6,408.56,420.19ZM439,417.35H422.73a2.83,2.83,0,0,0,0,5.67H439a2.79,2.79,0,0,0,2.83-2.83C441.49,418.42,440.43,417.35,439,417.35Zm0,17.35H403.6a2.83,2.83,0,0,0,0,5.67H439a2.79,2.79,0,0,0,2.83-2.83C441.49,436.12,440.43,434.7,439,434.7Zm-50.63,0H377a2.83,2.83,0,0,0,0,5.67h11.33a2.79,2.79,0,0,0,2.83-2.83A3,3,0,0,0,388.38,434.7Z"/>
                  <path class="line5"   d="M157.87,112.13A2.79,2.79,0,0,0,160.7,115H211a2.83,2.83,0,0,0,0-5.67H160.35A3,3,0,0,0,157.87,112.13ZM127.42,115h16.29a2.83,2.83,0,0,0,0-5.67H127.42a2.83,2.83,0,0,0,0,5.67Zm0-17.35h35.41a2.83,2.83,0,0,0,0-5.67H127.42a2.79,2.79,0,0,0-2.83,2.83A3,3,0,0,0,127.42,97.62Zm50.63,0h11.33a2.83,2.83,0,0,0,0-5.67H178.05a2.79,2.79,0,0,0-2.83,2.83A3,3,0,0,0,178.05,97.62Z"/>
                  <path class="design"  d="M249.93,79.56a9.88,9.88,0,0,0,9.56-7.44H303a44.65,44.65,0,0,0-22.66,35.76h-4.25a2.79,2.79,0,0,0-2.83,2.83v12.75a2.79,2.79,0,0,0,2.83,2.83h12.75a2.79,2.79,0,0,0,2.83-2.83V110.72a2.79,2.79,0,0,0-2.83-2.83h-3.19a38.37,38.37,0,0,1,30.45-35.05v2.83A2.79,2.79,0,0,0,319,78.5h12.39a2.79,2.79,0,0,0,2.83-2.83V72.83a38.43,38.43,0,0,1,30.1,35.05h-3.19a2.79,2.79,0,0,0-2.83,2.83v12.75a2.79,2.79,0,0,0,2.83,2.83h12.75a2.79,2.79,0,0,0,2.83-2.83V110.72a2.79,2.79,0,0,0-2.83-2.83h-4.25A43.85,43.85,0,0,0,347,72.12H390.5a9.91,9.91,0,1,0,0-5H333.85V63.62A2.79,2.79,0,0,0,331,60.79H318.27a2.79,2.79,0,0,0-2.83,2.83v3.54H258.78a9.89,9.89,0,0,0-19.47,2.48C240,75.31,244.27,79.56,249.93,79.56Zm36.47,41.07H279V113.2h7.44Zm85,0h-7.44V113.2h7.44Zm29-55.59a4.6,4.6,0,1,1-4.6,4.6C395.46,67.17,397.59,65,400.42,65Zm-79,1.06h7.44v3.54h0v3.89h-7.44ZM249.93,65a4.6,4.6,0,1,1-4.6,4.6A4.69,4.69,0,0,1,249.93,65Z"/>
              </g>
            </svg>

          </div>
          <div id="apps-footer" class="text-center">
            <a href="#" class="btn btn-info">Go To Apps</a>
          </div>
        </section>
      </div>
    </div>
    {{-- Resources --}}
    <div class="row">
      <div class="col">
        <section id="resources">
          <div id="trigger-resources"></div>
          <div id="title-resources" class="title sp-center pt-5">
            Resources
          </div>
          <div class="empty-page">

          </div>
        </section>
      </div>
    </div>
    {{-- Login / call to action for registration --}}
    <div class="row">
      <div class="col">
        <section id="login">
          <div id="trigger-login"></div>
          <div id="title-login" class="title sp-center pt-5 pb-5">
            Login
          </div>
            <div class="login-wrapper">
              <div class="login-container">
                @if (Auth::user())
                  <a href="#" class="btn btn-lg btn-block">Your Account</a>
                @endif
                @if (Auth::guard('admin')->check())
                  <a href="{{ route('admin') }}" class="btn btn-block btn-info">Admin Panel</a>
                @endif
                @if (Auth::guard('teacher')->check())
                  <a href="#" class="btn btn-block btn-info">Teacher Area</a>
                @endif
                @if (Auth::guard('student')->check())
                  <a href="#" class="btn btn-block btn-info">Student Area</a>
                @endif
                @if (Auth::guest())
                  <a href="{{ route('login') }}" class="btn btn-block btn-info mb-3">Login</a>
                  <a href="{{ route('register') }}" class="btn btn-block btn-success">Sign Up</a>
                @endif
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="//raw.githubusercontent.com/lcdsantos/jquery-drawsvg/master/public/jquery.drawsvg.min.js"></script>
	<script src="{{ asset('js/anime.min.js') }}"></script>
	<script src="{{ asset('js/scrollMonitor.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
  <script type="text/javascript">
  (function() {
			// Fake loading.
			init();

			function init() {
				var rev1 = new RevealFx(document.querySelector('#el-1'), {
					revealSettings : {
						bgcolor: '#7f40f1',
						onCover: function(contentEl, revealerEl) {
							contentEl.style.opacity = 1;
						}
					}
				});
				rev1.reveal({
          bgcolor: '#c1c0b7',
          duration: 300,
          direction: 'tb',
          onStart: function(contentEl, revealerEl) {
            anime.remove(contentEl);
            contentEl.style.opacity = 0;
          },
          onCover: function(contentEl, revealerEl) {
            anime({
              targets: contentEl,
              duration: 500,
              delay: 50,
              easing: 'easeOutBounce',
              translateY: [-40,0],
              opacity: {
                value: [0,1],
                duration: 300,
                easing: 'linear'
              }
            });
          }
        });

        var scrollElemToWatch_1 = document.getElementById('news-title'),
					watcher_1 = scrollMonitor.create(scrollElemToWatch_1, -300),
					rev3 = new RevealFx(scrollElemToWatch_1, {
						revealSettings : {
							bgcolor: '#FDD351',
							direction: 'rl',
							onCover: function(contentEl, revealerEl) {
								contentEl.style.opacity = 1;
							}
						}
					});

          watcher_1.enterViewport(function() {
  					rev3.reveal();
  					watcher_1.destroy();
  				});
			}
		})();
  </script>
@endsection
