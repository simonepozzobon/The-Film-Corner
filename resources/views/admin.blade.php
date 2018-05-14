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
    <div class="col-md-8">
      <div class="row pb-3">
        <div class="col-md-12">
          <app-box title="Pagina della settimana" color="yellow">
            <p>Pagina più visitata della settimana</p>
            <h1 class="d-inline-block">{{ $stats['most_visited_page']['pageViews'] }}</h1><span> Visite</span>
            - <a href="{{ $stats['most_visited_page']['url'] }}" target="_blank">{{ $stats['most_visited_page']['pageTitle'] }}</a>
          </app-box>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <app-box title="App Insegnanti" color="green">
            <p>Numero di applicazioni svolte dagli insegnanti</p>
            <h1>{{ $stats['teacher_sessions'] }}</h1>
          </app-box>
        </div>
        <div class="col-md-6">
          <app-box title="App Studenti" color="orange">
            <p>Numero di applicazioni svolte dagli studenti</p>
            <h1>{{ $stats['student_sessions'] }}</h1>
          </app-box>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <app-box title="10 Browser più usati" color="blue">
        <ul>
          @foreach ($stats['browsers'] as $browser)
            <li>{{ $browser['browser'] }} - {{ $browser['sessions'] }}</li>
          @endforeach
        </ul>
      </app-box>
    </div>

  </div>
  <div class="row pb-3">
    <div class="col-md-4">
      <app-box title="Visitatori" color="blue">
        <p>Visitatori Unici</p>
        <h1>{{ $stats['visitors_tot'] }}</h1>
      </app-box>
    </div>
    <div class="col-md-8">
      <app-box title="Tipi di Utenti" color="yellow">
        <div class="d-flex justify-content-around">
          @foreach ($stats['users_type'] as $userType)
            <div>
              <h1>{{ $userType['sessions'] }}</h1><p>{{ $userType['type'] }}</p>
            </div>
          @endforeach
        </div>
      </app-box>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <app-box title="Visualizzazioni" color="orange">
        <p>Visualizzazioni di pagina totali</p>
        <h1>{{ $stats['page_views_60dd'] }}</h1>
      </app-box>
    </div>
    <div class="col-md-6">
      <app-box title="Durata Media Utilizzo" color="green">
        <p>Durata media delle sessioni</p>
        <h1>{{ $stats['session_time_avg'] }}</h1>
      </app-box>
    </div>
  </div>
</main>
@endsection
@section('scripts')
  <script src="{{ mix('js/admin/main.js') }}"></script>
@endsection
