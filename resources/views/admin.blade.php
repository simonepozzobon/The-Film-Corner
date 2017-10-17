@extends('layouts.admin')
@section('title', 'Statistiche')
@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="box container-fluid mb-4">
      <div class="row">
        <div class="col dark-blue py-3 px-5">
          <h3>Utenti Online</h3>
        </div>
      </div>
      <div class="row">
        <div class="col blue p-5">
          <h1>{{ $users->count() }}</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box container-fluid mb-4">
      <div class="row">
        <div class="col dark-blue py-3 px-5">
          <h3>Sessioni</h3>
        </div>
      </div>
      <div class="row">
        <div class="col blue p-5">
          <h1>{{ $sessions->count() }}</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box container-fluid mb-4">
      <div class="row">
        <div class="col dark-blue py-3 px-5">
          <h3>Visualizzazioni</h3>
        </div>
      </div>
      <div class="row">
        <div class="col blue p-5">
          <h1>{{ $page_views_tot }}</h1>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
