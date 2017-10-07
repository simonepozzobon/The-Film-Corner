import mojs from 'mo-js';
import $ from 'jquery';

class Website extends mojs.CustomShape {
  getShape() { return '<path d="M27.68,36.32a13.68,13.68,0,0,0,0,27.36H41.36a2.16,2.16,0,1,0,.06-4.32H27.68a9.36,9.36,0,1,1,0-18.72H42.8A9.29,9.29,0,0,1,52.16,50a2.16,2.16,0,1,0,4.32.06s0,0,0-.06A13.7,13.7,0,0,0,42.8,36.32Zm30.8,0a2.16,2.16,0,1,0,.16,4.32H72.32a9.36,9.36,0,1,1,0,18.72H57.2A9.29,9.29,0,0,1,47.84,50a2.16,2.16,0,1,0-4.32-.06s0,0,0,.06A13.7,13.7,0,0,0,57.2,63.68H72.32a13.68,13.68,0,1,0,0-27.36H58.48Z"/>'; }
}

class Mapplace extends mojs.CustomShape {
  getShape() { return '<path d="M50,6A27,27,0,0,0,23,33a32.11,32.11,0,0,0,2.13,10.72c7.71,15.69,15.4,33.44,23.09,49.16a2,2,0,0,0,3.56,0C59.56,77.2,67,59.35,74.88,43.72A31.94,31.94,0,0,0,77,33,27,27,0,0,0,50,6Zm0,4A23,23,0,0,1,73,33a29.68,29.68,0,0,1-1.87,9.28L50,87.47,28.88,42.28A29.83,29.83,0,0,1,27,33,22.93,22.93,0,0,1,50,10Zm0,8A15,15,0,1,0,65,33,15,15,0,0,0,50,18Zm0,4A11,11,0,1,1,39,33,11,11,0,0,1,50,22Z"/>'; }
}

mojs.addShape('website', Website);
mojs.addShape('mapplace', Mapplace);

const shiftCurve = mojs.easing.path( 'M0,100 C50,100 50,100 50,50 C50,0 50,0 100,0' );
const scaleCurveBase = mojs.easing.path( 'M0,100 C21.3776817,95.8051376 50,77.3262711 50,-700 C50,80.1708527 76.6222458,93.9449005 100,100' );
const scaleCurve = (p) => { return 1 + scaleCurveBase(p); };
const nScaleCurve = (p) => { return 1 - scaleCurveBase(p)/10; };
const noizeEasing = mojs.easing.path('M0,100 L24.2114672,99.7029845 L27.0786839,106.645089 L29.2555809,93.3549108 L32.0340385,103.816964 L35.3459816,94.6015626 L38.3783493,103.092634 L41.0513382,95.9547991 L43.7739944,106.645089 L45.6729927,96.8973214 L50,105.083147 L53.3504448,93.3549108 L57.7360497,103.816964 L60.8616066,95.9547991 L65.0345993,103.092634 L68.6997757,97.5106029 L71.6646194,102.03125 L75.5066986,96.5672433 L78.2949219,102.652344 L81.0313873,96.8973214 L84.0174408,102.328264 L86.0842667,97.7332592 L88.7289352,101.606306 L91.1429977,98.3533763 L94.3822556,101.287388 L97.0809174,98.7254467 L100,100');
const noizeProgress = (p) => { return 10+(5*noizeEasing(p)); };

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * MODAL CODE
 *
 */

// Definisco il Parent contenitore
const parent = document.querySelector('.main-wrapper');

// crea l'elemento
// Inner
const modalInner = document.createElement( 'div' );
modalInner.classList.add( 'modal__inner' );
parent.appendChild( modalInner );

// Location
const location = document.createElement( 'div' );
location.classList.add( 'modal__location' );
parent.appendChild( location );

// Link
const link = document.createElement( 'div' );
link.classList.add( 'modal__link' );
parent.appendChild( link );

// lo riempie con il contenuto
function fillElement (ele) {
  // Inner
  modalInner.innerHTML = document.querySelector('#js-modal-template-'+ele).innerHTML;
  // Location
  location.innerHTML = document.querySelector('#js-modal-location-'+ele).innerHTML;
  // Link
  link.innerHTML = document.querySelector('#js-modal-link-'+ele).innerHTML;
}

const modal = new mojs.Shape({
  parent:           '.main-wrapper',
  shape:            'circle',
  className:        'modal-trans',
  fill:             '#f9d953',
  scale:            {0 : 20},
  opacity:          {0 : 1},

  delay:            500,
  duration:         1500,
  easing:           'elastic.out',
});

const modalCloseBtn = new mojs.Shape({
  parent:           '.main-wrapper',
  shape:            'circle',
  className:        'modal-close-btn',
  fill:             'white',
  radius:           20,
  scale:            {0 : 1},
  opacity:          {0 : 1},

  top:              '120px',
  left:             '90%',
  delay:            1000,
  duration:         500,
  easing:           'elastic.out',
});

const closeBtn = new mojs.Shape({
  parent:           '.main-wrapper',
  className:        'close-btn',
  shape:            'cross',
  angle:            45,
  fill:             'none',
  radius:           {0 : 10},
  opacity:          {0 : 1},
  scale:            {0 : 1},
  stroke:           '#252525',
  strokeWidth:      4,

  top:              '120px',
  left:             '90%',

  duration:         500,
  easing:           'elastic.out',
});

const modalText = new mojs.Html({
  el:               '.modal__inner',
  opacity:          {0 : 1},
  scale:            {0 : 1},
  duration:         250,
  easing:           'cubic.out',
});

const webLink = new mojs.Shape({
  parent:           '.main-wrapper',
  shape:            'website',
  className:        'web-link',
  radius:           30,
  scale:            {0 : 1},
  opacity:          {0 : 1},
  fill:             '#252525',

  top:              '360px',
  left:             '90%',
  easing:           'elastic.out',
});

const mapPlace = new mojs.Shape({
  parent:           '.main-wrapper',
  shape:            'mapplace',
  className:        'map-place',
  radius:           30,
  scale:            {0 : 1},
  opacity:          {0 : 1},
  fill:             '#252525',

  top:              '220px',
  left:             '90%',
  easing:           'elastic.out',
});

const locationName = new mojs.Html({
  parent:           '.map-place',
  el:               '.modal__location',
  scale:            {0 : 1},
  opacity:          {0 : 1},
  top:              '260px',
  left:             '86%',
  easing:           'elastic.out',
});

const linkName = new mojs.Html({
  parent:           '.map-place',
  el:               '.modal__link',
  scale:            {0 : 1},
  opacity:          {0 : 1},
  top:              '380px',
  left:             '86%',
  easing:           'elastic.out',
  yoyo:             true,
});



const modalOpenTimeline = new mojs.Timeline({ delay: 0 });
modalOpenTimeline.append(modalCloseBtn, closeBtn, modalText, mapPlace, locationName, webLink, linkName);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * CLICK BUTTONS
 *
 */

// Cineteca
$('.mic-g').on('click', function (e) {
  fillElement('cineteca');
  modal.replay();
  modalOpenTimeline.replay();
});

// Belgrado / Kinoteka
$('.belgrado-g').on('click', function(e) {
  fillElement('kinoteka');
  modal.replay();
  modalOpenTimeline.replay();
});

// Nerve Centre
$('.nerve-centre-g').on('click', function(e) {
  fillElement('nerve-centre');
  modal.replay();
  modalOpenTimeline.replay();
});

// Bicocca
$('.bicocca-g').on('click', function(e) {
  fillElement('bicocca');
  modal.replay();
  modalOpenTimeline.replay();
});

// Film Space
$('.film-space-g').on('click', function(e) {
  fillElement('film-space');
  modal.replay();
  modalOpenTimeline.replay();
});

const noise = mojs.easing.path('M0,100 L2.0172237,93.0346887 L2.5383084,104.414093 L4.54648287,93 L5.95891666,104.414093 L8.51456926,93.0671151 L9.46473818,104.095861 L11.3469776,93.0844595 L12.9132633,104.095861 L15.0172237,93.0346887 L15.5383084,104.414093 L17.5464829,93 L18.9589167,104.414093 L21.5145693,93.0671151 L22.4647382,104.095861 L24.3469776,93.0844595 L25.9132633,104.095861 L28.0172237,93.0346887 L28.5383084,104.414093 L30.5464829,93 L31.9589167,104.414093 L34.5145693,93.0671151 L35.4647382,104.095861 L37.3469776,93.0844595 L38.9132633,104.095861 L41.0172237,93.0346887 L41.5383084,104.414093 L43.5464829,93 L44.9589167,104.414093 L47.5145693,93.0671151 L48.4647382,104.095861 L50.3469776,93.0844595 L51.7823677,105.309605 L53.6047297,93.9302003 L54.1258144,105.309604 L56.1339889,93.8955116 L57.5464227,105.309605 L60.1020753,93.9626267 L61.0522442,104.991373 L62.9344836,93.979971 L64.5007694,104.991373 L66.6047297,93.9302003 L67.1258144,105.309604 L69.1339889,93.8955116 L70.5464227,105.309605 L73.1020753,93.9626267 L74.0522442,104.991373 L75.9344836,93.979971 L77.5007694,104.991373 L79.6047297,93.9302003 L80.1258144,105.309604 L82.1339889,93.8955116 L83.5464227,105.309605 L86.1020753,93.9626267 L87.0522442,104.991373 L88.9344836,93.979971 L90.5007694,104.991373 C90.5007694,104.991373 91.7245407,96.0128348 92.3677444,93.0844595 C92.6568069,94.3823242 93.1258144,105.309604 93.1258144,105.309604 L95.1339889,93.8955116 L96.5464227,105.309605 L99.1020753,93.9626267 L100,100');
const noiseCurve = mojs.easing.path('M0, 100 C0, 100 5, 100 5, 100 C5, 100 5, 0 5, 0 C5, 0 10, 100 10, 100 C10, 100 10, 8 10, 8 C10, 8 15, 100 15, 100 C15, 100 15, 5 15, 5 C15, 5 20, 100 20, 100 C20, 100 22.714285714285715, 30 22.714285714285715, 30 C22.714285714285715, 30 26.57142857142857, 100 26.57142857142857, 100 C26.57142857142857, 100 28.285714285714285, 15 28.285714285714285, 15 C28.285714285714285, 15 32.85714285714286, 95 32.85714285714286, 95 C32.85714285714286, 95 35, 10 35, 10 C35, 10 36.57142857142857, 98 36.57142857142857, 98 C36.57142857142857, 98 40, 5 40, 5 C40, 5 41.71428571428571, 100 41.71428571428571, 100 C41.71428571428571, 100 45, 0 45, 0 C45, 0 50, 100 50, 100 C50, 100 53.285714285714285, 10 53.285714285714285, 10 C53.285714285714285, 10 57.142857142857146, 100 57.142857142857146, 100 C57.142857142857146, 100 60, 20 60, 20 C60, 20 63.42857142857143, 100 63.42857142857143, 100 C63.42857142857143, 100 66.85714285714286, 15 66.85714285714286, 15 C66.85714285714286, 15 70, 100 70, 100 C70, 100 75, 10 75, 10 C75, 10 77.42857142857143, 100 77.42857142857143, 100 C77.42857142857143, 100 80, 0 80, 0 C80, 0 83.14285714285714, 100 83.14285714285714, 100 C83.14285714285714, 100 86.85714285714286, 0 86.85714285714286, 0 C86.85714285714286, 0 87.71428571428571, 100 87.71428571428571, 100 C87.71428571428571, 100 91.74311926605505, 0 91.74311926605505, 0 C91.74311926605505, 0 93.348623853211, 100 93.348623853211, 100 C93.348623853211, 100 100, 100 100, 100');


const circless = new mojs.Burst({
  parent:             '#logo-img',
  radius:             { 100 : 300},
  count:              100,
  angle:              { 0: 90 },
  speed:              0.5,
  opacity:            1,

  duration:           2000,
  children: {
        shape:            'circle',
        points:           {3 : 10},
        fill:             'none',
        stroke:           ['#40BAB7', '#F79E5F', '#ee6568', '#FBD85E'],
        scale:            {1 : 0},
        degreeShift:      'rand(-360, 360)',
        delay:            'stagger(0, 100)',
        easing:           'cubic.out',
  },
  onComplete () {
        this.generate().replay();
  }

});

$('.modal-close-btn, .close-btn').on('click', function (e) {
  const modalCloseTimeline = new mojs.Timeline();

  const modalLinkClose = new mojs.Html({
    el:               '.modal__link',
    scale:            {1 : 0},
    opacity:          {1 : 0},
    duration:         500,
    easing:           'elastic.out',
  });
  modalCloseTimeline.add(modalLinkClose);

  const modalLocationClose = new mojs.Html({
    el:               '.modal__location',
    scale:            {1 : 0},
    opacity:          {1 : 0},
    duration:         500,
    easing:           'elastic.out',
  });
  modalCloseTimeline.add(modalLocationClose);

  const mapPlaceClose = new mojs.Html({
    el:               '.map-place',
    scale:            {1 : 0},
    opacity:          {1 : 0},
    duration:         500,
    easing:           'elastic.out',
  });
  modalCloseTimeline.add(mapPlaceClose);

  const webLinkClose = new mojs.Html({
    el:               '.web-link',
    scale:            {1 : 0},
    opacity:          {1 : 0},
    duration:         500,
    easing:           'elastic.out',
  });
  modalCloseTimeline.add(webLinkClose);

  const modalCloseCloseBtn = new mojs.Html({
    el:               '.modal-close-btn',
    scale:            {1 : 0},
    opacity:          {1 : 0},
    duration:         500,
    easing:           'elastic.out',
  });
  modalCloseTimeline.add(modalCloseCloseBtn);

  const CloseCloseBtn = new mojs.Html({
    el:               '.close-btn',
    scale:            {1 : 0},
    opacity:          {1 : 0},
    duration:         500,
    easing:           'elastic.out',
  });
  modalCloseTimeline.add(CloseCloseBtn);

  const modalCloseInner = new mojs.Html({
    el:               '.modal__inner',
    scale:            {1 : 0},
    opacity:          {1 : 0},
    duration:         500,
    easing:           'elastic.out',
  });
  modalCloseTimeline.add(modalCloseInner);

  const modalCloseTrans = new mojs.Html({
    el:               '.modal-trans',
    scale:            {1 : 0},
    opacity:          {1 : 0},
    duration:         500,
    easing:           'elastic.out',
  });
  modalCloseTimeline.add(modalCloseTrans);

  modalCloseTimeline.replay();
});

// RESIZE SVG TO WINDOW mantaining aspect Ratio

function setHeight(a) {
  const k = a / 1920;
  let h = 1080 * k;
  $('.main-wrapper').width(a).height(h);
};

var w = $(window).width();
setHeight(w);

$(window).resize(function() {
  var h = $(window).height();
  var w = $(window).width();
  setHeight(w);
});


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * OMINI
 *
 */

const manScale      = 0.5;                                // dimensione
const manNumber     = 70;                                 // total people
const refreshMans   = 10;                                 // Range for random new people
const refreshTime   = 10000;                              // time for new people in ms
const leftStreet    = .3;                                 // quanti nella strada di sinistra (es: 0.5 -> metà saranno su quella di sinistra, 0.4 -> il 40%)
const walkDuration  = 200000;                             // Durata dell'animazione totale
const left_path     = document.getElementById('path-2');  // Percorso di sinistra
const right_path    = document.getElementById('path-1');  // Percorso di destra
const repeat        = {
                        isYoyo: true,
                        repeat: 999,
                      };
const angle         = 30;
const colors        = [
                        '#939393',
                        '#7e7e7e',
                        '#696969',
                        '#545454',
                        '#3f3f3f',
                        '#2a2a2a',
                        '#151515',
                        '#808080',
                        '#585858',
                        '#383838',
                        '#686868',
                      ];
const paths           = [
  // ['direzione della path', 'direzione camminata omini', path],
  ['right_to_left', 'right', document.getElementById('path-1')],
  ['left_to_right', 'left', document.getElementById('path-2')],
  ['left_to_right', 'left', document.getElementById('path-3')],
  ['right_to_left', 'right', document.getElementById('path-4')],
  ['left_to_right', 'right', document.getElementById('path-5')],
  ['right_to_left', 'left', document.getElementById('path-6')],
  ['right_to_left', 'right', document.getElementById('path-7')],
  ['left_to_right', 'right', document.getElementById('path-8')],
  ['right_to_left', 'right', document.getElementById('path-9')],
  ['left_to_right', 'right', document.getElementById('path-10')],
  ['left_to_right', 'right', document.getElementById('path-11')],
  ['right_to_left', 'right', document.getElementById('path-12')],
  ['right_to_left', 'right', document.getElementById('path-12')],
  ['right_to_left', 'right', document.getElementById('path-13')],
  ['left_to_right', 'right', document.getElementById('path-14')],
  ['left_to_right', 'right', document.getElementById('path-15')],
];

let counter = 0;
const n_colors = colors.length;
const n_paths = paths.length;
console.log(n_paths);

const Lemming = function()
{
    this.generateLemming = function ( i )
    {
        let _color = colors[Math.floor(Math.random() * n_colors)];
        let _position = -1.5 + (Math.floor((Math.random() * 100) + 1) / 100);
        let _duration = Math.floor((Math.random() * 2000) + 2000);
        let _wrapper = new mojs.Shape({
          parent: '.omini',
          className: 'wrapper-'+i,
          fill: 'none',
          radius: 0,
          top: _position+'%',
          left: 0,
        });
        let _head = new mojs.Shape({
          parent: '.wrapper-'+i,
          className: 'omino man-head-'+i,
          shape: 'circle',
          radius: 6,
          fill: _color,
          top: _position+'%',
          // top: 0,
          left: 0,
          x: {1 : 0},
          y: {'-1' : 0},
          duration: _duration / 4,
          ...repeat
        });
        let _body = new mojs.Shape({
            parent: '.man-head-'+i,
            class: 'man-body-'+i,
            shape: 'line',
            stroke: _color,
            radius: 8,
            strokeWidth: 9,
            strokeLinecap: 'round',
            angle: {88 : 92},
            origin: 'center',
            x: {0 : '-1'},
            y: {24 : 23},
            duration: _duration / 2,
            ...repeat
        });
        let leg_shape_opts = {
            shape: 'line',
            radius: 6,
            stroke: _color,
            strokeWidth: 6,
            strokeLinecap: 'round',
            origin: '0% 50%',
            easing: 'sin.out',
            backwardEasing: 'sin.in',
            isShowStart: true,
            ...repeat
        };
        let leg_opts = {
            ...leg_shape_opts,
            y: 33,
            x: {9 : 8},
            duration: _duration / 2,
        };
        let leg_b_opts = {
            ...leg_shape_opts,
            x: 12,
            delay: _duration / 4,
            duration: _duration / 4,
        };
        let _LegL = new mojs.Shape({
            ...leg_opts,
            parent: '.man-head-'+i,
            className: 'left-leg-'+i,
            angle: {75 : 105},
        });
        let _LegLb = new mojs.Shape({
            ...leg_b_opts,
            parent: '.left-leg-'+i,
            y: {.6 : 0},
            angle: {345 : 360},
        });
        let _LegR = new mojs.Shape({
            ...leg_opts,
            parent: '.man-head-'+i,
            className: 'right-leg-'+i,
            angle: {105 : 75},
        });
        let _LegRb = new mojs.Shape({
            ...leg_b_opts,
            parent: '.right-leg-'+i,
            y: {0 : .6},
            angle: {360 : 345},
        });
        let arm_shape_opts = {
            shape: 'line',
            strokeWidth: 5,
            strokeLinecap: 'round',
            stroke: _color,
            origin: '0% 50%',
            easing: 'sin.out',
            backwardEasing: 'sin.in',
            isShowStart: true,
            duration: _duration / 2,
            ...repeat
        };
        let _armL = new mojs.Shape({
            ...arm_shape_opts,
            parent: '.man-head-'+i,
            className: 'arm-left-'+i,
            radius: 5,
            angle: {65 : 115},
            x: 7,
            y: 12,
        });
        let _armLb = new mojs.Shape({
            ...arm_shape_opts,
            parent: '.arm-left-'+i,
            radius: 5.5,
            angle: {15 : 40},
            x: 12,
            y: -1,
        });
        let _armR = new mojs.Shape({
            ...arm_shape_opts,
            parent: '.man-head-'+i,
            className: 'arm-right-'+i,
            radius: 5,
            angle: {115 : 65},
            x: 7,
            y: 12,
        })
        let _armRb = new mojs.Shape({
            ...arm_shape_opts,
            parent: '.arm-right-'+i,
            radius: 5.5,
            angle: {40 : 15},
            x: 12,
            y: -1,
        });

        let arm = new mojs.Timeline().add(_armL, _armLb, _armR, _armRb);
        let legs = new mojs.Timeline().add(_LegL, _LegLb, _LegR, _LegRb);
        let man = new mojs.Timeline().add(_head, _body, arm, legs);

        return man;
    }

    this.generateLemmingBackward = function ( i )
    {
        let _color = colors[Math.floor(Math.random() * n_colors)];
        let _position = -1.5 + (Math.floor((Math.random() * 100) + 1) / 100);
        let _duration = Math.floor((Math.random() * 2000) + 2000);
        let _wrapper = new mojs.Shape({
          parent: '.omini',
          className: 'wrapper-'+i,
          fill: 'none',
          radius: 1,
          top: _position+'%',
          left: 0,
        });
        let _head = new mojs.Shape({
          parent: '.wrapper-'+i,
          className: 'omino man-head-'+i,
          shape: 'circle',
          radius: 6,
          fill: _color,
          top: _position+'%',
          left: 0,
          x: {0 : 1},
          y: {0 : -1},
          duration: _duration / 4,
          ...repeat
        });
        let _body = new mojs.Shape({
            parent: '.man-head-'+i,
            class: 'man-body-'+i,
            shape: 'line',
            stroke: _color,
            radius: 8,
            strokeWidth: 9,
            strokeLinecap: 'round',
            angle: {92 : 88},
            origin: 'center',
            x: {'-1' : 0},
            y: {23 : 24},
            duration: _duration / 2,
            ...repeat
        });
        let leg_shape_opts = {
            shape: 'line',
            radius: 6,
            stroke: _color,
            strokeWidth: 6,
            strokeLinecap: 'round',
            origin: '0% 50%',
            easing: 'sin.out',
            backwardEasing: 'sin.in',
            isShowStart: true,
            ...repeat
        };
        let leg_opts = {
            ...leg_shape_opts,
            y: 33,
            x: {8 : 9},
            duration: _duration / 2,
        };
        let leg_b_opts = {
            ...leg_shape_opts,
            x: 12,
            delay: _duration / 4,
            duration: _duration / 4,
        };
        let _LegL = new mojs.Shape({
            ...leg_opts,
            parent: '.man-head-'+i,
            className: 'left-leg-'+i,
            angle: {75 : 105},
        });
        let _LegLb = new mojs.Shape({
            ...leg_b_opts,
            parent: '.left-leg-'+i,
            y: {0 : '-.6'},
            angle: {0 : 15},
        });
        let _LegR = new mojs.Shape({
            ...leg_opts,
            parent: '.man-head-'+i,
            className: 'right-leg-'+i,
            angle: {105 : 75},
          });
        let _LegRb = new mojs.Shape({
            ...leg_b_opts,
            parent: '.right-leg-'+i,
            y: {'-.4' : 0},
            angle: {15 : 0},
        });
        let arm_shape_opts = {
          shape: 'line',
          strokeWidth: 5,
          strokeLinecap: 'round',
          stroke: _color,
          origin: '0% 50%',
          easing: 'sin.out',
          backwardEasing: 'sin.in',
          isShowStart: true,
          duration: _duration / 2,
          ...repeat
        };
        let _armL = new mojs.Shape({
            ...arm_shape_opts,
            parent: '.man-head-'+i,
            className: 'arm-left-'+i,
            radius: 5,
            angle: {65 : 125},
            x: 7,
            y: 12,
        });
        let _armLb = new mojs.Shape({
            ...arm_shape_opts,
            parent: '.arm-left-'+i,
            radius: 5.5,
            angle: {325 : 350},
            x: 12,
            y: {1 : 0},
        });
        let _armR = new mojs.Shape({
            ...arm_shape_opts,
            parent: '.man-head-'+i,
            className: 'arm-right-'+i,
            radius: 5,
            angle: {125 : 65},
            x: 7,
            y: 12,
        })
        let _armRb = new mojs.Shape({
            ...arm_shape_opts,
            parent: '.arm-right-'+i,
            radius: 5.5,
            angle: {350 : 325},
            x: 12,
            y: {0 : 1},
        });

        let arm = new mojs.Timeline().add(_armL, _armLb, _armR, _armRb);
        let legs = new mojs.Timeline().add(_LegL, _LegLb, _LegR, _LegRb);
        let man = new mojs.Timeline().add(_head, _body, arm, legs);

        return man;
    }

    this.walks = function (_timeline, _direction, _path, index, shift)
    {
        // let name = '.man-head-'+i;
        // let object = document.querySelector(name);
        let _pathLenght = _path.getTotalLength();
        let _delay = Math.floor((Math.random() * walkDuration) + 1);
        let _walk = new mojs.Tween({
            duration: walkDuration,
            direction: _direction,
            delay: _delay,
            onUpdate (ep, p, isForward, isYoyo) {
                let v = _pathLenght * (p - 1) + _pathLenght;
                let w = $('#logo-img').outerWidth();
                let h = $('#logo-img').outerHeight();

                let point = _path.getPointAtLength(v);
                let startPoint = _path.getPointAtLength(0);
                let endPoint = _path.getPointAtLength(_pathLenght);


                let kx = w / 1920;
                let ky = h / 1080;
                let x = point.x * kx;
                let y = point.y * ky;
                let startX = startPoint.x * kx;
                let startY = startPoint.y * ky;
                let endX = endPoint.x *kx;
                let endY = endPoint.y *ky;
                let sx = manScale * (w / 1920) * (y/h);

                let _angle = 0;
                if (y < startY && y > endY) {
                    _angle = angle;
                }

                let obj = new mojs.Html({
                    el: '.wrapper-'+index,
                    x: x,
                    y: y,
                    angleY: angle,
                    scaleX: sx,
                    scaleY: sx
                }).play();

                // rimuove gli omini quando arrivano a fine corsa o all'inizio se la direzione è inversa altrimenti li manda in play
                if (_direction == 1 && y == endY && x == endX) {
                    _timeline.stop();
                    _walk.reset();
                    $('.wrapper-'+index).remove();
                }
                else if (_direction == -1 && y == startY && x == startX) {
                  _timeline.stop();
                  _walk.reset();
                  $('.wrapper-'+index).remove();
                } else {
                  _timeline.play();
                }
            },
            onPlaybackComplete () {
                _timeline.reset();
                _walk.reset();
                $('.wrapper-'+index).remove();
            }
        });
        if (_direction == 1) {
            _walk.play(shift);
        }
        else {
            // if (shift != 0) {
            //   shift = shift + walkDuration;
            // }
            _walk.playBackward(shift);
        }
    }

    this.goGoLemmmings = function (number, isStart)
    {
      console.log('Go Lemmings');
      for (var i = 0; i < number; i++) {
        let _pathIndex = Math.floor(Math.random() * n_paths);
        let direction = Math.random() >= 0.5;
        let timeline = null;
        let index = counter;


        // Assegno la direzione
        if (direction == false) {
            direction = -1;
        } else {
            direction = 1;
        }

        if (i < (number * leftStreet)) {
          while (paths[_pathIndex][1] == 'right') {
              _pathIndex = Math.floor(Math.random() * n_paths);
          }
        } else {
          while (paths[_pathIndex][1] == 'left') {
              _pathIndex = Math.floor(Math.random() * n_paths);
          }
        }

        let _pathDirection = paths[_pathIndex][0];
        let _pathSide = paths[_pathIndex][1];
        let _path = paths[_pathIndex][2];

        if (_pathDirection == 'left_to_right') {
            if (direction == -1) {
                timeline = this.generateLemming(index)
            } else {
                timeline = this.generateLemmingBackward(index)
            }
        } else if (_pathDirection == 'right_to_left') {
            if (direction == -1) {
                timeline = this.generateLemmingBackward(index)
            } else {
                timeline = this.generateLemming(index)
            }
        }


        if (isStart == true) {
          let shift = Math.floor((Math.random() * walkDuration) + 1);
          this.walks(timeline, direction, _path, index, shift);
        } else {
          this.walks(timeline, direction, _path, index, 0);
        }

        counter = counter + 1;

      }
    }
}



// prendo le dimensioni della del svg
w = $('.bicocca-g')[0].getBoundingClientRect().width;
let h = $('.bicocca-g')[0].getBoundingClientRect().height;

$(window).resize(function(){
  w = $('.bicocca-g')[0].getBoundingClientRect().width;
  h = $('.bicocca-g')[0].getBoundingClientRect().height;
});

const Animation = new Lemming();

Animation.goGoLemmmings(manNumber, true);
var newLemmings = function ()
{
  let random = Math.floor((Math.random() * refreshMans) + 1);
  Animation.goGoLemmmings(random, false);
}
setInterval(newLemmings, refreshTime)
