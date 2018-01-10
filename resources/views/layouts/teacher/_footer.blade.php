<footer class="{{ $footer == 'no-margin' ? 'no-margin-top' : '' }}">
  <div class="footer-content">
    Made by Fondazione Cineteca Italiana | <a href="#" data-toggle="modal" data-target="#creditsModal">Credits</a>
  </div>
  <div class="modal fade" id="creditsModal" tabindex="-1" role="dialog" aria-labelledby="creditsModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creditsModalTitle">Credits</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3>Credits</h3>
        <ul class="list-unstyled">
          @foreach (\Credit::get_all() as $key => $credit)
            <li>{{ $credit->name }} - {{ $credit->role }}</li>
          @endforeach
        </ul>
        <h3 class="mt">Filmography</h3>
        <ul class="list">
          @foreach (\Filmography::get_all() as $key => $filmography)
            <li>{{ $filmography->title }} - {{ $filmography->description }}</li>
          @endforeach
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Okay!</button>
      </div>
    </div>
  </div>
</div>
</footer>
