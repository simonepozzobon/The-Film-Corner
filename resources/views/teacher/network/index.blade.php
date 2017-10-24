@extends('layouts.teacher')
@section('content')
  <div class="mt-5 pt-5"></div>
  <section id="main" class="pb-5 px-5">
    <div class="row">
      @foreach ($items as $key => $item)
        <div class="box col-md-4 mb-5">
          <div class="container-fluid">
            <div class="row">
              <div class="col {{ $item->colors[1] }} py-3 px-5" >
                <h3>{{ $item->title }}</h3>
              </div>
            </div>
            <div class="row">
              <div class="col {{ $item->colors[0] }} px-5 pt-3 pb-5">
                <h5 class="d-inline-block"><span class="badge badge-default mb-3">{{ $item->app_category }}</span></h5>
                <h5 class="d-inline-block"><span class="badge badge-default mb-3">{{ $item->app_name }}</span></h5>
                <p>{{ $item->notes }}</p>
                <hr>
                <div class="row pt-4">
                  <div class="col">
                    <h4 class="text-center"><i class="fa fa-eye" aria-hidden="true"></i></h4>
                  </div>
                  <div class="col">
                    <h4 class="text-center"><i class="fa fa-heart" aria-hidden="true"></i></h4>
                  </div>
                  <div class="col">
                    <h4 class="text-center"><i class="fa fa-comment" aria-hidden="true"></i></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </secion>
@endsection
@section('scripts')
  <script src="{{ mix('js/network.js') }}"></script>
@endsection
