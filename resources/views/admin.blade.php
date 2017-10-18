@extends('layouts.admin')
@section('title', 'Statistiche')
@section('stylesheets')
  <style media="screen">
    .overlay {
      position: absolute;
      width: 100%;
      height: 100%;
      background: #000;
    }
  </style>
@endsection
@section('content')
<main id="app">
  @if (!isset($visited))
    <alert-tutorial title="Attenzione!!!" color="yellow" element="video-menu" position="bottom">
      <h4 class="text-center">Il pannello per caricare i video è stato spostato in alto a destra</h4>
    </alert-tutorial>
  @endif
  <div class="row">
    <div class="col-md-4">
      <app-box title="Utenti Online" color="blue">
        <h1>{{ $users->count() }}</h1>
      </app-box>
    </div>
    <div class="col-md-4">
      <app-box title="Sessioni" color="blue">
        <h1>{{ $sessions->count() }}</h1>
      </app-box>
    </div>
    <div class="col-md-4">
      <app-box title="Visualizzazioni" color="blue">
        <h1>{{ $page_views_tot }}</h1>
      </app-box>
    </div>
  </div>
</main>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/main.js') }}"></script>
@endsection
