@extends('layouts.admin')
@section('title')
  Partners
@endsection
@section('page-title')
  Partners
@endsection
@section('stylesheets')
  <script src="//cloud.tinymce.com/stable/tinymce.min.js?apiKey=qecr5wd0wdcbodk88lbyo28f9rwd2zpg9kqvq6cgle2fkal7"></script>
  <script type="text/javascript">
    tinymce.init({
      selector: 'textarea.content',
      plugins: 'link lists',
      menubar: false,

    });
  </script>
  <link rel="stylesheet" href="{{ asset('admin-assets/css/select2.min.css') }}">
@endsection
@section('content')
      <div class="clearfix">
        <div class="container">
          <div class="col mb-5">
            <div class="card">
              <h3 class="card-header">New Partner</h3>
              <div class="card-block">
                <div class="card-text">
                  <form action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name of the partner">
                    </div>
                    <div class="form-group">
                      <label for="media">Logo:</label>
                      <input type="file" name="media" class="form-control"></input>
                    </div>
                    <div class="form-group">
                      <label for="id_tag">ID tag HTML:</label>
                      <input type="text" name="id_tag" value="{{ old('id_tag') }}" class="form-control" placeholder="#id for Bootstrap">
                    </div>
                    <div class="form-group">
                      <label for="location">Location:</label>
                      <input type="text" name="location" value="{{ old('location') }}" class="form-control" placeholder="Logo url">
                    </div>
                    <div class="form-group">
                      <label for="url">Url:</label>
                      <input type="text" name="url" value="{{ old('url') }}" class="form-control" placeholder="Partner's website">
                    </div>
                    <div class="form-group">
                      <label for="description">Description:</label>
                      <textarea name="description" value="{{ old('description') }}" class="form-control content" id="description" placeholder="Description" rows="8"></textarea>

                    </div>

                      <button type="submit" name="button" class="btn btn-small btn-primary btn-block mt-4">Save</button>

                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>ID Html</th>
                    <th>Location</th>
                    <th>Url</th>
                    <th>Description</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($partners as $partner)
                  <tr>
                    <td>{{ $partner->id }}</td>
                    <td>{{ $partner->name }}</td>
                    <td><img width="57" class="mx-auto d-block" src="{{ Storage::disk('local')->url($partner->logo_url) }}"></td>
                    <td>{{ $partner->id_tag }}</td>
                    <td>{{ $partner->location }}</td>
                    <td>{{ $partner->url }}</td>
                    <td>{{ substr(strip_tags($partner->description), 0, 50) }}{{ strlen(strip_tags($partner->description)) > 50 ? '...' : "" }}</td>
                    <td>
                      <form action="/admin/partners/{{ $partner->id }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        {{-- Modal Trigger --}}
                        <button type="button" class="btn btn-small btn-danger" data-toggle="modal" data-target="#delete" name="button">Delete</button>

                        {{-- Modal --}}
                        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteLabel">Delete Partner</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Are you sure?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-small btn-danger" value="Submit">Delete</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
  <script src="{{ asset('admin-assets/js/select2.full.min.js') }}"></script>
  <script type="text/javascript">
    $('.select2-multi').select2();
  </script>
@endsection
