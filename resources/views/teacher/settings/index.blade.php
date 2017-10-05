@extends('layouts.teacher')
@section('content')
  {{-- <section id="title" class="pt-5">
    <div class="title sp-center pt-5 pb-5">
      Editing
      <h2 class="p-2 block-title">Film Specific</h2>
    </div>
  </section> --}}
  <section id="breadcrumbs mt-5 pt-5 px-5">
    <div class="row pt-5">
      <div class="col pt-5 px-5">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Settings</a></li>
        </ol>
      </div>
    </div>
  </section>
  <section id="main" class="pb-5 px-5">
    <div class="row">
      <div class="col-md-9">
          <div id="messages" class="box container-fluid mb-4">
            <div class="row">
              <div class="col dark-blue py-3 px-5">
                <h3>Messages</h3>
              </div>
            </div>
            <div class="row">
              <div class="col blue p-5">
                <table class="table table-hover">
                  <thead>
                    <th>From</th>
                    <th>App</th>
                    <th>Status</th>
                    <th></th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Gianni</td>
                      <td>Nome App</td>
                      <td>Non visualizzato</td>
                      <td>tools</td>
                    </tr>
                    <tr>
                      <td>Gianni</td>
                      <td>Nome App</td>
                      <td>Non visualizzato</td>
                      <td>tools</td>
                    </tr>
                    <tr>
                      <td>Gianni</td>
                      <td>Nome App</td>
                      <td>Non visualizzato</td>
                      <td>tools</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div id="shares" class="box container-fluid">
            <div class="row">
              <div class="col dark-orange py-3 px-5">
                <h3>Ready To Share</h3>
              </div>
            </div>
            <div class="row">
              <div class="col orange p-5">
                <table class="table table-hover">
                  <thead>
                    <th>User</th>
                    <th>Studio</th>
                    <th>App</th>
                    <th></th>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Gianni</td>
                      <td>Film specific</td>
                      <td>Framing</td>
                      <td>tools</td>
                    </tr>
                    <tr>
                      <td>Gianni</td>
                      <td>Nome App</td>
                      <td>Non visualizzato</td>
                      <td>tools</td>
                    </tr>
                    <tr>
                      <td>Gianni</td>
                      <td>Nome App</td>
                      <td>Non visualizzato</td>
                      <td>tools</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
      <div class="col-md-3">
        <div id="students-info" class="box container-fluid visible">
          <div class="row">
            <div class="col dark-yellow py-3 px-5">
              <h3>Students</h3>
            </div>
          </div>
          <div class="row">
            <div class="col yellow p-5">
              <table id="students" class="table table-hover">
                <thead>
                  <th>Name</th>
                  <th></th>
                </thead>
                <tbody>
                  @foreach ($students as $key => $student)
                    <tr id="student-{{ $student->id }}">
                      <td class="align-middle">{{ $student->name }}</td>
                      <td class="align-middle"><a href="#" onclick="deleteStudent({{ $student->id }})" class="btn btn-yellow"><i class="fa fa-trash-o" aria-hidden="true"></a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <br>
              <div class="text-center">
                <a href="#" id="addStudent" class="btn btn-secondary btn-yellow"><i class="fa fa-plus" aria-hidden="true"></i> Add Student</a>
              </div>
            </div>
          </div>
        </div>
        <div id="students-add" class="box container-fluid not-visible">
          <div class="row">
            <div class="col dark-yellow py-3 px-5">
              <div class="d-flex justify-content-between">
                <h3>Students</h3><h3><i id="students-close" class="fa fa-times" aria-hidden="true"></i></h3>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col yellow p-5">
              <form method="post">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="form-group form-yellow">
                  <label for="">Name:</label>
                  <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group form-yellow">
                  <label for="">Email:</label>
                  <input type="text" name="email" class="form-control">
                </div>
                <div class="form-group form-yellow">
                  <label for="">Password:</label>
                  <input type="password" name="password" class="form-control">
                </div>
              </form>
              <br>
              <div class="text-center">
                <a href="#" id="saveStudent" class="btn btn-secondary btn-yellow"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@section('scripts')
  <script type="text/javascript">
    // Panels
    var u_info = $('#students-info');
    var u_add = $('#students-add');
    var max_students = {{ $teacher->students_slots }};

    studentCheck();

    // Add Student
    $('#addStudent').on('click', function(e) {
      u_info.toggleClass('visible').toggleClass('not-visible');
      u_add.toggleClass('not-visible').toggleClass('visible');
    });

    $('#students-close').on('click', function(e) {
      u_info.toggleClass('visible').toggleClass('not-visible');
      u_add.toggleClass('visible').toggleClass('not-visible');
    });

    // Save Student
    $('#saveStudent').on('click', function(e) {
      var data = {
        '_token' :    $('input[name=_token]').val(),
        'name' :      $('input[name="name"]').val(),
        'email' :     $('input[name="email"]').val(),
        'password' :  $('input[name="password"]').val(),
      };
      $.ajax({
        type: 'post',
        url:  '{{ route('teacher.student.store') }}',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: data,
        success: function (response) {
          console.log(response);

          var data = '';
          data += '<tr id="student-'+response.id+'">';
          data +=   '<td class="align-middle">'+response.name+'</td>';
          data +=   '<td class="align-middle"><a href="#" onclick="deleteStudent('+response.id+')" class="btn btn-yellow"><i class="fa fa-trash-o" aria-hidden="true"></a></td>';
          data += '</tr>';

          $('#students').append(data);
          u_info.toggleClass('visible').toggleClass('not-visible');
          u_add.toggleClass('visible').toggleClass('not-visible');

          studentCheck();
        },
        error: function (errors) {
          console.log(errors);
            $('.form-control-danger').removeClass('form-control-danger');
            $('.has-danger').removeClass('has-danger');
            $('.form-control-feedback').remove();
            if (errors.responseJSON) {
              $.each(errors.responseJSON.errors, function(k, v) {
                var elem = $('input[name='+k+']');
                elem.addClass('form-control-danger');
                elem.parent().addClass('has-danger');
                elem.parent().append('<div class="form-control-feedback">Error</div>');

              });
            } else {
              console.log(errors.responseText);
            }
        }
      });
    });

    function deleteStudent(id)
    {
      $.ajax({
        type: 'post',
        url:  '{{ route('teacher.student.delete') }}',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: {
          '_token' :    $('input[name=_token]').val(),
          'id' : id
        },
        success: function (response) {
          console.log(response);
          $('#student-'+response.id).remove();
          studentCheck();
        },
        error: function (errors) {
          console.log(errors);
        }
      });
    }

    function studentCount()
    {
      var count = 0;
      $('#students tr').each(function(i){
        count = count + 1;
      });
      return count;
    }

    function studentCheck()
    {
      var count = studentCount();
      if (count >= max_students) {
        $('#addStudent').addClass('d-none');
      } else {
        $('#addStudent').removeClass('d-none');
      }
    }
  </script>
@endsection
