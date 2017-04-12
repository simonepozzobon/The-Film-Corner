{{-- <script src="//code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" crossorigin="anonymous"></script> --}}

<script src="{{ asset('js/jquery-3.2.0.min.js') }}"></script>
<script src="{{ asset('js/tether.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

{{-- Script --}}
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
@yield('scripts')
 {{-- SOCIAL --}}
 <script>
   window.fbAsyncInit = function() {
     FB.init({
       appId      : '150115568851139',
       xfbml      : true,
       version    : 'v2.8'
     });
     FB.AppEvents.logPageView();
     FB.api(
       '/TheFilmCorner/posts',
       'GET',
       {},
       function(response) {
             console.log(response);
       }
     );
   };

   (function(d, s, id){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

 </script>

 {{-- SEND FEEDBACK --}}
<script type="text/javascript">
  var url = "";

  // send function
  $('#fdbck-send').on('click', function(e) {
    alert('cliccato');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

    e.preventDefault();

    var formData = {
      name:     $('#fdbck-name').val(),
      msg:      $('#fdbck-msg').val(),
    }

    var type = "POST";
    var my_url = url;

    $.ajax({
      type:     type,
      url:      my_url,
      data:     formData,
      dataType: 'json',
      success:  function (data)
        {
          console.log(data);
        },
      error:    function (data)
        {
          console.log(data);
        }
    })

  });

</script>
