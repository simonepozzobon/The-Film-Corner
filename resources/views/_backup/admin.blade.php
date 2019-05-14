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
  {{-- @if (!isset($visited))
    <alert-tutorial title="Attenzione!!!" color="yellow" element="libraries-menu" position="bottom">
      <h4 class="text-center">Il pannello per caricare i video è stato spostato in alto a destra</h4>
    </alert-tutorial>
  @endif --}}
  <stats-panel stats="{{ json_encode($stats) }}"></stats-panel>
</main>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/main.js') }}"></script>
@endsection
