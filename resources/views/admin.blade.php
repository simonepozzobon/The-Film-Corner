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
    <alert-tutorial title="Attenzione!!!" color="yellow" element="libraries-menu" position="bottom">
      <h4 class="text-center">Il pannello per caricare i video è stato spostato in alto a destra</h4>
    </alert-tutorial>
  @endif
  <div class="row pb-3">
    <div class="col-md-4">
      <app-box title="App Insegnanti" color="blue">
        <h1>{{ $stats['teacher_sessions'] }}</h1>
        <p>Numero di applicazioni svolte dagli insegnanti</p>
      </app-box>
    </div>
    <div class="col-md-4">
      <app-box title="App Studenti" color="blue">
        <h1>{{ $stats['student_sessions'] }}</h1>
        <p>Numero di applicazioni svolte dagli studenti</p>
      </app-box>
    </div>
    <div class="col-md-4">
      <app-box title="Visualizzazioni" color="blue">
        <h1>{{ $stats['page_views_60dd'] }}</h1>
        <p>Visualizzazioni di pagina</p>
      </app-box>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <app-box title="Ciao" color="blue">

      </app-box>
    </div>
  </div>
</main>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/main.js') }}"></script>
@endsection
