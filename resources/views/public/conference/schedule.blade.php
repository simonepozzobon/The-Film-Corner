@extends('layouts.conference', ['active' => 'schedule'])
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="row">
        <div class="col">
          <div class="block-subtitle mt-5">
            <h4>Schedule Draft</h4>
          </div>
        </div>
      </div>
      <div class="block-text">
        <div class="row">
          <div class="col">
            <h5>2017, November, 9th - Fondazione Cineteca Italiana HQ, viale Fulvio Testi, 121</h5>
          </div>
        </div>
        <div class="row pt-3">
          <div class="col-sm-2 offset-sm-1">
            <b>17:00</b>
          </div>
          <div class="col-sm-9">
            Visit to MIC-Interactive Film Museum and the Virtual Archive
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>19:00</b>
          </div>
          <div class="col-sm-9">
            Networking cocktail
          </div>
        </div>
        <div class="row pt-3">
          <div class="col">
            <h5>2017, November, 10th - Spazio Oberdan, Viale Vittorio Veneto, 2</h5>
          </div>
        </div>
        <div class="row pt-3">
          <div class="col-sm-2 offset-sm-1">
            <b>9:00 to 9:30</b>
          </div>
          <div class="col-sm-9">
            Registration and welcome coffee
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>9:30 to 10:00</b>
          </div>
          <div class="col-sm-9">
            Institutional greetings
            <ul>
              <li>Matteo Solaro (EACEA, European Commission)</li>
              <li>Nicola Borrelli (MIBACT-Ministero per i Beni e le Attività Culturali ed il Turismo-Direzione Generale Cinema)</li>
              <li>Giuseppe Pierro (MIUR-Ministero dell’Istruzione, Università e Ricerca)</li>
              <li>Delia Campanelli (Ufficio Scolastico Regionale, Regione Lombardia)</li>
              <li>Cristina Cappellini (Assessore alla Cultura, Regione Lombardia)</li>
              <li>Filippo del Corno (Assessore alla Cultura, Comune di Milano)</li>
              <li>Matteo Pavesi (Fondazione Cineteca Italiana)</li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>10:00 to 11:00</b>
          </div>
          <div class="col-sm-9">
            Launch of The Film Corner Platform
            <ul>
              <li>Silvia Pareti, Simone Moraldi (Fondazione Cineteca Italiana)</li>
              <li>Ian Wall (The Film space)</li>
              <li>Aleksandar Erdeljanovic, Branislav Erdeljanovic (Jugoslovenska Kinoteka)</li>
              <li>Marty Melarkey (The Nerve Centre)</li>
              <li>Emanuela Mancino (University of Milano-Bicocca)</li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>11:00 to 11:30</b>
          </div>
          <div class="col-sm-9">
            Keynote Speech
            <ul>
              <li>Maria Grazia Mattei (Meet the Media Guru)</li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>11:30 to 13:00</b>
          </div>
          <div class="col-sm-9">
            PANEL: Film education and audience development in the digital era
            <ul>
              <li>Alessandra Guarino (Fondazione Centro Sperimentale di Cinematografia)</li>
              <li>Claus Noer Hjorth (Danish Film Institute)</li>
              <li>Christine Eloy (Europa Distribution)</li>
              <li>Alessandro Bollo (Polo del ‘900, Fondazione San Paolo)</li>
              <li>Elisa Giovannelli (ECFA/Cineteca di Bologna)</li>
              <li>Alice Arecco (Milano Film Network)</li>
              <li>Chairman: Simone Moraldi (Fondazione Cineteca Italiana)</li>
            </ul>

          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>13:00 to 13:30</b>
          </div>
          <div class="col-sm-9">
            Q&A
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>13:30 to 14:30</b>
          </div>
          <div class="col-sm-9">
            Lunch break
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>14:30 to 16:00</b>
          </div>
          <div class="col-sm-9">
            PANEL: Film literacy methodologies and best practices in the digital era
            <ul>
              <li>Mark Reid (British Film Institute)</li>
              <li>Nathalie Bourgeois (Cinémathèque Française)</li>
              <li>Christine Kopf (Deutsche Filmmuseum)</li>
              <li>Núria Aidelman (A bao a Qu)</li>
              <li>Marty Melarkey (The Nerve Centre)</li>
              <li>Chairman: Ian Wall (The Film Space)</li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>16:00 to 16:30</b>
          </div>
          <div class="col-sm-9">
            Q&A
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 offset-sm-1">
            <b>16:30 to 17:00</b>
          </div>
          <div class="col-sm-9">
            Closing Remarks
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
