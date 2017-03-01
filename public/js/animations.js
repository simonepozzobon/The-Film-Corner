jQuery.noConflict();
var controller = new ScrollMagic.Controller();
jQuery(function($) {
  // wait for document ready

  // Titles that don't needs to be responsive
  var title1     = TweenMax.fromTo('#title-project', 1, {opacity: 0}, {opacity: 1});
  var title2     = TweenMax.fromTo('#title-partners', 1, {opacity: 0}, {opacity: 1});
  var title3     = TweenMax.fromTo('#title-apps', 1, {opacity: 0}, {opacity: 1});
  var title4     = TweenMax.fromTo('#title-resources', 1, {opacity: 0}, {opacity: 1});
  var title5     = TweenMax.fromTo('#title-login', 1, {opacity: 0}, {opacity: 1});

  // Resposive
  var _window = $(window).width();

  if (_window >= 480) {
    // Tablet e Desktop

    // The Project
    var container1 = TweenMax.fromTo('#container-1', 1, {x: percentToPixel(-100), opacity: "0"}, {x: percentToPixel(10), opacity: "1", ease:SlowMo.easeOut, onComplete: parallax('#container-1','#trigger-project', '80')});
    var container2 = TweenMax.fromTo('#container-2', 1, {x: percentToPixel(120), opacity: "0"}, {x: percentToPixel(35), opacity: ".5", ease: SlowMo.easeOut, delay: .8, onComplete: parallax('#container-2','#trigger-project', '-140')});
    var container3 = TweenMax.fromTo('#container-3', 1, {x: percentToPixel(120), opacity: "0"}, {x: percentToPixel(35), opacity: "1", ease: SlowMo.easeOut, delay: .8, onComplete: parallax('#container-3','#trigger-project-2', '10')});
    var container4 = TweenMax.fromTo('#container-4', 1, {x: percentToPixel(-100), opacity: "0"}, {x: percentToPixel(6), opacity: ".5", ease: SlowMo.easeOut, onComplete: parallax('#container-4','#trigger-project-2', '-160')});

    // Partners
    var container5 = TweenMax.fromTo('#container-5', 1, {opacity: 0, y: 100, ease: SlowMo.easeIn}, {opacity: 1, y: 0, ease: SlowMo.easeOut, onComplete: cascade(6, 3, 0, '#trigger-partners')});
    var container9 = TweenMax.fromTo('#container-9', 1, {opacity: 0, y: 100, ease: SlowMo.easeIn}, {opacity: 1, y: 0, ease: SlowMo.easeOut, delay: 1, onComplete: cascade(10, 3, 1, '#trigger-partners-2')});

  } else {
    // Mobile

    // The Project
    var container1 = TweenMax.fromTo('#container-1', 1, {x: percentToPixel(-100), opacity: "0"}, {x: percentToPixel(5), opacity: "1", ease:SlowMo.easeOut, onComplete: parallax('#container-1','#trigger-project', '40')});
    var container2 = TweenMax.fromTo('#container-2', 1, {x: percentToPixel(120), opacity: "0"}, {x: percentToPixel(35), opacity: ".5", ease: SlowMo.easeOut, delay: .8, onComplete: parallax('#container-2','#trigger-project', '-140')});
    var container3 = TweenMax.fromTo('#container-3', 1, {x: percentToPixel(120), opacity: "0"}, {x: percentToPixel(10), opacity: "1", ease: SlowMo.easeOut, delay: .8, onComplete: parallax('#container-3','#trigger-project-2', '-65')});
    var container4 = TweenMax.fromTo('#container-4', 1, {x: percentToPixel(-100), opacity: "0"}, {x: percentToPixel(6), opacity: ".5", ease: SlowMo.easeOut, onComplete: parallax('#container-4','#trigger-project-2', '-80')});

    // Partner
    var container5 = TweenMax.fromTo('#container-5', 1, {opacity: 0, y: 100, ease: SlowMo.easeIn}, {opacity: 1, y: 0, ease: SlowMo.easeOut, onComplete: cascade(6, 3, 0, '#trigger-partners')});
    var container9 = TweenMax.fromTo('#container-9', 1, {opacity: 0, y: 100, ease: SlowMo.easeIn}, {opacity: 1, y: 0, ease: SlowMo.easeOut, delay: 1, onComplete: cascade(10, 3, 1, '#trigger-partners-2-mobile')});

  }


  // build scene
  var title1 = new ScrollMagic.Scene({triggerElement: "#trigger-project", duration: 150}).setTween(title1).addIndicators().addTo(controller);
  var scene1 = new ScrollMagic.Scene({triggerElement: "#trigger-project", duration: 350}).setTween(container1).addIndicators().addTo(controller);
  var scene2 = new ScrollMagic.Scene({triggerElement: "#trigger-project", duration: 350}).setTween(container2).addIndicators().addTo(controller);
  var scene3 = new ScrollMagic.Scene({triggerElement: "#trigger-project-2", duration: 450}).setTween(container4).addIndicators().addTo(controller);
  var scene4 = new ScrollMagic.Scene({triggerElement: "#trigger-project-2", duration: 450}).setTween(container3).addIndicators().addTo(controller);

  var title2 = new ScrollMagic.Scene({triggerElement: "#trigger-partners", duration: 150}).setTween(title2).addIndicators().addTo(controller);
  var scene5 = new ScrollMagic.Scene({triggerElement: "#trigger-partners", duration: 350}).setTween(container5).addIndicators().addTo(controller);
  var scene6 = new ScrollMagic.Scene({triggerElement: "#trigger-partners-2", duration: 350}).setTween(container9).addIndicators().addTo(controller);

  var title3 = new ScrollMagic.Scene({triggerElement: "#trigger-apps", duration: 150}).setTween(title3).addIndicators().addTo(controller);
  var title4 = new ScrollMagic.Scene({triggerElement: "#trigger-resources", duration: 150}).setTween(title4).addIndicators().addTo(controller);
  var title5 = new ScrollMagic.Scene({triggerElement: "#trigger-login", duration: 150}).setTween(title5).addIndicators().addTo(controller);


  // Parallax function
  function parallax(selector, trigger, size) {
    parallaxController = new ScrollMagic.Controller({globalSceneOptions: {triggerHook: "onEnter", duration: "200%"}});
    new ScrollMagic.Scene({triggerElement: trigger}).setTween(selector, {y: size+"%", ease: Linear.easeNone, delay: 2}).addTo(parallaxController);
  }

  // Cascade Function
  function cascade(start, limit, delayStart, trigger) {
    for (var i = 0; i < limit; i++) {
      var selector = '#container-'+(i+start);
      var delayTime = i+1+delayStart;
      var cascade    = TweenMax.fromTo(selector, 1, {opacity: 0, y: 100, ease: SlowMo.easeIn}, {opacity: 1, y: 0, ease: SlowMo.easeOut, delay: delayTime});
      new ScrollMagic.Scene({triggerElement: trigger, duration: 350}).setTween(cascade).addIndicators().addTo(controller);
    }
  }

  // Responsive TweenMax
  function percentToPixel(_perc){
    var perc = $('body').outerWidth()

    var percentuale = (perc/100)* parseFloat(_perc);
    // alert(percentuale);
    return percentuale
  }

  // function tweenMax(trigger, selector, x_start_post, x_end_pos, parallax_y) {
  //   TweenMax.fromTo(selector, 1, {x: percentToPixel(selector, x_start_post), opacity: "0"}, {x: x_end_pos, opacity: "1", ease:SlowMo.easeOut, onComplete: parallax(selector, trigger, parallax_y)});
  // }


});
