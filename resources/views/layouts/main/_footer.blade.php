<footer>
  <div class="w-100 bg-faded p-5">
    <div class="row">
      <div class="col-md-4 p-5">
        {{-- The Film Corner --}}
        <div class="block-container pb-5">
          <div class="block-title">
            <h2>The Film Corner</h2>
          </div>
          <div class="block-text">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="{{ url('/') }}#project">The Project</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#conference">Conference</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#partners">Partners</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#login">Login</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4 p-5">
        Social Section
      </div>
      <div class="col-md-4 p-5">
        {{-- Feedback --}}
        <div class="block-container pb-5">
          <div class="block-title">
            <h2>Feedback</h2>
          </div>
          <div class="block-text">
            <form id="fdbck-form" method="POST">
              {{ csrf_field() }}
              {{ method_field('POST') }}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Name:</label>
                    <input type="text" id="name" name="name" value="" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row pb-3">
                <div class="col">
                  <label for="">Experience: </label>
                  <div>
                    <a href="#" class="btn btn-success "><i class="fa fa-thumbs-up" aria-hidden="true"></i> Positive</a>
                    <a href="#" class="btn btn-danger"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Negative</a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="">Feedback:</label>
                  <textarea name="feedback" rows="3" class="form-control"></textarea>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col">
                <button id="fdbck-send" class="g-recaptcha btn btn-primary mt-4">
                <i class="fa fa-send" aria-hidden="true"></i> Send
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
