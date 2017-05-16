@extends('layouts.conference', ['active' => 'application'])
@section('title')
  The Film Corner - International Conference
@endsection
@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
  <div class="block-subtitle mt-5">
    <h4>Online Application</h4>
  </div>
  <div class="block-text">
    <p id="message" class="text-justify">
      <form id="application-form" class="" action="{{ route('conference.application.send') }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <div class="row">
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Name*</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
                <p class="error name alert alert-danger invisible"></p>
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Surname*</label>
              <div class="col-sm-10">
                <input type="text" name="surname" class="form-control">
                <p class="error surname alert alert-danger invisible"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">E-mail*</label>
              <div class="col-sm-10">
                <input type="text" name="email" class="form-control">
                <p class="error email alert alert-danger invisible"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Institution</label>
              <div class="col-sm-10">
                <input type="text" name="institution" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Role</label>
              <div class="col-sm-10">
                <input type="text" name="role" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12">
            <div class="row">
              <label class="col-sm-1 col-form-label">Notes</label>
              <div class="col-sm-11">
                <textarea id="editor" name="notes" rows="8" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>
        <p>* Required</p>
        <div class="col-md-4 offset-md-4 pt-5">
          <button type="submit" name="button" id="submit" class="btn btn-primary btn-block">
            <i class="fa fa-check" aria-hidden="true"></i> Apply
          </button>
        </div>
      </form>
      <span id="success-message" class="alert alert-success invisible"></span>
    </p>
  </div>
@endsection
@section('scripts')
  <script type="text/javascript">
    CKEDITOR.replace( 'editor', {
      toolbarGroups: [
        { name: 'styles', groups: [ 'styles' ] },
    		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    		{ name: 'links', groups: [ 'links' ] },
    		{ name: 'insert', groups: [ 'insert' ] },
    		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
    		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    		{ name: 'forms', groups: [ 'forms' ] },
    		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
    		{ name: 'tools', groups: [ 'tools' ] },
    		{ name: 'others', groups: [ 'others' ] },
    		{ name: 'colors', groups: [ 'colors' ] },
    		{ name: 'about', groups: [ 'about' ] }
			],
			// Remove the redundant buttons from toolbar groups defined above.
			removeButtons: 'Subscript,Superscript,Cut,Scayt,SpecialChar,Strike,RemoveFormat,About,Source,Styles,Format,Link,Unlink,Anchor,Image,Table,HorizontalRule,Copy,Paste,PasteText,PasteFromWord,Undo,Redo'
    });

    $('#submit').on('click', function(e) {
      e.preventDefault();
      $('.error').addClass('invisible');

      $.ajax({
        type: 'post',
        url:  '{{ route('conference.application.send') }}',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
          '_token':       $('input[name=_token]').val(),
          'name':         $('input[name=name]').val(),
          'surname':      $('input[name=surname]').val(),
          'email':        $('input[name=email]').val(),
          'institution':  $('input[name=institution]').val(),
          'role':         $('input[name=role]').val(),
          'notes':        $('input[name=notes]').val()
        },
        success: function(data) {
          console.log(data);
          if ((data.errors)) {
                if (data.errors.name) {
                  $('.error.name').removeClass('invisible');
                  $('.error.name').text(data.errors.name);
                }
                if (data.errors.surname) {
                  $('.error.surname').removeClass('invisible');
                  $('.error.surname').text(data.errors.surname);
                }
                if (data.errors.email) {
                  $('.error.email').removeClass('invisible');
                  $('.error.email').text(data.errors.email);
                }

            } else {
                $('#application-form').hide();
                $('#success-message').removeClass('invisible');
                $('#success-message').html(data.success);
                console.log(data.success);
          }
        }
      });
    });
  </script>
@endsection
