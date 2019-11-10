@extends('layouts.teacher')
@section('title', 'Profile')
@section('content')
  <div id="main" class="container">
    @include('components.apps.heading_simple', ['title' => 'Profile'])
    <teacher-profile students="{{ $students }}"/>
    <div class="row mt">
      <div class="col-md-8">
        <div class="box blue">
          <div class="box-header">
            Sessions
          </div>
          <div id="messages" class="box-body">
            <table class="table table-hover">
              <thead>
                <th>From</th>
                <th>App</th>
                <th>Status</th>
                <th></th>
              </thead>
              <tbody>
                @foreach ($notifications as $key => $notification)
                  <tr data-notif-id="{{ $notification->id }}">
                    <td class="align-middle">{{ $notification->data['session']['student']['name'] }}</td>
                    <td class="align-middle">{{ $notification->data['session']['app']['title'] }}</td>
                    <td class="align-middle">
                      @if ($notification->read_at == null)
                        <h4><i class="fa fa-hand-o-right text-danger" aria-hidden="true"></i></h4>
                      @else
                        <h4><i class="fa fa-check text-success" aria-hidden="true"></i></h4>
                      @endif
                    </td>
                    <td class="align-middle">
                      @php
                        $section_slug = $notification->data['session']['app']['category']['section']['slug'];
                        $category_slug = $notification->data['session']['app']['category']['slug'];
                        $app_slug = $notification->data['session']['app']['slug'];
                        $token = $notification->data['session']['token'];
                      @endphp
                      <div class="btn-group">
                        <a class="btn btn-secondary btn-blue markasread" data-notif-id="{{ $notification->id }}" href="{{ url('/') }}/teacher/{{ $section_slug }}/{{ $category_slug }}/{{ $app_slug }}/{{ $token }}">
                          <i class="fa fa-folder-open-o"></i>
                        </a>
                        <a class="btn btn-secondary btn-blue comment-notif" data-notif-id="{{ $notification->id }}" href="#">
                          <i class="fa fa-comment-o"></i>
                        </a>
                        <a class="btn btn-secondary btn-blue approve-notif" data-notif-id="{{ $notification->id }}" href="#">
                          <i class="fa fa-check-square-o"></i>
                        </a>
                        <a class="btn btn-secondary btn-blue" data-toggle="modal" data-target="#delete-notif" href="#">
                          <i class="fa fa-trash-o"></i>
                        </a>
                      </div>
                      <div class="modal fade" id="delete-notif" tabindex="-1" role="dialog" aria-labelledby="targetLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="targetLabel">Delete Notification</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h4 class="text-center">Pay attention</h4>
                              <p class="text-center">
                                This action can't be undone!
                              </p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <i class="fa fa-times"></i> Close
                              </button>
                              <button type="submit" class="btn btn-danger delete-notif" data-notif-id="{{ $notification->id }}" data-dismiss="modal">
                                <i class="fa fa-trash-o"></i> Delete
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div id="shares" class="box orange mt">
            <div class="box-header">
              Ready To Share
            </div>
            <div class="box-body">
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
      <div class="col-md-4">
        <div class="box yellow">
          <div class="box-header">
            Students
          </div>
          <div id="students-info" class="box-body">
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
            <a href="#" id="addStudent" class="btn btn-yellow"><i class="fa fa-plus" aria-hidden="true"></i> Add Student</a>
          </div>
          <div id="students-add" class="box-body not-visible">
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
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ mix('js/teacher-profile.js') }}">

  </script>
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
