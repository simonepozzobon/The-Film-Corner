@extends('layouts.main')

@section('content')
@include('layouts.main._menu')
<br><br>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="card">
            <h3 class="card-header">Reset Password</h3>
            <div class="card-block">
              <div class="card-text">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">
                          Send Password Reset Link
                      </button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
