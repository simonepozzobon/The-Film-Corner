{{-- <script src="//code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" crossorigin="anonymous"></script> --}}

<script src="{{ asset('js/jquery-3.2.0.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="{{ asset('js/tether.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

{{-- Script --}}
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
@yield('scripts')


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
