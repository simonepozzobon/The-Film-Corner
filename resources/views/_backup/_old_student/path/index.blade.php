@extends('layouts.student')
@section('content')
<section id="title" class="pt-5">
  <div class="title sp-center pt-5 pb-5">
    Editing
    <h2 class="p-2 block-title">Film Specific</h2>
  </div>
</section>
<section id="breadcrumbs pr-5 pl-5 pb-5">
  <div class="row">
    <div class="col pr-5 pl-5 pb-5">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Padiglioni</a></li>
        <li class="breadcrumb-item"><a href="#">Percorsi</a></li>
        <li class="breadcrumb-item active">Editing</li>
      </ol>
    </div>
  </div>
</section>
<section class="pb-5 pr-5 pl-5">
  <div class="row">
    <div class="col">
      <div class="container-fluid" style="background-color: #d9f5fc; color: #252525">
        <div class="row" style="background-color: #a6dbe2; color: #252525">
          <div class="col align-text-bottom">
            <h3 class="p-2">Info</h3>
          </div>
        </div>
        <div class="row">
          <div class="col pt-5 pr-5 pb-5">
            <p class="pl-2">
              Testo informativo
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="main" class="pb-5 pr-5 pl-5">
    <div class="row">
      <div class="col">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 pr-5">
                <div class="row pb-5">
                  <div class="container-fluid" style="background-color: #d9f5fc; color: #252525">
                    <div class="row" style="background-color: #a6dbe2; color: #252525">
                      <div class="col align-text-bottom">
                        <h3 class="p-2">Examples</h3>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col pt-5 pb-5">
                        <p class="pl-2">
                          Examples of pictures and clips related to each app with a short explanations
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row pb-5">
                  <div class="container" style="background-color: #f5db5e; color: #252525">
                    <div class="row" style="background-color: #e9c845; color: #252525">
                      <div class="col align-text-bottom">
                        <h3 class="p-2">References</h3>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col pt-5 pr-5 pb-5">
                        <p class="pl-2">
                          <ul>
                            <li>lista 1</li>
                            <li>lista 2</li>
                            <li>altro elemento</li>
                          </ul>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row pb-5">
                    <span class="badge badge-default mb-2 mr-2">Keyword 1</span>
                    <span class="badge badge-default mb-2 mr-2">Keyword più lunga 2</span>
                    <span class="badge badge-default mb-2 mr-2">Corta 3</span>
                    <span class="badge badge-default mb-2 mr-2">Keyword 4</span>
                    <span class="badge badge-default mb-2 mr-2">Keyword 5</span>
                    <span class="badge badge-default mb-2 mr-2">Keyword 6</span>
                </div>
            </div>
            <div class="col-md-9">
              {{-- LISTA APP --}}
              <div class="row">
                <div class="container" style="background-color: #f5db5e; color: #252525">
                  <div class="row" style="background-color: #e9c845; color: #252525">
                    <div class="col align-text-bottom">
                      <h3 class="p-2">Titolo App</h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col pt-5 pr-5 pb-5">
                      <p class="pl-2">
                        In order for my website to look good I need to use a custom font, specifically, Thonburi-Bold. The problem is - the font does not get displayed unless the user has installed it. It also isn't displayed in firefox.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="container" style="background-color: #d8ef8f; color: #252525">
                  <div class="row" style="background-color: #b7cc5e; color: #252525">
                    <div class="col align-text-bottom">
                      <h3 class="p-2">Titolo App</h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col pt-5 pr-5 pb-5">
                      <p class="pl-2">
                        In order for my website to look good I need to use a custom font, specifically, Thonburi-Bold. The problem is - the font does not get displayed unless the user has installed it. It also isn't displayed in firefox.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="container" style="background-color: #f4c490; color: #252525">
                  <div class="row" style="background-color: #e8a360; color: #252525">
                    <div class="col align-text-bottom">
                      <h3 class="p-2">Titolo App</h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col pt-5 pr-5 pb-5">
                      <p class="pl-2">
                        In order for my website to look good I need to use a custom font, specifically, Thonburi-Bold. The problem is - the font does not get displayed unless the user has installed it. It also isn't displayed in firefox.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="container" style="background-color: #d9f5fc; color: #252525">
                  <div class="row" style="background-color: #a6dbe2; color: #252525">
                    <div class="col align-text-bottom">
                      <h3 class="p-2">Titolo App</h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col pt-5 pr-5 pb-5">
                      <p class="pl-2">
                        In order for my website to look good I need to use a custom font, specifically, Thonburi-Bold. The problem is - the font does not get displayed unless the user has installed it. It also isn't displayed in firefox.
                      </p>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
