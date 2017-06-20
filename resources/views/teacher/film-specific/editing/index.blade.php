@extends('layouts.teacher')
@section('title', 'Editing')
@section('content')
  <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      {{ $app_category->name }}
      <h2 class="p-2 block-title">{{ $app_category->section->name }}</h2>
    </div>
  </section>
  <section id="breadcrumbs pr-5 pl-5 pb-5">
    <div class="row">
      <div class="col pr-5 pl-5 pb-5">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('teacher') }}">Pavilions</a></li>
          <li class="breadcrumb-item"><a href="{{ route('teacher') }}/{{ $app_category->section->slug }}">{{ $app_category->section->name }}</a></li>
          <li class="breadcrumb-item active">{{ $app_category->name }}</li>
        </ol>
      </div>
    </div>
  </section>
  <section class="pb-5 pr-5 pl-5">
    <div class="row" style="background-color: #a6dbe2; color: #252525">
      <div class="col align-text-bottom">
        <h3 class="pl-2 pt-4 pb-2 pr-2">Info</h3>
      </div>
    </div>
    <div class="row" style="background-color: #d9f5fc; color: #252525">
      <div class="col pt-5 pr-5 pb-5">
        <p class="pl-2">
          Testo informativo
        </p>
      </div>
    </div>
  </section>
  <section id="main" class="pb-5 pr-5 pl-5">
          <div class="row">
              <div class="col-md-3">
                <div class="container pl-2 pr-2">
                  <div class="row">
                    <div class="col" style="background-color: #a6dbe2; color: #252525">
                      <h3 class="pl-2 pr-2 pt-4 pb-2">Examples</h3>
                    </div>
                  </div>
                  <div class="row pb-5">
                    <div class="col pt-5 pb-5" style="background-color: #d9f5fc; color: #252525">
                      <p class="pl-2">
                        Examples of pictures and clips related to each app with a short explanations
                      </p>
                    </div>
                  </div>
                  <div class="row" style="background-color: #e9c845; color: #252525">
                    <div class="col">
                      <h3 class="pl-2 pr-2 pt-4 pb-2">References</h3>
                    </div>
                  </div>
                  <div class="row mb-5" style="background-color: #f5db5e; color: #252525">
                    <div class="col pt-5 pb-5">
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
              <div class="col-md-9">
                <div class="container pl-2 pr-2">
                  @if ($apps->count() > 0)
                    @foreach ($apps as $key => $app)
                          <div class="row" style="background-color: {{ $app->colors[1] }}; color: #252525">
                            <div class="col">
                              <div class="d-flex justify-content-start">
                                <div class="mr-auto"><h3 class="ml-2 pt-4 pb-1">{{ $app->title }}</h3></div>
                                <div class="p-4">fatto?</div>
                              </div>
                            </div>
                          </div>
                          <div class="row" style="background-color: {{ $app->colors[0] }}; color: #252525">
                            <div class="col pt-5 pr-5 pb-3">
                              <p class="ml-2">
                                {{ $app->description }}
                              </p>
                            </div>
                          </div>
                          <div class="row pb-5" style="background-color: {{ $app->colors[0] }}; color: #252525">
                            <div class="col-md-6 offset-md-3">
                              <div class="btn-group btn-block">
                                <a href="#" class="btn btn-primary w-50"><i class="fa fa-file-o" aria-hidden="true"></i> New</a>
                                <a href="#" class="btn btn-warning w-50"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Open</a>
                              </div>
                            </div>
                          </div>
                    @endforeach
                  @else
                    <div class="row">
                      <div class="container" style="background-color: #f5db5e; color: #252525">
                        <div class="row" style="background-color: #e9c845; color: #252525">
                          <div class="col align-text-bottom">
                            <h3 class="p-2">Oooops</h3>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col pt-5 pr-5 pb-5">
                            <p class="pl-2">
                              No apps available for now
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
  </section>
@endsection
