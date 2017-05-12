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
    <p class="text-justify">
      <form class="" action="" method="">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <div class="row">
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Surname</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">E-mail</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Institution</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group col-md-6">
            <div class="row">
              <label class="col-sm-2 col-form-label">Role</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12">
            <div class="row">
              <label class="col-sm-1 col-form-label">Notes</label>
              <div class="col-sm-11">
                <textarea id="editor" name="name" rows="8" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 offset-md-4 pt-5">
          <button type="submit" name="button" class="btn btn-primary btn-block">
            <i class="fa fa-check" aria-hidden="true"></i> Apply
          </button>
        </div>
      </form>
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
  </script>
@endsection
