<!DOCTYPE html>
@if (!isset($type))
  {{ $type = '' }}
@endif
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  @yield('section')
  @include('layouts.teacher._head')

    <style media="screen">
      body {
        background-color: #dfeee9;
        background-image: none !important;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
      }

      #back {
        position: absolute;
      }

    </style>
</head>

  <body>
    @include('layouts.main._menu')
    <svg id="back" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 1080">
      <defs>
        <style>
          .cls-2{fill:#9ae2d9;}
          .cls-3{fill:#c0ede6};
        </style>
      </defs>
      <g id="Layer_2" data-name="Layer 2">
        <g id="_1" data-name="1">
          <path class="cls-2" d="M565,391.14a35,35,0,0,0-53.58-29.68,39.44,39.44,0,0,0-57.24-26,57.9,57.9,0,0,0-114.29,5.13,36.75,36.75,0,0,0-58.54,34.59,26.55,26.55,0,1,0-14,50.73l.25,0q.62.08,1.24.13c.35,0,.69.11,1,.11H531.13c.39,0,.75-.08,1.13-.11A35,35,0,0,0,565,391.14ZM297.73,401h-.26v-.15Z"/>
        </g>
        <g id="_2" data-name="2">
          <path class="cls-3" d="M1644.86,122.15a24.9,24.9,0,0,0-32.47-23.72,41.14,41.14,0,1,0-81.3-12.21,26.12,26.12,0,0,0-41.62,24.58,18.87,18.87,0,1,0-9.93,36.06l.17,0,.89.09c.25,0,.49.07.74.07h139.41c.28,0,.53-.06.8-.08A24.88,24.88,0,0,0,1644.86,122.15Zm-143.76,7h-.18v-.11Z"/>
        </g>
        <g id="_4" data-name="4">
          <path class="cls-3" d="M1888.89,1030.39a20.54,20.54,0,0,0-30.24-18.11,35.15,35.15,0,0,0-55.9-32.88c0-.63,0-1.27,0-1.91A58.82,58.82,0,0,0,1685.22,975a24.78,24.78,0,0,0-37.54,29.1c-.56,0-1.12-.09-1.68-.09a23.44,23.44,0,0,0-3.16,46.66l.22,0,1.1.11c.31,0,.61.09.92.09h224.52a10.75,10.75,0,0,0,2.75-.4A20.55,20.55,0,0,0,1888.89,1030.39Z"/>
        </g>
        <g id="_6" data-name="6">
          <path class="cls-2" d="M1770.47,657.07a23,23,0,0,0-42.23-12.63,24.11,24.11,0,0,0-42.64-21.36c.06-.77.12-1.54.12-2.33a28.32,28.32,0,0,0-49.65-18.65,37.07,37.07,0,0,0-63.84-22.8,50.49,50.49,0,0,0-97.36,18.77c0,1.49.1,3,.22,4.41a34.3,34.3,0,0,0-53.43,41,18.82,18.82,0,1,0-3.56,36.41,12.89,12.89,0,0,0,1.84.19H1750a12.94,12.94,0,0,0,7.32-2.26A23,23,0,0,0,1770.47,657.07Z"/>
        </g>
        <g id="_7" data-name="7">
          <path class="cls-2" d="M421.06,993.38a20.74,20.74,0,0,0-27-19.76,34.27,34.27,0,1,0-67.72-10.17,21.76,21.76,0,0,0-34.67,20.48,15.72,15.72,0,1,0-8.27,30l.15,0,.74.07c.21,0,.41.06.62.06H401c.23,0,.45,0,.67-.07A20.73,20.73,0,0,0,421.06,993.38Zm-119.76,5.86h-.15v-.09Z"/>
        </g>
      </g>
    </svg>
    @yield('content')
    @include('layouts.teacher._scripts')
  </body>
</html>
