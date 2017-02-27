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
              <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                  {{ csrf_field() }}
                  <input type="hidden" name="token" value="{{ $token }}">
                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label for="email">E-Mail Address</label>
                      <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                      @if ($errors->has('email'))
                          <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  </div>
                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <label for="password">Password</label>
                      <input id="password" type="password" class="form-control" name="password" required>
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
                  <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                      <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                      @if ($errors->has('password_confirmation'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                  </div>
                  <div class="form-group mt-5">
                      <button type="submit" class="btn btn-primary btn-block">
                          Reset Password
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
