@extends('layouts.main')
@section('title')
  Home Page
@endsection
@section('content')
{{-- Main Hero Cover --}}
<section class="hero home">
  <div class="flex-center position-ref full-height">
    <div class="content">
      <div class="logo">
        <img src="/img/logo.png">
      </div>
      <div class="title m-b-md">
          The Film Corner
      </div>
      <div class="links">
        <a href="#project">The Project</a>
        <a href="#partners">Partners</a>
        <a href="#apps">Apps</a>
        <a href="#resources">Resources</a>
        <a href="#login">Login</a>
      </div>
    </div>
  </div>
</section>
{{-- End Main Hero Cover --}}
<div class="animations-wrapper">
  {{-- Project --}}
  <section id="project">
    <div id="trigger-project"></div>
    <div id="title-project" class="title sp-center pt-5">
      The Project
    </div>
    {{-- Slide 1 --}}
    <div id="container-1" class="tween-content-container">
      <h3 class="tween-title">New on and off activities for Film Literacy</h3>
      <p class="tween-content mt-4">
        Cross-media and engagement
        for Film Literacy and Audience Development
      </p>
    </div>

    {{-- Image Slide 1 --}}
    <div id="container-2" class="tween-image-container" style="background: url('/img/home/1.png');">
    </div>
  </section>
  <section>
    <div id="trigger-project-2"></div>
    {{-- Image Slide 2 --}}
    <div id="container-4" class="tween-image-container" style="background: url('/img/home/2.png');">
    </div>
    {{-- Slide 2 --}}
    <div id="container-3" class="tween-content-container">
      <h3 class="tween-title">Criteria</h3>
      <p class="tween-content mt-4">
        Approaches: Film specific / Ancillary<br>
        Outcome: Critical-theorical / creative-practical<br>
        Target: 12-year-old up to 16-year-old<br>
        <br><br>
        <h5 class="tween-subtitle">COMBINATION</h5>
        Some of the apps are based on combination of elementary items into more complex systems (e.g. “Cross-Ejzenstejn”)
        <br><br>
        <h5 class="tween-subtitle">SIMULATION</h5>
        Some of the apps are based on simulation, meaning that they are aimed to simulate other tools through crossmedia (e.g. “Frame counter”)
        <br><br>
        <h5 class="tween-subtitle">ASSOCIATION</h5>
        Some of the apps are based on association, that means that they are based on association between two or more elements (e.g. “Stories”)
        <br>
      </p>
    </div>
  </section>
  {{-- Partners --}}
  <section id="partners">
    <div id="trigger-partners"></div>
    <div id="title-partners" class="title sp-center pt-5">
      Partners
    </div>
    <div class="container">
      <div class="row pt-5">
        <div class="col-md-2 offset-md-2 text-center">
          Partner 1
        </div>
        <div class="col-md-2 text-center">
          Partner 2
        </div>
        <div class="col-md-2 text-center">
          Partner 3
        </div>
        <div class="col-md-2 text-center">
          Partner 4
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 offset-md-2 text-center">
          Partner 5
        </div>
        <div class="col-md-2 text-center">
          Partner 6
        </div>
        <div class="col-md-2 text-center">
          Partner 7
        </div>
        <div class="col-md-2 text-center">
          Partner 8
        </div>
      </div>
    </div>
  </section>
  {{-- Apps --}}
  <section id="apps">
    <div id="trigger-apps"></div>
  </section>
  {{-- Resources --}}
  <section id="resources">
    <div id="trigger-resources"></div>
  </section>
  {{-- Login / call to action for registration --}}
  <section id="login">
    <div id="trigger-login"></div>
  </section>
</div>
@endsection
@section('scripts')
  <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/ScrollToPlugin.min.js"></script>
  <script>
  var controller = new ScrollMagic.Controller();
  $(function() {
    // wait for document ready
    // build the tweens
    var title1     = TweenMax.fromTo('#title-project', 1, {opacity: 0}, {opacity: 1});
    var container1 = TweenMax.fromTo('#container-1', 1, {left: "-600px", opacity: "0"}, {left: "10%", opacity: "1", ease:SlowMo.easeOut, onComplete: parallax('#container-1','#trigger-project', '30')});
    var container2 = TweenMax.fromTo('#container-2', 1, {left: "120%", opacity: "0"}, {left: "45%", opacity: "1", ease: SlowMo.easeOut, delay: .8, onComplete: parallax('#container-2','#trigger-project', '-140')});
    var container3 = TweenMax.fromTo('#container-3', 1, {right: "-700px", opacity: "0"}, {right: "5%", opacity: "1", ease: SlowMo.easeOut, delay: .8, onComplete: parallax('#container-3','#trigger-project-2', '10')});
    var container4 = TweenMax.fromTo('#container-4', 1, {left: "-700px", opacity: "0"}, {left: "6%", opacity: "1", ease: SlowMo.easeOut, onComplete: parallax('#container-4','#trigger-project-2', '-160')});

    var title2     = TweenMax.fromTo('#title-partners', 1, {opacity: 0}, {opacity: 1});

		// build scene
    var title1 = new ScrollMagic.Scene({triggerElement: "#trigger-project", duration: 150}).setTween(title1).addIndicators().addTo(controller);
    var scene1 = new ScrollMagic.Scene({triggerElement: "#trigger-project", duration: 350}).setTween(container1).addIndicators().addTo(controller);
    var scene2 = new ScrollMagic.Scene({triggerElement: "#trigger-project", duration: 350}).setTween(container2).addIndicators().addTo(controller);
    var scene3 = new ScrollMagic.Scene({triggerElement: "#trigger-project-2", duration: 450}).setTween(container4).addIndicators().addTo(controller);
    var scene4 = new ScrollMagic.Scene({triggerElement: "#trigger-project-2", duration: 450}).setTween(container3).addIndicators().addTo(controller);

    var title1 = new ScrollMagic.Scene({triggerElement: "#trigger-partners", duration: 150}).setTween(title2).addIndicators().addTo(controller);

    // Parallax function
    function parallax(selector, trigger, size) {
      parallaxController = new ScrollMagic.Controller({globalSceneOptions: {triggerHook: "onEnter", duration: "200%"}});
      new ScrollMagic.Scene({triggerElement: trigger}).setTween(selector, {y: size+"%", ease: Linear.easeNone, delay: 2}).addIndicators().addTo(parallaxController);
    }



  });
  </script>
@endsection
