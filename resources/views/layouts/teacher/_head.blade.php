
<script src="https://{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>

{{-- Main Stylesheet --}}
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

{{-- Google Analytics --}}
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92981271-1', 'auto');
  ga('send', 'pageview');

</script>


<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>


@yield('stylesheets')
