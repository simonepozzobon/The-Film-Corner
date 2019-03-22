{{-- <script src="{{ mix('js/manifest.js') }}"></script> --}}
{{-- <script src="{{ mix('js/vendor.js') }}"></script> --}}
{{-- <script src="{{ mix('js/app.js') }}"></script> --}}

@yield('scripts')
 {{-- SEND FEEDBACK --}}
{{-- <script type="text/javascript">
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

  }); --}}

</script>
