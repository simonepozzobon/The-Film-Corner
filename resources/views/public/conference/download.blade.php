@extends('layouts.conference', ['active' => 'download'])
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
@section('content')
  <div class="conference-container">
        <div class="block-subtitle">
          <h4>Downloads</h4>
        </div>
        <div class="block-text">
          <table class="table table-hover">
            <thead>
              <th>Description</th>
              <th>Download</th>
            </thead>
            <tbody>
              <tr>
                <td class="align-middle">General statement</td>
                <td class="align-middle">
                  <a href="{{ asset('downloads/conference/TFC_General_Statement.pdf') }}" target="_blank" class="btn btn-primary">
                    <i class="fa fa-download" aria-hidden="true"></i> Download
                  </a>
                </td>
              </tr>
              <tr>
                <td class="align-middle">Invitation</td>
                <td class="align-middle">
                  <div class="btn-group">
                    <a href="{{ asset('downloads/conference/The_Film_Corner_-_International_Conference_Invitation.pdf') }}" target="_blank" class="btn btn-primary">
                      <i class="fa fa-download" aria-hidden="true"></i> Download
                    </a>
                    <a href="{{ route('conference.application') }}" class="btn btn-info">
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Online Application
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="block-subtitle mt-5">
          <h4>Press</h4>
        </div>
        <div class="block-text mb-5">
          <table class="table table-hover">
            <thead>
              <th>Description</th>
              <th>Download</th>
            </thead>
            <tbody>
              <tr>
                <td class="align-middle">International Conference - Eng</td>
                <td class="align-middle">
                  <a href="{{ asset('downloads/conference/press/TFC_International_Conference_ENG.pdf') }}" target="_blank" class="btn btn-primary">
                    <i class="fa fa-download" aria-hidden="true"></i> Download
                  </a>
                </td>
              </tr>
              <tr>
                <td class="align-middle">International Conference - Ita</td>
                <td class="align-middle">
                  <div class="btn-group">
                    <a href="{{ asset('downloads/conference/press/TFC_International_Conference_ITA.pdf') }}" target="_blank" class="btn btn-primary">
                      <i class="fa fa-download" aria-hidden="true"></i> Download
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
  </div>
@endsection
