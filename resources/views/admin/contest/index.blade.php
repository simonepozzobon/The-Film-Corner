@extends('layouts.admin')
@section('title', 'Contest')
@section('content')
<div id="app" class="container">
  <div class="row">
    <div class="col">
      <div class="box green">
        <div class="box-header">
          <h3>Contest Video</h3>
        </div>
        <div class="box-body">
          <list></list>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/contest.js') }}"></script>
@endsection
