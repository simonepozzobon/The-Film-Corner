webpackJsonp([0],[
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _vue = __webpack_require__(18);

var _vue2 = _interopRequireDefault(_vue);

var _moJs = __webpack_require__(10);

var _moJs2 = _interopRequireDefault(_moJs);

var _VideoFormUpload = __webpack_require__(12);

var _VideoFormUpload2 = _interopRequireDefault(_VideoFormUpload);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var app = new _vue2.default({
    el: '#app',
    data: {
        content: ''
    },
    methods: {},
    components: {
        VideoFormUpload: _VideoFormUpload2.default
    }
});

/***/ }),
/* 5 */,
/* 6 */,
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


exports.default = {
    props: ['_token', '_method', 'diocane'],
    data: function data() {
        return {
            title: '',
            file: '',
            categories: '',
            opts: [{ text: 'ciao', value: 1 }, { text: 'Gianni', value: 2 }]
        };
    },
    mounted: function mounted() {
        this.showFormBtn = this.$refs['show-modal-btn'];
        this.sendBtn = this.$refs['send-btn'];
        this.form = this.$refs['this-form'];
        this.closeFormBtn = this.$refs['close-form-btn'];

        // get the original heights
        this.formOriginalHeight = this.form.clientHeight;
        this.showFormOriginalHeight = this.showFormBtn.clientHeight;

        // Initialize style
        this.form.style.opacity = '0';
        this.form.style.height = '0';
        this.form.style.display = 'none';
        this.closeFormBtn.style.opacity = '0';

        console.log(this.form.style.opacity);
    },

    methods: {
        showModal: function showModal(e) {
            var showForm = new mojs.Html({
                el: this.form,
                height: { 0: this.formOriginalHeight, delay: 150 },
                opacity: { 0: 1, delay: 150 },
                y: { '-100': 0 },
                easing: 'sin.out',
                delay: 100
            });

            var showCloseFormBtn = new mojs.Html({
                el: this.closeFormBtn,
                opacity: { 0: 1 },
                y: { '-40': 0 },
                angleZ: { 90: 0 },
                easing: 'sin.out',
                delay: 200
            });

            var showFormTimeline = new mojs.Timeline().add(showForm, showCloseFormBtn);

            this.form.style.display = 'inherit';

            new mojs.Html({
                el: this.showFormBtn,
                opacity: { 1: 0 },
                height: { 55: 0 },
                onComplete: function onComplete() {
                    showFormTimeline.play();
                }
            }).play();
        },
        hideModal: function hideModal() {
            var showSendBtn = new mojs.Html({
                el: this.showFormBtn,
                opacity: { 0: 1 },
                height: { 50: this.showFormOriginalHeight },
                easing: 'sin.out',
                delay: 100
            });

            var hideForm = new mojs.Html({
                el: this.form,
                height: { 100: 0 },
                opacity: { 1: 0 },
                y: { 0: '-100' },
                easing: 'sin.in',
                onComplete: function onComplete() {
                    showSendBtn.play();
                }
            });

            var hideCloseFormBtn = new mojs.Html({
                el: this.closeFormBtn,
                opacity: { 1: 0 },
                y: { 0: '-40' },
                angleZ: { 0: 90 },
                easing: 'sin.in',
                duration: 100
            });

            var hideFormTimeline = new mojs.Timeline().add(hideCloseFormBtn, hideForm).play();
            this.form.style.display = 'none';
        },
        sendForm: function sendForm(e) {
            e.preventDefault();

            var button = new mojs.Html({
                el: this.sendBtn,
                opacity: { 1: 0 },
                scale: { 1: 0 },
                height: { '100%': 0 }
            });

            var element = new mojs.Html({
                el: this.form,
                opacity: { 1: 0 },
                scale: { 1: 0 },
                height: { '100%': 0 }
            });

            var timeline = new mojs.Timeline().add(button, element).play();
        }
    }
};

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(9)();
exports.push([module.i, "\n.close-btn {\n  position: absolute;\n  right: 1.5rem;\n  top: 1.5rem;\n}\n", ""]);

/***/ }),
/* 9 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function() {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		var result = [];
		for(var i = 0; i < this.length; i++) {
			var item = this[i];
			if(item[2]) {
				result.push("@media " + item[2] + "{" + item[1] + "}");
			} else {
				result.push(item[1]);
			}
		}
		return result.join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};


/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

(function webpackUniversalModuleDefinition(root, factory) {
	if(true)
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define("mojs", [], factory);
	else if(typeof exports === 'object')
		exports["mojs"] = factory();
	else
		root["mojs"] = factory();
})(this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "build/";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(1);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

	var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/* WEBPACK VAR INJECTION */(function(module) {'use strict';

	exports.__esModule = true;

	var _typeof2 = __webpack_require__(3);

	var _typeof3 = _interopRequireDefault(_typeof2);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	var _shapesMap = __webpack_require__(72);

	var _shapesMap2 = _interopRequireDefault(_shapesMap);

	var _shape = __webpack_require__(94);

	var _shape2 = _interopRequireDefault(_shape);

	var _shapeSwirl = __webpack_require__(117);

	var _shapeSwirl2 = _interopRequireDefault(_shapeSwirl);

	var _burst = __webpack_require__(118);

	var _burst2 = _interopRequireDefault(_burst);

	var _html = __webpack_require__(119);

	var _html2 = _interopRequireDefault(_html);

	var _stagger = __webpack_require__(127);

	var _stagger2 = _interopRequireDefault(_stagger);

	var _spriter = __webpack_require__(128);

	var _spriter2 = _interopRequireDefault(_spriter);

	var _motionPath = __webpack_require__(129);

	var _motionPath2 = _interopRequireDefault(_motionPath);

	var _tween = __webpack_require__(101);

	var _tween2 = _interopRequireDefault(_tween);

	var _timeline = __webpack_require__(110);

	var _timeline2 = _interopRequireDefault(_timeline);

	var _tweener = __webpack_require__(102);

	var _tweener2 = _interopRequireDefault(_tweener);

	var _tweenable = __webpack_require__(100);

	var _tweenable2 = _interopRequireDefault(_tweenable);

	var _thenable = __webpack_require__(99);

	var _thenable2 = _interopRequireDefault(_thenable);

	var _tunable = __webpack_require__(116);

	var _tunable2 = _interopRequireDefault(_tunable);

	var _delta = __webpack_require__(126);

	var _delta2 = _interopRequireDefault(_delta);

	var _deltas = __webpack_require__(125);

	var _deltas2 = _interopRequireDefault(_deltas);

	var _module = __webpack_require__(84);

	var _module2 = _interopRequireDefault(_module);

	var _easing = __webpack_require__(105);

	var _easing2 = _interopRequireDefault(_easing);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var mojs = {
	  revision: '0.288.2', isDebug: true, helpers: _h2.default,
	  Shape: _shape2.default, ShapeSwirl: _shapeSwirl2.default, Burst: _burst2.default, Html: _html2.default, stagger: _stagger2.default, Spriter: _spriter2.default, MotionPath: _motionPath2.default,
	  Tween: _tween2.default, Timeline: _timeline2.default, Tweenable: _tweenable2.default, Thenable: _thenable2.default, Tunable: _tunable2.default, Module: _module2.default,
	  tweener: _tweener2.default, easing: _easing2.default, shapesMap: _shapesMap2.default, _pool: { Delta: _delta2.default, Deltas: _deltas2.default }
	};

	// functions alias
	mojs.h = mojs.helpers;
	mojs.delta = mojs.h.delta;
	// custom shape add function and class
	mojs.addShape = mojs.shapesMap.addShape;
	mojs.CustomShape = mojs.shapesMap.custom;
	// module alias
	mojs.Transit = mojs.Shape;
	mojs.Swirl = mojs.ShapeSwirl;

	// TODO:
	/*
	  H/V in paths

	  rand for direction
	  burst children angle after tune
	  burst pathScale after tune
	  swirl then issue
	  'rand' angle flick with `then`
	  not able to `play()` in `onComplete` callback
	  ---
	  module names
	  swirls in then chains for x/y
	  parse rand(stagger(20, 10), 20) values
	  percentage for radius
	*/

	// istanbul ignore next
	if (true) {
	  !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = function () {
	    return mojs;
	  }.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	}
	// istanbul ignore next
	if (( false ? 'undefined' : (0, _typeof3.default)(module)) === "object" && (0, _typeof3.default)(module.exports) === "object") {
	  module.exports = mojs;
	}

	exports.default = mojs;


	typeof window !== 'undefined' && (window.mojs = mojs);
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(2)(module)))

/***/ }),
/* 2 */
/***/ (function(module, exports) {

	module.exports = function(module) {
		if(!module.webpackPolyfill) {
			module.deprecate = function() {};
			module.paths = [];
			// module.parent = undefined by default
			module.children = [];
			module.webpackPolyfill = 1;
		}
		return module;
	}


/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";

	exports.__esModule = true;

	var _iterator = __webpack_require__(4);

	var _iterator2 = _interopRequireDefault(_iterator);

	var _symbol = __webpack_require__(55);

	var _symbol2 = _interopRequireDefault(_symbol);

	var _typeof = typeof _symbol2.default === "function" && typeof _iterator2.default === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof _symbol2.default === "function" && obj.constructor === _symbol2.default && obj !== _symbol2.default.prototype ? "symbol" : typeof obj; };

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = typeof _symbol2.default === "function" && _typeof(_iterator2.default) === "symbol" ? function (obj) {
	  return typeof obj === "undefined" ? "undefined" : _typeof(obj);
	} : function (obj) {
	  return obj && typeof _symbol2.default === "function" && obj.constructor === _symbol2.default && obj !== _symbol2.default.prototype ? "symbol" : typeof obj === "undefined" ? "undefined" : _typeof(obj);
	};

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(5), __esModule: true };

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(6);
	__webpack_require__(50);
	module.exports = __webpack_require__(54).f('iterator');

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var $at  = __webpack_require__(7)(true);

	// 21.1.3.27 String.prototype[@@iterator]()
	__webpack_require__(10)(String, 'String', function(iterated){
	  this._t = String(iterated); // target
	  this._i = 0;                // next index
	// 21.1.5.2.1 %StringIteratorPrototype%.next()
	}, function(){
	  var O     = this._t
	    , index = this._i
	    , point;
	  if(index >= O.length)return {value: undefined, done: true};
	  point = $at(O, index);
	  this._i += point.length;
	  return {value: point, done: false};
	});

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

	var toInteger = __webpack_require__(8)
	  , defined   = __webpack_require__(9);
	// true  -> String#at
	// false -> String#codePointAt
	module.exports = function(TO_STRING){
	  return function(that, pos){
	    var s = String(defined(that))
	      , i = toInteger(pos)
	      , l = s.length
	      , a, b;
	    if(i < 0 || i >= l)return TO_STRING ? '' : undefined;
	    a = s.charCodeAt(i);
	    return a < 0xd800 || a > 0xdbff || i + 1 === l || (b = s.charCodeAt(i + 1)) < 0xdc00 || b > 0xdfff
	      ? TO_STRING ? s.charAt(i) : a
	      : TO_STRING ? s.slice(i, i + 2) : (a - 0xd800 << 10) + (b - 0xdc00) + 0x10000;
	  };
	};

/***/ }),
/* 8 */
/***/ (function(module, exports) {

	// 7.1.4 ToInteger
	var ceil  = Math.ceil
	  , floor = Math.floor;
	module.exports = function(it){
	  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
	};

/***/ }),
/* 9 */
/***/ (function(module, exports) {

	// 7.2.1 RequireObjectCoercible(argument)
	module.exports = function(it){
	  if(it == undefined)throw TypeError("Can't call method on  " + it);
	  return it;
	};

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var LIBRARY        = __webpack_require__(11)
	  , $export        = __webpack_require__(12)
	  , redefine       = __webpack_require__(27)
	  , hide           = __webpack_require__(17)
	  , has            = __webpack_require__(28)
	  , Iterators      = __webpack_require__(29)
	  , $iterCreate    = __webpack_require__(30)
	  , setToStringTag = __webpack_require__(46)
	  , getPrototypeOf = __webpack_require__(48)
	  , ITERATOR       = __webpack_require__(47)('iterator')
	  , BUGGY          = !([].keys && 'next' in [].keys()) // Safari has buggy iterators w/o `next`
	  , FF_ITERATOR    = '@@iterator'
	  , KEYS           = 'keys'
	  , VALUES         = 'values';

	var returnThis = function(){ return this; };

	module.exports = function(Base, NAME, Constructor, next, DEFAULT, IS_SET, FORCED){
	  $iterCreate(Constructor, NAME, next);
	  var getMethod = function(kind){
	    if(!BUGGY && kind in proto)return proto[kind];
	    switch(kind){
	      case KEYS: return function keys(){ return new Constructor(this, kind); };
	      case VALUES: return function values(){ return new Constructor(this, kind); };
	    } return function entries(){ return new Constructor(this, kind); };
	  };
	  var TAG        = NAME + ' Iterator'
	    , DEF_VALUES = DEFAULT == VALUES
	    , VALUES_BUG = false
	    , proto      = Base.prototype
	    , $native    = proto[ITERATOR] || proto[FF_ITERATOR] || DEFAULT && proto[DEFAULT]
	    , $default   = $native || getMethod(DEFAULT)
	    , $entries   = DEFAULT ? !DEF_VALUES ? $default : getMethod('entries') : undefined
	    , $anyNative = NAME == 'Array' ? proto.entries || $native : $native
	    , methods, key, IteratorPrototype;
	  // Fix native
	  if($anyNative){
	    IteratorPrototype = getPrototypeOf($anyNative.call(new Base));
	    if(IteratorPrototype !== Object.prototype){
	      // Set @@toStringTag to native iterators
	      setToStringTag(IteratorPrototype, TAG, true);
	      // fix for some old engines
	      if(!LIBRARY && !has(IteratorPrototype, ITERATOR))hide(IteratorPrototype, ITERATOR, returnThis);
	    }
	  }
	  // fix Array#{values, @@iterator}.name in V8 / FF
	  if(DEF_VALUES && $native && $native.name !== VALUES){
	    VALUES_BUG = true;
	    $default = function values(){ return $native.call(this); };
	  }
	  // Define iterator
	  if((!LIBRARY || FORCED) && (BUGGY || VALUES_BUG || !proto[ITERATOR])){
	    hide(proto, ITERATOR, $default);
	  }
	  // Plug for library
	  Iterators[NAME] = $default;
	  Iterators[TAG]  = returnThis;
	  if(DEFAULT){
	    methods = {
	      values:  DEF_VALUES ? $default : getMethod(VALUES),
	      keys:    IS_SET     ? $default : getMethod(KEYS),
	      entries: $entries
	    };
	    if(FORCED)for(key in methods){
	      if(!(key in proto))redefine(proto, key, methods[key]);
	    } else $export($export.P + $export.F * (BUGGY || VALUES_BUG), NAME, methods);
	  }
	  return methods;
	};

/***/ }),
/* 11 */
/***/ (function(module, exports) {

	module.exports = true;

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

	var global    = __webpack_require__(13)
	  , core      = __webpack_require__(14)
	  , ctx       = __webpack_require__(15)
	  , hide      = __webpack_require__(17)
	  , PROTOTYPE = 'prototype';

	var $export = function(type, name, source){
	  var IS_FORCED = type & $export.F
	    , IS_GLOBAL = type & $export.G
	    , IS_STATIC = type & $export.S
	    , IS_PROTO  = type & $export.P
	    , IS_BIND   = type & $export.B
	    , IS_WRAP   = type & $export.W
	    , exports   = IS_GLOBAL ? core : core[name] || (core[name] = {})
	    , expProto  = exports[PROTOTYPE]
	    , target    = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE]
	    , key, own, out;
	  if(IS_GLOBAL)source = name;
	  for(key in source){
	    // contains in native
	    own = !IS_FORCED && target && target[key] !== undefined;
	    if(own && key in exports)continue;
	    // export native or passed
	    out = own ? target[key] : source[key];
	    // prevent global pollution for namespaces
	    exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
	    // bind timers to global for call from export context
	    : IS_BIND && own ? ctx(out, global)
	    // wrap global constructors for prevent change them in library
	    : IS_WRAP && target[key] == out ? (function(C){
	      var F = function(a, b, c){
	        if(this instanceof C){
	          switch(arguments.length){
	            case 0: return new C;
	            case 1: return new C(a);
	            case 2: return new C(a, b);
	          } return new C(a, b, c);
	        } return C.apply(this, arguments);
	      };
	      F[PROTOTYPE] = C[PROTOTYPE];
	      return F;
	    // make static versions for prototype methods
	    })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
	    // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
	    if(IS_PROTO){
	      (exports.virtual || (exports.virtual = {}))[key] = out;
	      // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
	      if(type & $export.R && expProto && !expProto[key])hide(expProto, key, out);
	    }
	  }
	};
	// type bitmap
	$export.F = 1;   // forced
	$export.G = 2;   // global
	$export.S = 4;   // static
	$export.P = 8;   // proto
	$export.B = 16;  // bind
	$export.W = 32;  // wrap
	$export.U = 64;  // safe
	$export.R = 128; // real proto method for `library` 
	module.exports = $export;

/***/ }),
/* 13 */
/***/ (function(module, exports) {

	// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
	var global = module.exports = typeof window != 'undefined' && window.Math == Math
	  ? window : typeof self != 'undefined' && self.Math == Math ? self : Function('return this')();
	if(typeof __g == 'number')__g = global; // eslint-disable-line no-undef

/***/ }),
/* 14 */
/***/ (function(module, exports) {

	var core = module.exports = {version: '2.4.0'};
	if(typeof __e == 'number')__e = core; // eslint-disable-line no-undef

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

	// optional / simple context binding
	var aFunction = __webpack_require__(16);
	module.exports = function(fn, that, length){
	  aFunction(fn);
	  if(that === undefined)return fn;
	  switch(length){
	    case 1: return function(a){
	      return fn.call(that, a);
	    };
	    case 2: return function(a, b){
	      return fn.call(that, a, b);
	    };
	    case 3: return function(a, b, c){
	      return fn.call(that, a, b, c);
	    };
	  }
	  return function(/* ...args */){
	    return fn.apply(that, arguments);
	  };
	};

/***/ }),
/* 16 */
/***/ (function(module, exports) {

	module.exports = function(it){
	  if(typeof it != 'function')throw TypeError(it + ' is not a function!');
	  return it;
	};

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

	var dP         = __webpack_require__(18)
	  , createDesc = __webpack_require__(26);
	module.exports = __webpack_require__(22) ? function(object, key, value){
	  return dP.f(object, key, createDesc(1, value));
	} : function(object, key, value){
	  object[key] = value;
	  return object;
	};

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

	var anObject       = __webpack_require__(19)
	  , IE8_DOM_DEFINE = __webpack_require__(21)
	  , toPrimitive    = __webpack_require__(25)
	  , dP             = Object.defineProperty;

	exports.f = __webpack_require__(22) ? Object.defineProperty : function defineProperty(O, P, Attributes){
	  anObject(O);
	  P = toPrimitive(P, true);
	  anObject(Attributes);
	  if(IE8_DOM_DEFINE)try {
	    return dP(O, P, Attributes);
	  } catch(e){ /* empty */ }
	  if('get' in Attributes || 'set' in Attributes)throw TypeError('Accessors not supported!');
	  if('value' in Attributes)O[P] = Attributes.value;
	  return O;
	};

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

	var isObject = __webpack_require__(20);
	module.exports = function(it){
	  if(!isObject(it))throw TypeError(it + ' is not an object!');
	  return it;
	};

/***/ }),
/* 20 */
/***/ (function(module, exports) {

	module.exports = function(it){
	  return typeof it === 'object' ? it !== null : typeof it === 'function';
	};

/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = !__webpack_require__(22) && !__webpack_require__(23)(function(){
	  return Object.defineProperty(__webpack_require__(24)('div'), 'a', {get: function(){ return 7; }}).a != 7;
	});

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

	// Thank's IE8 for his funny defineProperty
	module.exports = !__webpack_require__(23)(function(){
	  return Object.defineProperty({}, 'a', {get: function(){ return 7; }}).a != 7;
	});

/***/ }),
/* 23 */
/***/ (function(module, exports) {

	module.exports = function(exec){
	  try {
	    return !!exec();
	  } catch(e){
	    return true;
	  }
	};

/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

	var isObject = __webpack_require__(20)
	  , document = __webpack_require__(13).document
	  // in old IE typeof document.createElement is 'object'
	  , is = isObject(document) && isObject(document.createElement);
	module.exports = function(it){
	  return is ? document.createElement(it) : {};
	};

/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

	// 7.1.1 ToPrimitive(input [, PreferredType])
	var isObject = __webpack_require__(20);
	// instead of the ES6 spec version, we didn't implement @@toPrimitive case
	// and the second argument - flag - preferred type is a string
	module.exports = function(it, S){
	  if(!isObject(it))return it;
	  var fn, val;
	  if(S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it)))return val;
	  if(typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it)))return val;
	  if(!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it)))return val;
	  throw TypeError("Can't convert object to primitive value");
	};

/***/ }),
/* 26 */
/***/ (function(module, exports) {

	module.exports = function(bitmap, value){
	  return {
	    enumerable  : !(bitmap & 1),
	    configurable: !(bitmap & 2),
	    writable    : !(bitmap & 4),
	    value       : value
	  };
	};

/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(17);

/***/ }),
/* 28 */
/***/ (function(module, exports) {

	var hasOwnProperty = {}.hasOwnProperty;
	module.exports = function(it, key){
	  return hasOwnProperty.call(it, key);
	};

/***/ }),
/* 29 */
/***/ (function(module, exports) {

	module.exports = {};

/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var create         = __webpack_require__(31)
	  , descriptor     = __webpack_require__(26)
	  , setToStringTag = __webpack_require__(46)
	  , IteratorPrototype = {};

	// 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
	__webpack_require__(17)(IteratorPrototype, __webpack_require__(47)('iterator'), function(){ return this; });

	module.exports = function(Constructor, NAME, next){
	  Constructor.prototype = create(IteratorPrototype, {next: descriptor(1, next)});
	  setToStringTag(Constructor, NAME + ' Iterator');
	};

/***/ }),
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
	var anObject    = __webpack_require__(19)
	  , dPs         = __webpack_require__(32)
	  , enumBugKeys = __webpack_require__(44)
	  , IE_PROTO    = __webpack_require__(41)('IE_PROTO')
	  , Empty       = function(){ /* empty */ }
	  , PROTOTYPE   = 'prototype';

	// Create object with fake `null` prototype: use iframe Object with cleared prototype
	var createDict = function(){
	  // Thrash, waste and sodomy: IE GC bug
	  var iframe = __webpack_require__(24)('iframe')
	    , i      = enumBugKeys.length
	    , lt     = '<'
	    , gt     = '>'
	    , iframeDocument;
	  iframe.style.display = 'none';
	  __webpack_require__(45).appendChild(iframe);
	  iframe.src = 'javascript:'; // eslint-disable-line no-script-url
	  // createDict = iframe.contentWindow.Object;
	  // html.removeChild(iframe);
	  iframeDocument = iframe.contentWindow.document;
	  iframeDocument.open();
	  iframeDocument.write(lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt);
	  iframeDocument.close();
	  createDict = iframeDocument.F;
	  while(i--)delete createDict[PROTOTYPE][enumBugKeys[i]];
	  return createDict();
	};

	module.exports = Object.create || function create(O, Properties){
	  var result;
	  if(O !== null){
	    Empty[PROTOTYPE] = anObject(O);
	    result = new Empty;
	    Empty[PROTOTYPE] = null;
	    // add "__proto__" for Object.getPrototypeOf polyfill
	    result[IE_PROTO] = O;
	  } else result = createDict();
	  return Properties === undefined ? result : dPs(result, Properties);
	};


/***/ }),
/* 32 */
/***/ (function(module, exports, __webpack_require__) {

	var dP       = __webpack_require__(18)
	  , anObject = __webpack_require__(19)
	  , getKeys  = __webpack_require__(33);

	module.exports = __webpack_require__(22) ? Object.defineProperties : function defineProperties(O, Properties){
	  anObject(O);
	  var keys   = getKeys(Properties)
	    , length = keys.length
	    , i = 0
	    , P;
	  while(length > i)dP.f(O, P = keys[i++], Properties[P]);
	  return O;
	};

/***/ }),
/* 33 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.14 / 15.2.3.14 Object.keys(O)
	var $keys       = __webpack_require__(34)
	  , enumBugKeys = __webpack_require__(44);

	module.exports = Object.keys || function keys(O){
	  return $keys(O, enumBugKeys);
	};

/***/ }),
/* 34 */
/***/ (function(module, exports, __webpack_require__) {

	var has          = __webpack_require__(28)
	  , toIObject    = __webpack_require__(35)
	  , arrayIndexOf = __webpack_require__(38)(false)
	  , IE_PROTO     = __webpack_require__(41)('IE_PROTO');

	module.exports = function(object, names){
	  var O      = toIObject(object)
	    , i      = 0
	    , result = []
	    , key;
	  for(key in O)if(key != IE_PROTO)has(O, key) && result.push(key);
	  // Don't enum bug & hidden keys
	  while(names.length > i)if(has(O, key = names[i++])){
	    ~arrayIndexOf(result, key) || result.push(key);
	  }
	  return result;
	};

/***/ }),
/* 35 */
/***/ (function(module, exports, __webpack_require__) {

	// to indexed object, toObject with fallback for non-array-like ES3 strings
	var IObject = __webpack_require__(36)
	  , defined = __webpack_require__(9);
	module.exports = function(it){
	  return IObject(defined(it));
	};

/***/ }),
/* 36 */
/***/ (function(module, exports, __webpack_require__) {

	// fallback for non-array-like ES3 and non-enumerable old V8 strings
	var cof = __webpack_require__(37);
	module.exports = Object('z').propertyIsEnumerable(0) ? Object : function(it){
	  return cof(it) == 'String' ? it.split('') : Object(it);
	};

/***/ }),
/* 37 */
/***/ (function(module, exports) {

	var toString = {}.toString;

	module.exports = function(it){
	  return toString.call(it).slice(8, -1);
	};

/***/ }),
/* 38 */
/***/ (function(module, exports, __webpack_require__) {

	// false -> Array#indexOf
	// true  -> Array#includes
	var toIObject = __webpack_require__(35)
	  , toLength  = __webpack_require__(39)
	  , toIndex   = __webpack_require__(40);
	module.exports = function(IS_INCLUDES){
	  return function($this, el, fromIndex){
	    var O      = toIObject($this)
	      , length = toLength(O.length)
	      , index  = toIndex(fromIndex, length)
	      , value;
	    // Array#includes uses SameValueZero equality algorithm
	    if(IS_INCLUDES && el != el)while(length > index){
	      value = O[index++];
	      if(value != value)return true;
	    // Array#toIndex ignores holes, Array#includes - not
	    } else for(;length > index; index++)if(IS_INCLUDES || index in O){
	      if(O[index] === el)return IS_INCLUDES || index || 0;
	    } return !IS_INCLUDES && -1;
	  };
	};

/***/ }),
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

	// 7.1.15 ToLength
	var toInteger = __webpack_require__(8)
	  , min       = Math.min;
	module.exports = function(it){
	  return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
	};

/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

	var toInteger = __webpack_require__(8)
	  , max       = Math.max
	  , min       = Math.min;
	module.exports = function(index, length){
	  index = toInteger(index);
	  return index < 0 ? max(index + length, 0) : min(index, length);
	};

/***/ }),
/* 41 */
/***/ (function(module, exports, __webpack_require__) {

	var shared = __webpack_require__(42)('keys')
	  , uid    = __webpack_require__(43);
	module.exports = function(key){
	  return shared[key] || (shared[key] = uid(key));
	};

/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

	var global = __webpack_require__(13)
	  , SHARED = '__core-js_shared__'
	  , store  = global[SHARED] || (global[SHARED] = {});
	module.exports = function(key){
	  return store[key] || (store[key] = {});
	};

/***/ }),
/* 43 */
/***/ (function(module, exports) {

	var id = 0
	  , px = Math.random();
	module.exports = function(key){
	  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
	};

/***/ }),
/* 44 */
/***/ (function(module, exports) {

	// IE 8- don't enum bug keys
	module.exports = (
	  'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
	).split(',');

/***/ }),
/* 45 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = __webpack_require__(13).document && document.documentElement;

/***/ }),
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

	var def = __webpack_require__(18).f
	  , has = __webpack_require__(28)
	  , TAG = __webpack_require__(47)('toStringTag');

	module.exports = function(it, tag, stat){
	  if(it && !has(it = stat ? it : it.prototype, TAG))def(it, TAG, {configurable: true, value: tag});
	};

/***/ }),
/* 47 */
/***/ (function(module, exports, __webpack_require__) {

	var store      = __webpack_require__(42)('wks')
	  , uid        = __webpack_require__(43)
	  , Symbol     = __webpack_require__(13).Symbol
	  , USE_SYMBOL = typeof Symbol == 'function';

	var $exports = module.exports = function(name){
	  return store[name] || (store[name] =
	    USE_SYMBOL && Symbol[name] || (USE_SYMBOL ? Symbol : uid)('Symbol.' + name));
	};

	$exports.store = store;

/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
	var has         = __webpack_require__(28)
	  , toObject    = __webpack_require__(49)
	  , IE_PROTO    = __webpack_require__(41)('IE_PROTO')
	  , ObjectProto = Object.prototype;

	module.exports = Object.getPrototypeOf || function(O){
	  O = toObject(O);
	  if(has(O, IE_PROTO))return O[IE_PROTO];
	  if(typeof O.constructor == 'function' && O instanceof O.constructor){
	    return O.constructor.prototype;
	  } return O instanceof Object ? ObjectProto : null;
	};

/***/ }),
/* 49 */
/***/ (function(module, exports, __webpack_require__) {

	// 7.1.13 ToObject(argument)
	var defined = __webpack_require__(9);
	module.exports = function(it){
	  return Object(defined(it));
	};

/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(51);
	var global        = __webpack_require__(13)
	  , hide          = __webpack_require__(17)
	  , Iterators     = __webpack_require__(29)
	  , TO_STRING_TAG = __webpack_require__(47)('toStringTag');

	for(var collections = ['NodeList', 'DOMTokenList', 'MediaList', 'StyleSheetList', 'CSSRuleList'], i = 0; i < 5; i++){
	  var NAME       = collections[i]
	    , Collection = global[NAME]
	    , proto      = Collection && Collection.prototype;
	  if(proto && !proto[TO_STRING_TAG])hide(proto, TO_STRING_TAG, NAME);
	  Iterators[NAME] = Iterators.Array;
	}

/***/ }),
/* 51 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var addToUnscopables = __webpack_require__(52)
	  , step             = __webpack_require__(53)
	  , Iterators        = __webpack_require__(29)
	  , toIObject        = __webpack_require__(35);

	// 22.1.3.4 Array.prototype.entries()
	// 22.1.3.13 Array.prototype.keys()
	// 22.1.3.29 Array.prototype.values()
	// 22.1.3.30 Array.prototype[@@iterator]()
	module.exports = __webpack_require__(10)(Array, 'Array', function(iterated, kind){
	  this._t = toIObject(iterated); // target
	  this._i = 0;                   // next index
	  this._k = kind;                // kind
	// 22.1.5.2.1 %ArrayIteratorPrototype%.next()
	}, function(){
	  var O     = this._t
	    , kind  = this._k
	    , index = this._i++;
	  if(!O || index >= O.length){
	    this._t = undefined;
	    return step(1);
	  }
	  if(kind == 'keys'  )return step(0, index);
	  if(kind == 'values')return step(0, O[index]);
	  return step(0, [index, O[index]]);
	}, 'values');

	// argumentsList[@@iterator] is %ArrayProto_values% (9.4.4.6, 9.4.4.7)
	Iterators.Arguments = Iterators.Array;

	addToUnscopables('keys');
	addToUnscopables('values');
	addToUnscopables('entries');

/***/ }),
/* 52 */
/***/ (function(module, exports) {

	module.exports = function(){ /* empty */ };

/***/ }),
/* 53 */
/***/ (function(module, exports) {

	module.exports = function(done, value){
	  return {value: value, done: !!done};
	};

/***/ }),
/* 54 */
/***/ (function(module, exports, __webpack_require__) {

	exports.f = __webpack_require__(47);

/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(56), __esModule: true };

/***/ }),
/* 56 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(57);
	__webpack_require__(68);
	__webpack_require__(69);
	__webpack_require__(70);
	module.exports = __webpack_require__(14).Symbol;

/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	// ECMAScript 6 symbols shim
	var global         = __webpack_require__(13)
	  , has            = __webpack_require__(28)
	  , DESCRIPTORS    = __webpack_require__(22)
	  , $export        = __webpack_require__(12)
	  , redefine       = __webpack_require__(27)
	  , META           = __webpack_require__(58).KEY
	  , $fails         = __webpack_require__(23)
	  , shared         = __webpack_require__(42)
	  , setToStringTag = __webpack_require__(46)
	  , uid            = __webpack_require__(43)
	  , wks            = __webpack_require__(47)
	  , wksExt         = __webpack_require__(54)
	  , wksDefine      = __webpack_require__(59)
	  , keyOf          = __webpack_require__(60)
	  , enumKeys       = __webpack_require__(61)
	  , isArray        = __webpack_require__(64)
	  , anObject       = __webpack_require__(19)
	  , toIObject      = __webpack_require__(35)
	  , toPrimitive    = __webpack_require__(25)
	  , createDesc     = __webpack_require__(26)
	  , _create        = __webpack_require__(31)
	  , gOPNExt        = __webpack_require__(65)
	  , $GOPD          = __webpack_require__(67)
	  , $DP            = __webpack_require__(18)
	  , $keys          = __webpack_require__(33)
	  , gOPD           = $GOPD.f
	  , dP             = $DP.f
	  , gOPN           = gOPNExt.f
	  , $Symbol        = global.Symbol
	  , $JSON          = global.JSON
	  , _stringify     = $JSON && $JSON.stringify
	  , PROTOTYPE      = 'prototype'
	  , HIDDEN         = wks('_hidden')
	  , TO_PRIMITIVE   = wks('toPrimitive')
	  , isEnum         = {}.propertyIsEnumerable
	  , SymbolRegistry = shared('symbol-registry')
	  , AllSymbols     = shared('symbols')
	  , OPSymbols      = shared('op-symbols')
	  , ObjectProto    = Object[PROTOTYPE]
	  , USE_NATIVE     = typeof $Symbol == 'function'
	  , QObject        = global.QObject;
	// Don't use setters in Qt Script, https://github.com/zloirock/core-js/issues/173
	var setter = !QObject || !QObject[PROTOTYPE] || !QObject[PROTOTYPE].findChild;

	// fallback for old Android, https://code.google.com/p/v8/issues/detail?id=687
	var setSymbolDesc = DESCRIPTORS && $fails(function(){
	  return _create(dP({}, 'a', {
	    get: function(){ return dP(this, 'a', {value: 7}).a; }
	  })).a != 7;
	}) ? function(it, key, D){
	  var protoDesc = gOPD(ObjectProto, key);
	  if(protoDesc)delete ObjectProto[key];
	  dP(it, key, D);
	  if(protoDesc && it !== ObjectProto)dP(ObjectProto, key, protoDesc);
	} : dP;

	var wrap = function(tag){
	  var sym = AllSymbols[tag] = _create($Symbol[PROTOTYPE]);
	  sym._k = tag;
	  return sym;
	};

	var isSymbol = USE_NATIVE && typeof $Symbol.iterator == 'symbol' ? function(it){
	  return typeof it == 'symbol';
	} : function(it){
	  return it instanceof $Symbol;
	};

	var $defineProperty = function defineProperty(it, key, D){
	  if(it === ObjectProto)$defineProperty(OPSymbols, key, D);
	  anObject(it);
	  key = toPrimitive(key, true);
	  anObject(D);
	  if(has(AllSymbols, key)){
	    if(!D.enumerable){
	      if(!has(it, HIDDEN))dP(it, HIDDEN, createDesc(1, {}));
	      it[HIDDEN][key] = true;
	    } else {
	      if(has(it, HIDDEN) && it[HIDDEN][key])it[HIDDEN][key] = false;
	      D = _create(D, {enumerable: createDesc(0, false)});
	    } return setSymbolDesc(it, key, D);
	  } return dP(it, key, D);
	};
	var $defineProperties = function defineProperties(it, P){
	  anObject(it);
	  var keys = enumKeys(P = toIObject(P))
	    , i    = 0
	    , l = keys.length
	    , key;
	  while(l > i)$defineProperty(it, key = keys[i++], P[key]);
	  return it;
	};
	var $create = function create(it, P){
	  return P === undefined ? _create(it) : $defineProperties(_create(it), P);
	};
	var $propertyIsEnumerable = function propertyIsEnumerable(key){
	  var E = isEnum.call(this, key = toPrimitive(key, true));
	  if(this === ObjectProto && has(AllSymbols, key) && !has(OPSymbols, key))return false;
	  return E || !has(this, key) || !has(AllSymbols, key) || has(this, HIDDEN) && this[HIDDEN][key] ? E : true;
	};
	var $getOwnPropertyDescriptor = function getOwnPropertyDescriptor(it, key){
	  it  = toIObject(it);
	  key = toPrimitive(key, true);
	  if(it === ObjectProto && has(AllSymbols, key) && !has(OPSymbols, key))return;
	  var D = gOPD(it, key);
	  if(D && has(AllSymbols, key) && !(has(it, HIDDEN) && it[HIDDEN][key]))D.enumerable = true;
	  return D;
	};
	var $getOwnPropertyNames = function getOwnPropertyNames(it){
	  var names  = gOPN(toIObject(it))
	    , result = []
	    , i      = 0
	    , key;
	  while(names.length > i){
	    if(!has(AllSymbols, key = names[i++]) && key != HIDDEN && key != META)result.push(key);
	  } return result;
	};
	var $getOwnPropertySymbols = function getOwnPropertySymbols(it){
	  var IS_OP  = it === ObjectProto
	    , names  = gOPN(IS_OP ? OPSymbols : toIObject(it))
	    , result = []
	    , i      = 0
	    , key;
	  while(names.length > i){
	    if(has(AllSymbols, key = names[i++]) && (IS_OP ? has(ObjectProto, key) : true))result.push(AllSymbols[key]);
	  } return result;
	};

	// 19.4.1.1 Symbol([description])
	if(!USE_NATIVE){
	  $Symbol = function Symbol(){
	    if(this instanceof $Symbol)throw TypeError('Symbol is not a constructor!');
	    var tag = uid(arguments.length > 0 ? arguments[0] : undefined);
	    var $set = function(value){
	      if(this === ObjectProto)$set.call(OPSymbols, value);
	      if(has(this, HIDDEN) && has(this[HIDDEN], tag))this[HIDDEN][tag] = false;
	      setSymbolDesc(this, tag, createDesc(1, value));
	    };
	    if(DESCRIPTORS && setter)setSymbolDesc(ObjectProto, tag, {configurable: true, set: $set});
	    return wrap(tag);
	  };
	  redefine($Symbol[PROTOTYPE], 'toString', function toString(){
	    return this._k;
	  });

	  $GOPD.f = $getOwnPropertyDescriptor;
	  $DP.f   = $defineProperty;
	  __webpack_require__(66).f = gOPNExt.f = $getOwnPropertyNames;
	  __webpack_require__(63).f  = $propertyIsEnumerable;
	  __webpack_require__(62).f = $getOwnPropertySymbols;

	  if(DESCRIPTORS && !__webpack_require__(11)){
	    redefine(ObjectProto, 'propertyIsEnumerable', $propertyIsEnumerable, true);
	  }

	  wksExt.f = function(name){
	    return wrap(wks(name));
	  }
	}

	$export($export.G + $export.W + $export.F * !USE_NATIVE, {Symbol: $Symbol});

	for(var symbols = (
	  // 19.4.2.2, 19.4.2.3, 19.4.2.4, 19.4.2.6, 19.4.2.8, 19.4.2.9, 19.4.2.10, 19.4.2.11, 19.4.2.12, 19.4.2.13, 19.4.2.14
	  'hasInstance,isConcatSpreadable,iterator,match,replace,search,species,split,toPrimitive,toStringTag,unscopables'
	).split(','), i = 0; symbols.length > i; )wks(symbols[i++]);

	for(var symbols = $keys(wks.store), i = 0; symbols.length > i; )wksDefine(symbols[i++]);

	$export($export.S + $export.F * !USE_NATIVE, 'Symbol', {
	  // 19.4.2.1 Symbol.for(key)
	  'for': function(key){
	    return has(SymbolRegistry, key += '')
	      ? SymbolRegistry[key]
	      : SymbolRegistry[key] = $Symbol(key);
	  },
	  // 19.4.2.5 Symbol.keyFor(sym)
	  keyFor: function keyFor(key){
	    if(isSymbol(key))return keyOf(SymbolRegistry, key);
	    throw TypeError(key + ' is not a symbol!');
	  },
	  useSetter: function(){ setter = true; },
	  useSimple: function(){ setter = false; }
	});

	$export($export.S + $export.F * !USE_NATIVE, 'Object', {
	  // 19.1.2.2 Object.create(O [, Properties])
	  create: $create,
	  // 19.1.2.4 Object.defineProperty(O, P, Attributes)
	  defineProperty: $defineProperty,
	  // 19.1.2.3 Object.defineProperties(O, Properties)
	  defineProperties: $defineProperties,
	  // 19.1.2.6 Object.getOwnPropertyDescriptor(O, P)
	  getOwnPropertyDescriptor: $getOwnPropertyDescriptor,
	  // 19.1.2.7 Object.getOwnPropertyNames(O)
	  getOwnPropertyNames: $getOwnPropertyNames,
	  // 19.1.2.8 Object.getOwnPropertySymbols(O)
	  getOwnPropertySymbols: $getOwnPropertySymbols
	});

	// 24.3.2 JSON.stringify(value [, replacer [, space]])
	$JSON && $export($export.S + $export.F * (!USE_NATIVE || $fails(function(){
	  var S = $Symbol();
	  // MS Edge converts symbol values to JSON as {}
	  // WebKit converts symbol values to JSON as null
	  // V8 throws on boxed symbols
	  return _stringify([S]) != '[null]' || _stringify({a: S}) != '{}' || _stringify(Object(S)) != '{}';
	})), 'JSON', {
	  stringify: function stringify(it){
	    if(it === undefined || isSymbol(it))return; // IE8 returns string on undefined
	    var args = [it]
	      , i    = 1
	      , replacer, $replacer;
	    while(arguments.length > i)args.push(arguments[i++]);
	    replacer = args[1];
	    if(typeof replacer == 'function')$replacer = replacer;
	    if($replacer || !isArray(replacer))replacer = function(key, value){
	      if($replacer)value = $replacer.call(this, key, value);
	      if(!isSymbol(value))return value;
	    };
	    args[1] = replacer;
	    return _stringify.apply($JSON, args);
	  }
	});

	// 19.4.3.4 Symbol.prototype[@@toPrimitive](hint)
	$Symbol[PROTOTYPE][TO_PRIMITIVE] || __webpack_require__(17)($Symbol[PROTOTYPE], TO_PRIMITIVE, $Symbol[PROTOTYPE].valueOf);
	// 19.4.3.5 Symbol.prototype[@@toStringTag]
	setToStringTag($Symbol, 'Symbol');
	// 20.2.1.9 Math[@@toStringTag]
	setToStringTag(Math, 'Math', true);
	// 24.3.3 JSON[@@toStringTag]
	setToStringTag(global.JSON, 'JSON', true);

/***/ }),
/* 58 */
/***/ (function(module, exports, __webpack_require__) {

	var META     = __webpack_require__(43)('meta')
	  , isObject = __webpack_require__(20)
	  , has      = __webpack_require__(28)
	  , setDesc  = __webpack_require__(18).f
	  , id       = 0;
	var isExtensible = Object.isExtensible || function(){
	  return true;
	};
	var FREEZE = !__webpack_require__(23)(function(){
	  return isExtensible(Object.preventExtensions({}));
	});
	var setMeta = function(it){
	  setDesc(it, META, {value: {
	    i: 'O' + ++id, // object ID
	    w: {}          // weak collections IDs
	  }});
	};
	var fastKey = function(it, create){
	  // return primitive with prefix
	  if(!isObject(it))return typeof it == 'symbol' ? it : (typeof it == 'string' ? 'S' : 'P') + it;
	  if(!has(it, META)){
	    // can't set metadata to uncaught frozen object
	    if(!isExtensible(it))return 'F';
	    // not necessary to add metadata
	    if(!create)return 'E';
	    // add missing metadata
	    setMeta(it);
	  // return object ID
	  } return it[META].i;
	};
	var getWeak = function(it, create){
	  if(!has(it, META)){
	    // can't set metadata to uncaught frozen object
	    if(!isExtensible(it))return true;
	    // not necessary to add metadata
	    if(!create)return false;
	    // add missing metadata
	    setMeta(it);
	  // return hash weak collections IDs
	  } return it[META].w;
	};
	// add metadata on freeze-family methods calling
	var onFreeze = function(it){
	  if(FREEZE && meta.NEED && isExtensible(it) && !has(it, META))setMeta(it);
	  return it;
	};
	var meta = module.exports = {
	  KEY:      META,
	  NEED:     false,
	  fastKey:  fastKey,
	  getWeak:  getWeak,
	  onFreeze: onFreeze
	};

/***/ }),
/* 59 */
/***/ (function(module, exports, __webpack_require__) {

	var global         = __webpack_require__(13)
	  , core           = __webpack_require__(14)
	  , LIBRARY        = __webpack_require__(11)
	  , wksExt         = __webpack_require__(54)
	  , defineProperty = __webpack_require__(18).f;
	module.exports = function(name){
	  var $Symbol = core.Symbol || (core.Symbol = LIBRARY ? {} : global.Symbol || {});
	  if(name.charAt(0) != '_' && !(name in $Symbol))defineProperty($Symbol, name, {value: wksExt.f(name)});
	};

/***/ }),
/* 60 */
/***/ (function(module, exports, __webpack_require__) {

	var getKeys   = __webpack_require__(33)
	  , toIObject = __webpack_require__(35);
	module.exports = function(object, el){
	  var O      = toIObject(object)
	    , keys   = getKeys(O)
	    , length = keys.length
	    , index  = 0
	    , key;
	  while(length > index)if(O[key = keys[index++]] === el)return key;
	};

/***/ }),
/* 61 */
/***/ (function(module, exports, __webpack_require__) {

	// all enumerable object keys, includes symbols
	var getKeys = __webpack_require__(33)
	  , gOPS    = __webpack_require__(62)
	  , pIE     = __webpack_require__(63);
	module.exports = function(it){
	  var result     = getKeys(it)
	    , getSymbols = gOPS.f;
	  if(getSymbols){
	    var symbols = getSymbols(it)
	      , isEnum  = pIE.f
	      , i       = 0
	      , key;
	    while(symbols.length > i)if(isEnum.call(it, key = symbols[i++]))result.push(key);
	  } return result;
	};

/***/ }),
/* 62 */
/***/ (function(module, exports) {

	exports.f = Object.getOwnPropertySymbols;

/***/ }),
/* 63 */
/***/ (function(module, exports) {

	exports.f = {}.propertyIsEnumerable;

/***/ }),
/* 64 */
/***/ (function(module, exports, __webpack_require__) {

	// 7.2.2 IsArray(argument)
	var cof = __webpack_require__(37);
	module.exports = Array.isArray || function isArray(arg){
	  return cof(arg) == 'Array';
	};

/***/ }),
/* 65 */
/***/ (function(module, exports, __webpack_require__) {

	// fallback for IE11 buggy Object.getOwnPropertyNames with iframe and window
	var toIObject = __webpack_require__(35)
	  , gOPN      = __webpack_require__(66).f
	  , toString  = {}.toString;

	var windowNames = typeof window == 'object' && window && Object.getOwnPropertyNames
	  ? Object.getOwnPropertyNames(window) : [];

	var getWindowNames = function(it){
	  try {
	    return gOPN(it);
	  } catch(e){
	    return windowNames.slice();
	  }
	};

	module.exports.f = function getOwnPropertyNames(it){
	  return windowNames && toString.call(it) == '[object Window]' ? getWindowNames(it) : gOPN(toIObject(it));
	};


/***/ }),
/* 66 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.7 / 15.2.3.4 Object.getOwnPropertyNames(O)
	var $keys      = __webpack_require__(34)
	  , hiddenKeys = __webpack_require__(44).concat('length', 'prototype');

	exports.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O){
	  return $keys(O, hiddenKeys);
	};

/***/ }),
/* 67 */
/***/ (function(module, exports, __webpack_require__) {

	var pIE            = __webpack_require__(63)
	  , createDesc     = __webpack_require__(26)
	  , toIObject      = __webpack_require__(35)
	  , toPrimitive    = __webpack_require__(25)
	  , has            = __webpack_require__(28)
	  , IE8_DOM_DEFINE = __webpack_require__(21)
	  , gOPD           = Object.getOwnPropertyDescriptor;

	exports.f = __webpack_require__(22) ? gOPD : function getOwnPropertyDescriptor(O, P){
	  O = toIObject(O);
	  P = toPrimitive(P, true);
	  if(IE8_DOM_DEFINE)try {
	    return gOPD(O, P);
	  } catch(e){ /* empty */ }
	  if(has(O, P))return createDesc(!pIE.f.call(O, P), O[P]);
	};

/***/ }),
/* 68 */
/***/ (function(module, exports) {

	

/***/ }),
/* 69 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(59)('asyncIterator');

/***/ }),
/* 70 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(59)('observable');

/***/ }),
/* 71 */
/***/ (function(module, exports) {

	var Helpers, h;

	Helpers = (function() {
	  Helpers.prototype.NS = 'http://www.w3.org/2000/svg';

	  Helpers.prototype.logBadgeCss = 'background:#3A0839;color:#FF512F;border-radius:5px; padding: 1px 5px 2px; border: 1px solid #FF512F;';

	  Helpers.prototype.shortColors = {
	    transparent: 'rgba(0,0,0,0)',
	    none: 'rgba(0,0,0,0)',
	    aqua: 'rgb(0,255,255)',
	    black: 'rgb(0,0,0)',
	    blue: 'rgb(0,0,255)',
	    fuchsia: 'rgb(255,0,255)',
	    gray: 'rgb(128,128,128)',
	    green: 'rgb(0,128,0)',
	    lime: 'rgb(0,255,0)',
	    maroon: 'rgb(128,0,0)',
	    navy: 'rgb(0,0,128)',
	    olive: 'rgb(128,128,0)',
	    purple: 'rgb(128,0,128)',
	    red: 'rgb(255,0,0)',
	    silver: 'rgb(192,192,192)',
	    teal: 'rgb(0,128,128)',
	    white: 'rgb(255,255,255)',
	    yellow: 'rgb(255,255,0)',
	    orange: 'rgb(255,128,0)'
	  };

	  Helpers.prototype.chainOptionMap = {};

	  Helpers.prototype.callbacksMap = {
	    onRefresh: 1,
	    onStart: 1,
	    onComplete: 1,
	    onFirstUpdate: 1,
	    onUpdate: 1,
	    onProgress: 1,
	    onRepeatStart: 1,
	    onRepeatComplete: 1,
	    onPlaybackStart: 1,
	    onPlaybackPause: 1,
	    onPlaybackStop: 1,
	    onPlaybackComplete: 1
	  };

	  Helpers.prototype.tweenOptionMap = {
	    duration: 1,
	    delay: 1,
	    speed: 1,
	    repeat: 1,
	    easing: 1,
	    backwardEasing: 1,
	    isYoyo: 1,
	    shiftTime: 1,
	    isReversed: 1,
	    callbacksContext: 1
	  };

	  Helpers.prototype.unitOptionMap = {
	    left: 1,
	    top: 1,
	    x: 1,
	    y: 1,
	    rx: 1,
	    ry: 1
	  };

	  Helpers.prototype.RAD_TO_DEG = 180 / Math.PI;

	  function Helpers() {
	    this.vars();
	  }

	  Helpers.prototype.vars = function() {
	    var ua;
	    this.prefix = this.getPrefix();
	    this.getRemBase();
	    this.isFF = this.prefix.lowercase === 'moz';
	    this.isIE = this.prefix.lowercase === 'ms';
	    ua = navigator.userAgent;
	    this.isOldOpera = ua.match(/presto/gim);
	    this.isSafari = ua.indexOf('Safari') > -1;
	    this.isChrome = ua.indexOf('Chrome') > -1;
	    this.isOpera = ua.toLowerCase().indexOf("op") > -1;
	    this.isChrome && this.isSafari && (this.isSafari = false);
	    (ua.match(/PhantomJS/gim)) && (this.isSafari = false);
	    this.isChrome && this.isOpera && (this.isChrome = false);
	    this.is3d = this.checkIf3d();
	    this.uniqIDs = -1;
	    this.div = document.createElement('div');
	    document.body.appendChild(this.div);
	    return this.defaultStyles = this.computedStyle(this.div);
	  };

	  Helpers.prototype.cloneObj = function(obj, exclude) {
	    var i, key, keys, newObj;
	    keys = Object.keys(obj);
	    newObj = {};
	    i = keys.length;
	    while (i--) {
	      key = keys[i];
	      if (exclude != null) {
	        if (!exclude[key]) {
	          newObj[key] = obj[key];
	        }
	      } else {
	        newObj[key] = obj[key];
	      }
	    }
	    return newObj;
	  };

	  Helpers.prototype.extend = function(objTo, objFrom) {
	    var key, value;
	    for (key in objFrom) {
	      value = objFrom[key];
	      if (objTo[key] == null) {
	        objTo[key] = objFrom[key];
	      }
	    }
	    return objTo;
	  };

	  Helpers.prototype.getRemBase = function() {
	    var html, style;
	    html = document.querySelector('html');
	    style = getComputedStyle(html);
	    return this.remBase = parseFloat(style.fontSize);
	  };

	  Helpers.prototype.clamp = function(value, min, max) {
	    if (value < min) {
	      return min;
	    } else if (value > max) {
	      return max;
	    } else {
	      return value;
	    }
	  };

	  Helpers.prototype.setPrefixedStyle = function(el, name, value) {
	    (name === 'transform') && (el.style["" + this.prefix.css + name] = value);
	    return el.style[name] = value;
	  };

	  Helpers.prototype.style = function(el, name, value) {
	    var key, keys, len, results;
	    if (typeof name === 'object') {
	      keys = Object.keys(name);
	      len = keys.length;
	      results = [];
	      while (len--) {
	        key = keys[len];
	        value = name[key];
	        results.push(this.setPrefixedStyle(el, key, value));
	      }
	      return results;
	    } else {
	      return this.setPrefixedStyle(el, name, value);
	    }
	  };

	  Helpers.prototype.prepareForLog = function(args) {
	    args = Array.prototype.slice.apply(args);
	    args.unshift('::');
	    args.unshift(this.logBadgeCss);
	    args.unshift('%cmo·js%c');
	    return args;
	  };

	  Helpers.prototype.log = function() {
	    if (mojs.isDebug === false) {
	      return;
	    }
	    return console.log.apply(console, this.prepareForLog(arguments));
	  };

	  Helpers.prototype.warn = function() {
	    if (mojs.isDebug === false) {
	      return;
	    }
	    return console.warn.apply(console, this.prepareForLog(arguments));
	  };

	  Helpers.prototype.error = function() {
	    if (mojs.isDebug === false) {
	      return;
	    }
	    return console.error.apply(console, this.prepareForLog(arguments));
	  };

	  Helpers.prototype.parseUnit = function(value) {
	    var amount, isStrict, ref, regex, returnVal, unit;
	    if (typeof value === 'number') {
	      return returnVal = {
	        unit: 'px',
	        isStrict: false,
	        value: value,
	        string: value === 0 ? "" + value : value + "px"
	      };
	    } else if (typeof value === 'string') {
	      regex = /px|%|rem|em|ex|cm|ch|mm|in|pt|pc|vh|vw|vmin|deg/gim;
	      unit = (ref = value.match(regex)) != null ? ref[0] : void 0;
	      isStrict = true;
	      if (!unit) {
	        unit = 'px';
	        isStrict = false;
	      }
	      amount = parseFloat(value);
	      return returnVal = {
	        unit: unit,
	        isStrict: isStrict,
	        value: amount,
	        string: amount === 0 ? "" + amount : "" + amount + unit
	      };
	    }
	    return value;
	  };

	  Helpers.prototype.bind = function(func, context) {
	    var bindArgs, wrapper;
	    wrapper = function() {
	      var args, unshiftArgs;
	      args = Array.prototype.slice.call(arguments);
	      unshiftArgs = bindArgs.concat(args);
	      return func.apply(context, unshiftArgs);
	    };
	    bindArgs = Array.prototype.slice.call(arguments, 2);
	    return wrapper;
	  };

	  Helpers.prototype.getRadialPoint = function(o) {
	    var point, radAngle, radiusX, radiusY;
	    if (o == null) {
	      o = {};
	    }
	    radAngle = (o.angle - 90) * 0.017453292519943295;
	    radiusX = o.radiusX != null ? o.radiusX : o.radius;
	    radiusY = o.radiusY != null ? o.radiusY : o.radius;
	    return point = {
	      x: o.center.x + (Math.cos(radAngle) * radiusX),
	      y: o.center.y + (Math.sin(radAngle) * radiusY)
	    };
	  };

	  Helpers.prototype.getPrefix = function() {
	    var dom, pre, styles, v;
	    styles = window.getComputedStyle(document.documentElement, "");
	    v = Array.prototype.slice.call(styles).join("").match(/-(moz|webkit|ms)-/);
	    pre = (v || (styles.OLink === "" && ["", "o"]))[1];
	    dom = "WebKit|Moz|MS|O".match(new RegExp("(" + pre + ")", "i"))[1];
	    return {
	      dom: dom,
	      lowercase: pre,
	      css: "-" + pre + "-",
	      js: pre[0].toUpperCase() + pre.substr(1)
	    };
	  };

	  Helpers.prototype.strToArr = function(string) {
	    var arr;
	    arr = [];
	    if (typeof string === 'number' && !isNaN(string)) {
	      arr.push(this.parseUnit(string));
	      return arr;
	    }
	    string.trim().split(/\s+/gim).forEach((function(_this) {
	      return function(str) {
	        return arr.push(_this.parseUnit(_this.parseIfRand(str)));
	      };
	    })(this));
	    return arr;
	  };

	  Helpers.prototype.calcArrDelta = function(arr1, arr2) {
	    var delta, i, j, len1, num;
	    delta = [];
	    for (i = j = 0, len1 = arr1.length; j < len1; i = ++j) {
	      num = arr1[i];
	      delta[i] = this.parseUnit("" + (arr2[i].value - arr1[i].value) + arr2[i].unit);
	    }
	    return delta;
	  };

	  Helpers.prototype.isArray = function(variable) {
	    return variable instanceof Array;
	  };

	  Helpers.prototype.normDashArrays = function(arr1, arr2) {
	    var arr1Len, arr2Len, currItem, i, j, k, lenDiff, ref, ref1, startI;
	    arr1Len = arr1.length;
	    arr2Len = arr2.length;
	    if (arr1Len > arr2Len) {
	      lenDiff = arr1Len - arr2Len;
	      startI = arr2.length;
	      for (i = j = 0, ref = lenDiff; 0 <= ref ? j < ref : j > ref; i = 0 <= ref ? ++j : --j) {
	        currItem = i + startI;
	        arr2.push(this.parseUnit("0" + arr1[currItem].unit));
	      }
	    } else if (arr2Len > arr1Len) {
	      lenDiff = arr2Len - arr1Len;
	      startI = arr1.length;
	      for (i = k = 0, ref1 = lenDiff; 0 <= ref1 ? k < ref1 : k > ref1; i = 0 <= ref1 ? ++k : --k) {
	        currItem = i + startI;
	        arr1.push(this.parseUnit("0" + arr2[currItem].unit));
	      }
	    }
	    return [arr1, arr2];
	  };

	  Helpers.prototype.makeColorObj = function(color) {
	    var alpha, b, colorObj, g, isRgb, r, regexString1, regexString2, result, rgbColor;
	    if (color[0] === '#') {
	      result = /^#?([a-f\d]{1,2})([a-f\d]{1,2})([a-f\d]{1,2})$/i.exec(color);
	      colorObj = {};
	      if (result) {
	        r = result[1].length === 2 ? result[1] : result[1] + result[1];
	        g = result[2].length === 2 ? result[2] : result[2] + result[2];
	        b = result[3].length === 2 ? result[3] : result[3] + result[3];
	        colorObj = {
	          r: parseInt(r, 16),
	          g: parseInt(g, 16),
	          b: parseInt(b, 16),
	          a: 1
	        };
	      }
	    }
	    if (color[0] !== '#') {
	      isRgb = color[0] === 'r' && color[1] === 'g' && color[2] === 'b';
	      if (isRgb) {
	        rgbColor = color;
	      }
	      if (!isRgb) {
	        rgbColor = !this.shortColors[color] ? (this.div.style.color = color, this.computedStyle(this.div).color) : this.shortColors[color];
	      }
	      regexString1 = '^rgba?\\((\\d{1,3}),\\s?(\\d{1,3}),';
	      regexString2 = '\\s?(\\d{1,3}),?\\s?(\\d{1}|0?\\.\\d{1,})?\\)$';
	      result = new RegExp(regexString1 + regexString2, 'gi').exec(rgbColor);
	      colorObj = {};
	      alpha = parseFloat(result[4] || 1);
	      if (result) {
	        colorObj = {
	          r: parseInt(result[1], 10),
	          g: parseInt(result[2], 10),
	          b: parseInt(result[3], 10),
	          a: (alpha != null) && !isNaN(alpha) ? alpha : 1
	        };
	      }
	    }
	    return colorObj;
	  };

	  Helpers.prototype.computedStyle = function(el) {
	    return getComputedStyle(el);
	  };

	  Helpers.prototype.capitalize = function(str) {
	    if (typeof str !== 'string') {
	      throw Error('String expected - nothing to capitalize');
	    }
	    return str.charAt(0).toUpperCase() + str.substring(1);
	  };

	  Helpers.prototype.parseRand = function(string) {
	    var rand, randArr, units;
	    randArr = string.split(/rand\(|\,|\)/);
	    units = this.parseUnit(randArr[2]);
	    rand = this.rand(parseFloat(randArr[1]), parseFloat(randArr[2]));
	    if (units.unit && randArr[2].match(units.unit)) {
	      return rand + units.unit;
	    } else {
	      return rand;
	    }
	  };

	  Helpers.prototype.parseStagger = function(string, index) {
	    var base, number, splittedValue, unit, unitValue, value;
	    value = string.split(/stagger\(|\)$/)[1].toLowerCase();
	    splittedValue = value.split(/(rand\(.*?\)|[^\(,\s]+)(?=\s*,|\s*$)/gim);
	    value = splittedValue.length > 3 ? (base = this.parseUnit(this.parseIfRand(splittedValue[1])), splittedValue[3]) : (base = this.parseUnit(0), splittedValue[1]);
	    value = this.parseIfRand(value);
	    unitValue = this.parseUnit(value);
	    number = index * unitValue.value + base.value;
	    unit = base.isStrict ? base.unit : unitValue.isStrict ? unitValue.unit : '';
	    if (unit) {
	      return "" + number + unit;
	    } else {
	      return number;
	    }
	  };

	  Helpers.prototype.parseIfStagger = function(value, i) {
	    if (!(typeof value === 'string' && value.match(/stagger/g))) {
	      return value;
	    } else {
	      return this.parseStagger(value, i);
	    }
	  };

	  Helpers.prototype.parseIfRand = function(str) {
	    if (typeof str === 'string' && str.match(/rand\(/)) {
	      return this.parseRand(str);
	    } else {
	      return str;
	    }
	  };

	  Helpers.prototype.parseDelta = function(key, value, index) {
	    var curve, delta, easing, end, endArr, endColorObj, i, j, len1, start, startArr, startColorObj;
	    value = this.cloneObj(value);
	    easing = value.easing;
	    if (easing != null) {
	      easing = mojs.easing.parseEasing(easing);
	    }
	    delete value.easing;
	    curve = value.curve;
	    if (curve != null) {
	      curve = mojs.easing.parseEasing(curve);
	    }
	    delete value.curve;
	    start = Object.keys(value)[0];
	    end = value[start];
	    delta = {
	      start: start
	    };
	    if (isNaN(parseFloat(start)) && !start.match(/rand\(/) && !start.match(/stagger\(/)) {
	      if (key === 'strokeLinecap') {
	        this.warn("Sorry, stroke-linecap property is not animatable yet, using the start(" + start + ") value instead", value);
	        return delta;
	      }
	      startColorObj = this.makeColorObj(start);
	      endColorObj = this.makeColorObj(end);
	      delta = {
	        type: 'color',
	        name: key,
	        start: startColorObj,
	        end: endColorObj,
	        easing: easing,
	        curve: curve,
	        delta: {
	          r: endColorObj.r - startColorObj.r,
	          g: endColorObj.g - startColorObj.g,
	          b: endColorObj.b - startColorObj.b,
	          a: endColorObj.a - startColorObj.a
	        }
	      };
	    } else if (key === 'strokeDasharray' || key === 'strokeDashoffset' || key === 'origin') {
	      startArr = this.strToArr(start);
	      endArr = this.strToArr(end);
	      this.normDashArrays(startArr, endArr);
	      for (i = j = 0, len1 = startArr.length; j < len1; i = ++j) {
	        start = startArr[i];
	        end = endArr[i];
	        this.mergeUnits(start, end, key);
	      }
	      delta = {
	        type: 'array',
	        name: key,
	        start: startArr,
	        end: endArr,
	        delta: this.calcArrDelta(startArr, endArr),
	        easing: easing,
	        curve: curve
	      };
	    } else {
	      if (!this.callbacksMap[key] && !this.tweenOptionMap[key]) {
	        if (this.unitOptionMap[key]) {
	          end = this.parseUnit(this.parseStringOption(end, index));
	          start = this.parseUnit(this.parseStringOption(start, index));
	          this.mergeUnits(start, end, key);
	          delta = {
	            type: 'unit',
	            name: key,
	            start: start,
	            end: end,
	            delta: end.value - start.value,
	            easing: easing,
	            curve: curve
	          };
	        } else {
	          end = parseFloat(this.parseStringOption(end, index));
	          start = parseFloat(this.parseStringOption(start, index));
	          delta = {
	            type: 'number',
	            name: key,
	            start: start,
	            end: end,
	            delta: end - start,
	            easing: easing,
	            curve: curve
	          };
	        }
	      }
	    }
	    return delta;
	  };

	  Helpers.prototype.mergeUnits = function(start, end, key) {
	    if (!end.isStrict && start.isStrict) {
	      end.unit = start.unit;
	      return end.string = "" + end.value + end.unit;
	    } else if (end.isStrict && !start.isStrict) {
	      start.unit = end.unit;
	      return start.string = "" + start.value + start.unit;
	    } else if (end.isStrict && start.isStrict) {
	      if (end.unit !== start.unit) {
	        start.unit = end.unit;
	        start.string = "" + start.value + start.unit;
	        return this.warn("Two different units were specified on \"" + key + "\" delta property, mo · js will fallback to end \"" + end.unit + "\" unit ");
	      }
	    }
	  };

	  Helpers.prototype.rand = function(min, max) {
	    return (Math.random() * (max - min)) + min;
	  };

	  Helpers.prototype.isDOM = function(o) {
	    var isNode;
	    if (o == null) {
	      return false;
	    }
	    isNode = typeof o.nodeType === 'number' && typeof o.nodeName === 'string';
	    return typeof o === 'object' && isNode;
	  };

	  Helpers.prototype.getChildElements = function(element) {
	    var childNodes, children, i;
	    childNodes = element.childNodes;
	    children = [];
	    i = childNodes.length;
	    while (i--) {
	      if (childNodes[i].nodeType === 1) {
	        children.unshift(childNodes[i]);
	      }
	    }
	    return children;
	  };

	  Helpers.prototype.delta = function(start, end) {
	    var isType1, isType2, obj, type1, type2;
	    type1 = typeof start;
	    type2 = typeof end;
	    isType1 = type1 === 'string' || type1 === 'number' && !isNaN(start);
	    isType2 = type2 === 'string' || type2 === 'number' && !isNaN(end);
	    if (!isType1 || !isType2) {
	      this.error("delta method expects Strings or Numbers at input but got - " + start + ", " + end);
	      return;
	    }
	    obj = {};
	    obj[start] = end;
	    return obj;
	  };

	  Helpers.prototype.getUniqID = function() {
	    return ++this.uniqIDs;
	  };

	  Helpers.prototype.parsePath = function(path) {
	    var domPath;
	    if (typeof path === 'string') {
	      if (path.charAt(0).toLowerCase() === 'm') {
	        domPath = document.createElementNS(this.NS, 'path');
	        domPath.setAttributeNS(null, 'd', path);
	        return domPath;
	      } else {
	        return document.querySelector(path);
	      }
	    }
	    if (path.style) {
	      return path;
	    }
	  };

	  Helpers.prototype.closeEnough = function(num1, num2, eps) {
	    return Math.abs(num1 - num2) < eps;
	  };

	  Helpers.prototype.checkIf3d = function() {
	    var div, prefixed, style, tr;
	    div = document.createElement('div');
	    this.style(div, 'transform', 'translateZ(0)');
	    style = div.style;
	    prefixed = this.prefix.css + "transform";
	    tr = style[prefixed] != null ? style[prefixed] : style.transform;
	    return tr !== '';
	  };


	  /*
	    Method to check if variable holds pointer to an object.
	    @param {Any} Variable to test
	    @returns {Boolean} If variable is object.
	   */

	  Helpers.prototype.isObject = function(variable) {
	    return variable !== null && typeof variable === 'object';
	  };


	  /*
	    Method to get first value of the object.
	    Used to get end value on ∆s.
	    @param {Object} Object to get the value of.
	    @returns {Any} The value of the first object' property.
	   */

	  Helpers.prototype.getDeltaEnd = function(obj) {
	    var key;
	    key = Object.keys(obj)[0];
	    return obj[key];
	  };


	  /*
	    Method to get first key of the object.
	    Used to get start value on ∆s.
	    @param {Object} Object to get the value of.
	    @returns {String} The key of the first object' property.
	   */

	  Helpers.prototype.getDeltaStart = function(obj) {
	    var key;
	    key = Object.keys(obj)[0];
	    return key;
	  };


	  /*
	    Method to check if propery exists in callbacksMap or tweenOptionMap.
	    @param {String} Property name to check for
	    @returns {Boolean} If property is tween property.
	   */

	  Helpers.prototype.isTweenProp = function(keyName) {
	    return this.tweenOptionMap[keyName] || this.callbacksMap[keyName];
	  };


	  /*
	    Method to parse string property value
	    which can include both `rand` and `stagger `
	    value in various positions.
	    @param {String} Property name to check for.
	    @param {Number} Optional index for stagger.
	    @returns {Number} Parsed option value.
	   */

	  Helpers.prototype.parseStringOption = function(value, index) {
	    if (index == null) {
	      index = 0;
	    }
	    if (typeof value === 'string') {
	      value = this.parseIfStagger(value, index);
	      value = this.parseIfRand(value);
	    }
	    return value;
	  };


	  /*
	    Method to get the last item of array.
	    @private
	    @param {Array} Array to get the last item in.
	    @returns {Any} The last item of array.
	   */

	  Helpers.prototype.getLastItem = function(arr) {
	    return arr[arr.length - 1];
	  };


	  /*
	    Method parse HTMLElement.
	    @private
	    @param {String, Object} Selector string or HTMLElement.
	    @returns {Object} HTMLElement.
	   */

	  Helpers.prototype.parseEl = function(el) {
	    if (h.isDOM(el)) {
	      return el;
	    } else if (typeof el === 'string') {
	      el = document.querySelector(el);
	    }
	    if (el === null) {
	      h.error("Can't parse HTML element: ", el);
	    }
	    return el;
	  };


	  /*
	    Method force compositor layer on HTMLElement.
	    @private
	    @param {Object} HTMLElement.
	    @returns {Object} HTMLElement.
	   */

	  Helpers.prototype.force3d = function(el) {
	    this.setPrefixedStyle(el, 'backface-visibility', 'hidden');
	    return el;
	  };


	  /*
	    Method to check if value is delta.
	    @private
	    @param {Any} Property to check.
	    @returns {Boolean} If value is delta.
	   */

	  Helpers.prototype.isDelta = function(optionsValue) {
	    var isObject;
	    isObject = this.isObject(optionsValue);
	    isObject = isObject && !optionsValue.unit;
	    return !(!isObject || this.isArray(optionsValue) || this.isDOM(optionsValue));
	  };

	  return Helpers;

	})();

	h = new Helpers;

	module.exports = h;


/***/ }),
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

	var Bit, BitsMap, Circle, Cross, Curve, Custom, Equal, Line, Polygon, Rect, Zigzag, h;

	Bit = __webpack_require__(73)["default"] || __webpack_require__(73);

	Custom = __webpack_require__(85)["default"] || __webpack_require__(85);

	Circle = __webpack_require__(86);

	Line = __webpack_require__(87);

	Zigzag = __webpack_require__(88);

	Rect = __webpack_require__(89);

	Polygon = __webpack_require__(90);

	Cross = __webpack_require__(91);

	Curve = __webpack_require__(92)["default"] || __webpack_require__(92);

	Equal = __webpack_require__(93);

	h = __webpack_require__(71);

	BitsMap = (function() {
	  function BitsMap() {
	    this.addShape = h.bind(this.addShape, this);
	  }

	  BitsMap.prototype.bit = Bit;

	  BitsMap.prototype.custom = Custom;

	  BitsMap.prototype.circle = Circle;

	  BitsMap.prototype.line = Line;

	  BitsMap.prototype.zigzag = Zigzag;

	  BitsMap.prototype.rect = Rect;

	  BitsMap.prototype.polygon = Polygon;

	  BitsMap.prototype.cross = Cross;

	  BitsMap.prototype.equal = Equal;

	  BitsMap.prototype.curve = Curve;

	  BitsMap.prototype.getShape = function(name) {
	    return this[name] || h.error("no \"" + name + "\" shape available yet, please choose from this list:", ['circle', 'line', 'zigzag', 'rect', 'polygon', 'cross', 'equal', 'curve']);
	  };


	  /*
	    Method to add shape to the map.
	    @public
	    @param {String} Name of the shape module.
	    @param {Object} Shape module class.
	   */

	  BitsMap.prototype.addShape = function(name, Module) {
	    return this[name] = Module;
	  };

	  return BitsMap;

	})();

	module.exports = new BitsMap;


/***/ }),
/* 73 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _typeof2 = __webpack_require__(3);

	var _typeof3 = _interopRequireDefault(_typeof2);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _module = __webpack_require__(84);

	var _module2 = _interopRequireDefault(_module);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var Bit = function (_Module) {
	  (0, _inherits3.default)(Bit, _Module);

	  function Bit() {
	    (0, _classCallCheck3.default)(this, Bit);
	    return (0, _possibleConstructorReturn3.default)(this, _Module.apply(this, arguments));
	  }

	  /*
	    Method to declare module's defaults.
	    @private
	  */
	  Bit.prototype._declareDefaults = function _declareDefaults() {
	    this._defaults = {
	      'ns': 'http://www.w3.org/2000/svg',
	      'tag': 'ellipse',
	      'parent': document.body,
	      'ratio': 1,
	      'radius': 50,
	      'radiusX': null,
	      'radiusY': null,
	      'stroke': 'hotpink',
	      'stroke-dasharray': '',
	      'stroke-dashoffset': '',
	      'stroke-linecap': '',
	      'stroke-width': 2,
	      'stroke-opacity': 1,
	      'fill': 'transparent',
	      'fill-opacity': 1,
	      'width': 0,
	      'height': 0
	    };
	    this._drawMap = ['stroke', 'stroke-width', 'stroke-opacity', 'stroke-dasharray', 'fill', 'stroke-dashoffset', 'stroke-linecap', 'fill-opacity', 'transform'];
	  };

	  Bit.prototype._vars = function _vars() {
	    this._state = {};
	    this._drawMapLength = this._drawMap.length;
	  };
	  /*
	    Method for initial render of the shape.
	    @private
	  */


	  Bit.prototype._render = function _render() {
	    if (this._isRendered) {
	      return;
	    }
	    // set `_isRendered` hatch
	    this._isRendered = true;
	    // create `SVG` canvas to draw in
	    this._createSVGCanvas();
	    // set canvas size
	    this._setCanvasSize();
	    // draw the initial state
	    // this._draw();
	    // append the canvas to the parent from props
	    this._props.parent.appendChild(this._canvas);
	  };
	  /*
	    Method to create `SVG` canvas to draw in.
	    @private
	  */


	  Bit.prototype._createSVGCanvas = function _createSVGCanvas() {
	    var p = this._props;
	    // create canvas - `svg` element to draw in
	    this._canvas = document.createElementNS(p.ns, 'svg');
	    // create the element shape element and add it to the canvas
	    this.el = document.createElementNS(p.ns, p.tag);
	    this._canvas.appendChild(this.el);
	  };
	  /*
	    Method to set size of the _canvas.
	    @private
	  */


	  Bit.prototype._setCanvasSize = function _setCanvasSize() {
	    var p = this._props,
	        style = this._canvas.style;

	    style.display = 'block';
	    style.width = '100%';
	    style.height = '100%';
	    style.left = '0px';
	    style.top = '0px';
	  };
	  /*
	    Method to draw the shape.
	    Called on every frame.
	    @private
	  */


	  Bit.prototype._draw = function _draw() {
	    this._props.length = this._getLength();

	    var state = this._state,
	        props = this._props;

	    var len = this._drawMapLength;
	    while (len--) {
	      var name = this._drawMap[len];
	      switch (name) {
	        case 'stroke-dasharray':
	        case 'stroke-dashoffset':
	          this.castStrokeDash(name);
	      }
	      this._setAttrIfChanged(name, this._props[name]);
	    }
	    this._state.radius = this._props.radius;
	  };

	  Bit.prototype.castStrokeDash = function castStrokeDash(name) {
	    // # if array of values
	    var p = this._props;
	    if (_h2.default.isArray(p[name])) {
	      var stroke = '';
	      for (var i = 0; i < p[name].length; i++) {
	        var dash = p[name][i],
	            cast = dash.unit === '%' ? this.castPercent(dash.value) : dash.value;
	        stroke += cast + ' ';
	      }
	      p[name] = stroke === '0 ' ? stroke = '' : stroke;
	      return p[name] = stroke;
	    }
	    // # if single value
	    if ((0, _typeof3.default)(p[name]) === 'object') {
	      stroke = p[name].unit === '%' ? this.castPercent(p[name].value) : p[name].value;
	      p[name] = stroke === 0 ? stroke = '' : stroke;
	    }
	  };

	  Bit.prototype.castPercent = function castPercent(percent) {
	    return percent * (this._props.length / 100);
	  };

	  /*
	    Method to set props to attributes and cache the values.
	    @private
	  */


	  Bit.prototype._setAttrIfChanged = function _setAttrIfChanged(name, value) {
	    if (this._state[name] !== value) {
	      // this.el.style[name] = value;
	      this.el.setAttribute(name, value);
	      this._state[name] = value;
	    }
	  };
	  /*
	    Method to length of the shape.
	    @private
	    @returns {Number} Length of the shape.
	  */


	  Bit.prototype._getLength = function _getLength() {
	    var p = this._props,
	        len = 0,
	        isGetLength = !!(this.el && this.el.getTotalLength);

	    if (isGetLength && this.el.getAttribute('d')) {
	      len = this.el.getTotalLength();
	    } else {
	      len = 2 * (p.radiusX != null ? p.radiusX : p.radius);
	    }
	    return len;
	  };
	  /*
	    Method to calculate total sum between points.
	    @private
	    @param {Array} Array of points.
	    @returns {Number} Distance bewtween all points.
	  */


	  Bit.prototype._getPointsPerimiter = function _getPointsPerimiter(points) {
	    var sum = 0;

	    for (var i = 1; i < points.length; i++) {
	      sum += this._pointsDelta(points[i - 1], points[i]);
	    }

	    sum += this._pointsDelta(points[0], _h2.default.getLastItem(points));
	    return sum;
	  };
	  /*
	    Method to get delta from two points.
	    @private
	    @param {Object} Point 1.
	    @param {Object} Point 2.
	    @returns {Number} Distance between the pooints.
	  */


	  Bit.prototype._pointsDelta = function _pointsDelta(point1, point2) {
	    var dx = Math.abs(point1.x - point2.x),
	        dy = Math.abs(point1.y - point2.y);
	    return Math.sqrt(dx * dx + dy * dy);
	  };
	  /*
	    Method to set module's size.
	    @private
	    @param {Number} Module width.
	    @param {Number} Module height.
	  */


	  Bit.prototype._setSize = function _setSize(width, height) {
	    var p = this._props;
	    p.width = width;
	    p.height = height;
	    this._draw();
	  };

	  return Bit;
	}(_module2.default);

	exports.default = Bit;

/***/ }),
/* 74 */
/***/ (function(module, exports) {

	"use strict";

	exports.__esModule = true;

	exports.default = function (instance, Constructor) {
	  if (!(instance instanceof Constructor)) {
	    throw new TypeError("Cannot call a class as a function");
	  }
	};

/***/ }),
/* 75 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";

	exports.__esModule = true;

	var _typeof2 = __webpack_require__(3);

	var _typeof3 = _interopRequireDefault(_typeof2);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = function (self, call) {
	  if (!self) {
	    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
	  }

	  return call && ((typeof call === "undefined" ? "undefined" : (0, _typeof3.default)(call)) === "object" || typeof call === "function") ? call : self;
	};

/***/ }),
/* 76 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";

	exports.__esModule = true;

	var _setPrototypeOf = __webpack_require__(77);

	var _setPrototypeOf2 = _interopRequireDefault(_setPrototypeOf);

	var _create = __webpack_require__(81);

	var _create2 = _interopRequireDefault(_create);

	var _typeof2 = __webpack_require__(3);

	var _typeof3 = _interopRequireDefault(_typeof2);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = function (subClass, superClass) {
	  if (typeof superClass !== "function" && superClass !== null) {
	    throw new TypeError("Super expression must either be null or a function, not " + (typeof superClass === "undefined" ? "undefined" : (0, _typeof3.default)(superClass)));
	  }

	  subClass.prototype = (0, _create2.default)(superClass && superClass.prototype, {
	    constructor: {
	      value: subClass,
	      enumerable: false,
	      writable: true,
	      configurable: true
	    }
	  });
	  if (superClass) _setPrototypeOf2.default ? (0, _setPrototypeOf2.default)(subClass, superClass) : subClass.__proto__ = superClass;
	};

/***/ }),
/* 77 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(78), __esModule: true };

/***/ }),
/* 78 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(79);
	module.exports = __webpack_require__(14).Object.setPrototypeOf;

/***/ }),
/* 79 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.3.19 Object.setPrototypeOf(O, proto)
	var $export = __webpack_require__(12);
	$export($export.S, 'Object', {setPrototypeOf: __webpack_require__(80).set});

/***/ }),
/* 80 */
/***/ (function(module, exports, __webpack_require__) {

	// Works with __proto__ only. Old v8 can't work with null proto objects.
	/* eslint-disable no-proto */
	var isObject = __webpack_require__(20)
	  , anObject = __webpack_require__(19);
	var check = function(O, proto){
	  anObject(O);
	  if(!isObject(proto) && proto !== null)throw TypeError(proto + ": can't set as prototype!");
	};
	module.exports = {
	  set: Object.setPrototypeOf || ('__proto__' in {} ? // eslint-disable-line
	    function(test, buggy, set){
	      try {
	        set = __webpack_require__(15)(Function.call, __webpack_require__(67).f(Object.prototype, '__proto__').set, 2);
	        set(test, []);
	        buggy = !(test instanceof Array);
	      } catch(e){ buggy = true; }
	      return function setPrototypeOf(O, proto){
	        check(O, proto);
	        if(buggy)O.__proto__ = proto;
	        else set(O, proto);
	        return O;
	      };
	    }({}, false) : undefined),
	  check: check
	};

/***/ }),
/* 81 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(82), __esModule: true };

/***/ }),
/* 82 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(83);
	var $Object = __webpack_require__(14).Object;
	module.exports = function create(P, D){
	  return $Object.create(P, D);
	};

/***/ }),
/* 83 */
/***/ (function(module, exports, __webpack_require__) {

	var $export = __webpack_require__(12)
	// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
	$export($export.S, 'Object', {create: __webpack_require__(31)});

/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _typeof2 = __webpack_require__(3);

	var _typeof3 = _interopRequireDefault(_typeof2);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	/*
	  Base class for module. Extends and parses defaults.
	*/
	var Module = function () {
	  function Module() {
	    var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    (0, _classCallCheck3.default)(this, Module);

	    // this._isIt = o.isIt;
	    // delete o.isIt;
	    this._o = o;
	    this._index = this._o.index || 0;
	    // map of props that should be
	    // parsed to arrays of values
	    this._arrayPropertyMap = {
	      strokeDashoffset: 1,
	      strokeDasharray: 1,
	      origin: 1
	    };

	    this._skipPropsDelta = {
	      timeline: 1,
	      prevChainModule: 1,
	      callbacksContext: 1
	    };

	    this._declareDefaults();
	    this._extendDefaults();

	    this._vars();
	    this._render();
	  }
	  /*
	    Method to declare defaults.
	    @private
	  */


	  Module.prototype._declareDefaults = function _declareDefaults() {
	    this._defaults = {};
	  };
	  /*
	    Method to declare module's variables.
	    @private
	  */


	  Module.prototype._vars = function _vars() {
	    this._progress = 0;
	    this._strokeDasharrayBuffer = [];
	  };
	  /*
	    Method to render on initialization.
	    @private
	  */


	  Module.prototype._render = function _render() {};
	  /*
	    Method to set property on the module.
	    @private
	    @param {String, Object} Name of the property to set
	                            or object with properties to set.
	    @param {Any} Value for the property to set. Could be
	                  undefined if the first param is object.
	  */


	  Module.prototype._setProp = function _setProp(attr, value) {
	    if ((typeof attr === 'undefined' ? 'undefined' : (0, _typeof3.default)(attr)) === 'object') {
	      for (var key in attr) {
	        this._assignProp(key, attr[key]);
	      }
	    } else {
	      this._assignProp(attr, value);
	    }
	  };
	  /*
	    Method to assign single property's value.
	    @private
	    @param {String} Property name.
	    @param {Any}    Property value.
	  */


	  Module.prototype._assignProp = function _assignProp(key, value) {
	    this._props[key] = value;
	  };
	  /*
	    Method to show element.
	    @private
	  */


	  Module.prototype._show = function _show() {
	    var p = this._props;
	    if (!this.el) {
	      return;
	    }

	    if (p.isSoftHide) {
	      // this.el.style.opacity = p.opacity;
	      this._showByTransform();
	    } else {
	      this.el.style.display = 'block';
	    }

	    this._isShown = true;
	  };
	  /*
	    Method to hide element.
	    @private
	  */


	  Module.prototype._hide = function _hide() {
	    if (!this.el) {
	      return;
	    }

	    if (this._props.isSoftHide) {
	      // this.el.style.opacity = 0;
	      _h2.default.setPrefixedStyle(this.el, 'transform', 'scale(0)');
	    } else {
	      this.el.style.display = 'none';
	    }

	    this._isShown = false;
	  };
	  /*
	    Method to show element by applying transform back to normal.
	    @private
	  */


	  Module.prototype._showByTransform = function _showByTransform() {};
	  /*
	    Method to parse option string.
	    Searches for stagger and rand values and parses them.
	    Leaves the value unattended otherwise.
	    @param {Any} Option value to parse.
	    @returns {Number} Parsed options value.
	  */


	  Module.prototype._parseOptionString = function _parseOptionString(value) {
	    if (typeof value === 'string') {
	      if (value.match(/stagger/)) {
	        value = _h2.default.parseStagger(value, this._index);
	      }
	    }
	    if (typeof value === 'string') {
	      if (value.match(/rand/)) {
	        value = _h2.default.parseRand(value);
	      }
	    }
	    return value;
	  };
	  /*
	    Method to parse postion option.
	    @param {String} Property name.
	    @param {Any} Property Value.
	    @returns {String} Parsed options value.
	  */


	  Module.prototype._parsePositionOption = function _parsePositionOption(key, value) {
	    if (_h2.default.unitOptionMap[key]) {
	      value = _h2.default.parseUnit(value).string;
	    }
	    return value;
	  };
	  /*
	    Method to parse strokeDash.. option.
	    @param {String} Property name.
	    @param {Any}    Property value.
	    @returns {String} Parsed options value.
	  */


	  Module.prototype._parseStrokeDashOption = function _parseStrokeDashOption(key, value) {
	    var result = value;
	    // parse numeric/percent values for strokeDash.. properties
	    if (this._arrayPropertyMap[key]) {
	      var result = [];
	      switch (typeof value === 'undefined' ? 'undefined' : (0, _typeof3.default)(value)) {
	        case 'number':
	          result.push(_h2.default.parseUnit(value));
	          break;
	        case 'string':
	          var array = value.split(' ');
	          for (var i = 0; i < array.length; i++) {
	            result.push(_h2.default.parseUnit(array[i]));
	          }
	          break;
	      }
	    }
	    return result;
	  };
	  /*
	    Method to check if the property is delta property.
	    @private
	    @param {Any} Parameter value to check.
	    @returns {Boolean}
	  */


	  Module.prototype._isDelta = function _isDelta(optionsValue) {
	    var isObject = _h2.default.isObject(optionsValue);
	    isObject = isObject && !optionsValue.unit;
	    return !(!isObject || _h2.default.isArray(optionsValue) || _h2.default.isDOM(optionsValue));
	  };
	  /*
	    Method to get delta from property and set
	    the property's start value to the props object.
	    @private
	    @param {String} Key name to get delta for.
	    @param {Object} Option value to get the delta for.
	  */


	  Module.prototype._getDelta = function _getDelta(key, optionsValue) {
	    var delta;
	    if ((key === 'left' || key === 'top') && !this._o.ctx) {
	      _h2.default.warn('Consider to animate x/y properties instead of left/top,\n        as it would be much more performant', optionsValue);
	    }
	    // skip delta calculation for a property if it is listed
	    // in skipPropsDelta object
	    if (this._skipPropsDelta && this._skipPropsDelta[key]) {
	      return;
	    }
	    // get delta
	    delta = _h2.default.parseDelta(key, optionsValue, this._index);
	    // if successfully parsed - save it
	    if (delta.type != null) {
	      this._deltas[key] = delta;
	    }

	    var deltaEnd = (0, _typeof3.default)(delta.end) === 'object' ? delta.end.value === 0 ? 0 : delta.end.string : delta.end;
	    // set props to end value of the delta
	    // 0 should be 0 regardless units
	    this._props[key] = deltaEnd;
	  };
	  /*
	    Method to copy `_o` options to `_props` object
	    with fallback to `_defaults`.
	    @private
	  */


	  Module.prototype._extendDefaults = function _extendDefaults() {
	    this._props = {};
	    this._deltas = {};
	    for (var key in this._defaults) {
	      // skip property if it is listed in _skipProps
	      // if (this._skipProps && this._skipProps[key]) { continue; }
	      // copy the properties to the _o object
	      var value = this._o[key] != null ? this._o[key] : this._defaults[key];
	      // parse option
	      this._parseOption(key, value);
	    }
	  };
	  /*
	    Method to tune new oprions to _o and _props object.
	    @private
	    @param {Object} Options object to tune to.
	  */


	  Module.prototype._tuneNewOptions = function _tuneNewOptions(o) {
	    // hide the module before tuning it's options
	    // cuz the user could see the change
	    this._hide();
	    for (var key in o) {
	      // skip property if it is listed in _skipProps
	      // if (this._skipProps && this._skipProps[key]) { continue; }
	      // copy the properties to the _o object
	      // delete the key from deltas
	      o && delete this._deltas[key];
	      // rewrite _o record
	      this._o[key] = o[key];
	      // save the options to _props
	      this._parseOption(key, o[key]);
	    }
	  };
	  /*
	    Method to parse option value.
	    @private
	    @param {String} Option name.
	    @param {Any} Option value.
	  */


	  Module.prototype._parseOption = function _parseOption(name, value) {
	    // if delta property
	    if (this._isDelta(value) && !this._skipPropsDelta[name]) {
	      this._getDelta(name, value);
	      var deltaEnd = _h2.default.getDeltaEnd(value);
	      return this._assignProp(name, this._parseProperty(name, deltaEnd));
	    }

	    this._assignProp(name, this._parseProperty(name, value));
	  };
	  /*
	    Method to parse postion and string props.
	    @private
	    @param {String} Property name.
	    @param {Any}    Property value.
	    @returns {Any}  Parsed property value.
	  */


	  Module.prototype._parsePreArrayProperty = function _parsePreArrayProperty(name, value) {
	    // parse stagger and rand values
	    value = this._parseOptionString(value);
	    // parse units for position properties
	    return this._parsePositionOption(name, value);
	  };
	  /*
	    Method to parse property value.
	    @private
	    @param {String} Property name.
	    @param {Any}    Property value.
	    @returns {Any}  Parsed property value.
	  */


	  Module.prototype._parseProperty = function _parseProperty(name, value) {
	    // parse `HTML` element in `parent` option
	    if (name === 'parent') {
	      return _h2.default.parseEl(value);
	    }
	    // parse `stagger`, `rand` and `position`
	    value = this._parsePreArrayProperty(name, value);
	    // parse numeric/percent values for strokeDash.. properties
	    return this._parseStrokeDashOption(name, value);
	  };
	  /*
	    Method to parse values inside ∆.
	    @private
	    @param {String} Key name.
	    @param {Object} Delta.
	    @returns {Object} Delta with parsed parameters.
	  */


	  Module.prototype._parseDeltaValues = function _parseDeltaValues(name, delta) {
	    // return h.parseDelta( name, delta, this._index );

	    var d = {};
	    for (var key in delta) {
	      var value = delta[key];

	      // delete delta[key];
	      // add parsed properties
	      var newEnd = this._parsePreArrayProperty(name, value);
	      d[this._parsePreArrayProperty(name, key)] = newEnd;
	    }
	    return d;
	  };
	  /*
	    Method to parse delta and nondelta properties.
	    @private
	    @param {String} Property name.
	    @param {Any}    Property value.
	    @returns {Any}  Parsed property value.
	  */


	  Module.prototype._preparsePropValue = function _preparsePropValue(key, value) {
	    return this._isDelta(value) ? this._parseDeltaValues(key, value) : this._parsePreArrayProperty(key, value);
	  };
	  /*
	    Method to calculate current progress of the deltas.
	    @private
	    @param {Number} Eased progress to calculate - [0..1].
	    @param {Number} Progress to calculate - [0..1].
	  */


	  Module.prototype._calcCurrentProps = function _calcCurrentProps(easedProgress, p) {

	    for (var key in this._deltas) {

	      var value = this._deltas[key];

	      // get eased progress from delta easing if defined and not curve
	      var isCurve = !!value.curve;
	      var ep = value.easing != null && !isCurve ? value.easing(p) : easedProgress;

	      if (value.type === 'array') {
	        var arr;
	        // if prop property is array - reuse it else - create an array
	        if (_h2.default.isArray(this._props[key])) {
	          arr = this._props[key];
	          arr.length = 0;
	        } else {
	          arr = [];
	        }

	        // just optimization to prevent curve
	        // calculations on every array item
	        var proc = isCurve ? value.curve(p) : null;

	        for (var i = 0; i < value.delta.length; i++) {
	          var item = value.delta[i],
	              dash = !isCurve ? value.start[i].value + ep * item.value : proc * (value.start[i].value + p * item.value);
	          arr.push({
	            string: '' + dash + item.unit,
	            value: dash,
	            unit: item.unit
	          });
	        }

	        this._props[key] = arr;
	      } else if (value.type === 'number') {
	        this._props[key] = !isCurve ? value.start + ep * value.delta : value.curve(p) * (value.start + p * value.delta);
	      } else if (value.type === 'unit') {
	        var currentValue = !isCurve ? value.start.value + ep * value.delta : value.curve(p) * (value.start.value + p * value.delta);

	        this._props[key] = '' + currentValue + value.end.unit;
	      } else if (value.type === 'color') {
	        var r, g, b, a;
	        if (!isCurve) {
	          r = parseInt(value.start.r + ep * value.delta.r, 10);
	          g = parseInt(value.start.g + ep * value.delta.g, 10);
	          b = parseInt(value.start.b + ep * value.delta.b, 10);
	          a = parseFloat(value.start.a + ep * value.delta.a);
	        } else {
	          var cp = value.curve(p);
	          r = parseInt(cp * (value.start.r + p * value.delta.r), 10);
	          g = parseInt(cp * (value.start.g + p * value.delta.g), 10);
	          b = parseInt(cp * (value.start.b + p * value.delta.b), 10);
	          a = parseFloat(cp * (value.start.a + p * value.delta.a));
	        }
	        this._props[key] = 'rgba(' + r + ',' + g + ',' + b + ',' + a + ')';
	      }
	    }
	  };
	  /*
	    Method to calculate current progress and probably draw it in children.
	    @private
	    @param {Number} Eased progress to set - [0..1].
	    @param {Number} Progress to set - [0..1].
	  */


	  Module.prototype._setProgress = function _setProgress(easedProgress, progress) {
	    this._progress = easedProgress;
	    this._calcCurrentProps(easedProgress, progress);
	  };

	  return Module;
	}();

	exports.default = Module;

/***/ }),
/* 85 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _bit = __webpack_require__(73);

	var _bit2 = _interopRequireDefault(_bit);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var Custom = function (_Bit) {
	  (0, _inherits3.default)(Custom, _Bit);

	  function Custom() {
	    (0, _classCallCheck3.default)(this, Custom);
	    return (0, _possibleConstructorReturn3.default)(this, _Bit.apply(this, arguments));
	  }

	  /*
	    Method to declare module's defaults.
	    @private
	    @overrides @ Bit
	  */
	  Custom.prototype._declareDefaults = function _declareDefaults() {
	    _Bit.prototype._declareDefaults.call(this);

	    this._defaults.tag = 'path';
	    this._defaults.parent = null;

	    // remove `stroke-width` from `_drawMap`
	    // because we need to recal strokeWidth size regarding scale
	    for (var i = 0; i < this._drawMap.length; i++) {
	      if (this._drawMap[i] === 'stroke-width') {
	        this._drawMap.splice(i, 1);
	      }
	    }
	  };
	  /*
	    Method to get shape to set on module's path.
	    @public
	    @returns {String} Empty string.
	  */


	  Custom.prototype.getShape = function getShape() {
	    return '';
	  };
	  /*
	    Method to get shape perimeter length.
	    @public
	    @returns {Number} Default length string.
	  */


	  Custom.prototype.getLength = function getLength() {
	    return 100;
	  };
	  /*
	    Method to draw the shape.
	    Called on every frame.
	    @private
	    @overrides @ Bit
	  */


	  Custom.prototype._draw = function _draw() {
	    var p = this._props,
	        state = this._state,
	        radiusXChange = state['radiusX'] !== p.radiusX,
	        radiusYChange = state['radiusY'] !== p.radiusY,
	        radiusChange = state['radius'] !== p.radius;

	    // update transform only if one of radiuses changed
	    if (radiusXChange || radiusYChange || radiusChange) {
	      this.el.setAttribute('transform', this._getScale());
	      state['radiusX'] = p.radiusX;
	      state['radiusY'] = p.radiusY;
	      state['radius'] = p.radius;
	    }

	    this._setAttrIfChanged('stroke-width', p['stroke-width'] / p.maxScale);

	    _Bit.prototype._draw.call(this);
	  };
	  /*
	    Method for initial render of the shape.
	    @private
	    @overrides @ Bit
	  */


	  Custom.prototype._render = function _render() {
	    if (this._isRendered) {
	      return;
	    }
	    this._isRendered = true;

	    this._length = this.getLength();

	    var p = this._props;
	    p.parent.innerHTML = '<svg id="js-mojs-shape-canvas" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink"><g id="js-mojs-shape-el">' + this.getShape() + '</g></svg>';

	    this._canvas = p.parent.querySelector('#js-mojs-shape-canvas');
	    this.el = p.parent.querySelector('#js-mojs-shape-el');
	    this._setCanvasSize();
	  };
	  /*
	    Method to get scales for the shape.
	    @private
	    @mutates @props
	  */


	  Custom.prototype._getScale = function _getScale() {
	    var p = this._props,
	        radiusX = p.radiusX ? p.radiusX : p.radius,
	        radiusY = p.radiusY ? p.radiusY : p.radius;

	    p.scaleX = 2 * radiusX / 100;
	    p.scaleY = 2 * radiusY / 100;
	    p.maxScale = Math.max(p.scaleX, p.scaleY);

	    p.shiftX = p.width / 2 - 50 * p.scaleX;
	    p.shiftY = p.height / 2 - 50 * p.scaleY;

	    var translate = 'translate(' + p.shiftX + ', ' + p.shiftY + ')';
	    return translate + ' scale(' + p.scaleX + ', ' + p.scaleY + ')';
	  };
	  /*
	    Method to length of the shape.
	    @private
	    @returns {Number} Length of the shape.
	  */


	  Custom.prototype._getLength = function _getLength() {
	    return this._length;
	  };

	  return Custom;
	}(_bit2.default);

	exports.default = Custom;

/***/ }),
/* 86 */
/***/ (function(module, exports, __webpack_require__) {

	
	/* istanbul ignore next */
	var Bit, Circle,
	  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
	  hasProp = {}.hasOwnProperty;

	Bit = __webpack_require__(73)["default"] || __webpack_require__(73);

	Circle = (function(superClass) {
	  extend(Circle, superClass);

	  function Circle() {
	    return Circle.__super__.constructor.apply(this, arguments);
	  }

	  Circle.prototype._declareDefaults = function() {
	    Circle.__super__._declareDefaults.apply(this, arguments);
	    return this._defaults.shape = 'ellipse';
	  };

	  Circle.prototype._draw = function() {
	    var rx, ry;
	    rx = this._props.radiusX != null ? this._props.radiusX : this._props.radius;
	    ry = this._props.radiusY != null ? this._props.radiusY : this._props.radius;
	    this._setAttrIfChanged('rx', rx);
	    this._setAttrIfChanged('ry', ry);
	    this._setAttrIfChanged('cx', this._props.width / 2);
	    this._setAttrIfChanged('cy', this._props.height / 2);
	    return Circle.__super__._draw.apply(this, arguments);
	  };

	  Circle.prototype._getLength = function() {
	    var radiusX, radiusY;
	    radiusX = this._props.radiusX != null ? this._props.radiusX : this._props.radius;
	    radiusY = this._props.radiusY != null ? this._props.radiusY : this._props.radius;
	    return 2 * Math.PI * Math.sqrt((radiusX * radiusX + radiusY * radiusY) / 2);
	  };

	  return Circle;

	})(Bit);

	module.exports = Circle;


/***/ }),
/* 87 */
/***/ (function(module, exports, __webpack_require__) {

	
	/* istanbul ignore next */
	var Bit, Line,
	  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
	  hasProp = {}.hasOwnProperty;

	Bit = __webpack_require__(73)["default"] || __webpack_require__(73);

	Line = (function(superClass) {
	  extend(Line, superClass);

	  function Line() {
	    return Line.__super__.constructor.apply(this, arguments);
	  }

	  Line.prototype._declareDefaults = function() {
	    Line.__super__._declareDefaults.apply(this, arguments);
	    return this._defaults.tag = 'line';
	  };

	  Line.prototype._draw = function() {
	    var radiusX, x, y;
	    radiusX = this._props.radiusX != null ? this._props.radiusX : this._props.radius;
	    x = this._props.width / 2;
	    y = this._props.height / 2;
	    this._setAttrIfChanged('x1', x - radiusX);
	    this._setAttrIfChanged('x2', x + radiusX);
	    this._setAttrIfChanged('y1', y);
	    this._setAttrIfChanged('y2', y);
	    return Line.__super__._draw.apply(this, arguments);
	  };

	  return Line;

	})(Bit);

	module.exports = Line;


/***/ }),
/* 88 */
/***/ (function(module, exports, __webpack_require__) {

	
	/* istanbul ignore next */
	var Bit, Zigzag,
	  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
	  hasProp = {}.hasOwnProperty;

	Bit = __webpack_require__(73)["default"] || __webpack_require__(73);

	Zigzag = (function(superClass) {
	  extend(Zigzag, superClass);

	  function Zigzag() {
	    return Zigzag.__super__.constructor.apply(this, arguments);
	  }

	  Zigzag.prototype._declareDefaults = function() {
	    Zigzag.__super__._declareDefaults.apply(this, arguments);
	    this._defaults.tag = 'path';
	    return this._defaults.points = 3;
	  };

	  Zigzag.prototype._draw = function() {
	    var currentX, currentY, delta, i, isPoints, isRadiusX, isRadiusY, j, length, p, points, radiusX, radiusY, ref, stepX, x, y, yFlip;
	    Zigzag.__super__._draw.apply(this, arguments);
	    p = this._props;
	    if (!this._props.points) {
	      return;
	    }
	    radiusX = this._props.radiusX != null ? this._props.radiusX : this._props.radius;
	    radiusY = this._props.radiusY != null ? this._props.radiusY : this._props.radius;
	    isRadiusX = radiusX === this._prevRadiusX;
	    isRadiusY = radiusY === this._prevRadiusY;
	    isPoints = p.points === this._prevPoints;
	    if (isRadiusX && isRadiusY && isPoints) {
	      return;
	    }
	    x = p.width / 2;
	    y = p.height / 2;
	    currentX = x - radiusX;
	    currentY = y;
	    stepX = (2 * radiusX) / (p.points - 1);
	    yFlip = -1;
	    delta = Math.sqrt(stepX * stepX + radiusY * radiusY);
	    length = -delta;
	    points = "M" + currentX + ", " + y + " ";
	    for (i = j = 0, ref = p.points; 0 <= ref ? j < ref : j > ref; i = 0 <= ref ? ++j : --j) {
	      points += "L" + currentX + ", " + currentY + " ";
	      currentX += stepX;
	      length += delta;
	      currentY = yFlip === -1 ? y - radiusY : y;
	      yFlip = -yFlip;
	    }
	    this._length = length;
	    this.el.setAttribute('d', points);
	    this._prevPoints = p.points;
	    this._prevRadiusX = radiusX;
	    return this._prevRadiusY = radiusY;
	  };

	  Zigzag.prototype._getLength = function() {
	    return this._length;
	  };

	  return Zigzag;

	})(Bit);

	module.exports = Zigzag;


/***/ }),
/* 89 */
/***/ (function(module, exports, __webpack_require__) {

	
	/* istanbul ignore next */
	var Bit, Rect,
	  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
	  hasProp = {}.hasOwnProperty;

	Bit = __webpack_require__(73)["default"] || __webpack_require__(73);

	Rect = (function(superClass) {
	  extend(Rect, superClass);

	  function Rect() {
	    return Rect.__super__.constructor.apply(this, arguments);
	  }

	  Rect.prototype._declareDefaults = function() {
	    Rect.__super__._declareDefaults.apply(this, arguments);
	    this._defaults.tag = 'rect';
	    this._defaults.rx = 0;
	    return this._defaults.ry = 0;
	  };

	  Rect.prototype._draw = function() {
	    var p, radiusX, radiusY;
	    Rect.__super__._draw.apply(this, arguments);
	    p = this._props;
	    radiusX = p.radiusX != null ? p.radiusX : p.radius;
	    radiusY = p.radiusY != null ? p.radiusY : p.radius;
	    this._setAttrIfChanged('width', 2 * radiusX);
	    this._setAttrIfChanged('height', 2 * radiusY);
	    this._setAttrIfChanged('x', (p.width / 2) - radiusX);
	    this._setAttrIfChanged('y', (p.height / 2) - radiusY);
	    this._setAttrIfChanged('rx', p.rx);
	    return this._setAttrIfChanged('ry', p.ry);
	  };

	  Rect.prototype._getLength = function() {
	    var radiusX, radiusY;
	    radiusX = this._props.radiusX != null ? this._props.radiusX : this._props.radius;
	    radiusY = this._props.radiusY != null ? this._props.radiusY : this._props.radius;
	    return 2 * (2 * radiusX + 2 * radiusY);
	  };

	  return Rect;

	})(Bit);

	module.exports = Rect;


/***/ }),
/* 90 */
/***/ (function(module, exports, __webpack_require__) {

	
	/* istanbul ignore next */
	var Bit, Polygon, h,
	  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
	  hasProp = {}.hasOwnProperty;

	Bit = __webpack_require__(73)["default"] || __webpack_require__(73);

	h = __webpack_require__(71);

	Polygon = (function(superClass) {
	  extend(Polygon, superClass);

	  function Polygon() {
	    return Polygon.__super__.constructor.apply(this, arguments);
	  }


	  /*
	    Method to declare defaults.
	    @overrides @ Bit
	   */

	  Polygon.prototype._declareDefaults = function() {
	    Polygon.__super__._declareDefaults.apply(this, arguments);
	    this._defaults.tag = 'path';
	    return this._defaults.points = 3;
	  };


	  /*
	    Method to draw the shape.
	    @overrides @ Bit
	   */

	  Polygon.prototype._draw = function() {
	    var char, d, i, isPoints, isRadiusX, isRadiusY, j, k, len, p, point, radiusX, radiusY, ref, ref1, step;
	    p = this._props;
	    radiusX = this._props.radiusX != null ? this._props.radiusX : this._props.radius;
	    radiusY = this._props.radiusY != null ? this._props.radiusY : this._props.radius;
	    isRadiusX = radiusX === this._prevRadiusX;
	    isRadiusY = radiusY === this._prevRadiusY;
	    isPoints = p.points === this._prevPoints;
	    if (!(isRadiusX && isRadiusY && isPoints)) {
	      step = 360 / this._props.points;
	      if (this._radialPoints == null) {
	        this._radialPoints = [];
	      } else {
	        this._radialPoints.length = 0;
	      }
	      for (i = j = 0, ref = this._props.points; 0 <= ref ? j < ref : j > ref; i = 0 <= ref ? ++j : --j) {
	        this._radialPoints.push(h.getRadialPoint({
	          radius: this._props.radius,
	          radiusX: this._props.radiusX,
	          radiusY: this._props.radiusY,
	          angle: i * step,
	          center: {
	            x: p.width / 2,
	            y: p.height / 2
	          }
	        }));
	      }
	      d = '';
	      ref1 = this._radialPoints;
	      for (i = k = 0, len = ref1.length; k < len; i = ++k) {
	        point = ref1[i];
	        char = i === 0 ? 'M' : 'L';
	        d += "" + char + (point.x.toFixed(4)) + "," + (point.y.toFixed(4)) + " ";
	      }
	      this._prevPoints = p.points;
	      this._prevRadiusX = radiusX;
	      this._prevRadiusY = radiusY;
	      this.el.setAttribute('d', (d += 'z'));
	    }
	    return Polygon.__super__._draw.apply(this, arguments);
	  };


	  /*
	    Method to get length of the shape.
	    @overrides @ Bit
	   */

	  Polygon.prototype._getLength = function() {
	    return this._getPointsPerimiter(this._radialPoints);
	  };

	  return Polygon;

	})(Bit);

	module.exports = Polygon;


/***/ }),
/* 91 */
/***/ (function(module, exports, __webpack_require__) {

	
	/* istanbul ignore next */
	var Bit, Cross,
	  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
	  hasProp = {}.hasOwnProperty;

	Bit = __webpack_require__(73)["default"] || __webpack_require__(73);

	Cross = (function(superClass) {
	  extend(Cross, superClass);

	  function Cross() {
	    return Cross.__super__.constructor.apply(this, arguments);
	  }

	  Cross.prototype._declareDefaults = function() {
	    Cross.__super__._declareDefaults.apply(this, arguments);
	    return this._defaults.tag = 'path';
	  };

	  Cross.prototype._draw = function() {
	    var d, isRadiusX, isRadiusY, line1, line2, p, radiusX, radiusY, x, x1, x2, y, y1, y2;
	    Cross.__super__._draw.apply(this, arguments);
	    p = this._props;
	    radiusX = this._props.radiusX != null ? this._props.radiusX : this._props.radius;
	    radiusY = this._props.radiusY != null ? this._props.radiusY : this._props.radius;
	    isRadiusX = radiusX === this._prevRadiusX;
	    isRadiusY = radiusY === this._prevRadiusY;
	    if (isRadiusX && isRadiusY) {
	      return;
	    }
	    x = this._props.width / 2;
	    y = this._props.height / 2;
	    x1 = x - radiusX;
	    x2 = x + radiusX;
	    line1 = "M" + x1 + "," + y + " L" + x2 + "," + y;
	    y1 = y - radiusY;
	    y2 = y + radiusY;
	    line2 = "M" + x + "," + y1 + " L" + x + "," + y2;
	    d = line1 + " " + line2;
	    this.el.setAttribute('d', d);
	    this._prevRadiusX = radiusX;
	    return this._prevRadiusY = radiusY;
	  };

	  Cross.prototype._getLength = function() {
	    var radiusX, radiusY;
	    radiusX = this._props.radiusX != null ? this._props.radiusX : this._props.radius;
	    radiusY = this._props.radiusY != null ? this._props.radiusY : this._props.radius;
	    return 2 * (radiusX + radiusY);
	  };

	  return Cross;

	})(Bit);

	module.exports = Cross;


/***/ }),
/* 92 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _bit = __webpack_require__(73);

	var _bit2 = _interopRequireDefault(_bit);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var Curve = function (_Bit) {
	  (0, _inherits3.default)(Curve, _Bit);

	  function Curve() {
	    (0, _classCallCheck3.default)(this, Curve);
	    return (0, _possibleConstructorReturn3.default)(this, _Bit.apply(this, arguments));
	  }

	  /*
	    Method to declare module's defaults.
	    @private
	    @overrides @ Bit
	  */
	  Curve.prototype._declareDefaults = function _declareDefaults() {
	    _Bit.prototype._declareDefaults.call(this);
	    this._defaults.tag = 'path';
	  };
	  /*
	    Method to draw the module.
	    @private
	    @overrides @ Bit
	  */


	  Curve.prototype._draw = function _draw() {
	    _Bit.prototype._draw.call(this);
	    var p = this._props;

	    var radiusX = p.radiusX != null ? p.radiusX : p.radius;
	    var radiusY = p.radiusY != null ? p.radiusY : p.radius;

	    var isRadiusX = radiusX === this._prevRadiusX;
	    var isRadiusY = radiusY === this._prevRadiusY;
	    var isPoints = p.points === this._prevPoints;
	    // skip if nothing changed
	    if (isRadiusX && isRadiusY && isPoints) {
	      return;
	    }

	    var x = p.width / 2;
	    var y = p.height / 2;
	    var x1 = x - radiusX;
	    var x2 = x + radiusX;

	    var d = 'M' + x1 + ' ' + y + ' Q ' + x + ' ' + (y - 2 * radiusY) + ' ' + x2 + ' ' + y;

	    // set the `d` attribute and save it to `_prevD`
	    this.el.setAttribute('d', d);
	    // save the properties
	    this._prevPoints = p.points;
	    this._prevRadiusX = radiusX;
	    this._prevRadiusY = radiusY;
	  };

	  Curve.prototype._getLength = function _getLength() {
	    var p = this._props;

	    var radiusX = p.radiusX != null ? p.radiusX : p.radius;
	    var radiusY = p.radiusY != null ? p.radiusY : p.radius;

	    var dRadius = radiusX + radiusY;
	    var sqrt = Math.sqrt((3 * radiusX + radiusY) * (radiusX + 3 * radiusY));

	    return .5 * Math.PI * (3 * dRadius - sqrt);
	  };

	  return Curve;
	}(_bit2.default); // istanbul ignore next


	exports.default = Curve;

/***/ }),
/* 93 */
/***/ (function(module, exports, __webpack_require__) {

	
	/* istanbul ignore next */
	var Bit, Equal,
	  extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
	  hasProp = {}.hasOwnProperty;

	Bit = __webpack_require__(73)["default"] || __webpack_require__(73);

	Equal = (function(superClass) {
	  extend(Equal, superClass);

	  function Equal() {
	    return Equal.__super__.constructor.apply(this, arguments);
	  }

	  Equal.prototype._declareDefaults = function() {
	    Equal.__super__._declareDefaults.apply(this, arguments);
	    this._defaults.tag = 'path';
	    return this._defaults.points = 2;
	  };

	  Equal.prototype._draw = function() {
	    var d, i, isPoints, isRadiusX, isRadiusY, j, p, radiusX, radiusY, ref, x, x1, x2, y, yStart, yStep;
	    Equal.__super__._draw.apply(this, arguments);
	    p = this._props;
	    if (!this._props.points) {
	      return;
	    }
	    radiusX = this._props.radiusX != null ? this._props.radiusX : this._props.radius;
	    radiusY = this._props.radiusY != null ? this._props.radiusY : this._props.radius;
	    isRadiusX = radiusX === this._prevRadiusX;
	    isRadiusY = radiusY === this._prevRadiusY;
	    isPoints = p.points === this._prevPoints;
	    if (isRadiusX && isRadiusY && isPoints) {
	      return;
	    }
	    x = this._props.width / 2;
	    y = this._props.height / 2;
	    x1 = x - radiusX;
	    x2 = x + radiusX;
	    d = '';
	    yStep = 2 * radiusY / (this._props.points - 1);
	    yStart = y - radiusY;
	    for (i = j = 0, ref = this._props.points; 0 <= ref ? j < ref : j > ref; i = 0 <= ref ? ++j : --j) {
	      y = "" + (i * yStep + yStart);
	      d += "M" + x1 + ", " + y + " L" + x2 + ", " + y + " ";
	    }
	    this.el.setAttribute('d', d);
	    this._prevPoints = p.points;
	    this._prevRadiusX = radiusX;
	    return this._prevRadiusY = radiusY;
	  };

	  Equal.prototype._getLength = function() {
	    return 2 * (this._props.radiusX != null ? this._props.radiusX : this._props.radius);
	  };

	  return Equal;

	})(Bit);

	module.exports = Equal;


/***/ }),
/* 94 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _keys = __webpack_require__(95);

	var _keys2 = _interopRequireDefault(_keys);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _module = __webpack_require__(84);

	var _module2 = _interopRequireDefault(_module);

	var _thenable = __webpack_require__(99);

	var _thenable2 = _interopRequireDefault(_thenable);

	var _tunable = __webpack_require__(116);

	var _tunable2 = _interopRequireDefault(_tunable);

	var _tweenable = __webpack_require__(100);

	var _tweenable2 = _interopRequireDefault(_tweenable);

	var _tween = __webpack_require__(101);

	var _tween2 = _interopRequireDefault(_tween);

	var _timeline = __webpack_require__(110);

	var _timeline2 = _interopRequireDefault(_timeline);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var h = __webpack_require__(71);
	var Bit = __webpack_require__(73);
	var shapesMap = __webpack_require__(72);

	// TODO
	//  - refactor
	//    - add setIfChanged to Module
	//  --
	//  - tween for every prop

	var Shape = function (_Tunable) {
	  (0, _inherits3.default)(Shape, _Tunable);

	  function Shape() {
	    (0, _classCallCheck3.default)(this, Shape);
	    return (0, _possibleConstructorReturn3.default)(this, _Tunable.apply(this, arguments));
	  }

	  /*
	    Method to declare module's defaults.
	    @private
	  */
	  Shape.prototype._declareDefaults = function _declareDefaults() {
	    // DEFAULTS / APIs
	    this._defaults = {
	      // where to append the module to [selector, HTMLElement]
	      parent: document.body,
	      // class name for the `el`
	      className: '',
	      // Possible values: [circle, line, zigzag, rect, polygon, cross, equal ]
	      shape: 'circle',
	      // ∆ :: Possible values: [color name, rgb, rgba, hex]
	      stroke: 'transparent',
	      // ∆ :: Possible values: [ 0..1 ]
	      strokeOpacity: 1,
	      // Possible values: ['butt' | 'round' | 'square']
	      strokeLinecap: '',
	      // ∆ :: Possible values: [ number ]
	      strokeWidth: 2,
	      // ∆ :: Units :: Possible values: [ number, string ]
	      strokeDasharray: 0,
	      // ∆ :: Units :: Possible values: [ number, string ]
	      strokeDashoffset: 0,
	      // ∆ :: Possible values: [color name, rgb, rgba, hex]
	      fill: 'deeppink',
	      // ∆ :: Possible values: [ 0..1 ]
	      fillOpacity: 1,
	      // {Boolean} - if should hide module with `opacity` instead of `display`
	      isSoftHide: true,
	      // {Boolean} - if should trigger composite layer for the `el`
	      isForce3d: false,
	      // ∆ :: Units :: Possible values: [ number, string ]
	      left: '50%',
	      // ∆ :: Units :: Possible values: [ number, string ]
	      top: '50%',
	      // ∆ :: Units :: Possible values: [ number, string ]
	      x: 0,
	      // ∆ :: Units :: Possible values: [ number, string ]
	      y: 0,
	      // ∆ :: Possible values: [ number ]
	      angle: 0,
	      // ∆ :: Possible values: [ number ]
	      scale: 1,
	      // ∆ :: Possible values: [ number ] Fallbacks to `scale`.
	      scaleX: null,
	      // ∆ :: Possible values: [ number ] Fallbacks to `scale`.
	      scaleY: null,
	      // ∆ :: Possible values: [ number, string ]
	      origin: '50% 50%',
	      // ∆ :: Possible values: [ 0..1 ]
	      opacity: 1,
	      // ∆ :: Units :: Possible values: [ number, string ]
	      rx: 0,
	      // ∆ :: Units :: Possible values: [ number, string ]
	      ry: 0,
	      // ∆ :: Possible values: [ number ]
	      points: 3,
	      // ∆ :: Possible values: [ number ]
	      radius: 50,
	      // ∆ :: Possible values: [ number ]
	      radiusX: null,
	      // ∆ :: Possible values: [ number ]
	      radiusY: null,
	      // Possible values: [ boolean ]
	      isShowStart: false,
	      // Possible values: [ boolean ]
	      isShowEnd: true,
	      // Possible values: [ boolean ]
	      isRefreshState: true,
	      // Possible values: [ number > 0 ]
	      duration: 400,
	      // Possible values: [ number ]

	      /* technical ones: */
	      // explicit width of the module canvas
	      width: null,
	      // explicit height of the module canvas
	      height: null,
	      // Possible values: [ number ]
	      // sizeGap:          0,
	      /* [boolean] :: If should have child shape. */
	      isWithShape: true,
	      // context for all the callbacks
	      callbacksContext: this
	    };
	  };
	  /*
	    Method to start the animation with optional new options.
	    @public
	    @overrides @ Tunable
	    @param {Object} New options to set on the run.
	    @returns {Object} this.
	  */


	  Shape.prototype.tune = function tune(o) {
	    _Tunable.prototype.tune.call(this, o);
	    // update shapeModule's size to the max in `then` chain
	    this._getMaxSizeInChain();
	    return this;
	  };
	  /*
	    Method to create a then record for the module.
	    @public
	    @overrides @ Thenable
	    @param    {Object} Options for the next animation.
	    @returns  {Object} this.
	  */


	  Shape.prototype.then = function then(o) {
	    // this._makeTimeline()
	    _Tunable.prototype.then.call(this, o);
	    // update shapeModule's size to the max in `then` chain
	    this._getMaxSizeInChain();
	    return this;
	  };

	  // ^ PUBLIC  METHOD(S) ^
	  // v PRIVATE METHOD(S) v

	  /*
	    Method to declare variables.
	    @overrides Thenable
	  */


	  Shape.prototype._vars = function _vars() {
	    // call _vars method on Thenable
	    _Tunable.prototype._vars.call(this);
	    this._lastSet = {};
	    // save previous module in the chain
	    this._prevChainModule = this._o.prevChainModule;
	    // should draw on foreign svg canvas
	    this.isForeign = !!this._o.ctx;
	    // this._o.isTimelineLess = true;
	    // should take an svg element as self bit
	    return this.isForeignBit = !!this._o.shape;
	  };
	  /*
	    Method to initialize modules presentation.
	    @private
	    @overrides Module
	  */


	  Shape.prototype._render = function _render() {
	    if (!this._isRendered && !this._isChained) {
	      // create `mojs` shape element
	      this.el = document.createElement('div');
	      // set name on the `el`
	      this.el.setAttribute('data-name', 'mojs-shape');
	      // set class on the `el`
	      this.el.setAttribute('class', this._props.className);
	      // create shape module
	      this._createShape();
	      // append `el` to parent
	      this._props.parent.appendChild(this.el);
	      // set position styles on the el
	      this._setElStyles();
	      // set initial position for the first module in the chain
	      this._setProgress(0, 0);
	      // show at start if `isShowStart`
	      if (this._props.isShowStart) {
	        this._show();
	      } else {
	        this._hide();
	      }
	      // set `_isRendered` hatch
	      this._isRendered = true;
	    } else if (this._isChained) {
	      // save elements from master module
	      this.el = this._masterModule.el;
	      this.shapeModule = this._masterModule.shapeModule;
	    }

	    return this;
	  };
	  /*
	    Method to set el styles on initialization.
	    @private
	  */


	  Shape.prototype._setElStyles = function _setElStyles() {
	    if (!this.el) {
	      return;
	    }
	    // if (!this.isForeign) {
	    var p = this._props,
	        style = this.el.style,
	        width = p.shapeWidth,
	        height = p.shapeHeight;

	    style.position = 'absolute';
	    this._setElSizeStyles(width, height);

	    if (p.isForce3d) {
	      var name = 'backface-visibility';
	      style['' + name] = 'hidden';
	      style['' + h.prefix.css + name] = 'hidden';
	    }
	    // }
	  };
	  /*
	    Method to set `width`/`height`/`margins` to the `el` styles.
	    @param {Number} Width.
	    @param {height} Height.
	  */


	  Shape.prototype._setElSizeStyles = function _setElSizeStyles(width, height) {
	    var style = this.el.style;
	    style.width = width + 'px';
	    style.height = height + 'px';
	    style['margin-left'] = -width / 2 + 'px';
	    style['margin-top'] = -height / 2 + 'px';
	  };
	  /*
	    Method to draw shape.
	    @private
	  */


	  Shape.prototype._draw = function _draw() {
	    if (!this.shapeModule) {
	      return;
	    }

	    var p = this._props,
	        bP = this.shapeModule._props;
	    // set props on bit
	    // bP.x                    = this._origin.x;
	    // bP.y                    = this._origin.y;
	    bP.rx = p.rx;
	    bP.ry = p.ry;
	    bP.stroke = p.stroke;
	    bP['stroke-width'] = p.strokeWidth;
	    bP['stroke-opacity'] = p.strokeOpacity;
	    bP['stroke-dasharray'] = p.strokeDasharray;
	    bP['stroke-dashoffset'] = p.strokeDashoffset;
	    bP['stroke-linecap'] = p.strokeLinecap;
	    bP['fill'] = p.fill;
	    bP['fill-opacity'] = p.fillOpacity;
	    bP.radius = p.radius;
	    bP.radiusX = p.radiusX;
	    bP.radiusY = p.radiusY;
	    bP.points = p.points;

	    this.shapeModule._draw();
	    this._drawEl();
	  };
	  /*
	    Method to set current modules props to main div el.
	    @private
	  */


	  Shape.prototype._drawEl = function _drawEl() {
	    // return;
	    if (this.el == null) {
	      return true;
	    }
	    var p = this._props;
	    var style = this.el.style;

	    // style.opacity = p.opacity;
	    this._isPropChanged('opacity') && (style.opacity = p.opacity);
	    if (!this.isForeign) {
	      this._isPropChanged('left') && (style.left = p.left);
	      this._isPropChanged('top') && (style.top = p.top);

	      var isX = this._isPropChanged('x'),
	          isY = this._isPropChanged('y'),
	          isTranslate = isX || isY,
	          isScaleX = this._isPropChanged('scaleX'),
	          isScaleY = this._isPropChanged('scaleY'),
	          isScale = this._isPropChanged('scale'),
	          isScale = isScale || isScaleX || isScaleY,
	          isRotate = this._isPropChanged('angle');

	      if (isTranslate || isScale || isRotate) {
	        var transform = this._fillTransform();
	        style[h.prefix.css + 'transform'] = transform;
	        style['transform'] = transform;
	      }

	      if (this._isPropChanged('origin') || this._deltas['origin']) {
	        var origin = this._fillOrigin();
	        style[h.prefix.css + 'transform-origin'] = origin;
	        style['transform-origin'] = origin;
	      }
	    }
	  };
	  /*
	    Method to check if property changed after the latest check.
	    @private
	    @param {String} Name of the property to check.
	    @returns {Boolean}
	  */


	  Shape.prototype._isPropChanged = function _isPropChanged(name) {
	    // if there is no recod for the property - create it
	    if (this._lastSet[name] == null) {
	      this._lastSet[name] = {};
	    }
	    if (this._lastSet[name].value !== this._props[name]) {
	      this._lastSet[name].value = this._props[name];
	      return true;
	    } else {
	      return false;
	    }
	  };
	  /*
	    Method to tune new option on run.
	    @private
	    @override @ Module
	    @param {Object}  Option to tune on run.
	  */


	  Shape.prototype._tuneNewOptions = function _tuneNewOptions(o) {
	    // call super on Module
	    _Tunable.prototype._tuneNewOptions.call(this, o);
	    // return if empty object
	    if (!(o != null && (0, _keys2.default)(o).length)) {
	      return 1;
	    }

	    // this._calcSize();
	    this._setElStyles();
	  };
	  /*
	    Method to get max radiusX value.
	    @private
	    @param {String} Radius name.
	  */


	  Shape.prototype._getMaxRadius = function _getMaxRadius(name) {
	    var selfSize, selfSizeX;
	    selfSize = this._getRadiusSize('radius');
	    return this._getRadiusSize(name, selfSize);
	  };
	  /*
	    Method to increase calculated size based on easing.
	    @private
	  */


	  Shape.prototype._increaseSizeWithEasing = function _increaseSizeWithEasing() {
	    var p = this._props,
	        easing = this._o.easing,
	        isStringEasing = easing && typeof easing === 'string';

	    switch (isStringEasing && easing.toLowerCase()) {
	      case 'elastic.out':
	      case 'elastic.inout':
	        p.size *= 1.25;
	        break;
	      case 'back.out':
	      case 'back.inout':
	        p.size *= 1.1;
	    }
	  };
	  /*
	    Method to increase calculated size based on bit ratio.
	    @private
	  */
	  // _increaseSizeWithBitRatio () {
	  //   var p   = this._props;
	  //   // p.size *= this.shape._props.ratio;
	  //   p.size += 2 * p.sizeGap;
	  // }
	  /*
	    Method to get maximum radius size with optional fallback.
	    @private
	    @param {Object}
	      @param key {String} Name of the radius - [radius|radiusX|radiusY].
	      @param @optional fallback {Number}  Optional number to set if there
	                                          is no value for the key.
	  */


	  Shape.prototype._getRadiusSize = function _getRadiusSize(name) {
	    var fallback = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

	    var delta = this._deltas[name];
	    // if value is delta value
	    if (delta != null) {
	      // get maximum number between start and end values of the delta
	      return Math.max(Math.abs(delta.end), Math.abs(delta.start));
	    } else if (this._props[name] != null) {
	      // else get the value from props object
	      return parseFloat(this._props[name]);
	    } else {
	      return fallback;
	    }
	  };
	  /*
	    Method to get max shape canvas size and save it to _props.
	    @private
	  */


	  Shape.prototype._getShapeSize = function _getShapeSize() {
	    var p = this._props,

	    // get maximum stroke value
	    stroke = this._getMaxStroke();
	    // save shape `width` and `height` to `_props`
	    p.shapeWidth = p.width != null ? p.width : 2 * this._getMaxRadius('radiusX') + stroke;

	    p.shapeHeight = p.height != null ? p.height : 2 * this._getMaxRadius('radiusY') + stroke;
	  };
	  /*
	    Method to create shape.
	    @private
	  */


	  Shape.prototype._createShape = function _createShape() {
	    // calculate max shape canvas size and set to _props
	    this._getShapeSize();
	    // don't create actual shape if !`isWithShape`
	    if (!this._props.isWithShape) {
	      return;
	    }

	    var p = this._props;
	    // get shape's class
	    var Shape = shapesMap.getShape(this._props.shape);
	    // create `_shape` module
	    this.shapeModule = new Shape({
	      width: p.shapeWidth,
	      height: p.shapeHeight,
	      parent: this.el
	    });
	  };
	  /*
	    Method to get max size in `then` chain
	    @private
	  */


	  Shape.prototype._getMaxSizeInChain = function _getMaxSizeInChain() {
	    var p = this._props,
	        maxW = 0,
	        maxH = 0;

	    for (var i = 0; i < this._modules.length; i++) {
	      this._modules[i]._getShapeSize();
	      maxW = Math.max(maxW, this._modules[i]._props.shapeWidth);
	      maxH = Math.max(maxH, this._modules[i]._props.shapeHeight);
	    }

	    this.shapeModule && this.shapeModule._setSize(maxW, maxH);
	    this._setElSizeStyles(maxW, maxH);
	  };
	  /*
	    Method to get max value of the strokeWidth.
	    @private
	  */


	  Shape.prototype._getMaxStroke = function _getMaxStroke() {
	    var p = this._props;
	    var dStroke = this._deltas['strokeWidth'];
	    return dStroke != null ? Math.max(dStroke.start, dStroke.end) : p.strokeWidth;
	  };
	  /*
	    Method to draw current progress of the deltas.
	    @private
	    @override @ Module
	    @param   {Number}  EasedProgress to set - [0..1].
	    @param   {Number}  Progress to set - [0..1].
	  */


	  Shape.prototype._setProgress = function _setProgress(easedProgress, progress) {
	    // call the super on Module
	    _module2.default.prototype._setProgress.call(this, easedProgress, progress);
	    // draw current progress
	    this._draw(easedProgress);
	  };
	  /*
	    Method to add callback overrides to passed object.
	    @private
	    @param {Object} Object to add the overrides to.
	  */


	  Shape.prototype._applyCallbackOverrides = function _applyCallbackOverrides(obj) {
	    var it = this,
	        p = this._props;
	    // specify control functions for the module
	    obj.callbackOverrides = {
	      onUpdate: function onUpdate(ep, p) {
	        return it._setProgress(ep, p);
	      },
	      onStart: function onStart(isFwd) {
	        // don't touch main `el` onStart in chained elements
	        if (it._isChained) {
	          return;
	        };
	        if (isFwd) {
	          it._show();
	        } else {
	          if (!p.isShowStart) {
	            it._hide();
	          }
	        }
	      },
	      onComplete: function onComplete(isFwd) {
	        // don't touch main `el` if not the last in `then` chain
	        if (!it._isLastInChain()) {
	          return;
	        }
	        if (isFwd) {
	          if (!p.isShowEnd) {
	            it._hide();
	          }
	        } else {
	          it._show();
	        }
	      },
	      onRefresh: function onRefresh(isBefore) {
	        p.isRefreshState && isBefore && it._refreshBefore();
	      }
	    };
	  };
	  /*
	    Method to setup tween and timeline options before creating them.
	    @override @ Tweenable
	    @private
	  */


	  Shape.prototype._transformTweenOptions = function _transformTweenOptions() {
	    this._applyCallbackOverrides(this._o);
	  };
	  /*
	    Method to create transform string.
	    @private
	    @returns {String} Transform string.
	  */


	  Shape.prototype._fillTransform = function _fillTransform() {
	    var p = this._props,
	        scaleX = p.scaleX != null ? p.scaleX : p.scale,
	        scaleY = p.scaleY != null ? p.scaleY : p.scale,
	        scale = scaleX + ', ' + scaleY;
	    return 'translate(' + p.x + ', ' + p.y + ') rotate(' + p.angle + 'deg) scale(' + scale + ')';
	  };
	  /*
	    Method to create transform-origin string.
	    @private
	    @returns {String} Transform string.
	  */


	  Shape.prototype._fillOrigin = function _fillOrigin() {
	    var p = this._props,
	        str = '';
	    for (var i = 0; i < p.origin.length; i++) {
	      str += p.origin[i].string + ' ';
	    }
	    return str;
	  };
	  /*
	    Method to refresh state befor startTime.
	    @private
	  */


	  Shape.prototype._refreshBefore = function _refreshBefore() {
	    // call setProgress with eased and normal progress
	    this._setProgress(this.tween._props.easing(0), 0);

	    if (this._props.isShowStart) {
	      this._show();
	    } else {
	      this._hide();
	    }
	  };
	  /*
	    Method that gets called on `soft` show of the module,
	    it should restore transform styles of the module.
	    @private
	    @overrides @ Module
	  */


	  Shape.prototype._showByTransform = function _showByTransform() {
	    // reset the cache of the scale prop
	    this._lastSet.scale = null;
	    // draw el accroding to it's props
	    this._drawEl();
	  };

	  return Shape;
	}(_tunable2.default);

	exports.default = Shape;

/***/ }),
/* 95 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(96), __esModule: true };

/***/ }),
/* 96 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(97);
	module.exports = __webpack_require__(14).Object.keys;

/***/ }),
/* 97 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.2.14 Object.keys(O)
	var toObject = __webpack_require__(49)
	  , $keys    = __webpack_require__(33);

	__webpack_require__(98)('keys', function(){
	  return function keys(it){
	    return $keys(toObject(it));
	  };
	});

/***/ }),
/* 98 */
/***/ (function(module, exports, __webpack_require__) {

	// most Object methods by ES6 should accept primitives
	var $export = __webpack_require__(12)
	  , core    = __webpack_require__(14)
	  , fails   = __webpack_require__(23);
	module.exports = function(KEY, exec){
	  var fn  = (core.Object || {})[KEY] || Object[KEY]
	    , exp = {};
	  exp[KEY] = exec(fn);
	  $export($export.S + $export.F * fails(function(){ fn(1); }), 'Object', exp);
	};

/***/ }),
/* 99 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _keys = __webpack_require__(95);

	var _keys2 = _interopRequireDefault(_keys);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _tweenable = __webpack_require__(100);

	var _tweenable2 = _interopRequireDefault(_tweenable);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	/*
	  The Thenable class adds .then public method and
	  the ability to chain API calls.
	*/
	var Thenable = function (_Tweenable) {
	  (0, _inherits3.default)(Thenable, _Tweenable);

	  function Thenable() {
	    (0, _classCallCheck3.default)(this, Thenable);
	    return (0, _possibleConstructorReturn3.default)(this, _Tweenable.apply(this, arguments));
	  }

	  /*
	    Method to create a then record for the module.
	    @public
	    @param    {Object} Options for the next animation.
	    @returns  {Object} this.
	  */
	  Thenable.prototype.then = function then(o) {
	    // return if nothing was passed
	    if (o == null || !(0, _keys2.default)(o).length) {
	      return 1;
	    }
	    // merge then options with the current ones
	    var prevRecord = this._history[this._history.length - 1],
	        prevModule = this._modules[this._modules.length - 1],
	        merged = this._mergeThenOptions(prevRecord, o);

	    this._resetMergedFlags(merged);
	    // create a submodule of the same type as the master module
	    var module = new this.constructor(merged);
	    // set `this` as amster module of child module
	    module._masterModule = this;
	    // save the modules to the _modules array
	    this._modules.push(module);
	    // add module's tween into master timeline
	    this.timeline.append(module);

	    return this;
	  };

	  // ^ PUBLIC  METHOD(S) ^
	  // v PRIVATE METHOD(S) v

	  /*
	    Method to reset some flags on merged options object.
	    @private
	    @param   {Object} Options object.
	    @returns {Object} Options object.
	  */


	  Thenable.prototype._resetMergedFlags = function _resetMergedFlags(obj) {
	    // set the submodule to be without timeline for perf reasons
	    obj.isTimelineLess = true;
	    // reset isShowStart flag for the submodules
	    obj.isShowStart = false;
	    // reset isRefreshState flag for the submodules
	    obj.isRefreshState = false;
	    // set the submodule callbacks context
	    obj.callbacksContext = this._props.callbacksContext || this;
	    // set previous module
	    obj.prevChainModule = _h2.default.getLastItem(this._modules);
	    // pass the `this` as master module
	    obj.masterModule = this;
	    return obj;
	  };
	  /*
	    Method to initialize properties.
	    @private
	  */


	  Thenable.prototype._vars = function _vars() {
	    _Tweenable.prototype._vars.call(this);
	    // save _master module
	    this._masterModule = this._o.masterModule;
	    // set isChained flag based on prevChainModule option
	    this._isChained = !!this._masterModule;
	    // we are expect that the _o object
	    // have been already extended by defaults
	    var initialRecord = _h2.default.cloneObj(this._props);
	    for (var key in this._arrayPropertyMap) {
	      if (this._o[key]) {
	        var preParsed = this._parsePreArrayProperty(key, this._o[key]);
	        initialRecord[key] = preParsed;
	      }
	    }

	    this._history = [initialRecord];
	    // the array holds all modules in the then chain
	    this._modules = [this];
	    // the props that to exclude from then merge
	    this._nonMergeProps = { shape: 1 };
	  };
	  /*
	    Method to merge two options into one. Used in .then chains.
	    @private
	    @param {Object} Start options for the merge.
	    @param {Object} End options for the merge.
	    @returns {Object} Merged options.
	  */


	  Thenable.prototype._mergeThenOptions = function _mergeThenOptions(start, end) {
	    var o = {};
	    this._mergeStartLoop(o, start);
	    this._mergeEndLoop(o, start, end);
	    this._history.push(o);
	    return o;
	  };
	  /*
	    Method to pipe startValue of the delta.
	    @private
	    @param {String} Start property name.
	    @param {Any} Start property value.
	    @returns {Any} Start property value.
	  */


	  Thenable.prototype._checkStartValue = function _checkStartValue(name, value) {
	    return value;
	  };
	  /*
	    Originally part of the _mergeThenOptions.
	    Loops thru start object and copies all the props from it.
	    @param {Object} An object to copy in.
	    @parma {Object} Start options object.
	  */


	  Thenable.prototype._mergeStartLoop = function _mergeStartLoop(o, start) {
	    // loop thru start options object
	    for (var key in start) {
	      var value = start[key];
	      if (start[key] == null) {
	        continue;
	      };
	      // copy all values from start if not tween prop or duration
	      if (!_h2.default.isTweenProp(key) || key === 'duration') {
	        // if delta - copy only the end value
	        if (this._isDelta(value)) {
	          o[key] = _h2.default.getDeltaEnd(value);
	        } else {
	          o[key] = value;
	        }
	      }
	    }
	  };
	  /*
	    Originally part of the _mergeThenOptions.
	    Loops thru start object and merges all the props from it.
	    @param {Object} An object to copy in.
	    @parma {Object} Start options object.
	    @parma {Object} End options object.
	  */


	  Thenable.prototype._mergeEndLoop = function _mergeEndLoop(o, start, end) {
	    var endKeys = (0, _keys2.default)(end);

	    for (var key in end) {
	      // just copy parent option
	      if (key == 'parent') {
	        o[key] = end[key];continue;
	      };

	      // get key/value of the end object
	      // endKey - name of the property, endValue - value of the property
	      var endValue = end[key],
	          startValue = start[key] != null ? start[key] : this._defaults[key];

	      startValue = this._checkStartValue(key, startValue);
	      if (endValue == null) {
	        continue;
	      };
	      // make ∆ of start -> end
	      // if key name is radiusX/radiusY and
	      // the startValue is not set fallback to radius value
	      var isSubRadius = key === 'radiusX' || key === 'radiusY';
	      if (isSubRadius && startValue == null) {
	        startValue = start.radius;
	      }

	      var isSubRadius = key === 'scaleX' || key === 'scaleY';
	      if (isSubRadius && startValue == null) {
	        startValue = start.scale;
	      }

	      o[key] = this._mergeThenProperty(key, startValue, endValue);
	    }
	  };
	  /*
	    Method to merge `start` and `end` for a property in then record.
	    @private
	    @param {String} Property name.
	    @param {Any}    Start value of the property.
	    @param {Any}    End value of the property.
	  */


	  Thenable.prototype._mergeThenProperty = function _mergeThenProperty(key, startValue, endValue) {
	    // if isnt tween property
	    var isBoolean = typeof endValue === 'boolean',
	        curve,
	        easing;

	    if (!_h2.default.isTweenProp(key) && !this._nonMergeProps[key] && !isBoolean) {

	      if (_h2.default.isObject(endValue) && endValue.to != null) {
	        curve = endValue.curve;
	        easing = endValue.easing;
	        endValue = endValue.to;
	      }

	      // if end value is delta - just save it
	      if (this._isDelta(endValue)) {
	        return this._parseDeltaValues(key, endValue);
	      } else {
	        var parsedEndValue = this._parsePreArrayProperty(key, endValue);
	        // if end value is not delta - merge with start value
	        if (this._isDelta(startValue)) {
	          var _ref;

	          // if start value is delta - take the end value
	          // as start value of the new delta
	          return _ref = {}, _ref[_h2.default.getDeltaEnd(startValue)] = parsedEndValue, _ref.easing = easing, _ref.curve = curve, _ref;
	          // if both start and end value are not ∆ - make ∆
	        } else {
	          var _ref2;

	          return _ref2 = {}, _ref2[startValue] = parsedEndValue, _ref2.easing = easing, _ref2.curve = curve, _ref2;
	        }
	      }
	      // copy the tween values unattended
	    } else {
	      return endValue;
	    }
	  };
	  /*
	    Method to retreive array's length and return -1 for
	    all other types.
	    @private
	    @param {Array, Any} Array to get the width for.
	    @returns {Number} Array length or -1 if not array.
	  */


	  Thenable.prototype._getArrayLength = function _getArrayLength(arr) {
	    return _h2.default.isArray(arr) ? arr.length : -1;
	  };
	  /*
	    Method to check if the property is delta property.
	    @private
	    @param {Any} Parameter value to check.
	    @returns {Boolean}
	  */


	  Thenable.prototype._isDelta = function _isDelta(optionsValue) {
	    var isObject = _h2.default.isObject(optionsValue);
	    isObject = isObject && !optionsValue.unit;
	    return !(!isObject || _h2.default.isArray(optionsValue) || _h2.default.isDOM(optionsValue));
	  };
	  /*
	    Method to check if the module is first in `then` chain.
	    @private
	    @returns {Boolean} If the module is the first in module chain.
	  */


	  Thenable.prototype._isFirstInChain = function _isFirstInChain() {
	    return !this._masterModule;
	  };
	  /*
	    Method to check if the module is last in `then` chain.
	    @private
	    @returns {Boolean} If the module is the last in module chain.
	  */


	  Thenable.prototype._isLastInChain = function _isLastInChain() {
	    var master = this._masterModule;
	    // if there is no master field - check the modules length
	    // if module length is 1 thus there is no modules chain 
	    // it is the last one, otherwise it isnt
	    if (!master) {
	      return this._modules.length === 1;
	    }
	    // if there is master - check if it is the last item in _modules chain
	    return this === _h2.default.getLastItem(master._modules);
	  };

	  return Thenable;
	}(_tweenable2.default);

	exports.default = Thenable;

/***/ }),
/* 100 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _tween = __webpack_require__(101);

	var _tween2 = _interopRequireDefault(_tween);

	var _timeline = __webpack_require__(110);

	var _timeline2 = _interopRequireDefault(_timeline);

	var _module = __webpack_require__(84);

	var _module2 = _interopRequireDefault(_module);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	/*
	  Class to define a module ancestor
	  with timeline and tween options and functionality.
	  All runable modules should inherit from this class.

	  @class Tweenable
	*/
	var Tweenable = function (_Module) {
	  (0, _inherits3.default)(Tweenable, _Module);

	  /*
	    `play` method for the timeline.
	    @public
	    @param {Number} Time shift.
	    @returns this.
	  */
	  Tweenable.prototype.play = function play() {
	    this.timeline.play.apply(this.timeline, arguments);
	    return this;
	  };
	  /*
	    `playBackward` method for the timeline.
	    @public
	    @param {Number} Time shift.
	    @returns this.
	  */


	  Tweenable.prototype.playBackward = function playBackward() {
	    this.timeline.playBackward.apply(this.timeline, arguments);
	    return this;
	  };
	  /*
	    `pause` method for the timeline.
	    @public
	    @returns this.
	  */


	  Tweenable.prototype.pause = function pause() {
	    this.timeline.pause.apply(this.timeline, arguments);
	    return this;
	  };
	  /*
	    `stop` method for the timeline.
	    @public
	    @param {Number} [0...1] Progress to set on stop.
	                            *Default* is `0` if `play`
	                            and `1` if `playBAckward`.
	    @returns this.
	  */


	  Tweenable.prototype.stop = function stop() {
	    this.timeline.stop.apply(this.timeline, arguments);
	    return this;
	  };
	  /*
	    `reset` method for the timeline.
	    @public
	    @returns this.
	  */


	  Tweenable.prototype.reset = function reset() {
	    this.timeline.reset.apply(this.timeline, arguments);
	    return this;
	  };
	  /*
	    `replay` method for the timeline.
	    @public
	    @returns this.
	  */


	  Tweenable.prototype.replay = function replay() {
	    this.timeline.replay.apply(this.timeline, arguments);
	    return this;
	  };
	  /*
	    `replay` method for the timeline.
	    @public
	    @returns this.
	  */


	  Tweenable.prototype.replayBackward = function replayBackward() {
	    this.timeline.replayBackward.apply(this.timeline, arguments);
	    return this;
	  };
	  /*
	    `resume` method for the timeline.
	    @public
	    @param {Number} Time shift.
	    @returns this.
	  */


	  Tweenable.prototype.resume = function resume() {
	    var shift = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

	    this.timeline.resume.apply(this.timeline, arguments);
	    return this;
	  };
	  /*
	    `setProgress` method for the timeline.
	    @public
	    @param {Number} [0...1] Progress value.
	    @returns this.
	  */


	  Tweenable.prototype.setProgress = function setProgress() {
	    this.timeline.setProgress.apply(this.timeline, arguments);
	    return this;
	  };
	  /*
	    setSpeed method for the timeline.
	    @param {Number} Speed value.
	    @returns this.
	  */


	  Tweenable.prototype.setSpeed = function setSpeed(speed) {
	    this.timeline.setSpeed.apply(this.timeline, arguments);
	    return this;
	  };

	  // ^ PUBLIC  METHOD(S) ^
	  // v PRIVATE METHOD(S) v

	  function Tweenable() {
	    var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    (0, _classCallCheck3.default)(this, Tweenable);

	    // pipe function for _o object
	    // before creating tween/timeline
	    var _this = (0, _possibleConstructorReturn3.default)(this, _Module.call(this, o));
	    // super of Module


	    _this._transformTweenOptions();
	    // make tween only if isTweenLess option is not set
	    !_this._o.isTweenLess && _this._makeTween();
	    // make timeline only if isTimelineLess option is not set
	    !_this._o.isTimelineLess && _this._makeTimeline();
	    return _this;
	  }
	  /*
	    Placeholder method that should be overrided
	    and will be called before tween/timeline creation.
	    @private
	  */


	  Tweenable.prototype._transformTweenOptions = function _transformTweenOptions() {};
	  /*
	    Method to create tween.
	    @private
	  */


	  Tweenable.prototype._makeTween = function _makeTween() {
	    // pass callbacks context
	    this._o.callbacksContext = this._o.callbacksContext || this;
	    this.tween = new _tween2.default(this._o);
	    // make timeline property point to tween one is "no timeline" mode
	    this._o.isTimelineLess && (this.timeline = this.tween);
	  };
	  /*
	    Method to create timeline.
	    @private
	    @param {Object} Timeline's options.
	                    An object which contains "timeline" property with
	                    timeline options.
	  */


	  Tweenable.prototype._makeTimeline = function _makeTimeline() {
	    // pass callbacks context
	    this._o.timeline = this._o.timeline || {};
	    this._o.timeline.callbacksContext = this._o.callbacksContext || this;
	    this.timeline = new _timeline2.default(this._o.timeline);
	    // set the flag to indicate that real timeline is present
	    this._isTimeline = true;
	    // if tween exist - add it to the timeline there is some
	    // modules like burst and stagger that have no tween
	    this.tween && this.timeline.add(this.tween);
	  };

	  return Tweenable;
	}(_module2.default);

	exports.default = Tweenable;

/***/ }),
/* 101 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	var _tweener = __webpack_require__(102);

	var _tweener2 = _interopRequireDefault(_tweener);

	var _easing = __webpack_require__(105);

	var _easing2 = _interopRequireDefault(_easing);

	var _module = __webpack_require__(84);

	var _module2 = _interopRequireDefault(_module);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	// import h from '../h';
	var Tween = function (_Module) {
	  (0, _inherits3.default)(Tween, _Module);

	  /*
	    Method do declare defaults with this._defaults object.
	    @private
	  */
	  Tween.prototype._declareDefaults = function _declareDefaults() {
	    // DEFAULTS
	    this._defaults = {
	      /* duration of the tween [0..∞] */
	      duration: 350,
	      /* delay of the tween [-∞..∞] */
	      delay: 0,
	      /* repeat of the tween [0..∞], means how much to
	         repeat the tween regardless first run,
	         for instance repeat: 2 will make the tween run 3 times */
	      repeat: 0,
	      /* speed of playback [0..∞], speed that is less then 1
	         will slowdown playback, for instance .5 will make tween
	         run 2x slower. Speed of 2 will speedup the tween to 2x. */
	      speed: 1,
	      /*  flip onUpdate's progress on each even period.
	          note that callbacks order won't flip at least
	          for now (under consideration). */
	      isYoyo: false,
	      /* easing for the tween, could be any easing type [link to easing-types.md] */
	      easing: 'Sin.Out',
	      /*
	        Easing for backward direction of the tweenthe tween,
	        if `null` - fallbacks to `easing` property.
	        forward direction in `yoyo` period is treated as backward for the easing.
	      */
	      backwardEasing: null,
	      /* custom tween's name */
	      name: null,
	      /* custom tween's base name */
	      nameBase: 'Tween',
	      /*
	        onProgress callback runs before any other callback.
	        @param {Number}   The entire, not eased, progress
	                          of the tween regarding repeat option.
	        @param {Boolean}  The direction of the tween.
	                          `true` for forward direction.
	                          `false` for backward direction(tween runs in reverse).
	      */
	      onProgress: null,
	      /*
	        onStart callback runs on very start of the tween just after onProgress
	        one. Runs on very end of the tween if tween is reversed.
	        @param {Boolean}  Direction of the tween.
	                          `true` for forward direction.
	                          `false` for backward direction(tween runs in reverse).
	      */
	      onStart: null,
	      onRefresh: null,
	      onComplete: null,
	      onRepeatStart: null,
	      onRepeatComplete: null,
	      onFirstUpdate: null,
	      onUpdate: null,
	      isChained: false,
	      // playback callbacks
	      onPlaybackStart: null,
	      onPlaybackPause: null,
	      onPlaybackStop: null,
	      onPlaybackComplete: null,
	      // context which all callbacks will be called with
	      callbacksContext: null
	    };
	  };
	  /*
	    API method to play the Tween.
	    @public
	    @param  {Number} Shift time in milliseconds.
	    @return {Object} Self.
	  */


	  Tween.prototype.play = function play() {
	    var shift = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

	    if (this._state === 'play' && this._isRunning) {
	      return this;
	    }
	    this._props.isReversed = false;
	    this._subPlay(shift, 'play');
	    this._setPlaybackState('play');
	    return this;
	  };
	  /*
	    API method to play the Tween in reverse.
	    @public
	    @param  {Number} Shift time in milliseconds.
	    @return {Object} Self.
	  */


	  Tween.prototype.playBackward = function playBackward() {
	    var shift = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

	    if (this._state === 'reverse' && this._isRunning) {
	      return this;
	    }
	    this._props.isReversed = true;
	    this._subPlay(shift, 'reverse');
	    this._setPlaybackState('reverse');
	    return this;
	  };
	  /*
	    API method to pause Tween.
	    @public
	    @returns {Object} Self.
	  */


	  Tween.prototype.pause = function pause() {
	    if (this._state === 'pause' || this._state === 'stop') {
	      return this;
	    }
	    this._removeFromTweener();
	    this._setPlaybackState('pause');
	    return this;
	  };
	  /*
	    API method to stop the Tween.
	    @public
	    @param   {Number} Progress [0..1] to set when stopped.
	    @returns {Object} Self.
	  */


	  Tween.prototype.stop = function stop(progress) {
	    if (this._state === 'stop') {
	      return this;
	    }

	    this._wasUknownUpdate = undefined;

	    var stopProc = progress != null ? progress
	    /* if no progress passsed - set 1 if tween
	       is playingBackward, otherwise set to 0 */
	    : this._state === 'reverse' ? 1 : 0;

	    this.setProgress(stopProc);

	    this.reset();
	    return this;
	  };
	  /*
	    API method to replay(restart) the Tween.
	    @public
	    @param   {Number} Shift time in milliseconds.
	    @returns {Object} Self.
	  */


	  Tween.prototype.replay = function replay() {
	    var shift = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

	    this.reset();
	    this.play(shift);
	    return this;
	  };
	  /*
	    API method to replay(restart) backward the Tween.
	    @public
	    @param   {Number} Shift time in milliseconds.
	    @returns {Object} Self.
	  */


	  Tween.prototype.replayBackward = function replayBackward() {
	    var shift = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

	    this.reset();
	    this.playBackward(shift);
	    return this;
	  };
	  /*
	    API method to resume the Tween.
	    @public
	    @param  {Number} Shift time in milliseconds.
	    @return {Object} Self.
	  */


	  Tween.prototype.resume = function resume() {
	    var shift = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

	    if (this._state !== 'pause') {
	      return this;
	    }

	    switch (this._prevState) {
	      case 'play':
	        this.play(shift);
	        break;
	      case 'reverse':
	        this.playBackward(shift);
	        break;
	    }

	    return this;
	  };
	  /*
	    API method to set progress on tween.
	    @public
	    @param {Number} Progress to set.
	    @returns {Object} Self.
	  */


	  Tween.prototype.setProgress = function setProgress(progress) {
	    var p = this._props;
	    // set start time if there is no one yet.
	    !p.startTime && this._setStartTime();
	    // reset play time
	    this._playTime = null;
	    // progress should be in range of [0..1]
	    progress < 0 && (progress = 0);
	    progress > 1 && (progress = 1);
	    // update self with calculated time
	    this._update(p.startTime - p.delay + progress * p.repeatTime);
	    return this;
	  };
	  /*
	    Method to set tween's speed.
	    @public
	    @param {Number} Speed value.
	    @returns this.
	  */


	  Tween.prototype.setSpeed = function setSpeed(speed) {
	    this._props.speed = speed;
	    // if playing - normalize _startTime and _prevTime to the current point.
	    if (this._state === 'play' || this._state === 'reverse') {
	      this._setResumeTime(this._state);
	    }
	    return this;
	  };
	  /*
	    Method to reset tween's state and properties.
	    @public
	    @returns this.
	  */


	  Tween.prototype.reset = function reset() {
	    this._removeFromTweener();
	    this._setPlaybackState('stop');
	    this._progressTime = 0;
	    this._isCompleted = false;
	    this._isStarted = false;
	    this._isFirstUpdate = false;
	    this._wasUknownUpdate = undefined;
	    this._prevTime = undefined;
	    this._prevYoyo = undefined;
	    // this._props.startTime  = undefined;
	    this._props.isReversed = false;
	    return this;
	  };

	  // ^ PUBLIC  METHOD(S) ^
	  // v PRIVATE METHOD(S) v

	  /*
	    Method to launch play. Used as launch
	    method for bothplay and reverse methods.
	    @private
	    @param  {Number} Shift time in milliseconds.
	    @param  {String} Play or reverse state.
	    @return {Object} Self.
	  */


	  Tween.prototype._subPlay = function _subPlay() {
	    var shift = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
	    var state = arguments[1];

	    var resumeTime,
	        startTime,
	        p = this._props,

	    // check if direction of playback changes,
	    // if so, the _progressTime needs to be flipped
	    _state = this._state,
	        _prevState = this._prevState,
	        isPause = _state === 'pause',
	        wasPlay = _state === 'play' || isPause && _prevState === 'play',
	        wasReverse = _state === 'reverse' || isPause && _prevState === 'reverse',
	        isFlip = wasPlay && state === 'reverse' || wasReverse && state === 'play';

	    // if tween was ended, set progress to 0 if not, set to elapsed progress
	    this._progressTime = this._progressTime >= p.repeatTime ? 0 : this._progressTime;
	    // flip the _progressTime if playback direction changed
	    if (isFlip) {
	      this._progressTime = p.repeatTime - this._progressTime;
	    }
	    // set resume time and normalize prev/start times
	    this._setResumeTime(state, shift);
	    // add self to tweener = play
	    _tweener2.default.add(this);
	    return this;
	  };
	  /*
	    Method to set _resumeTime, _startTime and _prevTime.
	    @private
	    @param {String} Current state. [play, reverse]
	    @param {Number} Time shift. *Default* is 0.
	  */


	  Tween.prototype._setResumeTime = function _setResumeTime(state) {
	    var shift = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

	    // get current moment as resume time
	    this._resumeTime = performance.now();
	    // set start time regarding passed `shift` and `procTime`
	    var startTime = this._resumeTime - Math.abs(shift) - this._progressTime;
	    this._setStartTime(startTime, false);
	    // if we have prevTime - we need to normalize
	    // it for the current resume time
	    if (this._prevTime != null) {
	      this._prevTime = state === 'play' ? this._normPrevTimeForward() : this._props.endTime - this._progressTime;
	    }
	  };
	  /*
	    Method recalculate _prevTime for forward direction.
	    @private
	    @return {Number} Normalized prev time.
	  */


	  Tween.prototype._normPrevTimeForward = function _normPrevTimeForward() {
	    var p = this._props;
	    return p.startTime + this._progressTime - p.delay;
	  };
	  /*
	    Constructor of the class.
	    @private
	  */


	  function Tween() {
	    var _ret;

	    var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    (0, _classCallCheck3.default)(this, Tween);

	    var _this = (0, _possibleConstructorReturn3.default)(this, _Module.call(this, o));

	    _this._props.name == null && _this._setSelfName();
	    return _ret = _this, (0, _possibleConstructorReturn3.default)(_this, _ret);
	  }
	  /*
	    Method to set self name to generic one.
	    @private
	  */


	  Tween.prototype._setSelfName = function _setSelfName() {
	    var globalName = '_' + this._props.nameBase + 's';
	    // track amount of tweens globally
	    _tweener2.default[globalName] = _tweener2.default[globalName] == null ? 1 : ++_tweener2.default[globalName];
	    // and set generic tween's name  || Tween # ||
	    this._props.name = this._props.nameBase + ' ' + _tweener2.default[globalName];
	  };
	  /*
	    Method set playback state string.
	    @private
	    @param {String} State name
	  */


	  Tween.prototype._setPlaybackState = function _setPlaybackState(state) {
	    // save previous state
	    this._prevState = this._state;
	    this._state = state;

	    // callbacks
	    var wasPause = this._prevState === 'pause',
	        wasStop = this._prevState === 'stop',
	        wasPlay = this._prevState === 'play',
	        wasReverse = this._prevState === 'reverse',
	        wasPlaying = wasPlay || wasReverse,
	        wasStill = wasStop || wasPause;

	    if ((state === 'play' || state === 'reverse') && wasStill) {
	      this._playbackStart();
	    }
	    if (state === 'pause' && wasPlaying) {
	      this._playbackPause();
	    }
	    if (state === 'stop' && (wasPlaying || wasPause)) {
	      this._playbackStop();
	    }
	  };
	  /*
	    Method to declare some vars.
	    @private
	  */


	  Tween.prototype._vars = function _vars() {
	    this.progress = 0;
	    this._prevTime = undefined;
	    this._progressTime = 0;
	    this._negativeShift = 0;
	    this._state = 'stop';
	    // if negative delay was specified,
	    // save it to _negativeShift property and
	    // reset it back to 0
	    if (this._props.delay < 0) {
	      this._negativeShift = this._props.delay;
	      this._props.delay = 0;
	    }

	    return this._calcDimentions();
	  };
	  /*
	    Method to calculate tween's dimentions.
	    @private
	  */


	  Tween.prototype._calcDimentions = function _calcDimentions() {
	    this._props.time = this._props.duration + this._props.delay;
	    this._props.repeatTime = this._props.time * (this._props.repeat + 1);
	  };
	  /*
	    Method to extend defaults by options and put them in _props.
	    @private
	  */


	  Tween.prototype._extendDefaults = function _extendDefaults() {
	    // save callback overrides object with fallback to empty one
	    this._callbackOverrides = this._o.callbackOverrides || {};
	    delete this._o.callbackOverrides;
	    // call the _extendDefaults @ Module
	    _Module.prototype._extendDefaults.call(this);

	    var p = this._props;
	    p.easing = _easing2.default.parseEasing(p.easing);
	    p.easing._parent = this;

	    // parse only present backward easing to prevent parsing as `linear.none`
	    // because we need to fallback to `easing` in `_setProgress` method
	    if (p.backwardEasing != null) {
	      p.backwardEasing = _easing2.default.parseEasing(p.backwardEasing);
	      p.backwardEasing._parent = this;
	    }
	  };
	  /*
	    Method for setting start and end time to props.
	    @private
	    @param {Number(Timestamp)}, {Null} Start time.
	    @param {Boolean} Should reset flags.
	    @returns this
	  */


	  Tween.prototype._setStartTime = function _setStartTime(time) {
	    var isResetFlags = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

	    var p = this._props,
	        shiftTime = p.shiftTime || 0;
	    // reset flags
	    if (isResetFlags) {
	      this._isCompleted = false;this._isRepeatCompleted = false;
	      this._isStarted = false;
	    }
	    // set start time to passed time or to the current moment
	    var startTime = time == null ? performance.now() : time;
	    // calculate bounds
	    // - negativeShift is negative delay in options hash
	    // - shift time is shift of the parent
	    p.startTime = startTime + p.delay + this._negativeShift + shiftTime;
	    p.endTime = p.startTime + p.repeatTime - p.delay;
	    // set play time to the startTimes
	    // if playback controls are used - use _resumeTime as play time,
	    // else use shifted startTime -- shift is needed for timelines append chains
	    this._playTime = this._resumeTime != null ? this._resumeTime : startTime + shiftTime;
	    this._resumeTime = null;

	    return this;
	  };
	  /*
	    Method to update tween's progress.
	    @private
	    @param {Number} Current update time.
	    -- next params only present when parent Timeline calls the method.
	    @param {Number} Previous Timeline's update time.
	    @param {Boolean} Was parent in yoyo period.
	    @param {Number} [-1, 0, 1] If update is on edge.
	                   -1 = edge jump in negative direction.
	                    0 = no edge jump.
	                    1 = edge jump in positive direction.
	  */


	  Tween.prototype._update = function _update(time, timelinePrevTime, wasYoyo, onEdge) {
	    var p = this._props;
	    // if we don't the _prevTime thus the direction we are heading to,
	    // but prevTime was passed thus we are child of a Timeline
	    // set _prevTime to passed one and pretent that there was unknown
	    // update to not to block start/complete callbacks
	    if (this._prevTime == null && timelinePrevTime != null) {

	      if (this._props.speed && this._playTime) {
	        // play point + ( speed * delta )
	        this._prevTime = this._playTime + this._props.speed * (timelinePrevTime - this._playTime);
	      }
	      // this._prevTime = timelinePrevTime;
	      this._wasUknownUpdate = true;
	    }

	    // var before = time;
	    // cache vars
	    var startPoint = p.startTime - p.delay;
	    // if speed param was defined - calculate
	    // new time regarding speed
	    if (p.speed && this._playTime) {
	      // play point + ( speed * delta )
	      time = this._playTime + p.speed * (time - this._playTime);
	    }

	    // due to javascript precision issues, after speed mapping
	    // we can get very close number that was made from progress of 1
	    // and in fact represents `endTime` if so, set the time to `endTime`
	    if (Math.abs(p.endTime - time) < 0.00000001) {
	      time = p.endTime;
	    }

	    // if parent is onEdge but not very start nor very end
	    if (onEdge && wasYoyo != null) {
	      var T = this._getPeriod(time),
	          isYoyo = !!(p.isYoyo && this._props.repeat && T % 2 === 1);

	      // for timeline
	      // notify children about edge jump
	      if (this._timelines) {
	        for (var i = 0; i < this._timelines.length; i++) {
	          this._timelines[i]._update(time, timelinePrevTime, wasYoyo, onEdge);
	        }
	      }
	      // forward edge direction
	      if (onEdge === 1) {
	        // jumped from yoyo period?
	        if (wasYoyo) {
	          this._prevTime = time + 1;
	          this._repeatStart(time, isYoyo);
	          this._start(time, isYoyo);
	        } else {
	          this._prevTime = time - 1;
	          this._repeatComplete(time, isYoyo);
	          this._complete(time, isYoyo);
	        }
	        // backward edge direction
	      } else if (onEdge === -1) {
	        // jumped from yoyo period?
	        if (wasYoyo) {
	          this._prevTime = time - 1;
	          this._repeatComplete(time, isYoyo);
	          this._complete(time, isYoyo);
	        } else {
	          // call _start callbacks only if prev time was in active area
	          // not always true for append chains
	          if (this._prevTime >= p.startTime && this._prevTime <= p.endTime) {
	            this._prevTime = time + 1;
	            this._repeatStart(time, isYoyo);
	            this._start(time, isYoyo);
	            // reset isCOmpleted immediately to prevent onComplete cb
	            this._isCompleted = true;
	          }
	        }
	      }
	      // reset the _prevTime - drop one frame to undestand
	      // where we are heading
	      this._prevTime = undefined;
	    }
	    // if in active area and not ended - save progress time
	    // for pause/play purposes.
	    if (time > startPoint && time < p.endTime) {
	      this._progressTime = time - startPoint;
	    }
	    // else if not started or ended set progress time to 0
	    else if (time <= startPoint) {
	        this._progressTime = 0;
	      } else if (time >= p.endTime) {
	        // set progress time to repeat time + tiny cofficient
	        // to make it extend further than the end time
	        this._progressTime = p.repeatTime + .00000000001;
	      }
	    // reverse time if _props.isReversed is set
	    if (p.isReversed) {
	      time = p.endTime - this._progressTime;
	    }
	    // We need to know what direction we are heading to,
	    // so if we don't have the previous update value - this is very first
	    // update, - skip it entirely and wait for the next value
	    if (this._prevTime == null) {
	      this._prevTime = time;
	      this._wasUknownUpdate = true;
	      return false;
	    }

	    // ====== AFTER SKIPPED FRAME ======

	    // handle onProgress callback
	    if (time >= startPoint && time <= p.endTime) {
	      this._progress((time - startPoint) / p.repeatTime, time);
	    }
	    /*
	      if time is inside the active area of the tween.
	      active area is the area from start time to end time,
	      with all the repeat and delays in it
	    */
	    if (time >= p.startTime && time <= p.endTime) {
	      this._updateInActiveArea(time);
	    } else {
	      // if was in active area - update in inactive area but just once -
	      // right after the active area
	      if (this._isInActiveArea) {
	        this._updateInInactiveArea(time);
	      } else if (!this._isRefreshed) {
	        // onRefresh callback
	        // before startTime
	        if (time < p.startTime && this.progress !== 0) {
	          this._refresh(true);
	          this._isRefreshed = true;
	          // after endTime
	        }
	        // else if ( time > p.endTime ) { }
	      }
	    }

	    this._prevTime = time;
	    return time >= p.endTime || time <= startPoint;
	  };
	  /*
	    Method to handle tween's progress in inactive area.
	    @private
	    @param {Number} Current update time.
	  */


	  Tween.prototype._updateInInactiveArea = function _updateInInactiveArea(time) {
	    if (!this._isInActiveArea) {
	      return;
	    }
	    var p = this._props;
	    // complete if time is larger then end time
	    if (time > p.endTime && !this._isCompleted) {
	      this._progress(1, time);
	      // get period number
	      var T = this._getPeriod(p.endTime),
	          isYoyo = p.isYoyo && T % 2 === 0;

	      this._setProgress(isYoyo ? 0 : 1, time, isYoyo);
	      this._repeatComplete(time, isYoyo);
	      this._complete(time, isYoyo);
	    }
	    // if was active and went to - inactive area "-"
	    if (time < this._prevTime && time < p.startTime && !this._isStarted && !this._isCompleted) {
	      // if was in active area and didn't fire onStart callback
	      this._progress(0, time, false);
	      this._setProgress(0, time, false);
	      this._isRepeatStart = false;
	      this._repeatStart(time, false);
	      this._start(time, false);
	    }
	    this._isInActiveArea = false;
	  };
	  /*
	    Method to handle tween's progress in active area.
	    @private
	    @param {Number} Current update time.
	  */


	  Tween.prototype._updateInActiveArea = function _updateInActiveArea(time) {

	    var props = this._props,
	        delayDuration = props.delay + props.duration,
	        startPoint = props.startTime - props.delay,
	        elapsed = (time - props.startTime + props.delay) % delayDuration,
	        TCount = Math.round((props.endTime - props.startTime + props.delay) / delayDuration),
	        T = this._getPeriod(time),
	        TValue = this._delayT,
	        prevT = this._getPeriod(this._prevTime),
	        TPrevValue = this._delayT;

	    // "zero" and "one" value regarding yoyo and it's period
	    var isYoyo = props.isYoyo && T % 2 === 1,
	        isYoyoPrev = props.isYoyo && prevT % 2 === 1,
	        yoyoZero = isYoyo ? 1 : 0,
	        yoyoOne = 1 - yoyoZero;

	    if (time === props.endTime) {
	      this._wasUknownUpdate = false;
	      // if `time` is equal to `endTime`, T represents the next period,
	      // so we need to decrement T and calculate "one" value regarding yoyo
	      var isYoyo = props.isYoyo && (T - 1) % 2 === 1;
	      this._setProgress(isYoyo ? 0 : 1, time, isYoyo);
	      if (time > this._prevTime) {
	        this._isRepeatCompleted = false;
	      }
	      this._repeatComplete(time, isYoyo);
	      return this._complete(time, isYoyo);
	    }

	    // reset callback flags
	    this._isCompleted = false;
	    this._isRefreshed = false;
	    // if time is inside the duration area of the tween
	    if (startPoint + elapsed >= props.startTime) {
	      this._isInActiveArea = true;this._isRepeatCompleted = false;
	      this._isRepeatStart = false;this._isStarted = false;
	      // active zone or larger then end
	      var elapsed2 = (time - props.startTime) % delayDuration,
	          proc = elapsed2 / props.duration;
	      // |=====|=====|=====| >>>
	      //      ^1^2
	      var isOnEdge = T > 0 && prevT < T;
	      // |=====|=====|=====| <<<
	      //      ^2^1
	      var isOnReverseEdge = prevT > T;

	      // for use in timeline
	      this._onEdge = 0;
	      isOnEdge && (this._onEdge = 1);
	      isOnReverseEdge && (this._onEdge = -1);

	      if (this._wasUknownUpdate) {
	        if (time > this._prevTime) {
	          this._start(time, isYoyo);
	          this._repeatStart(time, isYoyo);
	          this._firstUpdate(time, isYoyo);
	        }
	        // if backward direction and 
	        // if ( time < this._prevTime && time !== this._props.startTime ) {
	        if (time < this._prevTime) {
	          this._complete(time, isYoyo);
	          this._repeatComplete(time, isYoyo);
	          this._firstUpdate(time, isYoyo);
	          // reset isCompleted immediately
	          this._isCompleted = false;
	        }
	      }

	      if (isOnEdge) {
	        // if not just after delay
	        // |---=====|---=====|---=====| >>>
	        //            ^1 ^2
	        // because we have already handled
	        // 1 and onRepeatComplete in delay gap
	        if (this.progress !== 1) {
	          // prevT
	          var isThisYoyo = props.isYoyo && (T - 1) % 2 === 1;
	          this._repeatComplete(time, isThisYoyo);
	        }
	        // if on edge but not at very start
	        // |=====|=====|=====| >>>
	        // ^!    ^here ^here 
	        if (prevT >= 0) {
	          this._repeatStart(time, isYoyo);
	        }
	      }

	      if (time > this._prevTime) {
	        //  |=====|=====|=====| >>>
	        // ^1  ^2
	        if (!this._isStarted && this._prevTime <= props.startTime) {
	          this._start(time, isYoyo);
	          this._repeatStart(time, isYoyo);
	          // it was zero anyways

	          // restart flags immediately in case if we will
	          // return to '-' inactive area on the next step
	          this._isStarted = false;
	          this._isRepeatStart = false;
	        }
	        this._firstUpdate(time, isYoyo);
	      }

	      if (isOnReverseEdge) {
	        // if on edge but not at very end
	        // |=====|=====|=====| <<<
	        //       ^here ^here ^not here
	        if (this.progress !== 0 && this.progress !== 1 && prevT != TCount) {
	          this._repeatStart(time, isYoyoPrev);
	        }
	        // if on very end edge
	        // |=====|=====|=====| <<<
	        //       ^!    ^! ^2 ^1
	        // we have handled the case in this._wasUknownUpdate
	        // block so filter that
	        if (prevT === TCount && !this._wasUknownUpdate) {
	          this._complete(time, isYoyo);
	          this._repeatComplete(time, isYoyo);
	          this._firstUpdate(time, isYoyo);
	          // reset isComplete flag call
	          // cuz we returned to active area
	          // this._isRepeatCompleted = false;
	          this._isCompleted = false;
	        }
	        this._repeatComplete(time, isYoyo);
	      }

	      if (prevT === 'delay') {
	        // if just before delay gap
	        // |---=====|---=====|---=====| <<<
	        //               ^2    ^1
	        if (T < TPrevValue) {
	          this._repeatComplete(time, isYoyo);
	        }
	        // if just after delay gap
	        // |---=====|---=====|---=====| >>>
	        //            ^1  ^2
	        if (T === TPrevValue && T > 0) {
	          this._repeatStart(time, isYoyo);
	        }
	      }

	      // swap progress and repeatStart based on direction
	      if (time > this._prevTime) {
	        // if progress is equal 0 and progress grows
	        if (proc === 0) {
	          this._repeatStart(time, isYoyo);
	        }
	        if (time !== props.endTime) {
	          this._setProgress(isYoyo ? 1 - proc : proc, time, isYoyo);
	        }
	      } else {
	        if (time !== props.endTime) {
	          this._setProgress(isYoyo ? 1 - proc : proc, time, isYoyo);
	        }
	        // if progress is equal 0 and progress grows
	        if (proc === 0) {
	          this._repeatStart(time, isYoyo);
	        }
	      }

	      if (time === props.startTime) {
	        this._start(time, isYoyo);
	      }
	      // delay gap - react only once
	    } else if (this._isInActiveArea) {
	      // because T will be string of "delay" here,
	      // let's normalize it be setting to TValue
	      var t = T === 'delay' ? TValue : T,
	          isGrows = time > this._prevTime;
	      // decrement period if forward direction of update
	      isGrows && t--;
	      // calculate normalized yoyoZero value
	      yoyoZero = props.isYoyo && t % 2 === 1 ? 1 : 0;
	      // if was in active area and previous time was larger
	      // |---=====|---=====|---=====| <<<
	      //   ^2 ^1    ^2 ^1    ^2 ^1
	      if (time < this._prevTime) {
	        this._setProgress(yoyoZero, time, yoyoZero === 1);
	        this._repeatStart(time, yoyoZero === 1);
	      }
	      // set 1 or 0 regarding direction and yoyo
	      this._setProgress(isGrows ? 1 - yoyoZero : yoyoZero, time, yoyoZero === 1);
	      // if time grows
	      if (time > this._prevTime) {
	        // if reverse direction and in delay gap, then progress will be 0
	        // if so we don't need to call the onRepeatComplete callback
	        // |---=====|---=====|---=====| <<<
	        //   ^0       ^0       ^0   
	        // OR we have flipped 0 to 1 regarding yoyo option
	        if (this.progress !== 0 || yoyoZero === 1) {
	          // since we repeatComplete for previous period
	          // invert isYoyo option
	          // is elapsed is 0 - count as previous period
	          this._repeatComplete(time, yoyoZero === 1);
	        }
	      }
	      // set flag to indicate inactive area
	      this._isInActiveArea = false;
	    }
	    // we've got the first update now
	    this._wasUknownUpdate = false;
	  };
	  /*
	    Method to remove the Tween from the tweener.
	    @private
	    @returns {Object} Self.
	  */


	  Tween.prototype._removeFromTweener = function _removeFromTweener() {
	    _tweener2.default.remove(this);return this;
	  };
	  /*
	    Method to get current period number.
	    @private
	    @param {Number} Time to get the period for.
	    @returns {Number} Current period number.
	  */


	  Tween.prototype._getPeriod = function _getPeriod(time) {
	    var p = this._props,
	        TTime = p.delay + p.duration,
	        dTime = p.delay + time - p.startTime,
	        T = dTime / TTime,

	    // if time if equal to endTime we need to set the elapsed
	    // time to 0 to fix the occasional precision js bug, which
	    // causes 0 to be something like 1e-12
	    elapsed = time < p.endTime ? dTime % TTime : 0;
	    // If the latest period, round the result, otherwise floor it.
	    // Basically we always can floor the result, but because of js
	    // precision issues, sometimes the result is 2.99999998 which
	    // will result in 2 instead of 3 after the floor operation.
	    T = time >= p.endTime ? Math.round(T) : Math.floor(T);
	    // if time is larger then the end time
	    if (time > p.endTime) {
	      // set equal to the periods count
	      T = Math.round((p.endTime - p.startTime + p.delay) / TTime);
	      // if in delay gap, set _delayT to current
	      // period number and return "delay"
	    } else if (elapsed > 0 && elapsed < p.delay) {
	      this._delayT = T;T = 'delay';
	    }
	    // if the end of period and there is a delay
	    return T;
	  };
	  /*
	    Method to set Tween's progress and call onUpdate callback.
	    @private
	    @override @ Module
	    @param {Number} Progress to set.
	    @param {Number} Current update time.
	    @param {Boolean} Is yoyo perido. Used in Timeline to pass to Tween.
	    @returns {Object} Self.
	  */


	  Tween.prototype._setProgress = function _setProgress(proc, time, isYoyo) {
	    var p = this._props,
	        isYoyoChanged = p.wasYoyo !== isYoyo,
	        isForward = time > this._prevTime;

	    this.progress = proc;
	    // get the current easing for `forward` direction regarding `yoyo`
	    if (isForward && !isYoyo || !isForward && isYoyo) {
	      this.easedProgress = p.easing(proc);
	      // get the current easing for `backward` direction regarding `yoyo`
	    } else if (!isForward && !isYoyo || isForward && isYoyo) {
	      var easing = p.backwardEasing != null ? p.backwardEasing : p.easing;

	      this.easedProgress = easing(proc);
	    }

	    if (p.prevEasedProgress !== this.easedProgress || isYoyoChanged) {
	      if (p.onUpdate != null && typeof p.onUpdate === 'function') {
	        p.onUpdate.call(p.callbacksContext || this, this.easedProgress, this.progress, isForward, isYoyo);
	      }
	    }
	    p.prevEasedProgress = this.easedProgress;
	    p.wasYoyo = isYoyo;
	    return this;
	  };
	  /*
	    Method to set tween's state to start and call onStart callback.
	    @method _start
	    @private
	    @param {Number} Progress to set.
	    @param {Boolean} Is yoyo period.
	  */


	  Tween.prototype._start = function _start(time, isYoyo) {
	    if (this._isStarted) {
	      return;
	    }
	    var p = this._props;
	    if (p.onStart != null && typeof p.onStart === 'function') {
	      p.onStart.call(p.callbacksContext || this, time > this._prevTime, isYoyo);
	    }
	    this._isCompleted = false;this._isStarted = true;
	    this._isFirstUpdate = false;
	  };
	  /*
	    Method to call onPlaybackStart callback
	    @private
	  */


	  Tween.prototype._playbackStart = function _playbackStart() {
	    var p = this._props;
	    if (p.onPlaybackStart != null && typeof p.onPlaybackStart === 'function') {
	      p.onPlaybackStart.call(p.callbacksContext || this);
	    }
	  };
	  /*
	    Method to call onPlaybackPause callback
	    @private
	  */


	  Tween.prototype._playbackPause = function _playbackPause() {
	    var p = this._props;
	    if (p.onPlaybackPause != null && typeof p.onPlaybackPause === 'function') {
	      p.onPlaybackPause.call(p.callbacksContext || this);
	    }
	  };
	  /*
	    Method to call onPlaybackStop callback
	    @private
	  */


	  Tween.prototype._playbackStop = function _playbackStop() {
	    var p = this._props;
	    if (p.onPlaybackStop != null && typeof p.onPlaybackStop === 'function') {
	      p.onPlaybackStop.call(p.callbacksContext || this);
	    }
	  };
	  /*
	    Method to call onPlaybackComplete callback
	    @private
	  */


	  Tween.prototype._playbackComplete = function _playbackComplete() {
	    var p = this._props;
	    if (p.onPlaybackComplete != null && typeof p.onPlaybackComplete === 'function') {
	      p.onPlaybackComplete.call(p.callbacksContext || this);
	    }
	  };
	  /*
	    Method to set tween's state to complete.
	    @method _complete
	    @private
	    @param {Number} Current time.
	    @param {Boolean} Is yoyo period.
	  */


	  Tween.prototype._complete = function _complete(time, isYoyo) {
	    if (this._isCompleted) {
	      return;
	    }
	    var p = this._props;
	    if (p.onComplete != null && typeof p.onComplete === 'function') {
	      p.onComplete.call(p.callbacksContext || this, time > this._prevTime, isYoyo);
	    }

	    this._isCompleted = true;this._isStarted = false;
	    this._isFirstUpdate = false;
	    // reset _prevYoyo for timeline usage
	    this._prevYoyo = undefined;
	  };

	  /*
	    Method to run onFirstUpdate callback.
	    @method _firstUpdate
	    @private
	    @param {Number} Current update time.
	    @param {Boolean} Is yoyo period.
	  */


	  Tween.prototype._firstUpdate = function _firstUpdate(time, isYoyo) {
	    if (this._isFirstUpdate) {
	      return;
	    }
	    var p = this._props;
	    if (p.onFirstUpdate != null && typeof p.onFirstUpdate === 'function') {
	      // onFirstUpdate should have tween pointer
	      p.onFirstUpdate.tween = this;
	      p.onFirstUpdate.call(p.callbacksContext || this, time > this._prevTime, isYoyo);
	    }
	    this._isFirstUpdate = true;
	  };
	  /*
	    Method call onRepeatComplete calback and set flags.
	    @private
	    @param {Number} Current update time.
	    @param {Boolean} Is repeat period.
	  */


	  Tween.prototype._repeatComplete = function _repeatComplete(time, isYoyo) {
	    if (this._isRepeatCompleted) {
	      return;
	    }
	    var p = this._props;
	    if (p.onRepeatComplete != null && typeof p.onRepeatComplete === 'function') {
	      p.onRepeatComplete.call(p.callbacksContext || this, time > this._prevTime, isYoyo);
	    }
	    this._isRepeatCompleted = true;
	    // this._prevYoyo = null;
	  };

	  /*
	    Method call onRepeatStart calback and set flags.
	    @private
	    @param {Number} Current update time.
	    @param {Boolean} Is yoyo period.
	  */


	  Tween.prototype._repeatStart = function _repeatStart(time, isYoyo) {
	    if (this._isRepeatStart) {
	      return;
	    }
	    var p = this._props;
	    if (p.onRepeatStart != null && typeof p.onRepeatStart === 'function') {
	      p.onRepeatStart.call(p.callbacksContext || this, time > this._prevTime, isYoyo);
	    }
	    this._isRepeatStart = true;
	  };
	  /*
	    Method to launch onProgress callback.
	    @method _progress
	    @private
	    @param {Number} Progress to set.
	  */


	  Tween.prototype._progress = function _progress(progress, time) {
	    var p = this._props;
	    if (p.onProgress != null && typeof p.onProgress === 'function') {
	      p.onProgress.call(p.callbacksContext || this, progress, time > this._prevTime);
	    }
	  };
	  /*
	    Method to launch onRefresh callback.
	    @method _refresh
	    @private
	    @param {Boolean} If refresh even before start time.
	  */


	  Tween.prototype._refresh = function _refresh(isBefore) {
	    var p = this._props;
	    if (p.onRefresh != null) {
	      var context = p.callbacksContext || this,
	          progress = isBefore ? 0 : 1;

	      p.onRefresh.call(context, isBefore, p.easing(progress), progress);
	    }
	  };
	  /*
	    Method which is called when the tween is removed from tweener.
	    @private
	  */


	  Tween.prototype._onTweenerRemove = function _onTweenerRemove() {};
	  /*
	    Method which is called when the tween is removed
	    from tweener when finished.
	    @private
	  */


	  Tween.prototype._onTweenerFinish = function _onTweenerFinish() {
	    this._setPlaybackState('stop');
	    this._playbackComplete();
	  };
	  /*
	    Method to set property[s] on Tween.
	    @private
	    @override @ Module
	    @param {Object, String} Hash object of key/value pairs, or property name.
	    @param {_} Property's value to set.
	  */


	  Tween.prototype._setProp = function _setProp(obj, value) {
	    _Module.prototype._setProp.call(this, obj, value);
	    this._calcDimentions();
	  };
	  /*
	    Method to set single property.
	    @private
	    @override @ Module
	    @param {String} Name of the property.
	    @param {Any} Value for the property.
	  */


	  Tween.prototype._assignProp = function _assignProp(key, value) {
	    // fallback to defaults
	    if (value == null) {
	      value = this._defaults[key];
	    }
	    // parse easing
	    if (key === 'easing') {
	      value = _easing2.default.parseEasing(value);
	      value._parent = this;
	    }
	    // handle control callbacks overrides
	    var control = this._callbackOverrides[key],
	        isntOverriden = !value || !value.isMojsCallbackOverride;
	    if (control && isntOverriden) {
	      value = this._overrideCallback(value, control);
	    }
	    // call super on Module
	    _Module.prototype._assignProp.call(this, key, value);
	  };
	  /*
	    Method to override callback for controll pupropes.
	    @private
	    @param {String}    Callback name.
	    @parma {Function}  Method to call  
	  */


	  Tween.prototype._overrideCallback = function _overrideCallback(callback, fun) {
	    var isCallback = callback && typeof callback === 'function',
	        override = function callbackOverride() {
	      // call overriden callback if it exists
	      isCallback && callback.apply(this, arguments);
	      // call the passed cleanup function
	      fun.apply(this, arguments);
	    };
	    // add overridden flag
	    override.isMojsCallbackOverride = true;
	    return override;
	  };

	  // _visualizeProgress(time) {
	  //   var str = '|',
	  //       procStr = ' ',
	  //       p = this._props,
	  //       proc = p.startTime - p.delay;

	  //   while ( proc < p.endTime ) {
	  //     if (p.delay > 0 ) {
	  //       var newProc = proc + p.delay;
	  //       if ( time > proc && time < newProc ) {
	  //         procStr += ' ^ ';
	  //       } else {
	  //         procStr += '   ';
	  //       }
	  //       proc = newProc;
	  //       str  += '---';
	  //     }
	  //     var newProc = proc + p.duration;
	  //     if ( time > proc && time < newProc ) {
	  //       procStr += '  ^   ';
	  //     } else if (time === proc) {
	  //       procStr += '^     ';
	  //     } else if (time === newProc) {
	  //       procStr += '    ^ ';
	  //     } else {
	  //       procStr += '      ';
	  //     }
	  //     proc = newProc;
	  //     str += '=====|';
	  //   }

	  //   console.log(str);
	  //   console.log(procStr);
	  // }


	  return Tween;
	}(_module2.default);

	exports.default = Tween;

/***/ }),
/* 102 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	__webpack_require__(103);

	__webpack_require__(104);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var Tweener = function () {
	  function Tweener() {
	    (0, _classCallCheck3.default)(this, Tweener);

	    this._vars();
	    this._listenVisibilityChange();
	    return this;
	  }

	  Tweener.prototype._vars = function _vars() {
	    this.tweens = [];
	    this._savedTweens = [];
	    this._loop = this._loop.bind(this);
	    this._onVisibilityChange = this._onVisibilityChange.bind(this);
	  };
	  /*
	    Main animation loop. Should have only one concurrent loop.
	    @private
	    @returns this
	  */


	  Tweener.prototype._loop = function _loop() {
	    if (!this._isRunning) {
	      return false;
	    }
	    this._update(window.performance.now());
	    if (!this.tweens.length) {
	      return this._isRunning = false;
	    }
	    requestAnimationFrame(this._loop);
	    return this;
	  };
	  /*
	    Method to start animation loop.
	    @private
	  */


	  Tweener.prototype._startLoop = function _startLoop() {
	    if (this._isRunning) {
	      return;
	    };this._isRunning = true;
	    requestAnimationFrame(this._loop);
	  };
	  /*
	    Method to stop animation loop.
	    @private
	  */


	  Tweener.prototype._stopLoop = function _stopLoop() {
	    this._isRunning = false;
	  };
	  /*
	    Method to update every tween/timeline on animation frame.
	    @private
	  */


	  Tweener.prototype._update = function _update(time) {
	    var i = this.tweens.length;
	    while (i--) {
	      // cache the current tween
	      var tween = this.tweens[i];
	      if (tween && tween._update(time) === true) {
	        this.remove(tween);
	        tween._onTweenerFinish();
	        tween._prevTime = undefined;
	      }
	    }
	  };
	  /*
	    Method to add a Tween/Timeline to loop pool.
	    @param {Object} Tween/Timeline to add.
	  */


	  Tweener.prototype.add = function add(tween) {
	    // return if tween is already running
	    if (tween._isRunning) {
	      return;
	    }
	    tween._isRunning = true;
	    this.tweens.push(tween);
	    this._startLoop();
	  };
	  /*
	    Method stop updating all the child tweens/timelines.
	    @private
	  */


	  Tweener.prototype.removeAll = function removeAll() {
	    this.tweens.length = 0;
	  };
	  /*
	    Method to remove specific tween/timeline form updating.
	    @private
	  */


	  Tweener.prototype.remove = function remove(tween) {
	    var index = typeof tween === 'number' ? tween : this.tweens.indexOf(tween);

	    if (index !== -1) {
	      tween = this.tweens[index];
	      if (tween) {
	        tween._isRunning = false;
	        this.tweens.splice(index, 1);
	        tween._onTweenerRemove();
	      }
	    }
	  };

	  /*
	    Method to initialize event listeners to visibility change events.
	    @private
	  */


	  Tweener.prototype._listenVisibilityChange = function _listenVisibilityChange() {
	    if (typeof document.hidden !== "undefined") {
	      this._visibilityHidden = "hidden";
	      this._visibilityChange = "visibilitychange";
	    } else if (typeof document.mozHidden !== "undefined") {
	      this._visibilityHidden = "mozHidden";
	      this._visibilityChange = "mozvisibilitychange";
	    } else if (typeof document.msHidden !== "undefined") {
	      this._visibilityHidden = "msHidden";
	      this._visibilityChange = "msvisibilitychange";
	    } else if (typeof document.webkitHidden !== "undefined") {
	      this._visibilityHidden = "webkitHidden";
	      this._visibilityChange = "webkitvisibilitychange";
	    }

	    document.addEventListener(this._visibilityChange, this._onVisibilityChange, false);
	  };
	  /*
	    Method that will fire on visibility change.
	  */


	  Tweener.prototype._onVisibilityChange = function _onVisibilityChange() {
	    if (document[this._visibilityHidden]) {
	      this._savePlayingTweens();
	    } else {
	      this._restorePlayingTweens();
	    }
	  };
	  /*
	    Method to save all playing tweens.
	    @private
	  */


	  Tweener.prototype._savePlayingTweens = function _savePlayingTweens() {
	    this._savedTweens = this.tweens.slice(0);
	    for (var i = 0; i < this._savedTweens.length; i++) {
	      this._savedTweens[i].pause();
	    }
	  };
	  /*
	    Method to restore all playing tweens.
	    @private
	  */


	  Tweener.prototype._restorePlayingTweens = function _restorePlayingTweens() {
	    for (var i = 0; i < this._savedTweens.length; i++) {
	      this._savedTweens[i].resume();
	    }
	  };

	  return Tweener;
	}();

	var t = new Tweener();
	exports.default = t;

/***/ }),
/* 103 */
/***/ (function(module, exports) {

	
	/* istanbul ignore next */
	(function() {
	  'use strict';
	  var cancel, i, isOldBrowser, lastTime, vendors, vp, w;
	  vendors = ['webkit', 'moz'];
	  i = 0;
	  w = window;
	  while (i < vendors.length && !w.requestAnimationFrame) {
	    vp = vendors[i];
	    w.requestAnimationFrame = w[vp + 'RequestAnimationFrame'];
	    cancel = w[vp + 'CancelAnimationFrame'];
	    w.cancelAnimationFrame = cancel || w[vp + 'CancelRequestAnimationFrame'];
	    ++i;
	  }
	  isOldBrowser = !w.requestAnimationFrame || !w.cancelAnimationFrame;
	  if (/iP(ad|hone|od).*OS 6/.test(w.navigator.userAgent) || isOldBrowser) {
	    lastTime = 0;
	    w.requestAnimationFrame = function(callback) {
	      var nextTime, now;
	      now = Date.now();
	      nextTime = Math.max(lastTime + 16, now);
	      return setTimeout((function() {
	        callback(lastTime = nextTime);
	      }), nextTime - now);
	    };
	    w.cancelAnimationFrame = clearTimeout;
	  }
	})();


/***/ }),
/* 104 */
/***/ (function(module, exports) {

	
	/* istanbul ignore next */
	(function(root) {
	  var offset, ref, ref1;
	  if (root.performance == null) {
	    root.performance = {};
	  }
	  Date.now = Date.now || function() {
	    return (new Date).getTime();
	  };
	  if (root.performance.now == null) {
	    offset = ((ref = root.performance) != null ? (ref1 = ref.timing) != null ? ref1.navigationStart : void 0 : void 0) ? performance.timing.navigationStart : Date.now();
	    return root.performance.now = function() {
	      return Date.now() - offset;
	    };
	  }
	})(window);


/***/ }),
/* 105 */
/***/ (function(module, exports, __webpack_require__) {

	var Easing, PI, PathEasing, approximate, bezier, easing, h, mix, sin;

	bezier = __webpack_require__(106);

	PathEasing = __webpack_require__(107);

	mix = __webpack_require__(108);

	h = __webpack_require__(71);

	approximate = __webpack_require__(109)["default"] || __webpack_require__(109);

	sin = Math.sin;

	PI = Math.PI;

	Easing = (function() {
	  function Easing() {}

	  Easing.prototype.bezier = bezier;

	  Easing.prototype.PathEasing = PathEasing;

	  Easing.prototype.path = (new PathEasing('creator')).create;

	  Easing.prototype.approximate = approximate;

	  Easing.prototype.inverse = function(p) {
	    return 1 - p;
	  };

	  Easing.prototype.linear = {
	    none: function(k) {
	      return k;
	    }
	  };

	  Easing.prototype.ease = {
	    "in": bezier.apply(Easing, [0.42, 0, 1, 1]),
	    out: bezier.apply(Easing, [0, 0, 0.58, 1]),
	    inout: bezier.apply(Easing, [0.42, 0, 0.58, 1])
	  };

	  Easing.prototype.sin = {
	    "in": function(k) {
	      return 1 - Math.cos(k * PI / 2);
	    },
	    out: function(k) {
	      return sin(k * PI / 2);
	    },
	    inout: function(k) {
	      return 0.5 * (1 - Math.cos(PI * k));
	    }
	  };

	  Easing.prototype.quad = {
	    "in": function(k) {
	      return k * k;
	    },
	    out: function(k) {
	      return k * (2 - k);
	    },
	    inout: function(k) {
	      if ((k *= 2) < 1) {
	        return 0.5 * k * k;
	      }
	      return -0.5 * (--k * (k - 2) - 1);
	    }
	  };

	  Easing.prototype.cubic = {
	    "in": function(k) {
	      return k * k * k;
	    },
	    out: function(k) {
	      return --k * k * k + 1;
	    },
	    inout: function(k) {
	      if ((k *= 2) < 1) {
	        return 0.5 * k * k * k;
	      }
	      return 0.5 * ((k -= 2) * k * k + 2);
	    }
	  };

	  Easing.prototype.quart = {
	    "in": function(k) {
	      return k * k * k * k;
	    },
	    out: function(k) {
	      return 1 - (--k * k * k * k);
	    },
	    inout: function(k) {
	      if ((k *= 2) < 1) {
	        return 0.5 * k * k * k * k;
	      }
	      return -0.5 * ((k -= 2) * k * k * k - 2);
	    }
	  };

	  Easing.prototype.quint = {
	    "in": function(k) {
	      return k * k * k * k * k;
	    },
	    out: function(k) {
	      return --k * k * k * k * k + 1;
	    },
	    inout: function(k) {
	      if ((k *= 2) < 1) {
	        return 0.5 * k * k * k * k * k;
	      }
	      return 0.5 * ((k -= 2) * k * k * k * k + 2);
	    }
	  };

	  Easing.prototype.expo = {
	    "in": function(k) {
	      if (k === 0) {
	        return 0;
	      } else {
	        return Math.pow(1024, k - 1);
	      }
	    },
	    out: function(k) {
	      if (k === 1) {
	        return 1;
	      } else {
	        return 1 - Math.pow(2, -10 * k);
	      }
	    },
	    inout: function(k) {
	      if (k === 0) {
	        return 0;
	      }
	      if (k === 1) {
	        return 1;
	      }
	      if ((k *= 2) < 1) {
	        return 0.5 * Math.pow(1024, k - 1);
	      }
	      return 0.5 * (-Math.pow(2, -10 * (k - 1)) + 2);
	    }
	  };

	  Easing.prototype.circ = {
	    "in": function(k) {
	      return 1 - Math.sqrt(1 - k * k);
	    },
	    out: function(k) {
	      return Math.sqrt(1 - (--k * k));
	    },
	    inout: function(k) {
	      if ((k *= 2) < 1) {
	        return -0.5 * (Math.sqrt(1 - k * k) - 1);
	      }
	      return 0.5 * (Math.sqrt(1 - (k -= 2) * k) + 1);
	    }
	  };

	  Easing.prototype.back = {
	    "in": function(k) {
	      var s;
	      s = 1.70158;
	      return k * k * ((s + 1) * k - s);
	    },
	    out: function(k) {
	      var s;
	      s = 1.70158;
	      return --k * k * ((s + 1) * k + s) + 1;
	    },
	    inout: function(k) {
	      var s;
	      s = 1.70158 * 1.525;
	      if ((k *= 2) < 1) {
	        return 0.5 * (k * k * ((s + 1) * k - s));
	      }
	      return 0.5 * ((k -= 2) * k * ((s + 1) * k + s) + 2);
	    }
	  };

	  Easing.prototype.elastic = {
	    "in": function(k) {
	      var a, p, s;
	      s = void 0;
	      p = 0.4;
	      if (k === 0) {
	        return 0;
	      }
	      if (k === 1) {
	        return 1;
	      }
	      a = 1;
	      s = p / 4;
	      return -(a * Math.pow(2, 10 * (k -= 1)) * Math.sin((k - s) * (2 * Math.PI) / p));
	    },
	    out: function(k) {
	      var a, p, s;
	      s = void 0;
	      p = 0.4;
	      if (k === 0) {
	        return 0;
	      }
	      if (k === 1) {
	        return 1;
	      }
	      a = 1;
	      s = p / 4;
	      return a * Math.pow(2, -10 * k) * Math.sin((k - s) * (2 * Math.PI) / p) + 1;
	    },
	    inout: function(k) {
	      var a, p, s;
	      s = void 0;
	      p = 0.4;
	      if (k === 0) {
	        return 0;
	      }
	      if (k === 1) {
	        return 1;
	      }
	      a = 1;
	      s = p / 4;
	      if ((k *= 2) < 1) {
	        return -0.5 * (a * Math.pow(2, 10 * (k -= 1)) * Math.sin((k - s) * (2 * Math.PI) / p));
	      }
	      return a * Math.pow(2, -10 * (k -= 1)) * Math.sin((k - s) * (2 * Math.PI) / p) * 0.5 + 1;
	    }
	  };

	  Easing.prototype.bounce = {
	    "in": function(k) {
	      return 1 - easing.bounce.out(1 - k);
	    },
	    out: function(k) {
	      if (k < (1 / 2.75)) {
	        return 7.5625 * k * k;
	      } else if (k < (2 / 2.75)) {
	        return 7.5625 * (k -= 1.5 / 2.75) * k + 0.75;
	      } else if (k < (2.5 / 2.75)) {
	        return 7.5625 * (k -= 2.25 / 2.75) * k + 0.9375;
	      } else {
	        return 7.5625 * (k -= 2.625 / 2.75) * k + 0.984375;
	      }
	    },
	    inout: function(k) {
	      if (k < 0.5) {
	        return easing.bounce["in"](k * 2) * 0.5;
	      }
	      return easing.bounce.out(k * 2 - 1) * 0.5 + 0.5;
	    }
	  };

	  Easing.prototype.parseEasing = function(easing) {
	    var easingParent, type;
	    if (easing == null) {
	      easing = 'linear.none';
	    }
	    type = typeof easing;
	    if (type === 'string') {
	      if (easing.charAt(0).toLowerCase() === 'm') {
	        return this.path(easing);
	      } else {
	        easing = this._splitEasing(easing);
	        easingParent = this[easing[0]];
	        if (!easingParent) {
	          h.error("Easing with name \"" + easing[0] + "\" was not found, fallback to \"linear.none\" instead");
	          return this['linear']['none'];
	        }
	        return easingParent[easing[1]];
	      }
	    }
	    if (h.isArray(easing)) {
	      return this.bezier.apply(this, easing);
	    }
	    if ('function') {
	      return easing;
	    }
	  };

	  Easing.prototype._splitEasing = function(string) {
	    var firstPart, secondPart, split;
	    if (typeof string === 'function') {
	      return string;
	    }
	    if (typeof string === 'string' && string.length) {
	      split = string.split('.');
	      firstPart = split[0].toLowerCase() || 'linear';
	      secondPart = split[1].toLowerCase() || 'none';
	      return [firstPart, secondPart];
	    } else {
	      return ['linear', 'none'];
	    }
	  };

	  return Easing;

	})();

	easing = new Easing;

	easing.mix = mix(easing);

	module.exports = easing;


/***/ }),
/* 106 */
/***/ (function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(global) {var BezierEasing, bezierEasing, h,
	  indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

	h = __webpack_require__(71);


	/**
	 * Copyright (c) 2014 Gaëtan Renaudeau http://goo.gl/El3k7u
	 * Adopted from https://github.com/gre/bezier-easing
	 */

	BezierEasing = (function() {
	  function BezierEasing(o) {
	    this.vars();
	    return this.generate;
	  }

	  BezierEasing.prototype.vars = function() {
	    return this.generate = h.bind(this.generate, this);
	  };

	  BezierEasing.prototype.generate = function(mX1, mY1, mX2, mY2) {
	    var A, B, C, NEWTON_ITERATIONS, NEWTON_MIN_SLOPE, SUBDIVISION_MAX_ITERATIONS, SUBDIVISION_PRECISION, _precomputed, arg, binarySubdivide, calcBezier, calcSampleValues, f, float32ArraySupported, getSlope, getTForX, i, j, kSampleStepSize, kSplineTableSize, mSampleValues, newtonRaphsonIterate, precompute, str;
	    if (arguments.length < 4) {
	      return this.error('Bezier function expects 4 arguments');
	    }
	    for (i = j = 0; j < 4; i = ++j) {
	      arg = arguments[i];
	      if (typeof arg !== "number" || isNaN(arg) || !isFinite(arg)) {
	        return this.error('Bezier function expects 4 arguments');
	      }
	    }
	    if (mX1 < 0 || mX1 > 1 || mX2 < 0 || mX2 > 1) {
	      return this.error('Bezier x values should be > 0 and < 1');
	    }
	    NEWTON_ITERATIONS = 4;
	    NEWTON_MIN_SLOPE = 0.001;
	    SUBDIVISION_PRECISION = 0.0000001;
	    SUBDIVISION_MAX_ITERATIONS = 10;
	    kSplineTableSize = 11;
	    kSampleStepSize = 1.0 / (kSplineTableSize - 1.0);
	    float32ArraySupported = indexOf.call(global, 'Float32Array') >= 0;
	    A = function(aA1, aA2) {
	      return 1.0 - 3.0 * aA2 + 3.0 * aA1;
	    };
	    B = function(aA1, aA2) {
	      return 3.0 * aA2 - 6.0 * aA1;
	    };
	    C = function(aA1) {
	      return 3.0 * aA1;
	    };
	    calcBezier = function(aT, aA1, aA2) {
	      return ((A(aA1, aA2) * aT + B(aA1, aA2)) * aT + C(aA1)) * aT;
	    };
	    getSlope = function(aT, aA1, aA2) {
	      return 3.0 * A(aA1, aA2) * aT * aT + 2.0 * B(aA1, aA2) * aT + C(aA1);
	    };
	    newtonRaphsonIterate = function(aX, aGuessT) {
	      var currentSlope, currentX;
	      i = 0;
	      while (i < NEWTON_ITERATIONS) {
	        currentSlope = getSlope(aGuessT, mX1, mX2);

	        /* istanbul ignore if */
	        if (currentSlope === 0.0) {
	          return aGuessT;
	        }
	        currentX = calcBezier(aGuessT, mX1, mX2) - aX;
	        aGuessT -= currentX / currentSlope;
	        ++i;
	      }
	      return aGuessT;
	    };
	    calcSampleValues = function() {
	      i = 0;
	      while (i < kSplineTableSize) {
	        mSampleValues[i] = calcBezier(i * kSampleStepSize, mX1, mX2);
	        ++i;
	      }
	    };

	    /* istanbul ignore next */
	    binarySubdivide = function(aX, aA, aB) {
	      var currentT, currentX, isBig;
	      currentX = void 0;
	      currentT = void 0;
	      i = 0;
	      while (true) {
	        currentT = aA + (aB - aA) / 2.0;
	        currentX = calcBezier(currentT, mX1, mX2) - aX;
	        if (currentX > 0.0) {
	          aB = currentT;
	        } else {
	          aA = currentT;
	        }
	        isBig = Math.abs(currentX) > SUBDIVISION_PRECISION;
	        if (!(isBig && ++i < SUBDIVISION_MAX_ITERATIONS)) {
	          break;
	        }
	      }
	      return currentT;
	    };
	    getTForX = function(aX) {
	      var currentSample, delta, dist, guessForT, initialSlope, intervalStart, lastSample;
	      intervalStart = 0.0;
	      currentSample = 1;
	      lastSample = kSplineTableSize - 1;
	      while (currentSample !== lastSample && mSampleValues[currentSample] <= aX) {
	        intervalStart += kSampleStepSize;
	        ++currentSample;
	      }
	      --currentSample;
	      delta = mSampleValues[currentSample + 1] - mSampleValues[currentSample];
	      dist = (aX - mSampleValues[currentSample]) / delta;
	      guessForT = intervalStart + dist * kSampleStepSize;
	      initialSlope = getSlope(guessForT, mX1, mX2);
	      if (initialSlope >= NEWTON_MIN_SLOPE) {
	        return newtonRaphsonIterate(aX, guessForT);
	      } else {

	        /* istanbul ignore next */
	        if (initialSlope === 0.0) {
	          return guessForT;
	        } else {
	          return binarySubdivide(aX, intervalStart, intervalStart + kSampleStepSize);
	        }
	      }
	    };
	    precompute = function() {
	      var _precomputed;
	      _precomputed = true;
	      if (mX1 !== mY1 || mX2 !== mY2) {
	        return calcSampleValues();
	      }
	    };
	    mSampleValues = !float32ArraySupported ? new Array(kSplineTableSize) : new Float32Array(kSplineTableSize);
	    _precomputed = false;
	    f = function(aX) {
	      if (!_precomputed) {
	        precompute();
	      }
	      if (mX1 === mY1 && mX2 === mY2) {
	        return aX;
	      }
	      if (aX === 0) {
	        return 0;
	      }
	      if (aX === 1) {
	        return 1;
	      }
	      return calcBezier(getTForX(aX), mY1, mY2);
	    };
	    str = "bezier(" + [mX1, mY1, mX2, mY2] + ")";
	    f.toStr = function() {
	      return str;
	    };
	    return f;
	  };

	  BezierEasing.prototype.error = function(msg) {
	    return h.error(msg);
	  };

	  return BezierEasing;

	})();

	bezierEasing = new BezierEasing;

	module.exports = bezierEasing;

	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ }),
/* 107 */
/***/ (function(module, exports, __webpack_require__) {

	var PathEasing, h;

	h = __webpack_require__(71);

	PathEasing = (function() {
	  PathEasing.prototype._vars = function() {
	    this._precompute = h.clamp(this.o.precompute || 1450, 100, 10000);
	    this._step = 1 / this._precompute;
	    this._rect = this.o.rect || 100;
	    this._approximateMax = this.o.approximateMax || 5;
	    this._eps = this.o.eps || 0.001;
	    return this._boundsPrevProgress = -1;
	  };

	  function PathEasing(path, o1) {
	    this.o = o1 != null ? o1 : {};
	    if (path === 'creator') {
	      return;
	    }
	    this.path = h.parsePath(path);
	    if (this.path == null) {
	      return h.error('Error while parsing the path');
	    }
	    this._vars();
	    this.path.setAttribute('d', this._normalizePath(this.path.getAttribute('d')));
	    this.pathLength = this.path.getTotalLength();
	    this.sample = h.bind(this.sample, this);
	    this._hardSample = h.bind(this._hardSample, this);
	    this._preSample();
	    this;
	  }

	  PathEasing.prototype._preSample = function() {
	    var i, j, length, point, progress, ref, results;
	    this._samples = [];
	    results = [];
	    for (i = j = 0, ref = this._precompute; 0 <= ref ? j <= ref : j >= ref; i = 0 <= ref ? ++j : --j) {
	      progress = i * this._step;
	      length = this.pathLength * progress;
	      point = this.path.getPointAtLength(length);
	      results.push(this._samples[i] = {
	        point: point,
	        length: length,
	        progress: progress
	      });
	    }
	    return results;
	  };

	  PathEasing.prototype._findBounds = function(array, p) {
	    var buffer, direction, end, i, j, len, loopEnd, pointP, pointX, ref, ref1, start, value;
	    if (p === this._boundsPrevProgress) {
	      return this._prevBounds;
	    }
	    if (this._boundsStartIndex == null) {
	      this._boundsStartIndex = 0;
	    }
	    len = array.length;
	    if (this._boundsPrevProgress > p) {
	      loopEnd = 0;
	      direction = 'reverse';
	    } else {
	      loopEnd = len;
	      direction = 'forward';
	    }
	    if (direction === 'forward') {
	      start = array[0];
	      end = array[array.length - 1];
	    } else {
	      start = array[array.length - 1];
	      end = array[0];
	    }
	    for (i = j = ref = this._boundsStartIndex, ref1 = loopEnd; ref <= ref1 ? j < ref1 : j > ref1; i = ref <= ref1 ? ++j : --j) {
	      value = array[i];
	      pointX = value.point.x / this._rect;
	      pointP = p;
	      if (direction === 'reverse') {
	        buffer = pointX;
	        pointX = pointP;
	        pointP = buffer;
	      }
	      if (pointX < pointP) {
	        start = value;
	        this._boundsStartIndex = i;
	      } else {
	        end = value;
	        break;
	      }
	    }
	    this._boundsPrevProgress = p;
	    return this._prevBounds = {
	      start: start,
	      end: end
	    };
	  };

	  PathEasing.prototype.sample = function(p) {
	    var bounds, res;
	    p = h.clamp(p, 0, 1);
	    bounds = this._findBounds(this._samples, p);
	    res = this._checkIfBoundsCloseEnough(p, bounds);
	    if (res != null) {
	      return res;
	    }
	    return this._findApproximate(p, bounds.start, bounds.end);
	  };

	  PathEasing.prototype._checkIfBoundsCloseEnough = function(p, bounds) {
	    var point, y;
	    point = void 0;
	    y = this._checkIfPointCloseEnough(p, bounds.start.point);
	    if (y != null) {
	      return y;
	    }
	    return this._checkIfPointCloseEnough(p, bounds.end.point);
	  };

	  PathEasing.prototype._checkIfPointCloseEnough = function(p, point) {
	    if (h.closeEnough(p, point.x / this._rect, this._eps)) {
	      return this._resolveY(point);
	    }
	  };

	  PathEasing.prototype._approximate = function(start, end, p) {
	    var deltaP, percentP;
	    deltaP = end.point.x - start.point.x;
	    percentP = (p - (start.point.x / this._rect)) / (deltaP / this._rect);
	    return start.length + percentP * (end.length - start.length);
	  };

	  PathEasing.prototype._findApproximate = function(p, start, end, approximateMax) {
	    var approximation, args, newPoint, point, x;
	    if (approximateMax == null) {
	      approximateMax = this._approximateMax;
	    }
	    approximation = this._approximate(start, end, p);
	    point = this.path.getPointAtLength(approximation);
	    x = point.x / this._rect;
	    if (h.closeEnough(p, x, this._eps)) {
	      return this._resolveY(point);
	    } else {
	      if (--approximateMax < 1) {
	        return this._resolveY(point);
	      }
	      newPoint = {
	        point: point,
	        length: approximation
	      };
	      args = p < x ? [p, start, newPoint, approximateMax] : [p, newPoint, end, approximateMax];
	      return this._findApproximate.apply(this, args);
	    }
	  };

	  PathEasing.prototype._resolveY = function(point) {
	    return 1 - (point.y / this._rect);
	  };

	  PathEasing.prototype._normalizePath = function(path) {
	    var commands, endIndex, normalizedPath, points, startIndex, svgCommandsRegexp;
	    svgCommandsRegexp = /[M|L|H|V|C|S|Q|T|A]/gim;
	    points = path.split(svgCommandsRegexp);
	    points.shift();
	    commands = path.match(svgCommandsRegexp);
	    startIndex = 0;
	    points[startIndex] = this._normalizeSegment(points[startIndex]);
	    endIndex = points.length - 1;
	    points[endIndex] = this._normalizeSegment(points[endIndex], this._rect || 100);
	    return normalizedPath = this._joinNormalizedPath(commands, points);
	  };

	  PathEasing.prototype._joinNormalizedPath = function(commands, points) {
	    var command, i, j, len1, normalizedPath, space;
	    normalizedPath = '';
	    for (i = j = 0, len1 = commands.length; j < len1; i = ++j) {
	      command = commands[i];
	      space = i === 0 ? '' : ' ';
	      normalizedPath += "" + space + command + (points[i].trim());
	    }
	    return normalizedPath;
	  };

	  PathEasing.prototype._normalizeSegment = function(segment, value) {
	    var i, j, lastPoint, len1, nRgx, pairs, parsedX, point, space, x;
	    if (value == null) {
	      value = 0;
	    }
	    segment = segment.trim();
	    nRgx = /(-|\+)?((\d+(\.(\d|\e(-|\+)?)+)?)|(\.?(\d|\e|(\-|\+))+))/gim;
	    pairs = this._getSegmentPairs(segment.match(nRgx));
	    lastPoint = pairs[pairs.length - 1];
	    x = lastPoint[0];
	    parsedX = Number(x);
	    if (parsedX !== value) {
	      segment = '';
	      lastPoint[0] = value;
	      for (i = j = 0, len1 = pairs.length; j < len1; i = ++j) {
	        point = pairs[i];
	        space = i === 0 ? '' : ' ';
	        segment += "" + space + point[0] + "," + point[1];
	      }
	    }
	    return segment;
	  };

	  PathEasing.prototype._getSegmentPairs = function(array) {
	    var i, j, len1, newArray, pair, value;
	    if (array.length % 2 !== 0) {
	      h.error('Failed to parse the path - segment pairs are not even.', array);
	    }
	    newArray = [];
	    for (i = j = 0, len1 = array.length; j < len1; i = j += 2) {
	      value = array[i];
	      pair = [array[i], array[i + 1]];
	      newArray.push(pair);
	    }
	    return newArray;
	  };

	  PathEasing.prototype.create = function(path, o) {
	    var handler;
	    handler = new PathEasing(path, o);
	    handler.sample.path = handler.path;
	    return handler.sample;
	  };

	  return PathEasing;

	})();

	module.exports = PathEasing;


/***/ }),
/* 108 */
/***/ (function(module, exports) {

	var create, easing, getNearest, mix, parseIfEasing, sort,
	  slice = [].slice;

	easing = null;

	parseIfEasing = function(item) {
	  if (typeof item.value === 'number') {
	    return item.value;
	  } else {
	    return easing.parseEasing(item.value);
	  }
	};

	sort = function(a, b) {
	  var returnValue;
	  a.value = parseIfEasing(a);
	  b.value = parseIfEasing(b);
	  returnValue = 0;
	  a.to < b.to && (returnValue = -1);
	  a.to > b.to && (returnValue = 1);
	  return returnValue;
	};

	getNearest = function(array, progress) {
	  var i, index, j, len, value;
	  index = 0;
	  for (i = j = 0, len = array.length; j < len; i = ++j) {
	    value = array[i];
	    index = i;
	    if (value.to > progress) {
	      break;
	    }
	  }
	  return index;
	};

	mix = function() {
	  var args;
	  args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
	  if (args.length > 1) {
	    args = args.sort(sort);
	  } else {
	    args[0].value = parseIfEasing(args[0]);
	  }
	  return function(progress) {
	    var index, value;
	    index = getNearest(args, progress);
	    if (index !== -1) {
	      value = args[index].value;
	      if (index === args.length - 1 && progress > args[index].to) {
	        return 1;
	      }
	      if (typeof value === 'function') {
	        return value(progress);
	      } else {
	        return value;
	      }
	    }
	  };
	};

	create = function(e) {
	  easing = e;
	  return mix;
	};

	module.exports = create;


/***/ }),
/* 109 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _typeof2 = __webpack_require__(3);

	var _typeof3 = _interopRequireDefault(_typeof2);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	/*
	  Method to bootstrap approximation function.
	  @private
	  @param   {Object} Samples Object.
	  @returns {Function} Approximate function.
	*/
	var _proximate = function _proximate(samples) {
	  var n = samples.base,
	      samplesAmount = Math.pow(10, n),
	      samplesStep = 1 / samplesAmount;

	  function RoundNumber(input, numberDecimals) {
	    numberDecimals = +numberDecimals || 0; // +var magic!

	    var multiplyer = Math.pow(10.0, numberDecimals);

	    return Math.round(input * multiplyer) / multiplyer;
	  }

	  var cached = function cached(p) {
	    var newKey = RoundNumber(p, n),
	        sample = samples[newKey.toString()];

	    if (Math.abs(p - newKey) < samplesStep) {
	      return sample;
	    }

	    if (p > newKey) {
	      var nextIndex = newKey + samplesStep;
	      var nextValue = samples[nextIndex];
	    } else {
	      var nextIndex = newKey - samplesStep;
	      var nextValue = samples[nextIndex];
	    }

	    var dLength = nextIndex - newKey;
	    var dValue = nextValue - sample;
	    if (dValue < samplesStep) {
	      return sample;
	    }

	    var progressScale = (p - newKey) / dLength;
	    var coef = nextValue > sample ? -1 : 1;
	    var scaledDifference = coef * progressScale * dValue;

	    return sample + scaledDifference;
	  };

	  cached.getSamples = function () {
	    return samples;
	  };

	  return cached;
	};
	/*
	    Method to take samples of the function and call the _proximate
	    method with the dunction and samples. Or if samples passed - pipe
	    them to the _proximate method without sampling.
	    @private
	    @param {Function} Function to sample.
	    @param {Number, Object, String} Precision or precomputed samples.
	  */
	var _sample = function _sample(fn) {
	  var n = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 4;


	  var nType = typeof n === 'undefined' ? 'undefined' : (0, _typeof3.default)(n);

	  var samples = {};
	  if (nType === 'number') {
	    var p = 0,
	        samplesCount = Math.pow(10, n),
	        step = 1 / samplesCount;

	    samples[0] = fn(0);
	    for (var i = 0; i < samplesCount - 1; i++) {
	      p += step;

	      var index = parseFloat(p.toFixed(n));
	      samples[index] = fn(p);
	    }
	    samples[1] = fn(1);

	    samples.base = n;
	  } else if (nType === 'object') {
	    samples = n;
	  } else if (nType === 'string') {
	    samples = JSON.parse(n);
	  }

	  return Approximate._sample._proximate(samples);
	};

	var Approximate = { _sample: _sample, _proximate: _proximate };
	Approximate._sample._proximate = Approximate._proximate;

	exports.default = Approximate._sample;

/***/ }),
/* 110 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _getIterator2 = __webpack_require__(111);

	var _getIterator3 = _interopRequireDefault(_getIterator2);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	var _tweener = __webpack_require__(102);

	var _tweener2 = _interopRequireDefault(_tweener);

	var _tween = __webpack_require__(101);

	var _tween2 = _interopRequireDefault(_tween);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var Timeline = function (_Tween) {
	  (0, _inherits3.default)(Timeline, _Tween);

	  /*
	    API method to add child tweens/timelines.
	    @public
	    @param {Object, Array} Tween/Timeline or an array of such.
	    @returns {Object} Self.
	  */
	  Timeline.prototype.add = function add() {
	    for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
	      args[_key] = arguments[_key];
	    }

	    this._pushTimelineArray(args);
	    this._calcDimentions();
	    return this;
	  };
	  /*
	    API method to append the Tween/Timeline to the end of the
	    timeline. Each argument is treated as a new append.
	    Array of tweens is treated as a parallel sequence. 
	    @public
	    @param {Object, Array} Tween/Timeline to append or array of such.
	    @returns {Object} Self.
	  */


	  Timeline.prototype.append = function append() {
	    for (var _len2 = arguments.length, timeline = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
	      timeline[_key2] = arguments[_key2];
	    }

	    for (var _iterator = timeline, _isArray = Array.isArray(_iterator), _i = 0, _iterator = _isArray ? _iterator : (0, _getIterator3.default)(_iterator);;) {
	      var _ref;

	      if (_isArray) {
	        if (_i >= _iterator.length) break;
	        _ref = _iterator[_i++];
	      } else {
	        _i = _iterator.next();
	        if (_i.done) break;
	        _ref = _i.value;
	      }

	      var tm = _ref;

	      if (_h2.default.isArray(tm)) {
	        this._appendTimelineArray(tm);
	      } else {
	        this._appendTimeline(tm, this._timelines.length);
	      }
	      this._calcDimentions();
	    }
	    return this;
	  };
	  /*
	    API method to stop the Tween.
	    @public
	    @param   {Number} Progress [0..1] to set when stopped.
	    @returns {Object} Self.
	  */


	  Timeline.prototype.stop = function stop(progress) {
	    _Tween.prototype.stop.call(this, progress);
	    this._stopChildren(progress);
	    return this;
	  };
	  /*
	    Method to reset tween's state and properties.
	    @public
	    @overrides @ Tween
	    @returns this.
	  */


	  Timeline.prototype.reset = function reset() {
	    _Tween.prototype.reset.call(this);
	    this._resetChildren();
	    return this;
	  };
	  /*
	    Method to call `reset` method on all children.
	    @private
	  */


	  Timeline.prototype._resetChildren = function _resetChildren() {
	    for (var i = 0; i < this._timelines.length; i++) {
	      this._timelines[i].reset();
	    }
	  };
	  /*
	    Method to call `stop` method on all children.
	    @private
	    @param   {Number} Progress [0..1] to set when stopped.
	  */


	  Timeline.prototype._stopChildren = function _stopChildren(progress) {
	    for (var i = this._timelines.length - 1; i >= 0; i--) {
	      this._timelines[i].stop(progress);
	    }
	  };
	  /*
	    Method to set tween's state to complete.
	    @private
	    @overrides @ Tween
	    @param {Number} Current time.
	    @param {Boolean} Is yoyo period.
	  */
	  // _complete ( time, isYoyo ) {
	  //   // this._updateChildren( 1, time, isYoyo );
	  //   // this._setProgress( 1, time, isYoyo );
	  //   super._complete( time, isYoyo );
	  //   // this._resetChildren();
	  // }

	  // ^ PUBLIC  METHOD(S) ^
	  // v PRIVATE METHOD(S) v

	  /*
	    Method to append Tween/Timeline array or mix of such.
	    @private
	    @param {Array} Array of Tweens/Timelines.
	  */


	  Timeline.prototype._appendTimelineArray = function _appendTimelineArray(timelineArray) {
	    var i = timelineArray.length,
	        time = this._props.repeatTime - this._props.delay,
	        len = this._timelines.length;

	    while (i--) {
	      this._appendTimeline(timelineArray[i], len, time);
	    }
	  };
	  /*
	    Method to append a single timeline to the Timeline.
	    @private
	    @param {Object} Tween/Timline to append.
	    @param {Number} Index of the append.
	    @param {Number} Shift time.
	  */


	  Timeline.prototype._appendTimeline = function _appendTimeline(timeline, index, time) {
	    // if timeline is a module with timeline property then extract it
	    if (timeline.timeline instanceof Timeline) {
	      timeline = timeline.timeline;
	    }
	    if (timeline.tween instanceof _tween2.default) {
	      timeline = timeline.tween;
	    }

	    var shift = time != null ? time : this._props.duration;
	    shift += timeline._props.shiftTime || 0;
	    timeline.index = index;this._pushTimeline(timeline, shift);
	  };
	  /*
	    PrivateMethod to push Tween/Timeline array.
	    @private
	    @param {Array} Array of Tweens/Timelines.
	  */


	  Timeline.prototype._pushTimelineArray = function _pushTimelineArray(array) {
	    for (var i = 0; i < array.length; i++) {
	      var tm = array[i];
	      // recursive push to handle arrays of arrays
	      if (_h2.default.isArray(tm)) {
	        this._pushTimelineArray(tm);
	      } else {
	        this._pushTimeline(tm);
	      }
	    };
	  };
	  /*
	    Method to push a single Tween/Timeline.
	    @private
	    @param {Object} Tween or Timeline to push.
	    @param {Number} Number of milliseconds to shift the start time
	                    of the Tween/Timeline.
	  */


	  Timeline.prototype._pushTimeline = function _pushTimeline(timeline, shift) {
	    // if timeline is a module with timeline property then extract it
	    if (timeline.timeline instanceof Timeline) {
	      timeline = timeline.timeline;
	    }
	    if (timeline.tween instanceof _tween2.default) {
	      timeline = timeline.tween;
	    }
	    // add self delay to the timeline
	    shift != null && timeline._setProp({ 'shiftTime': shift });
	    this._timelines.push(timeline);
	    this._recalcDuration(timeline);
	  };
	  /*
	    Method set progress on self and child Tweens/Timelines.
	    @private
	    @param {Number} Progress to set.
	    @param {Number} Current update time.
	  */


	  Timeline.prototype._setProgress = function _setProgress(p, time, isYoyo) {
	    // we need to pass self previous time to children
	    // to prevent initial _wasUnknownUpdate nested waterfall
	    // if not yoyo option set, pass the previous time
	    // otherwise, pass previous or next time regarding yoyo period.

	    // COVER CURRENT SWAPPED ORDER
	    this._updateChildren(p, time, isYoyo);

	    _tween2.default.prototype._setProgress.call(this, p, time);
	  };

	  Timeline.prototype._updateChildren = function _updateChildren(p, time, isYoyo) {
	    var coef = time > this._prevTime ? -1 : 1;
	    if (this._props.isYoyo && isYoyo) {
	      coef *= -1;
	    }
	    var timeToTimelines = this._props.startTime + p * this._props.duration,
	        prevTimeToTimelines = timeToTimelines + coef,
	        len = this._timelines.length;

	    for (var i = 0; i < len; i++) {
	      // specify the children's array update loop direction
	      // if time > prevTime go from 0->length else from length->0
	      // var j = ( time > this._prevTime ) ? i : (len-1) - i ;
	      var j = timeToTimelines > prevTimeToTimelines ? i : len - 1 - i;
	      this._timelines[j]._update(timeToTimelines, prevTimeToTimelines, this._prevYoyo, this._onEdge);
	    }
	    this._prevYoyo = isYoyo;
	  };
	  /*
	    Method calculate self duration based on timeline's duration.
	    @private
	    @param {Object} Tween or Timeline to calculate.
	  */


	  Timeline.prototype._recalcDuration = function _recalcDuration(timeline) {
	    var p = timeline._props,
	        timelineTime = p.repeatTime / p.speed + (p.shiftTime || 0) + timeline._negativeShift;

	    this._props.duration = Math.max(timelineTime, this._props.duration);
	  };
	  /*
	    Method calculate self duration from skretch.
	    @private
	  */


	  Timeline.prototype._recalcTotalDuration = function _recalcTotalDuration() {
	    var i = this._timelines.length;
	    this._props.duration = 0;
	    while (i--) {
	      var tm = this._timelines[i];
	      // recalc total duration on child timelines
	      tm._recalcTotalDuration && tm._recalcTotalDuration();
	      // add the timeline's duration to selft duration
	      this._recalcDuration(tm);
	    }
	    this._calcDimentions();
	  };
	  /*
	    Method set start and end times.
	    @private
	    @param {Number, Null} Time to start with.
	  */


	  Timeline.prototype._setStartTime = function _setStartTime(time) {
	    var isReset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

	    _Tween.prototype._setStartTime.call(this, time);
	    this._startTimelines(this._props.startTime, isReset);
	  };
	  /*
	    Method calculate self duration based on timeline's duration.
	    @private
	    @param {Number, Null} Time to start with.
	  */


	  Timeline.prototype._startTimelines = function _startTimelines(time) {
	    var isReset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

	    var p = this._props,
	        isStop = this._state === 'stop';

	    time == null && (time = this._props.startTime);

	    for (var i = 0; i < this._timelines.length; i++) {
	      var tm = this._timelines[i];
	      tm._setStartTime(time, isReset);
	      // if from `_subPlay` and `_prevTime` is set and state is `stop`
	      // prevTime normalizing is for play/pause functionality, so no
	      // need to normalize if the timeline is in `stop` state.
	      if (!isReset && tm._prevTime != null && !isStop) {
	        tm._prevTime = tm._normPrevTimeForward();
	      }
	    }
	  };
	  /*
	    Method to launch onRefresh callback.
	    @method _refresh
	    @private
	    @overrides @ Tween
	    @param {Boolean} If refresh even before start time.
	  */


	  Timeline.prototype._refresh = function _refresh(isBefore) {
	    var len = this._timelines.length;
	    for (var i = 0; i < len; i++) {
	      this._timelines[i]._refresh(isBefore);
	    }
	    _Tween.prototype._refresh.call(this, isBefore);
	  };
	  /*
	    Method do declare defaults by this._defaults object
	    @private
	  */


	  Timeline.prototype._declareDefaults = function _declareDefaults() {
	    // if duration was passed on initialization stage, warn user and reset it.
	    if (this._o.duration != null) {
	      _h2.default.error('Duration can not be declared on Timeline, but "' + this._o.duration + '" is. You probably want to use Tween instead.');
	      this._o.duration = 0;
	    }
	    _Tween.prototype._declareDefaults.call(this);
	    // remove default 
	    this._defaults.duration = 0;
	    this._defaults.easing = 'Linear.None';
	    this._defaults.backwardEasing = 'Linear.None';
	    this._defaults.nameBase = 'Timeline';
	  };

	  function Timeline() {
	    var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    (0, _classCallCheck3.default)(this, Timeline);
	    return (0, _possibleConstructorReturn3.default)(this, _Tween.call(this, o));
	  }
	  /*
	    Method to declare some vars.
	    @private
	  */


	  Timeline.prototype._vars = function _vars() {
	    this._timelines = [];
	    _Tween.prototype._vars.call(this);
	  };

	  return Timeline;
	}(_tween2.default);

	exports.default = Timeline;

/***/ }),
/* 111 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(112), __esModule: true };

/***/ }),
/* 112 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(50);
	__webpack_require__(6);
	module.exports = __webpack_require__(113);

/***/ }),
/* 113 */
/***/ (function(module, exports, __webpack_require__) {

	var anObject = __webpack_require__(19)
	  , get      = __webpack_require__(114);
	module.exports = __webpack_require__(14).getIterator = function(it){
	  var iterFn = get(it);
	  if(typeof iterFn != 'function')throw TypeError(it + ' is not iterable!');
	  return anObject(iterFn.call(it));
	};

/***/ }),
/* 114 */
/***/ (function(module, exports, __webpack_require__) {

	var classof   = __webpack_require__(115)
	  , ITERATOR  = __webpack_require__(47)('iterator')
	  , Iterators = __webpack_require__(29);
	module.exports = __webpack_require__(14).getIteratorMethod = function(it){
	  if(it != undefined)return it[ITERATOR]
	    || it['@@iterator']
	    || Iterators[classof(it)];
	};

/***/ }),
/* 115 */
/***/ (function(module, exports, __webpack_require__) {

	// getting tag from 19.1.3.6 Object.prototype.toString()
	var cof = __webpack_require__(37)
	  , TAG = __webpack_require__(47)('toStringTag')
	  // ES3 wrong here
	  , ARG = cof(function(){ return arguments; }()) == 'Arguments';

	// fallback for IE11 Script Access Denied error
	var tryGet = function(it, key){
	  try {
	    return it[key];
	  } catch(e){ /* empty */ }
	};

	module.exports = function(it){
	  var O, T, B;
	  return it === undefined ? 'Undefined' : it === null ? 'Null'
	    // @@toStringTag case
	    : typeof (T = tryGet(O = Object(it), TAG)) == 'string' ? T
	    // builtinTag case
	    : ARG ? cof(O)
	    // ES3 arguments fallback
	    : (B = cof(O)) == 'Object' && typeof O.callee == 'function' ? 'Arguments' : B;
	};

/***/ }),
/* 116 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _keys = __webpack_require__(95);

	var _keys2 = _interopRequireDefault(_keys);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	var _thenable = __webpack_require__(99);

	var _thenable2 = _interopRequireDefault(_thenable);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var Tuneable = function (_Thenable) {
	  (0, _inherits3.default)(Tuneable, _Thenable);

	  function Tuneable() {
	    (0, _classCallCheck3.default)(this, Tuneable);
	    return (0, _possibleConstructorReturn3.default)(this, _Thenable.apply(this, arguments));
	  }

	  /*
	    Method to start the animation with optional new options.
	    @public
	    @param {Object} New options to set on the run.
	    @returns {Object} this.
	  */
	  Tuneable.prototype.tune = function tune(o) {
	    // if options object was passed
	    if (o && (0, _keys2.default)(o).length) {
	      this._transformHistory(o);
	      this._tuneNewOptions(o);
	      // restore array prop values because _props
	      // contain them as parsed arrays
	      // but we need the as strings to store in history
	      // and merge in history chains
	      this._history[0] = _h2.default.cloneObj(this._props);
	      for (var key in this._arrayPropertyMap) {
	        if (o[key] != null) {
	          this._history[0][key] = this._preparsePropValue(key, o[key]);
	        }
	      }

	      this._tuneSubModules();
	      this._resetTweens();
	    }
	    return this;
	  };
	  /*
	    Method to regenerate all the random properties form initial object.
	    @public
	    @returns this.
	  */


	  Tuneable.prototype.generate = function generate() {
	    return this.tune(this._o);
	  };

	  // ^ PUBLIC  METHOD(S) ^
	  // v PRIVATE METHOD(S) v

	  /*
	    Method to preparse options in object.
	    @private
	    @param {Object} Object to preparse properties on.
	    @returns {Object} Passed object with preparsed props.
	  */
	  // _preParseOptions ( o ) {
	  //   for (var key in o) {
	  //     o[key] = this._preparsePropValue( key, o[key] );
	  //   }
	  //   return o;
	  // }
	  /*
	    Method to transform history rewrite new options object chain on run.
	    @private
	    @param {Object} New options to tune for.
	  */


	  Tuneable.prototype._transformHistory = function _transformHistory(o) {
	    for (var key in o) {
	      var value = o[key];
	      // don't transform for childOptions
	      // if ( key === 'childOptions' ) { continue; }
	      this._transformHistoryFor(key, this._preparsePropValue(key, value));
	    }
	  };
	  /*
	    Method to transform history chain for specific key/value.
	    @param {String} Name of the property to transform history for.
	    @param {Any} The new property's value.
	  */


	  Tuneable.prototype._transformHistoryFor = function _transformHistoryFor(key, value) {
	    for (var i = 0; i < this._history.length; i++) {
	      if (value = this._transformHistoryRecord(i, key, value)) {
	        // break if no further history modifications needed
	        if (value == null) {
	          break;
	        }
	      }
	    }
	  };
	  /*
	    Method to transform history recod with key/value.
	    @param {Number} Index of the history record to transform.
	    @param {String} Property name to transform.
	    @param {Any} Property value to transform to.
	    @param {Object} Optional the current history record.
	    @param {Object} Optional the next history record.
	    @returns {Boolean} Returns true if no further
	                       history modifications is needed.
	  */


	  Tuneable.prototype._transformHistoryRecord = function _transformHistoryRecord(index, key, newVal, currRecord, nextRecord) {
	    // newVal = this._parseProperty( key, newVal );
	    if (newVal == null) {
	      return null;
	    }

	    // fallback to history records, if wasn't specified
	    currRecord = currRecord == null ? this._history[index] : currRecord;
	    nextRecord = nextRecord == null ? this._history[index + 1] : nextRecord;

	    var oldVal = currRecord[key],
	        nextVal = nextRecord == null ? null : nextRecord[key];

	    // if index is 0 - always save the newVal
	    // and return non-delta for subsequent modifications
	    if (index === 0) {
	      currRecord[key] = newVal;
	      // always return on tween properties
	      if (_h2.default.isTweenProp(key) && key !== 'duration') {
	        return null;
	      }
	      // nontween properties
	      var isRewriteNext = this._isRewriteNext(oldVal, nextVal),
	          returnVal = this._isDelta(newVal) ? _h2.default.getDeltaEnd(newVal) : newVal;
	      return isRewriteNext ? returnVal : null;
	    } else {
	      // if was delta and came none-deltta - rewrite
	      // the start of the delta and stop
	      if (this._isDelta(oldVal)) {
	        var _currRecord$key;

	        currRecord[key] = (_currRecord$key = {}, _currRecord$key[newVal] = _h2.default.getDeltaEnd(oldVal), _currRecord$key);
	        return null;
	      } else {
	        // if the old value is not delta and the new one is
	        currRecord[key] = newVal;
	        // if the next item has the same value - return the
	        // item for subsequent modifications or stop
	        return this._isRewriteNext(oldVal, nextVal) ? newVal : null;
	      }
	    }
	  };
	  /*
	    Method to check if the next item should
	    be rewrited in transform history operation.
	    @private
	    @param {Any} Current value.
	    @param {Any} Next value.
	    @returns {Boolean} If need to rewrite the next value.
	  */


	  Tuneable.prototype._isRewriteNext = function _isRewriteNext(currVal, nextVal) {
	    // return false if nothing to rewrite next
	    if (nextVal == null && currVal != null) {
	      return false;
	    }

	    var isEqual = currVal === nextVal,
	        isNextDelta = this._isDelta(nextVal),
	        isDelta = this._isDelta(currVal),
	        isValueDeltaChain = false,
	        isDeltaChain = false;

	    if (isDelta && isNextDelta) {
	      if (_h2.default.getDeltaEnd(currVal) == _h2.default.getDeltaStart(nextVal)) {
	        isDeltaChain = true;
	      }
	    } else if (isNextDelta) {
	      isValueDeltaChain = _h2.default.getDeltaStart(nextVal) === '' + currVal;
	    }

	    return isEqual || isValueDeltaChain || isDeltaChain;
	  };
	  /*
	    Method to tune new history options to all the submodules.
	    @private
	  */


	  Tuneable.prototype._tuneSubModules = function _tuneSubModules() {
	    for (var i = 1; i < this._modules.length; i++) {
	      this._modules[i]._tuneNewOptions(this._history[i]);
	    }
	  };
	  /*
	    Method to set new options on run.
	    @param {Boolean} If foreign context.
	    @private
	  */


	  Tuneable.prototype._resetTweens = function _resetTweens() {
	    var i = 0,
	        shift = 0,
	        tweens = this.timeline._timelines;

	    // if `isTimelineLess` return
	    if (tweens == null) {
	      return;
	    }

	    for (var i = 0; i < tweens.length; i++) {
	      var tween = tweens[i],
	          prevTween = tweens[i - 1];

	      shift += prevTween ? prevTween._props.repeatTime : 0;
	      this._resetTween(tween, this._history[i], shift);
	    }
	    this.timeline._setProp(this._props.timeline);
	    this.timeline._recalcTotalDuration();
	  };
	  /*
	    Method to reset tween with new options.
	    @param {Object} Tween to reset.
	    @param {Object} Tween's to reset tween with.
	    @param {Number} Optional number to shift tween start time.
	  */


	  Tuneable.prototype._resetTween = function _resetTween(tween, o) {
	    var shift = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;

	    o.shiftTime = shift;tween._setProp(o);
	  };

	  return Tuneable;
	}(_thenable2.default);

	exports.default = Tuneable;

/***/ }),
/* 117 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _shape = __webpack_require__(94);

	var _shape2 = _interopRequireDefault(_shape);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	/*
	  *TODO:*
	  ---
	  - tweak then chains
	*/

	var ShapeSwirl = function (_Shape) {
	  (0, _inherits3.default)(ShapeSwirl, _Shape);

	  function ShapeSwirl() {
	    (0, _classCallCheck3.default)(this, ShapeSwirl);
	    return (0, _possibleConstructorReturn3.default)(this, _Shape.apply(this, arguments));
	  }

	  /*
	    Method to declare _defaults and other default objects.
	    @private
	    @override @ Shape
	  */
	  ShapeSwirl.prototype._declareDefaults = function _declareDefaults() {
	    _Shape.prototype._declareDefaults.call(this);

	    /* _DEFAULTS ARE - Shape DEFAULTS + THESE: */

	    /* [boolean] :: If shape should follow sinusoidal path. */
	    this._defaults.isSwirl = true;
	    /* ∆ :: [number > 0] :: Degree size of the sinusoidal path. */
	    this._defaults.swirlSize = 10;
	    /* ∆ :: [number > 0] :: Frequency of the sinusoidal path. */
	    this._defaults.swirlFrequency = 3;
	    /* ∆ :: [number > 0] :: Sinusoidal path length scale. */
	    this._defaults.pathScale = 1;
	    /* ∆ :: [number] :: Degree shift for the sinusoidal path. */
	    this._defaults.degreeShift = 0;
	    /* ∆ :: [number] :: Radius of the shape. */
	    this._defaults.radius = 5;
	    // ∆ :: Units :: Possible values: [ number, string ]
	    this._defaults.x = 0;
	    // ∆ :: Units :: Possible values: [ number, string ]
	    this._defaults.y = 0;
	    // ∆ :: Possible values: [ number ]
	    this._defaults.scale = { 1: 0 };
	    /* [number: -1, 1] :: Directon of Swirl. */
	    this._defaults.direction = 1;
	  };

	  // ^ PUBLIC  METHOD(S) ^
	  // v PRIVATE METHOD(S) v

	  /*
	    Method to copy _o options to _props with
	    fallback to _defaults.
	    @private
	    @override @ Module
	  */


	  ShapeSwirl.prototype._extendDefaults = function _extendDefaults() {
	    _Shape.prototype._extendDefaults.call(this);
	    this._calcPosData();
	  };
	  /*
	    Method to tune new oprions to _o and _props object.
	    @private
	    @overrides @ Module
	    @param {Object} Options object to tune to.
	  */


	  ShapeSwirl.prototype._tuneNewOptions = function _tuneNewOptions(o) {
	    if (o == null) {
	      return;
	    }

	    _Shape.prototype._tuneNewOptions.call(this, o);
	    if (o.x != null || o.y != null) {
	      this._calcPosData();
	    }
	  };
	  /*
	    Method to calculate Swirl's position data.
	    @private
	  */


	  ShapeSwirl.prototype._calcPosData = function _calcPosData() {
	    var x = this._getPosValue('x'),
	        y = this._getPosValue('y'),
	        angle = 90 + Math.atan(y.delta / x.delta || 0) * _h2.default.RAD_TO_DEG;

	    this._posData = {
	      radius: Math.sqrt(x.delta * x.delta + y.delta * y.delta),
	      angle: x.delta < 0 ? angle + 180 : angle,
	      x: x, y: y
	    };
	    // set the last position to _props
	    // this._calcSwirlXY( 1 );
	  };
	  /*
	    Gets `x` or `y` position value.
	    @private
	    @param {String} Name of the property.
	  */


	  ShapeSwirl.prototype._getPosValue = function _getPosValue(name) {
	    var delta = this._deltas[name];
	    if (delta) {
	      // delete from deltas to prevent normal
	      delete this._deltas[name];
	      return {
	        start: delta.start.value,
	        end: delta.end.value,
	        delta: delta.delta,
	        units: delta.end.unit
	      };
	    } else {
	      var pos = _h2.default.parseUnit(this._props[name]);
	      return { start: pos.value, end: pos.value, delta: 0, units: pos.unit };
	    }
	  };
	  /*
	    Method to calculate the progress of the Swirl.
	    @private
	    @overrides @ Shape
	    @param {Numer} Eased progress of the Swirl in range of [0..1]
	    @param {Numer} Progress of the Swirl in range of [0..1]
	  */


	  ShapeSwirl.prototype._setProgress = function _setProgress(easedProgress, progress) {
	    this._progress = easedProgress;
	    this._calcCurrentProps(easedProgress, progress);
	    this._calcSwirlXY(easedProgress);
	    // this._calcOrigin();
	    this._draw(easedProgress);
	  };
	  /*
	    Method to calculate x/y for Swirl's progress
	    @private
	    @mutates _props
	    @param {Number} Current progress in [0...1]
	  */


	  ShapeSwirl.prototype._calcSwirlXY = function _calcSwirlXY(proc) {
	    var p = this._props,
	        angle = this._posData.angle + p.degreeShift,
	        point = _h2.default.getRadialPoint({
	      angle: p.isSwirl ? angle + this._getSwirl(proc) : angle,
	      radius: proc * this._posData.radius * p.pathScale,
	      center: {
	        x: this._posData.x.start,
	        y: this._posData.y.start
	      }
	    });
	    // if foreign svg canvas - set position without units
	    var x = point.x,
	        y = point.y,
	        smallNumber = 0.000001;

	    // remove very small numbers to prevent exponential forms
	    if (x > 0 && x < smallNumber) {
	      x = smallNumber;
	    }
	    if (y > 0 && y < smallNumber) {
	      y = smallNumber;
	    }
	    if (x < 0 && x > -smallNumber) {
	      x = -smallNumber;
	    }
	    if (y < 0 && y > -smallNumber) {
	      y = -smallNumber;
	    }

	    p.x = this._o.ctx ? x : '' + x + this._posData.x.units;
	    p.y = this._o.ctx ? y : '' + y + this._posData.y.units;
	  };
	  /*
	    Method to get progress of the swirl.
	    @private
	    @param {Number} Progress of the Swirl.
	    @returns {Number} Progress of the swirl.
	  */


	  ShapeSwirl.prototype._getSwirl = function _getSwirl(proc) {
	    var p = this._props;
	    return p.direction * p.swirlSize * Math.sin(p.swirlFrequency * proc);
	  };
	  /*
	    Method to draw shape.
	    If !isWithShape - draw self el only, but not shape.
	    @private
	    @overrides @ Shape.
	  */


	  ShapeSwirl.prototype._draw = function _draw() {
	    // call _draw or just _drawEl @ Shape depending if there is `shape`
	    var methodName = this._props.isWithShape ? '_draw' : '_drawEl';
	    _shape2.default.prototype[methodName].call(this);
	  };

	  return ShapeSwirl;
	}(_shape2.default);

	exports.default = ShapeSwirl;

/***/ }),
/* 118 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _keys = __webpack_require__(95);

	var _keys2 = _interopRequireDefault(_keys);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _timeline = __webpack_require__(110);

	var _timeline2 = _interopRequireDefault(_timeline);

	var _shapeSwirl = __webpack_require__(117);

	var _shapeSwirl2 = _interopRequireDefault(_shapeSwirl);

	var _tunable = __webpack_require__(116);

	var _tunable2 = _interopRequireDefault(_tunable);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	// import Shape    from './shape';
	var Burst = function (_Tunable) {
	  (0, _inherits3.default)(Burst, _Tunable);

	  function Burst() {
	    (0, _classCallCheck3.default)(this, Burst);
	    return (0, _possibleConstructorReturn3.default)(this, _Tunable.apply(this, arguments));
	  }

	  /*
	    Method to declare defaults.
	    @override @ ShapeSwirl.
	  */
	  Burst.prototype._declareDefaults = function _declareDefaults() {
	    this._defaults = {
	      /* [number > 0] :: Quantity of Burst particles. */
	      count: 5,
	      /* [0 < number < 360] :: Degree of the Burst. */
	      degree: 360,
	      /* ∆ :: [number > 0] :: Radius of the Burst. */
	      radius: { 0: 50 },
	      /* ∆ :: [number > 0] :: X radius of the Burst. */
	      radiusX: null,
	      /* ∆ :: [number > 0] :: Y radius of the Burst. */
	      radiusY: null,
	      /* [number >= 0] :: width of the main swirl. */
	      width: 0,
	      /* [number >= 0] :: height of the main swirl. */
	      height: 0
	    };
	  };
	  /*
	    Method to create a then record for the module.
	    @public
	    overrides @ Thenable
	    @param    {Object} Options for the next animation.
	    @returns  {Object} this.
	  */


	  Burst.prototype.then = function then(o) {
	    // remove tween properties (not callbacks)
	    this._removeTweenProperties(o);

	    var newMaster = this._masterThen(o),
	        newSwirls = this._childThen(o);

	    this._setSwirlDuration(newMaster, this._calcPackTime(newSwirls));

	    this.timeline._recalcTotalDuration();
	    return this;
	  };
	  /*
	    Method to start the animation with optional new options.
	    @public
	    @param {Object} New options to set on the run.
	    @returns {Object} this.
	  */


	  Burst.prototype.tune = function tune(o) {
	    if (o == null) {
	      return this;
	    }
	    // save timeline options to _timelineOptions
	    // and delete the timeline options on o
	    // cuz masterSwirl should not get them
	    this._saveTimelineOptions(o);

	    // add new timeline properties to timeline
	    this.timeline._setProp(this._timelineOptions);

	    // remove tween options (not callbacks)
	    this._removeTweenProperties(o);

	    // tune _props
	    this._tuneNewOptions(o);

	    // tune master swirl
	    this.masterSwirl.tune(o);

	    // tune child swirls
	    this._tuneSwirls(o);

	    // recalc time for modules
	    this._recalcModulesTime();
	    return this;
	  };

	  // ^ PUBLIC  METHODS ^
	  // v PRIVATE METHODS v

	  /*
	    Method to copy `_o` options to `_props` object
	    with fallback to `_defaults`.
	    @private
	    @overrides @ Module
	  */


	  Burst.prototype._extendDefaults = function _extendDefaults() {
	    // remove tween properties (not callbacks)
	    this._removeTweenProperties(this._o);
	    _Tunable.prototype._extendDefaults.call(this);
	  };
	  /*
	    Method to remove all tween (excluding
	    callbacks) props from object.
	    @private
	    @param {Object} Object which should be cleaned
	                    up from tween properties.
	  */


	  Burst.prototype._removeTweenProperties = function _removeTweenProperties(o) {
	    for (var key in _h2.default.tweenOptionMap) {
	      // remove all items that are not declared in _defaults
	      if (this._defaults[key] == null) {
	        delete o[key];
	      }
	    }
	  };
	  /*
	    Method to recalc modules chain tween
	    times after tuning new options.
	    @private
	  */


	  Burst.prototype._recalcModulesTime = function _recalcModulesTime() {
	    var modules = this.masterSwirl._modules,
	        swirls = this._swirls,
	        shiftTime = 0;

	    for (var i = 0; i < modules.length; i++) {
	      var tween = modules[i].tween,
	          packTime = this._calcPackTime(swirls[i]);
	      tween._setProp({ 'duration': packTime, 'shiftTime': shiftTime });
	      shiftTime += packTime;
	    }

	    this.timeline._recalcTotalDuration();
	  };
	  /*
	    Method to tune Swirls with new options.
	    @private
	    @param {Object} New options.
	  */


	  Burst.prototype._tuneSwirls = function _tuneSwirls(o) {
	    // get swirls in first pack
	    var pack0 = this._swirls[0];
	    for (var i = 0; i < pack0.length; i++) {
	      var swirl = pack0[i],
	          option = this._getChildOption(o || {}, i);

	      // since the `degreeShift` participate in
	      // children position calculations, we need to keep
	      // the old `degreeShift` value if new not set
	      var isDegreeShift = option.degreeShift != null;
	      if (!isDegreeShift) {
	        option.degreeShift = this._swirls[0][i]._props.degreeShift;
	      }

	      this._addBurstProperties(option, i);

	      // after burst position calculation - delete the old `degreeShift`
	      // from the options, since anyways we have copied it from the swirl
	      if (!isDegreeShift) {
	        delete option.degreeShift;
	      }

	      swirl.tune(option);
	      this._refreshBurstOptions(swirl._modules, i);
	    }
	  };
	  /*
	    Method to refresh burst x/y/angle options on further chained 
	    swirls, because they will be overriden after `tune` call on
	    very first swirl.
	    @param {Array} Chained modules array
	    param {Number} Index of the first swirl in the chain.
	  */


	  Burst.prototype._refreshBurstOptions = function _refreshBurstOptions(modules, i) {
	    for (var j = 1; j < modules.length; j++) {
	      var module = modules[j],
	          options = {};
	      this._addBurstProperties(options, i, j);
	      module._tuneNewOptions(options);
	    }
	  };
	  /*
	    Method to call then on masterSwirl.
	    @param {Object} Then options.
	    @returns {Object} New master swirl.
	  */


	  Burst.prototype._masterThen = function _masterThen(o) {
	    this.masterSwirl.then(o);
	    // get the latest master swirl in then chain
	    var newMasterSwirl = _h2.default.getLastItem(this.masterSwirl._modules);
	    // save to masterSwirls
	    this._masterSwirls.push(newMasterSwirl);
	    return newMasterSwirl;
	  };
	  /*
	    Method to call then on child swilrs.
	    @param {Object} Then options.
	    @return {Array} Array of new Swirls.
	  */


	  Burst.prototype._childThen = function _childThen(o) {
	    var pack = this._swirls[0],
	        newPack = [];

	    for (var i = 0; i < pack.length; i++) {
	      // get option by modulus
	      var options = this._getChildOption(o, i);
	      var swirl = pack[i];
	      var lastSwirl = _h2.default.getLastItem(swirl._modules);
	      // add new Master Swirl as parent of new childswirl
	      options.parent = this.el;

	      this._addBurstProperties(options, i, this._masterSwirls.length - 1);

	      swirl.then(options);

	      // save the new item in `then` chain
	      newPack.push(_h2.default.getLastItem(swirl._modules));
	    }
	    // save the pack to _swirls object
	    this._swirls[this._masterSwirls.length - 1] = newPack;
	    return newPack;
	  };
	  /*
	    Method to initialize properties.
	    @private
	    @overrides @ Thenable
	  */


	  Burst.prototype._vars = function _vars() {
	    _Tunable.prototype._vars.call(this);
	    // just buffer timeline for calculations
	    this._bufferTimeline = new _timeline2.default();
	  };
	  /*
	    Method for initial render of the module.
	  */


	  Burst.prototype._render = function _render() {
	    this._o.isWithShape = false;
	    this._o.isSwirl = this._props.isSwirl;
	    this._o.callbacksContext = this;
	    // save timeline options and remove from _o
	    // cuz the master swirl should not get them
	    this._saveTimelineOptions(this._o);

	    this.masterSwirl = new MainSwirl(this._o);
	    this._masterSwirls = [this.masterSwirl];
	    this.el = this.masterSwirl.el;

	    this._renderSwirls();
	  };
	  /*
	    Method for initial render of swirls.
	    @private
	  */


	  Burst.prototype._renderSwirls = function _renderSwirls() {
	    var p = this._props,
	        pack = [];

	    for (var i = 0; i < p.count; i++) {
	      var option = this._getChildOption(this._o, i);
	      pack.push(new ChildSwirl(this._addOptionalProps(option, i)));
	    }
	    this._swirls = { 0: pack };
	    this._setSwirlDuration(this.masterSwirl, this._calcPackTime(pack));
	  };
	  /*
	    Method to save timeline options to _timelineOptions
	    and delete the property on the object.
	    @private
	    @param {Object} The object to save the timeline options from.
	  */


	  Burst.prototype._saveTimelineOptions = function _saveTimelineOptions(o) {
	    this._timelineOptions = o.timeline;
	    delete o.timeline;
	  };
	  /*
	    Method to calculate total time of array of
	    concurrent tweens.
	    @param   {Array}  Pack to calculate the total time for.
	    @returns {Number} Total pack duration.
	  */


	  Burst.prototype._calcPackTime = function _calcPackTime(pack) {
	    var maxTime = 0;
	    for (var i = 0; i < pack.length; i++) {
	      var tween = pack[i].tween,
	          p = tween._props;

	      maxTime = Math.max(p.repeatTime / p.speed, maxTime);
	    }

	    return maxTime;
	  };
	  /*
	    Method to set duration for Swirl.
	    @param {Object} Swirl instance to set the duration to.
	    @param {Number} Duration to set.
	  */


	  Burst.prototype._setSwirlDuration = function _setSwirlDuration(swirl, duration) {
	    swirl.tween._setProp('duration', duration);
	    var isRecalc = swirl.timeline && swirl.timeline._recalcTotalDuration;
	    isRecalc && swirl.timeline._recalcTotalDuration();
	  };
	  /*
	    Method to get childOption form object call by modulus.
	    @private
	    @param   {Object} Object to look in.
	    @param   {Number} Index of the current Swirl.
	    @returns {Object} Options for the current swirl.
	  */


	  Burst.prototype._getChildOption = function _getChildOption(obj, i) {
	    var options = {};
	    for (var key in obj.children) {
	      options[key] = this._getPropByMod(key, i, obj.children);
	    }
	    return options;
	  };
	  /*
	    Method to get property by modulus.
	    @private
	    @param {String} Name of the property.
	    @param {Number} Index for the modulus.
	    @param {Object} Source object to check in.
	    @returns {Any} Property.
	  */


	  Burst.prototype._getPropByMod = function _getPropByMod(name, index) {
	    var sourceObj = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

	    var prop = sourceObj[name];
	    return _h2.default.isArray(prop) ? prop[index % prop.length] : prop;
	  };
	  /*
	    Method to add optional Swirls' properties to passed object.
	    @private
	    @param {Object} Object to add the properties to.
	    @param {Number} Index of the property.
	  */


	  Burst.prototype._addOptionalProps = function _addOptionalProps(options, index) {
	    options.index = index;
	    options.parent = this.masterSwirl.el;

	    this._addBurstProperties(options, index);

	    return options;
	  };
	  /*
	    Method to add Burst options to object.
	    @private
	    @param {Object} Options to add the properties to.
	    @param {Number} Index of the Swirl.
	    @param {Number} Index of the main swirl.
	  */


	  Burst.prototype._addBurstProperties = function _addBurstProperties(options, index, i) {
	    // save index of the module
	    var mainIndex = this._index;
	    // temporary change the index to parse index based properties like stagger
	    this._index = index;
	    // parse degree shift for the bit
	    var degreeShift = this._parseProperty('degreeShift', options.degreeShift || 0);
	    // put the index of the module back
	    this._index = mainIndex;

	    var p = this._props,
	        degreeCnt = p.degree % 360 === 0 ? p.count : p.count - 1 || 1,
	        step = p.degree / degreeCnt,
	        pointStart = this._getSidePoint('start', index * step + degreeShift, i),
	        pointEnd = this._getSidePoint('end', index * step + degreeShift, i);

	    options.x = this._getDeltaFromPoints('x', pointStart, pointEnd);
	    options.y = this._getDeltaFromPoints('y', pointStart, pointEnd);

	    options.angle = this._getBitAngle(options.angle || 0, degreeShift, index);
	  };
	  /* 
	    Method to get shapes angle in burst so
	    it will follow circular shape.
	     
	     @param    {Number, Object} Base angle.
	     @param    {Number}         Angle shift for the bit
	     @param    {Number}         Shape's index in burst.
	     @returns  {Number}         Angle in burst.
	  */


	  Burst.prototype._getBitAngle = function _getBitAngle() {
	    var angleProperty = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
	    var angleShift = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
	    var i = arguments[2];

	    var p = this._props,
	        degCnt = p.degree % 360 === 0 ? p.count : p.count - 1 || 1,
	        step = p.degree / degCnt,
	        angle = i * step + 90;

	    angle += angleShift;
	    // if not delta option
	    if (!this._isDelta(angleProperty)) {
	      angleProperty += angle;
	    } else {
	      var delta = {},
	          keys = (0, _keys2.default)(angleProperty),
	          start = keys[0],
	          end = angleProperty[start];

	      start = _h2.default.parseStringOption(start, i);
	      end = _h2.default.parseStringOption(end, i);
	      // new start = newEnd
	      delta[parseFloat(start) + angle] = parseFloat(end) + angle;

	      angleProperty = delta;
	    }
	    return angleProperty;
	  };
	  /*
	    Method to get radial point on `start` or `end`.
	    @private
	    @param {String} Name of the side - [start, end].
	    @param {Number} Angle of the radial point.
	    @param {Number} Index of the main swirl.
	    @returns radial point.
	  */


	  Burst.prototype._getSidePoint = function _getSidePoint(side, angle, i) {
	    var p = this._props,
	        sideRadius = this._getSideRadius(side, i);

	    return _h2.default.getRadialPoint({
	      radius: sideRadius.radius,
	      radiusX: sideRadius.radiusX,
	      radiusY: sideRadius.radiusY,
	      angle: angle,
	      // center:  { x: p.center, y: p.center }
	      center: { x: 0, y: 0 }
	    });
	  };
	  /*
	    Method to get radius of the side.
	    @private
	    @param {String} Name of the side - [start, end].
	    @param {Number} Index of the main swirl.
	    @returns {Object} Radius.
	  */


	  Burst.prototype._getSideRadius = function _getSideRadius(side, i) {
	    return {
	      radius: this._getRadiusByKey('radius', side, i),
	      radiusX: this._getRadiusByKey('radiusX', side, i),
	      radiusY: this._getRadiusByKey('radiusY', side, i)
	    };
	  };
	  /*
	    Method to get radius from ∆ or plain property.
	    @private
	    @param {String} Key name.
	    @param {String} Side name - [start, end].
	    @param {Number} Index of the main swirl.
	    @returns {Number} Radius value.
	  */


	  Burst.prototype._getRadiusByKey = function _getRadiusByKey(key, side) {
	    var i = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;

	    var swirl = this._masterSwirls[i],
	        deltas = swirl._deltas,
	        props = swirl._props;

	    if (deltas[key] != null) {
	      return deltas[key][side];
	    } else if (props[key] != null) {
	      return props[key];
	    }
	  };
	  /*
	    Method to get delta from start and end position points.
	    @private
	    @param {String} Key name.
	    @param {Object} Start position point.
	    @param {Object} End position point.
	    @returns {Object} Delta of the end/start.
	  */


	  Burst.prototype._getDeltaFromPoints = function _getDeltaFromPoints(key, pointStart, pointEnd) {
	    var delta = {};
	    if (pointStart[key] === pointEnd[key]) {
	      delta = pointStart[key];
	    } else {
	      delta[pointStart[key]] = pointEnd[key];
	    }
	    return delta;
	  };
	  /*
	    Method to create timeline.
	    @private
	    @override @ Tweenable
	  */


	  Burst.prototype._makeTimeline = function _makeTimeline() {
	    // restore timeline options that were deleted in _render method
	    this._o.timeline = this._timelineOptions;
	    _Tunable.prototype._makeTimeline.call(this);
	    this.timeline.add(this.masterSwirl, this._swirls[0]);
	  };
	  /*
	    Method to make Tween for the module.
	    @private
	    @override @ Tweenable
	  */


	  Burst.prototype._makeTween = function _makeTween() {} /* don't create any tween */
	  /*
	    Override `_hide` and `_show` methods on module
	    since we don't have to hide nor show on the module.
	  */
	  ;

	  Burst.prototype._hide = function _hide() {/* do nothing */};

	  Burst.prototype._show = function _show() {/* do nothing */};

	  return Burst;
	}(_tunable2.default);

	var ChildSwirl = function (_ShapeSwirl) {
	  (0, _inherits3.default)(ChildSwirl, _ShapeSwirl);

	  function ChildSwirl() {
	    (0, _classCallCheck3.default)(this, ChildSwirl);
	    return (0, _possibleConstructorReturn3.default)(this, _ShapeSwirl.apply(this, arguments));
	  }

	  ChildSwirl.prototype._declareDefaults = function _declareDefaults() {
	    _ShapeSwirl.prototype._declareDefaults.call(this);
	    this._defaults.isSwirl = false;
	    this._o.duration = this._o.duration != null ? this._o.duration : 700;
	  };
	  // disable degreeshift calculations


	  ChildSwirl.prototype._calcSwirlXY = function _calcSwirlXY(proc) {
	    var degreeShift = this._props.degreeShift;

	    this._props.degreeShift = 0;
	    _ShapeSwirl.prototype._calcSwirlXY.call(this, proc);
	    this._props.degreeShift = degreeShift;
	  };

	  return ChildSwirl;
	}(_shapeSwirl2.default);

	var MainSwirl = function (_ChildSwirl) {
	  (0, _inherits3.default)(MainSwirl, _ChildSwirl);

	  function MainSwirl() {
	    (0, _classCallCheck3.default)(this, MainSwirl);
	    return (0, _possibleConstructorReturn3.default)(this, _ChildSwirl.apply(this, arguments));
	  }

	  MainSwirl.prototype._declareDefaults = function _declareDefaults() {
	    _ChildSwirl.prototype._declareDefaults.call(this);
	    this._defaults.scale = 1;
	    this._defaults.width = 0;
	    this._defaults.height = 0;
	    this._defaults.radius = { 25: 75 };
	    // this._defaults.duration = 2000;
	  };

	  return MainSwirl;
	}(ChildSwirl);

	Burst.ChildSwirl = ChildSwirl;
	Burst.MainSwirl = MainSwirl;

	exports.default = Burst;

/***/ }),
/* 119 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _extends4 = __webpack_require__(120);

	var _extends5 = _interopRequireDefault(_extends4);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _keys = __webpack_require__(95);

	var _keys2 = _interopRequireDefault(_keys);

	var _thenable = __webpack_require__(99);

	var _thenable2 = _interopRequireDefault(_thenable);

	var _tween = __webpack_require__(101);

	var _tween2 = _interopRequireDefault(_tween);

	var _deltas = __webpack_require__(125);

	var _deltas2 = _interopRequireDefault(_deltas);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var h = __webpack_require__(71);


	// get tween properties
	var obj = {};
	_tween2.default.prototype._declareDefaults.call(obj);
	var keys = (0, _keys2.default)(obj._defaults);
	for (var i = 0; i < keys.length; i++) {
	  obj._defaults[keys[i]] = 1;
	}
	obj._defaults['timeline'] = 1;
	var TWEEN_PROPERTIES = obj._defaults;

	/*
	  TODO:

	    - change _props to _propsObj for animations
	    - current values in deltas
	*/

	var Html = function (_Thenable) {
	  (0, _inherits3.default)(Html, _Thenable);

	  function Html() {
	    (0, _classCallCheck3.default)(this, Html);
	    return (0, _possibleConstructorReturn3.default)(this, _Thenable.apply(this, arguments));
	  }

	  Html.prototype._declareDefaults = function _declareDefaults() {
	    this._defaults = {
	      x: 0,
	      y: 0,
	      z: 0,

	      skewX: 0,
	      skewY: 0,

	      // angle:      0,
	      angleX: 0,
	      angleY: 0,
	      angleZ: 0,

	      scale: 1,
	      scaleX: 1,
	      scaleY: 1,

	      isSoftHide: true,
	      isShowStart: true,
	      isShowEnd: true,
	      isForce3d: false,
	      isRefreshState: true

	    };
	    // exclude from automatic drawing
	    this._drawExclude = { el: 1 };
	    // properties that cause 3d layer
	    this._3dProperties = ['angleX', 'angleY', 'z'];
	    // properties that have array values
	    this._arrayPropertyMap = { transformOrigin: 1, backgroundPosition: 1 };
	    // properties that have no units
	    this._numberPropertyMap = {
	      opacity: 1, scale: 1, scaleX: 1, scaleY: 1,
	      // angle: 1,
	      angleX: 1, angleY: 1, angleZ: 1,
	      skewX: 1, skewY: 1
	    };
	    // properties that should be prefixed 
	    this._prefixPropertyMap = { transform: 1, transformOrigin: 1 };
	    // save prefix
	    this._prefix = h.prefix.css;
	  };

	  Html.prototype.then = function then(o) {
	    // return if nothing was passed
	    if (o == null || !(0, _keys2.default)(o).length) {
	      return 1;
	    }

	    // get the last item in `then` chain
	    var prevModule = h.getLastItem(this._modules);
	    // set deltas to the finish state
	    prevModule.deltas.refresh(false);
	    // copy finish state to the last history record
	    this._history[this._history.length - 1] = prevModule._o;
	    // call super
	    _Thenable.prototype.then.call(this, o);
	    // restore the _props
	    prevModule.deltas.restore();

	    return this;
	  };
	  /*
	    Method to pipe startValue of the delta.
	    @private
	    @ovarrides @ Thenable
	    @param {String} Start property name.
	    @param {Any} Start property value.
	    @returns {Any} Start property value.
	  */


	  Html.prototype._checkStartValue = function _checkStartValue(key, value) {
	    if (value == null) {
	      // return default value for transforms
	      if (this._defaults[key] != null) {
	        return this._defaults[key];
	      }
	      // return default value from _customProps
	      if (this._customProps[key] != null) {
	        return this._customProps[key];
	      }
	      // try to get the default value
	      if (h.defaultStyles[key] != null) {
	        return h.defaultStyles[key];
	      }
	      // at the end return 0
	      return 0;
	    }

	    return value;
	  };
	  /*
	    Method to draw _props to el.
	    @private
	  */


	  Html.prototype._draw = function _draw() {
	    var p = this._props;
	    for (var i = 0; i < this._drawProps.length; i++) {
	      var name = this._drawProps[i];
	      this._setStyle(name, p[name]);
	    }
	    // draw transforms
	    this._drawTransform();
	    // call custom transform callback if exist
	    this._customDraw && this._customDraw(this._props.el, this._props);
	  };
	  /*
	    Method to set transform on element.
	    @private
	  */


	  Html.prototype._drawTransform = function _drawTransform() {
	    var p = this._props;
	    var string = !this._is3d ? 'translate(' + p.x + ', ' + p.y + ')\n          rotate(' + p.angleZ + 'deg)\n          skew(' + p.skewX + 'deg, ' + p.skewY + 'deg)\n          scale(' + p.scaleX + ', ' + p.scaleY + ')' : 'translate3d(' + p.x + ', ' + p.y + ', ' + p.z + ')\n          rotateX(' + p.angleX + 'deg)\n          rotateY(' + p.angleY + 'deg)\n          rotateZ(' + p.angleZ + 'deg)\n          skew(' + p.skewX + 'deg, ' + p.skewY + 'deg)\n          scale(' + p.scaleX + ', ' + p.scaleY + ')';

	    this._setStyle('transform', string);
	  };
	  /*
	    Method to render on initialization.
	    @private
	    @overrides @ Module
	  */


	  Html.prototype._render = function _render() {
	    // return immediately if not the first in `then` chain
	    if (this._o.prevChainModule) {
	      return;
	    }

	    var p = this._props;

	    for (var i = 0; i < this._renderProps.length; i++) {
	      var name = this._renderProps[i],
	          value = p[name];

	      value = typeof value === 'number' ? value + 'px' : value;
	      this._setStyle(name, value);
	    }

	    this._draw();

	    if (!p.isShowStart) {
	      this._hide();
	    }
	  };
	  /*
	    Method to set style on el.
	    @private
	    @param {String} Style property name.
	    @param {String} Style property value.
	  */


	  Html.prototype._setStyle = function _setStyle(name, value) {
	    if (this._state[name] !== value) {
	      var style = this._props.el.style;
	      // set style
	      style[name] = value;
	      // if prefix needed - set it
	      if (this._prefixPropertyMap[name]) {
	        style['' + this._prefix + name] = value;
	      }
	      // cache the last set value
	      this._state[name] = value;
	    }
	  };
	  /*
	    Method to copy `_o` options to `_props` object.
	    @private
	  */


	  Html.prototype._extendDefaults = function _extendDefaults() {
	    this._props = this._o.props || {};
	    // props for intial render only
	    this._renderProps = [];
	    // props for draw on every frame update
	    this._drawProps = [];
	    // save custom properties if present
	    this._saveCustomProperties(this._o);
	    // copy the options
	    var o = (0, _extends5.default)({}, this._o);
	    // extend options with defaults
	    o = this._addDefaults(o);

	    var keys = (0, _keys2.default)(o);
	    for (var i = 0; i < keys.length; i++) {
	      var key = keys[i];
	      // include the property if it is not in drawExclude object
	      // and not in defaults = not a transform
	      var isInclude = !this._drawExclude[key] && // not in exclude map
	      this._defaults[key] == null && // not transform property
	      !TWEEN_PROPERTIES[key]; // not tween property

	      var isCustom = this._customProps[key];
	      // copy all non-delta properties to the props
	      // if not delta then add the property to render
	      // list that is called on initialization
	      // otherwise add it to the draw list that will
	      // be drawed on each frame
	      if (!h.isDelta(o[key]) && !TWEEN_PROPERTIES[key]) {
	        this._parseOption(key, o[key]);
	        if (key === 'el') {
	          this._props.el = h.parseEl(o.el);
	          this.el = this._props.el;
	        }
	        if (isInclude && !isCustom) {
	          this._renderProps.push(key);
	        }
	        // copy delta prop but not transforms
	        // otherwise push it to draw list that gets traversed on every draw
	      } else if (isInclude && !isCustom) {
	        this._drawProps.push(key);
	      }
	    }

	    this._createDeltas(o);
	  };
	  /*
	    Method to save customProperties to _customProps.
	    @param {Object} Options of the module.
	  */


	  Html.prototype._saveCustomProperties = function _saveCustomProperties() {
	    var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

	    this._customProps = o.customProperties || {};
	    this._customProps = (0, _extends5.default)({}, this._customProps);
	    this._customDraw = this._customProps.draw;
	    delete this._customProps.draw;
	    delete o.customProperties;

	    this._copyDefaultCustomProps();

	    // if ( this._customProps ) {}
	    // this._customProps = this._customProps || {};
	  };

	  Html.prototype._copyDefaultCustomProps = function _copyDefaultCustomProps() {
	    for (var key in this._customProps) {
	      if (this._o[key] == null) {
	        this._o[key] = this._customProps[key];
	      }
	    }
	  };
	  /*
	    Method to reset some flags on merged options object.
	    @private
	    @overrides @ Thenable
	    @param   {Object} Options object.
	    @returns {Object} Options object.
	  */


	  Html.prototype._resetMergedFlags = function _resetMergedFlags(o) {
	    _Thenable.prototype._resetMergedFlags.call(this, o);
	    o.props = this._props;
	    o.customProperties = this._customProps;
	    return o;
	  };
	  /*
	    Method to parse option value.
	    @private
	    @param {String} Option name.
	    @param {Any} Option value.
	  */


	  Html.prototype._parseOption = function _parseOption(key, value) {
	    _Thenable.prototype._parseOption.call(this, key, value);
	    // at this point the property is parsed
	    var parsed = this._props[key];
	    // cast it to string if it is array
	    if (h.isArray(parsed)) {
	      this._props[key] = this._arrToString(parsed);
	    }
	  };
	  /*
	    Method cast array to string value.
	    @private
	    @param {Array} Array of parsed numbers with units.
	    @returns {String} Casted array.
	  */


	  Html.prototype._arrToString = function _arrToString(arr) {
	    var string = '';
	    for (var i = 0; i < arr.length; i++) {
	      string += arr[i].string + ' ';
	    }
	    return string;
	  };
	  /*
	    Method to add defauls to passed object.
	    @private
	    @param {Object} Object to add defaults to.
	  */


	  Html.prototype._addDefaults = function _addDefaults(obj) {
	    // flag that after all defaults are set will indicate
	    // if user have set the 3d transform
	    this._is3d = false;

	    for (var key in this._defaults) {
	      // skip property if it is listed in _skipProps
	      // if (this._skipProps && this._skipProps[key]) { continue; }

	      // copy the properties to the _o object
	      // if it's null - set the default value
	      if (obj[key] == null) {
	        // scaleX and scaleY should fallback to scale
	        if (key === 'scaleX' || key === 'scaleY') {
	          obj[key] = obj['scale'] != null ? obj['scale'] : this._defaults['scale'];
	        } else {
	          obj[key] = this._defaults[key];
	        }
	      } else {
	        // get if 3d property was set.
	        if (this._3dProperties.indexOf(key) !== -1) {
	          this._is3d = true;
	        }
	      }
	    }

	    if (this._o.isForce3d) {
	      this._is3d = true;
	    }

	    return obj;
	  };
	  /*
	    Lifecycle method to declare variables.
	    @private
	  */


	  Html.prototype._vars = function _vars() {
	    // set deltas to the last value, so the _props with
	    // end values will be copied to the _history, it is
	    // crucial for `then` chaining
	    this.deltas.refresh(false);
	    // call super vars
	    _Thenable.prototype._vars.call(this);
	    // state of set properties
	    this._state = {};
	    // restore delta values that we have refreshed before
	    this.deltas.restore(false);
	  };
	  /*
	    Method to create deltas from passed object.
	    @private
	    @param {Object} Options object to pass to the Deltas.
	  */


	  Html.prototype._createDeltas = function _createDeltas(options) {
	    this.deltas = new _deltas2.default({
	      options: options,
	      props: this._props,
	      arrayPropertyMap: this._arrayPropertyMap,
	      numberPropertyMap: this._numberPropertyMap,
	      customProps: this._customProps,
	      callbacksContext: options.callbacksContext || this,
	      isChained: !!this._o.prevChainModule
	    });

	    // if chained module set timeline to deltas' timeline 
	    if (this._o.prevChainModule) {
	      this.timeline = this.deltas.timeline;
	    }
	  };
	  /* @overrides @ Tweenable */


	  Html.prototype._makeTween = function _makeTween() {};

	  Html.prototype._makeTimeline = function _makeTimeline() {
	    // do not create timeline if module if chained
	    if (this._o.prevChainModule) {
	      return;
	    }
	    // add callbacks overrides
	    this._o.timeline = this._o.timeline || {};
	    this._addCallbackOverrides(this._o.timeline);
	    _Thenable.prototype._makeTimeline.call(this);
	    this.timeline.add(this.deltas);
	  };
	  /*
	    Method to add callback overrides to passed object object.
	    @param {Object} Object to add overrides on.
	  */


	  Html.prototype._addCallbackOverrides = function _addCallbackOverrides(o) {
	    var it = this;
	    var p = this._props;
	    o.callbackOverrides = {
	      onUpdate: this._draw,
	      onRefresh: this._props.isRefreshState ? this._draw : void 0,
	      onStart: function onStart(isFwd) {
	        // don't touch main `el` onStart in chained elements
	        if (it._isChained) {
	          return;
	        };
	        // show if was hidden at start
	        if (isFwd && !p.isShowStart) {
	          it._show();
	        }
	        // hide if should be hidden at start
	        else {
	            if (!p.isShowStart) {
	              it._hide();
	            }
	          }
	      },
	      onComplete: function onComplete(isFwd) {
	        // don't touch main `el` if not the last in `then` chain
	        if (it._isChained) {
	          return;
	        }
	        if (isFwd) {
	          if (!p.isShowEnd) {
	            it._hide();
	          }
	        } else if (!p.isShowEnd) {
	          it._show();
	        }
	      }
	    };
	  };

	  /*
	    Method that gets called on `soft` show of the module,
	    it should restore transform styles of the module.
	    @private
	    @overrides @ Module
	  */


	  Html.prototype._showByTransform = function _showByTransform() {
	    this._drawTransform();
	  };

	  /*
	    Method to merge `start` and `end` for a property in then record.
	    @private
	    @param {String} Property name.
	    @param {Any}    Start value of the property.
	    @param {Any}    End value of the property.
	  */
	  // !! COVER !!


	  Html.prototype._mergeThenProperty = function _mergeThenProperty(key, startValue, endValue) {
	    // if isnt tween property
	    var isBoolean = typeof endValue === 'boolean',
	        curve,
	        easing;

	    if (!h.isTweenProp(key) && !this._nonMergeProps[key] && !isBoolean) {

	      var TWEEN_PROPS = {};
	      if (h.isObject(endValue) && endValue.to != null) {
	        for (var _key in endValue) {
	          if (TWEEN_PROPERTIES[_key] || _key === 'curve') {
	            TWEEN_PROPS[_key] = endValue[_key];
	            delete endValue[_key];
	          }
	        }
	        // curve    = endValue.curve;
	        // easing   = endValue.easing;
	        endValue = endValue.to;
	      }

	      // if end value is delta - just save it
	      if (this._isDelta(endValue)) {

	        var _TWEEN_PROPS = {};
	        for (var _key2 in endValue) {
	          if (TWEEN_PROPERTIES[_key2] || _key2 === 'curve') {
	            _TWEEN_PROPS[_key2] = endValue[_key2];
	            delete endValue[_key2];
	          }
	        }
	        var result = this._parseDeltaValues(key, endValue);

	        return (0, _extends5.default)({}, result, _TWEEN_PROPS);
	      } else {
	        var parsedEndValue = this._parsePreArrayProperty(key, endValue);
	        // if end value is not delta - merge with start value
	        if (this._isDelta(startValue)) {
	          var _extends2;

	          // if start value is delta - take the end value
	          // as start value of the new delta
	          return (0, _extends5.default)((_extends2 = {}, _extends2[h.getDeltaEnd(startValue)] = parsedEndValue, _extends2), TWEEN_PROPS);
	          // if both start and end value are not ∆ - make ∆
	        } else {
	          var _extends3;

	          return (0, _extends5.default)((_extends3 = {}, _extends3[startValue] = parsedEndValue, _extends3), TWEEN_PROPS);
	        }
	      }
	      // copy the tween values unattended
	    } else {
	      return endValue;
	    }
	  };

	  return Html;
	}(_thenable2.default);

	exports.default = Html;

/***/ }),
/* 120 */
/***/ (function(module, exports, __webpack_require__) {

	"use strict";

	exports.__esModule = true;

	var _assign = __webpack_require__(121);

	var _assign2 = _interopRequireDefault(_assign);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = _assign2.default || function (target) {
	  for (var i = 1; i < arguments.length; i++) {
	    var source = arguments[i];

	    for (var key in source) {
	      if (Object.prototype.hasOwnProperty.call(source, key)) {
	        target[key] = source[key];
	      }
	    }
	  }

	  return target;
	};

/***/ }),
/* 121 */
/***/ (function(module, exports, __webpack_require__) {

	module.exports = { "default": __webpack_require__(122), __esModule: true };

/***/ }),
/* 122 */
/***/ (function(module, exports, __webpack_require__) {

	__webpack_require__(123);
	module.exports = __webpack_require__(14).Object.assign;

/***/ }),
/* 123 */
/***/ (function(module, exports, __webpack_require__) {

	// 19.1.3.1 Object.assign(target, source)
	var $export = __webpack_require__(12);

	$export($export.S + $export.F, 'Object', {assign: __webpack_require__(124)});

/***/ }),
/* 124 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	// 19.1.2.1 Object.assign(target, source, ...)
	var getKeys  = __webpack_require__(33)
	  , gOPS     = __webpack_require__(62)
	  , pIE      = __webpack_require__(63)
	  , toObject = __webpack_require__(49)
	  , IObject  = __webpack_require__(36)
	  , $assign  = Object.assign;

	// should work with symbols and should have deterministic property order (V8 bug)
	module.exports = !$assign || __webpack_require__(23)(function(){
	  var A = {}
	    , B = {}
	    , S = Symbol()
	    , K = 'abcdefghijklmnopqrst';
	  A[S] = 7;
	  K.split('').forEach(function(k){ B[k] = k; });
	  return $assign({}, A)[S] != 7 || Object.keys($assign({}, B)).join('') != K;
	}) ? function assign(target, source){ // eslint-disable-line no-unused-vars
	  var T     = toObject(target)
	    , aLen  = arguments.length
	    , index = 1
	    , getSymbols = gOPS.f
	    , isEnum     = pIE.f;
	  while(aLen > index){
	    var S      = IObject(arguments[index++])
	      , keys   = getSymbols ? getKeys(S).concat(getSymbols(S)) : getKeys(S)
	      , length = keys.length
	      , j      = 0
	      , key;
	    while(length > j)if(isEnum.call(S, key = keys[j++]))T[key] = S[key];
	  } return T;
	} : $assign;

/***/ }),
/* 125 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _extends2 = __webpack_require__(120);

	var _extends3 = _interopRequireDefault(_extends2);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _keys = __webpack_require__(95);

	var _keys2 = _interopRequireDefault(_keys);

	var _timeline = __webpack_require__(110);

	var _timeline2 = _interopRequireDefault(_timeline);

	var _tween = __webpack_require__(101);

	var _tween2 = _interopRequireDefault(_tween);

	var _delta = __webpack_require__(126);

	var _delta2 = _interopRequireDefault(_delta);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	/*
	  This module's target is to parse options object,
	  find deltas in it and send them to `Delta` classes.
	  The `Delta` class is dull - they expect actual parsed deltas
	  and separated tween options, so we should parse them here.
	  The timeline of the module controls the `Delta` modules' tweens.

	  @param {Object} props Object to set deltas result to (pass to the Delta classes).
	  @param {Object} options Object to parse the deltas from.
	  @param {Function} onUpdate onUpdate callback.
	  @param optional {Object} arrayPropertyMap List of properties with truthy
	                                            values which describe properties
	                                            that should be parsed as arrays.
	  @param optional {Object} numberPropertyMap List of properties with truthy
	                                            values which describe properties
	                                            that should be parsed as numbers
	                                            without units.
	*/

	// TODO:
	// - colors with curves change alpha level too
	// const html = new mojs.Html({
	//   el: '#js-el',
	//   x: { 0: 100 },
	//   onUpdate () {
	//     console.log(this._props.originX);
	//   },
	//   originX: { 'white': 'black', curve: 'M0,100 L100, 0' },
	//   customProperties: {
	//     originX: {
	//       type: 'color',
	//       default: 'cyan'
	//     },
	//     draw() { console.log('draw'); }
	//   }
	// });


	var easing = __webpack_require__(105);
	var h = __webpack_require__(71);


	// get tween properties
	var obj = {};
	_tween2.default.prototype._declareDefaults.call(obj);
	var keys = (0, _keys2.default)(obj._defaults);
	for (var i = 0; i < keys.length; i++) {
	  obj._defaults[keys[i]] = 1;
	}
	obj._defaults['timeline'] = 1;
	var TWEEN_PROPERTIES = obj._defaults;

	var Deltas = function () {
	  function Deltas() {
	    var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    (0, _classCallCheck3.default)(this, Deltas);

	    this._o = o;

	    this._shortColors = {
	      transparent: 'rgba(0,0,0,0)',
	      none: 'rgba(0,0,0,0)',
	      aqua: 'rgb(0,255,255)',
	      black: 'rgb(0,0,0)',
	      blue: 'rgb(0,0,255)',
	      fuchsia: 'rgb(255,0,255)',
	      gray: 'rgb(128,128,128)',
	      green: 'rgb(0,128,0)',
	      lime: 'rgb(0,255,0)',
	      maroon: 'rgb(128,0,0)',
	      navy: 'rgb(0,0,128)',
	      olive: 'rgb(128,128,0)',
	      purple: 'rgb(128,0,128)',
	      red: 'rgb(255,0,0)',
	      silver: 'rgb(192,192,192)',
	      teal: 'rgb(0,128,128)',
	      white: 'rgb(255,255,255)',
	      yellow: 'rgb(255,255,0)',
	      orange: 'rgb(255,128,0)'
	    };

	    this._ignoreDeltasMap = { prevChainModule: 1, masterModule: 1 };

	    this._parseDeltas(o.options);
	    this._createDeltas();
	    this._createTimeline(this._mainTweenOptions);
	  }
	  /*
	    Method to call `refresh` on all child `delta` objects.
	    @public
	    @param {Boolean} If before start time (true) or after end time (false).
	  */


	  Deltas.prototype.refresh = function refresh(isBefore) {
	    for (var i = 0; i < this._deltas.length; i++) {
	      this._deltas[i].refresh(isBefore);
	    }
	    return this;
	  };
	  /*
	    Method to call `restore` on all child `delta` objects.
	    @public
	  */


	  Deltas.prototype.restore = function restore() {
	    for (var i = 0; i < this._deltas.length; i++) {
	      this._deltas[i].restore();
	    }
	    return this;
	  };
	  /*
	    Method to create Timeline.
	    @private
	    @param {Object} Timeline options.
	  */


	  Deltas.prototype._createTimeline = function _createTimeline() {
	    var opts = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

	    // const o = this._o;
	    // opts.timeline = opts.timeline || {};
	    // opts.timeline.callbackOverrides = {
	    //   onUpdate:   o.onUpdate,
	    //   onRefresh:  o.onUpdate
	    // }
	    // send callbacksContext to timeline if set
	    // o.callbacksContext && (opts.timeline.callbacksContext = o.callbacksContext);
	    // opts.timeline
	    this.timeline = new _timeline2.default();
	    this.timeline.add(this._deltas);
	  };
	  /*
	    Method to create Deltas from parsed options.
	    @private
	  */


	  Deltas.prototype._createDeltas = function _createDeltas() {
	    this._deltas = [];

	    // create main delta object
	    this._deltas.push(this._createDelta(this._mainDeltas, this._mainTweenOptions));

	    // create child delta object
	    for (var i = 0; i < this._childDeltas.length; i++) {
	      var delta = this._childDeltas[i];
	      this._deltas.push(this._createDelta([delta.delta], delta.tweenOptions));
	    }
	  };
	  /*
	    Method to create Delta object with passed options.
	    @private
	    @param {Array} Array of deltas.
	    @param {Object} Tween properties.
	    @returns {Object} Delta object
	  */


	  Deltas.prototype._createDelta = function _createDelta(deltas, tweenOptions) {
	    var o = this._o;
	    return new _delta2.default({
	      deltas: deltas, tweenOptions: tweenOptions,
	      props: o.props,
	      isChained: o.isChained,
	      callbacksContext: o.callbacksContext
	    });
	  };
	  /*
	    Method to parse delta objects from options.
	    @private
	    @param {Object} Options object to parse the deltas from.
	  */


	  Deltas.prototype._parseDeltas = function _parseDeltas(obj) {
	    // spilt main animation properties and main tween properties
	    var mainSplit = this._splitTweenOptions(obj);
	    // main animation properties
	    var opts = mainSplit.delta;
	    // main tween properties
	    this._mainTweenOptions = mainSplit.tweenOptions;

	    this._mainDeltas = [];
	    this._childDeltas = [];
	    var keys = (0, _keys2.default)(opts);
	    // loop thru all properties without tween ones
	    for (var i = 0; i < keys.length; i++) {
	      var key = keys[i];
	      // is property is delta - parse it
	      if (this._isDelta(opts[key]) && !this._ignoreDeltasMap[key]) {
	        var delta = this._splitAndParseDelta(key, opts[key]);
	        // if parsed object has no tween values - it's delta of the main object
	        if (!delta.tweenOptions) {
	          this._mainDeltas.push(delta.delta);
	        }
	        // otherwise it is distinct delta object
	        else {
	            this._childDeltas.push(delta);
	          }
	      }
	    }
	  };
	  /*
	    Method to split tween values and parse single delta record.
	    @private
	    @param {String} Property name.
	    @param {Object} Raw delta object.
	    @returns {Object} Split object.
	                @param {Object} tweenOptions Tween properties.
	                @param {Object} delta Parsed delta.
	  */


	  Deltas.prototype._splitAndParseDelta = function _splitAndParseDelta(name, object) {
	    var split = this._splitTweenOptions(object);
	    // parse delta in the object
	    split.delta = this._parseDelta(name, split.delta);
	    return split;
	  };
	  /*
	    Method to parse delta by delegating the variables to _parse*Delta methods.
	    @private
	    @param {String} Property name.
	    @param {Object} Raw delta object.
	    @param {Number} Module index.
	  */


	  Deltas.prototype._parseDelta = function _parseDelta(name, object, index) {
	    // if name is in _o.customProps - parse it regarding the type
	    return this._o.customProps && this._o.customProps[name] != null ? this._parseDeltaByCustom(name, object, index) : this._parseDeltaByGuess(name, object, index);
	  };
	  /**
	    Method to parse delta by taking the type from the customProps object.
	    @private
	    @param {String} Property name.
	    @param {Object} Raw delta object.
	    @param {Number} Module index.
	  */


	  Deltas.prototype._parseDeltaByCustom = function _parseDeltaByCustom(name, object, index) {
	    return this._parseNumberDelta(name, object, index);
	    // const customRecord = this._o.customProps[name];
	    // switch ( customRecord.type.toLowerCase() ) {
	    //   case 'color':  { return this._parseColorDelta( name, object ); }
	    //   case 'array':  { return this._parseArrayDelta( name, object ); }
	    //   case 'number': { return this._parseNumberDelta( name, object, index ); }
	    //   case 'unit':   { return this._parseUnitDelta( name, object, index ); }
	    // }
	  };
	  /**
	    Method to parse delta by reasoning about it's value.
	    @private
	    @param {String} Property name.
	    @param {Object} Raw delta object.
	    @param {Number} Module index.
	  */


	  Deltas.prototype._parseDeltaByGuess = function _parseDeltaByGuess(name, object, index) {
	    var _preparseDelta2 = this._preparseDelta(object),
	        start = _preparseDelta2.start;

	    var o = this._o;

	    // color values
	    if (isNaN(parseFloat(start)) && !start.match(/rand\(/) && !start.match(/stagger\(/)) {
	      return this._parseColorDelta(name, object);
	      // array values
	    } else if (o.arrayPropertyMap && o.arrayPropertyMap[name]) {
	      return this._parseArrayDelta(name, object);
	      // unit or number values
	    } else {
	      return o.numberPropertyMap && o.numberPropertyMap[name] ?
	      // if the property is in the number property map - parse it like number
	      this._parseNumberDelta(name, object, index)
	      // otherwise - like number with units
	      : this._parseUnitDelta(name, object, index);
	    }
	  };
	  /*
	    Method to separate tween options from delta properties.
	    @param {Object} Object for separation.
	    @returns {Object} Object that contains 2 objects
	                        - one delta options
	                        - one tween options ( could be empty if no tween opts )
	  */


	  Deltas.prototype._splitTweenOptions = function _splitTweenOptions(delta) {
	    delta = (0, _extends3.default)({}, delta);

	    var keys = (0, _keys2.default)(delta),
	        tweenOptions = {};
	    var isTween = null;

	    for (var i = 0; i < keys.length; i++) {
	      var key = keys[i];
	      if (TWEEN_PROPERTIES[key]) {
	        if (delta[key] != null) {
	          tweenOptions[key] = delta[key];
	          isTween = true;
	        }
	        delete delta[key];
	      }
	    }
	    return {
	      delta: delta,
	      tweenOptions: isTween ? tweenOptions : undefined
	    };
	  };
	  /*
	    Method to check if the property is delta property.
	    @private
	    @param {Any} Parameter value to check.
	    @returns {Boolean}
	  */


	  Deltas.prototype._isDelta = function _isDelta(optionsValue) {
	    var isObject = h.isObject(optionsValue);
	    isObject = isObject && !optionsValue.unit;
	    return !(!isObject || h.isArray(optionsValue) || h.isDOM(optionsValue));
	  };
	  /*
	    Method to parse color delta values.
	    @private
	    @param {String} Name of the property.
	    @param {Any} Property value.
	    @returns {Object} Parsed delta.
	  */


	  Deltas.prototype._parseColorDelta = function _parseColorDelta(key, value) {
	    if (key === 'strokeLinecap') {
	      h.warn('Sorry, stroke-linecap property is not animatable yet, using the start(#{start}) value instead', value);
	      return {};
	    }
	    var preParse = this._preparseDelta(value);

	    var startColorObj = this._makeColorObj(preParse.start),
	        endColorObj = this._makeColorObj(preParse.end);

	    var delta = {
	      type: 'color',
	      name: key,
	      start: startColorObj,
	      end: endColorObj,
	      curve: preParse.curve,
	      delta: {
	        r: endColorObj.r - startColorObj.r,
	        g: endColorObj.g - startColorObj.g,
	        b: endColorObj.b - startColorObj.b,
	        a: endColorObj.a - startColorObj.a
	      }
	    };
	    return delta;
	  };
	  /*
	    Method to parse array delta values.
	    @private
	    @param {String} Name of the property.
	    @param {Any} Property value.
	    @returns {Object} Parsed delta.
	  */


	  Deltas.prototype._parseArrayDelta = function _parseArrayDelta(key, value) {
	    var preParse = this._preparseDelta(value);

	    var startArr = this._strToArr(preParse.start),
	        endArr = this._strToArr(preParse.end);

	    h.normDashArrays(startArr, endArr);

	    for (var i = 0; i < startArr.length; i++) {
	      var end = endArr[i];
	      h.mergeUnits(startArr[i], end, key);
	    }

	    var delta = {
	      type: 'array',
	      name: key,
	      start: startArr,
	      end: endArr,
	      delta: h.calcArrDelta(startArr, endArr),
	      curve: preParse.curve
	    };

	    return delta;
	  };
	  /*
	    Method to parse numeric delta values with units.
	    @private
	    @param {String} Name of the property.
	    @param {Any} Property value.
	    @param {Number} Index of the module.
	    @returns {Object} Parsed delta.
	  */


	  Deltas.prototype._parseUnitDelta = function _parseUnitDelta(key, value, index) {
	    var preParse = this._preparseDelta(value);

	    var end = h.parseUnit(h.parseStringOption(preParse.end, index)),
	        start = h.parseUnit(h.parseStringOption(preParse.start, index));

	    h.mergeUnits(start, end, key);
	    var delta = {
	      type: 'unit',
	      name: key,
	      start: start,
	      end: end,
	      delta: end.value - start.value,
	      curve: preParse.curve
	    };
	    return delta;
	  };
	  /*
	    Method to parse numeric delta values without units.
	    @private
	    @param {String} Name of the property.
	    @param {Any} Property value.
	    @param {Number} Index of the module.
	    @returns {Object} Parsed delta.
	  */


	  Deltas.prototype._parseNumberDelta = function _parseNumberDelta(key, value, index) {
	    var preParse = this._preparseDelta(value);

	    var end = parseFloat(h.parseStringOption(preParse.end, index)),
	        start = parseFloat(h.parseStringOption(preParse.start, index));

	    var delta = {
	      type: 'number',
	      name: key,
	      start: start,
	      end: end,
	      delta: end - start,
	      curve: preParse.curve
	    };

	    return delta;
	  };
	  /*
	    Method to extract `curve` and `start`/`end` values.
	    @private
	    @param {Object} Delta object.
	    @returns {Object} Preparsed delta.
	              @property {String} Start value.
	              @property {String, Number} End value.
	  */


	  Deltas.prototype._preparseDelta = function _preparseDelta(value) {
	    // clone value object
	    value = (0, _extends3.default)({}, value);
	    // parse curve if exist
	    var curve = value.curve;
	    if (curve != null) {
	      curve = easing.parseEasing(curve);
	      curve._parent = this;
	    }
	    delete value.curve;
	    // parse start and end values
	    var start = (0, _keys2.default)(value)[0],
	        end = value[start];

	    return { start: start, end: end, curve: curve };
	  };
	  /*
	    Method to parse color into usable object.
	    @private
	    @param {String} Color string.
	    @returns {Object} Parsed color value.
	  */


	  Deltas.prototype._makeColorObj = function _makeColorObj(color) {
	    // HEX
	    var colorObj = {};
	    if (color[0] === '#') {
	      var result = /^#?([a-f\d]{1,2})([a-f\d]{1,2})([a-f\d]{1,2})$/i.exec(color);
	      if (result) {
	        var r = result[1].length === 2 ? result[1] : result[1] + result[1],
	            g = result[2].length === 2 ? result[2] : result[2] + result[2],
	            b = result[3].length === 2 ? result[3] : result[3] + result[3];

	        colorObj = {
	          r: parseInt(r, 16), g: parseInt(g, 16), b: parseInt(b, 16), a: 1
	        };
	      }
	    }

	    // not HEX
	    // shorthand color and rgb()
	    if (color[0] !== '#') {
	      var isRgb = color[0] === 'r' && color[1] === 'g' && color[2] === 'b';
	      var rgbColor = void 0;
	      // rgb color
	      if (isRgb) {
	        rgbColor = color;
	      };
	      // shorthand color name
	      if (!isRgb) {
	        if (!this._shortColors[color]) {
	          h.div.style.color = color;
	          rgbColor = h.computedStyle(h.div).color;
	        } else {
	          rgbColor = this._shortColors[color];
	        }
	      }

	      var regexString1 = '^rgba?\\((\\d{1,3}),\\s?(\\d{1,3}),',
	          regexString2 = '\\s?(\\d{1,3}),?\\s?(\\d{1}|0?\\.\\d{1,})?\\)$',
	          _result = new RegExp(regexString1 + regexString2, 'gi').exec(rgbColor),
	          alpha = parseFloat(_result[4] || 1);

	      if (_result) {
	        colorObj = {
	          r: parseInt(_result[1], 10),
	          g: parseInt(_result[2], 10),
	          b: parseInt(_result[3], 10),
	          a: alpha != null && !isNaN(alpha) ? alpha : 1
	        };
	      }
	    }

	    return colorObj;
	  };
	  /*
	    Method to parse string into array.
	    @private
	    @param {String, Number} String or number to parse.
	    @returns {Array} Parsed array.
	  */


	  Deltas.prototype._strToArr = function _strToArr(string) {
	    var arr = [];
	    // plain number
	    if (typeof string === 'number' && !isNaN(string)) {
	      arr.push(h.parseUnit(string));
	      return arr;
	    }
	    // string array
	    string.trim().split(/\s+/gim).forEach(function (str) {
	      arr.push(h.parseUnit(h.parseIfRand(str)));
	    });
	    return arr;
	  };

	  return Deltas;
	}();

	exports.default = Deltas;

/***/ }),
/* 126 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _tween = __webpack_require__(101);

	var _tween2 = _interopRequireDefault(_tween);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var h = __webpack_require__(71);

	var Delta = function () {
	  function Delta() {
	    var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    (0, _classCallCheck3.default)(this, Delta);

	    this._o = o;
	    this._createTween(o.tweenOptions);
	    // initial properties render
	    !this._o.isChained && this.refresh(true);
	  }
	  /*
	    Method to call `_refresh` method on `tween`.
	    Use switch between `0` and `1` progress for delta value.
	    @public
	    @param {Boolean} If refresh before start time or after.
	    @returns this.
	  */


	  Delta.prototype.refresh = function refresh(isBefore) {
	    this._previousValues = [];

	    var deltas = this._o.deltas;
	    for (var i = 0; i < deltas.length; i++) {
	      var name = deltas[i].name;
	      this._previousValues.push({
	        name: name, value: this._o.props[name]
	      });
	    }

	    this.tween._refresh(isBefore);
	    return this;
	  };
	  /*
	    Method to restore all saved properties from `_previousValues` array.
	    @public
	    @returns this.
	  */


	  Delta.prototype.restore = function restore() {
	    var prev = this._previousValues;
	    for (var i = 0; i < prev.length; i++) {
	      var record = prev[i];
	      this._o.props[record.name] = record.value;
	    }
	    return this;
	  };
	  /*
	    Method to create tween of the delta.
	    @private
	    @param {Object} Options object.
	  */


	  Delta.prototype._createTween = function _createTween() {
	    var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

	    var it = this;
	    o.callbackOverrides = {
	      onUpdate: function onUpdate(ep, p) {
	        it._calcCurrentProps(ep, p);
	      }
	    };

	    // if not chained - add the onRefresh callback
	    // to refresh the tween when needed
	    if (!this._o.isChained) {
	      o.callbackOverrides.onRefresh = function (isBefore, ep, p) {
	        it._calcCurrentProps(ep, p);
	      };
	    }

	    o.callbacksContext = this._o.callbacksContext;
	    this.tween = new _tween2.default(o);
	  };
	  /*
	    Method to calculate current progress of the deltas.
	    @private
	    @param {Number} Eased progress to calculate - [0..1].
	    @param {Number} Progress to calculate - [0..1].
	  */


	  Delta.prototype._calcCurrentProps = function _calcCurrentProps(easedProgress, p) {
	    var deltas = this._o.deltas;
	    for (var i = 0; i < deltas.length; i++) {
	      var type = deltas[i].type;
	      this['_calcCurrent_' + type](deltas[i], easedProgress, p);
	    }
	  };
	  /*
	    Method to calc the current color delta value.
	    @param {Object} Delta
	    @param {Number} Eased progress [0..1].
	    @param {Number} Plain progress [0..1].
	  */


	  Delta.prototype._calcCurrent_color = function _calcCurrent_color(delta, ep, p) {
	    var r,
	        g,
	        b,
	        a,
	        start = delta.start,
	        d = delta.delta;
	    if (!delta.curve) {
	      r = parseInt(start.r + ep * d.r, 10);
	      g = parseInt(start.g + ep * d.g, 10);
	      b = parseInt(start.b + ep * d.b, 10);
	      a = parseFloat(start.a + ep * d.a);
	    } else {
	      var cp = delta.curve(p);
	      r = parseInt(cp * (start.r + p * d.r), 10);
	      g = parseInt(cp * (start.g + p * d.g), 10);
	      b = parseInt(cp * (start.b + p * d.b), 10);
	      a = parseFloat(cp * (start.a + p * d.a));
	    }
	    this._o.props[delta.name] = 'rgba(' + r + ',' + g + ',' + b + ',' + a + ')';
	  };
	  /*
	    Method to calc the current number delta value.
	    @param {Object} Delta
	    @param {Number} Eased progress [0..1].
	    @param {Number} Plain progress [0..1].
	  */


	  Delta.prototype._calcCurrent_number = function _calcCurrent_number(delta, ep, p) {
	    this._o.props[delta.name] = !delta.curve ? delta.start + ep * delta.delta : delta.curve(p) * (delta.start + p * delta.delta);
	  };
	  /*
	    Method to calc the current number with units delta value.
	    @param {Object} Delta
	    @param {Number} Eased progress [0..1].
	    @param {Number} Plain progress [0..1].
	  */


	  Delta.prototype._calcCurrent_unit = function _calcCurrent_unit(delta, ep, p) {
	    var currentValue = !delta.curve ? delta.start.value + ep * delta.delta : delta.curve(p) * (delta.start.value + p * delta.delta);

	    this._o.props[delta.name] = '' + currentValue + delta.end.unit;
	  };
	  /*
	    Method to calc the current array delta value.
	    @param {Object} Delta
	    @param {Number} Eased progress [0..1].
	    @param {Number} Plain progress [0..1].
	  */


	  Delta.prototype._calcCurrent_array = function _calcCurrent_array(delta, ep, p) {
	    // var arr,
	    var name = delta.name,
	        props = this._o.props,
	        string = '';

	    // to prevent GC bothering with arrays garbage
	    // if ( h.isArray( props[name] ) ) {
	    //   arr = props[name];
	    //   arr.length = 0;
	    // } else { arr = []; }

	    // just optimization to prevent curve
	    // calculations on every array item
	    var proc = delta.curve ? delta.curve(p) : null;

	    for (var i = 0; i < delta.delta.length; i++) {
	      var item = delta.delta[i],
	          dash = !delta.curve ? delta.start[i].value + ep * item.value : proc * (delta.start[i].value + p * item.value);

	      string += '' + dash + item.unit + ' ';
	      // arr.push({
	      //   string: `${dash}${item.unit}`,
	      //   value:  dash,
	      //   unit:   item.unit,
	      // });
	    }
	    props[name] = string;
	  };

	  return Delta;
	}();

	exports.default = Delta;

/***/ }),
/* 127 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _keys = __webpack_require__(95);

	var _keys2 = _interopRequireDefault(_keys);

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _possibleConstructorReturn2 = __webpack_require__(75);

	var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

	var _inherits2 = __webpack_require__(76);

	var _inherits3 = _interopRequireDefault(_inherits2);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	var _timeline = __webpack_require__(110);

	var _timeline2 = _interopRequireDefault(_timeline);

	var _tunable = __webpack_require__(116);

	var _tunable2 = _interopRequireDefault(_tunable);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	var Stagger = function (_Tunable) {
	  (0, _inherits3.default)(Stagger, _Tunable);

	  function Stagger(options, Module) {
	    var _ret;

	    (0, _classCallCheck3.default)(this, Stagger);

	    var _this = (0, _possibleConstructorReturn3.default)(this, _Tunable.call(this));

	    return _ret = _this._init(options, Module), (0, _possibleConstructorReturn3.default)(_this, _ret);
	  }
	  /*
	    Method to create then chain on child modules.
	    @param {Object} Then options.
	    @return {Object} this.
	  */


	  Stagger.prototype.then = function then(o) {
	    if (o == null) {
	      return this;
	    }
	    for (var i = 0; i < this._modules.length; i++) {
	      // get child module's option and pass to the child `then`
	      this._modules[i].then(this._getOptionByIndex(i, o));
	    }
	    this.timeline._recalcTotalDuration();
	    return this;
	  };
	  /*
	    Method to tune child modules.
	    @param {Object} Tune options.
	    @return {Object} this.
	  */


	  Stagger.prototype.tune = function tune(o) {
	    if (o == null) {
	      return this;
	    }
	    for (var i = 0; i < this._modules.length; i++) {
	      // get child module's option and pass to the child `then`
	      this._modules[i].tune(this._getOptionByIndex(i, o));
	    }
	    this.timeline._recalcTotalDuration();
	    return this;
	  };
	  /*
	    Method to generate child modules.
	    @return {Object} this.
	  */


	  Stagger.prototype.generate = function generate() {
	    for (var i = 0; i < this._modules.length; i++) {
	      // get child module's option and pass to the child `then`
	      this._modules[i].generate();
	    }
	    this.timeline._recalcTotalDuration();
	    return this;
	  };
	  /*
	    Method to get an option by modulo and name.
	    @param {String} Name of the property to get.
	    @param {Number} Index for the modulo calculation.
	    @param {Object} Options hash to look in.
	    @return {Any} Property.
	  */


	  Stagger.prototype._getOptionByMod = function _getOptionByMod(name, i, store) {
	    var props = store[name];
	    // if not dom list then clone it to array
	    if (props + '' === '[object NodeList]' || props + '' === '[object HTMLCollection]') props = Array.prototype.slice.call(props, 0);
	    // get the value in array or return the value itself
	    var value = _h2.default.isArray(props) ? props[i % props.length] : props;
	    // check if value has the stagger expression, if so parse it
	    return _h2.default.parseIfStagger(value, i);
	  };
	  /*
	    Method to get option by modulo of index.
	    @param {Number} Index for modulo calculations.
	    @param {Object} Options hash to look in.
	  */


	  Stagger.prototype._getOptionByIndex = function _getOptionByIndex(i, store) {
	    var _this2 = this;

	    var options = {};
	    (0, _keys2.default)(store).forEach(function (key) {
	      return options[key] = _this2._getOptionByMod(key, i, store);
	    });
	    return options;
	  };
	  /*
	    Method to get total child modules quantity.
	    @param  {String} Name of quantifier in options hash.
	    @param  {Object} Options hash object.
	    @return {Number} Number of child object that should be defined.
	  */


	  Stagger.prototype._getChildQuantity = function _getChildQuantity(name, store) {
	    // if number was set
	    if (typeof name === 'number') {
	      return name;
	    }

	    var quantifier = store[name];
	    if (_h2.default.isArray(quantifier)) {
	      return quantifier.length;
	    } else if (quantifier + '' === '[object NodeList]') {
	      return quantifier.length;
	    } else if (quantifier + '' === '[object HTMLCollection]') {
	      return Array.prototype.slice.call(quantifier, 0).length;
	    } else if (quantifier instanceof HTMLElement) {
	      return 1;
	    } else if (typeof quantifier == 'string') {
	      return 1;
	    }
	  };
	  /*
	    Method to make stagger form options
	    @param {Object} Options.
	    @param {Object} Child class.
	  */


	  Stagger.prototype._init = function _init(options, Module) {
	    var count = this._getChildQuantity(options.quantifier || 'el', options);
	    this._createTimeline(options);this._modules = [];
	    for (var i = 0; i < count; i++) {
	      // get child module's option
	      var option = this._getOptionByIndex(i, options);
	      option.isRunLess = true;
	      // set index of the module
	      option.index = i;
	      // create child module
	      var module = new Module(option);this._modules.push(module);
	      // add child module's timeline to the self timeline
	      this.timeline.add(module);
	    }
	    return this;
	  };
	  /*
	    Method to create timeline.
	    @param {Object} Timeline options.
	  */


	  Stagger.prototype._createTimeline = function _createTimeline() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

	    this.timeline = new _timeline2.default(options.timeline);
	  };

	  /* @overrides @ Tweenable */


	  Stagger.prototype._makeTween = function _makeTween() {};

	  Stagger.prototype._makeTimeline = function _makeTimeline() {};

	  return Stagger;
	}(_tunable2.default);

	module.exports = function (Module) {
	  return function (options) {
	    return new Stagger(options, Module);
	  };
	};

/***/ }),
/* 128 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _classCallCheck2 = __webpack_require__(74);

	var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

	var _h = __webpack_require__(71);

	var _h2 = _interopRequireDefault(_h);

	var _tween = __webpack_require__(101);

	var _tween2 = _interopRequireDefault(_tween);

	var _timeline = __webpack_require__(110);

	var _timeline2 = _interopRequireDefault(_timeline);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	/*
	  Class for toggling opacity on bunch of elements
	  @class Spriter
	  @todo
	    - add isForce3d option
	    - add run new option merging
	    - add then chains
	*/
	var Spriter = function () {
	  /*
	    Defaults/APIs
	  */
	  Spriter.prototype._declareDefaults = function _declareDefaults() {
	    this._defaults = {
	      /*
	        Duration
	        @property duration
	        @type     {Number}
	      */
	      duration: 500,
	      /*
	        Delay
	        @property delay
	        @type     {Number}
	      */
	      delay: 0,
	      /*
	        Easing. Please see the 
	        [timeline module parseEasing function](timeline.coffee.html#parseEasing)
	        for all avaliable options.
	          @property easing
	        @type     {String, Function}
	      */
	      easing: 'linear.none',
	      /*
	        Repeat times count
	        
	        @property repeat
	        @type     {Number}
	      */
	      repeat: 0,
	      /*
	        Yoyo option defines if animation should be altered on repeat.
	        
	        @property yoyo
	        @type     {Boolean}
	      */
	      yoyo: false,
	      /*
	        isRunLess option prevents animation from running immediately after
	        initialization.
	        
	        @property isRunLess
	        @type     {Boolean}
	      */
	      isRunLess: false,
	      /*
	        isShowEnd option defines if the last frame should be shown when
	        animation completed.
	        
	        @property isShowEnd
	        @type     {Boolean}
	      */
	      isShowEnd: false,
	      /*
	        onStart callback will be called once on animation start.
	        
	        @property onStart
	        @type     {Function}
	      */
	      onStart: null,
	      /*
	        onUpdate callback will be called on every frame of the animation.
	        The current progress in range **[0,1]** will be passed to the callback.
	        
	        @property onUpdate
	        @type     {Function}
	      */
	      onUpdate: null,
	      /*
	        onComplete callback will be called once on animation complete.
	        
	        @property onComplete
	        @type     {Function}
	      */
	      onComplete: null
	    };
	  };

	  function Spriter() {
	    var o = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    (0, _classCallCheck3.default)(this, Spriter);

	    this.o = o;
	    if (!this.o.el) {
	      return _h2.default.error('No "el" option specified, aborting');
	    }
	    this._vars();this._declareDefaults();this._extendDefaults();this._parseFrames();
	    if (this._frames.length <= 2) _h2.default.warn('Spriter: only ' + this._frames.length + ' frames found');
	    if (this._frames.length < 1) _h2.default.error("Spriter: there is no frames to animate, aborting");
	    this._createTween();
	    return this;
	  }
	  /*
	    Method to declare some variables.
	    
	    @method run
	    @param  {Object} New options
	    @todo   Implement new object merging
	  */


	  Spriter.prototype._vars = function _vars() {
	    this._props = _h2.default.cloneObj(this.o);
	    this.el = this.o.el;
	    this._frames = [];
	  };
	  /*
	    Method to run the spriter on demand.
	    
	    @method run
	    @param  {Object} New options
	    @todo   Implement new object merging
	  */


	  Spriter.prototype.run = function run(o) {
	    return this.timeline.play();
	  };
	  /*
	    Method to extend _props by options(this.o)
	    
	    @method _extendDefaults
	  */


	  Spriter.prototype._extendDefaults = function _extendDefaults() {
	    return _h2.default.extend(this._props, this._defaults);
	  };
	  /*
	    Method to parse frames as child nodes of el.
	    
	    @method _parseFrames
	  */


	  Spriter.prototype._parseFrames = function _parseFrames() {
	    this._frames = Array.prototype.slice.call(this.el.children, 0);
	    this._frames.forEach(function (frame, i) {
	      return frame.style.opacity = 0;
	    });
	    this._frameStep = 1 / this._frames.length;
	  };

	  /*
	    Method to create tween and timeline and supply callbacks.
	    
	    @method _createTween
	  */


	  Spriter.prototype._createTween = function _createTween() {
	    var _this = this;

	    this._tween = new _tween2.default({
	      duration: this._props.duration,
	      delay: this._props.delay,
	      yoyo: this._props.yoyo,
	      repeat: this._props.repeat,
	      easing: this._props.easing,
	      onStart: function onStart() {
	        return _this._props.onStart && _this._props.onStart();
	      },
	      onComplete: function onComplete() {
	        return _this._props.onComplete && _this._props.onComplete();
	      },
	      onUpdate: function onUpdate(p) {
	        return _this._setProgress(p);
	      }
	    });
	    this.timeline = new _timeline2.default();this.timeline.add(this._tween);
	    if (!this._props.isRunLess) this._startTween();
	  };

	  /*
	    Method to start tween
	    
	    @method _startTween
	  */


	  Spriter.prototype._startTween = function _startTween() {
	    var _this2 = this;

	    setTimeout(function () {
	      return _this2.timeline.play();
	    }, 1);
	  };
	  /*
	    Method to set progress of the sprite
	    
	    @method _setProgress
	    @param  {Number} Progress in range **[0,1]**
	  */


	  Spriter.prototype._setProgress = function _setProgress(p) {
	    // get the frame number
	    var proc = Math.floor(p / this._frameStep);
	    // react only if frame changes
	    if (this._prevFrame != this._frames[proc]) {
	      // if previous frame isnt current one, hide it
	      if (this._prevFrame) {
	        this._prevFrame.style.opacity = 0;
	      }
	      // if end of animation and isShowEnd flag was specified
	      // then show the last frame else show current frame
	      var currentNum = p === 1 && this._props.isShowEnd ? proc - 1 : proc;
	      // show the current frame
	      if (this._frames[currentNum]) {
	        this._frames[currentNum].style.opacity = 1;
	      }
	      // set previous frame as current
	      this._prevFrame = this._frames[proc];
	    }
	    if (this._props.onUpdate) {
	      this._props.onUpdate(p);
	    }
	  };

	  return Spriter;
	}();

	exports.default = Spriter;

/***/ }),
/* 129 */
/***/ (function(module, exports, __webpack_require__) {

	var MotionPath, Timeline, Tween, h, resize,
	  bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

	h = __webpack_require__(71);

	resize = __webpack_require__(130);

	Tween = __webpack_require__(101)["default"];

	Timeline = __webpack_require__(110)["default"];

	MotionPath = (function() {
	  MotionPath.prototype.defaults = {
	    path: null,
	    curvature: {
	      x: '75%',
	      y: '50%'
	    },
	    isCompositeLayer: true,
	    delay: 0,
	    duration: 1000,
	    easing: null,
	    repeat: 0,
	    yoyo: false,
	    onStart: null,
	    onComplete: null,
	    onUpdate: null,
	    offsetX: 0,
	    offsetY: 0,
	    angleOffset: null,
	    pathStart: 0,
	    pathEnd: 1,
	    motionBlur: 0,
	    transformOrigin: null,
	    isAngle: false,
	    isReverse: false,
	    isRunLess: false,
	    isPresetPosition: true
	  };

	  function MotionPath(o1) {
	    this.o = o1 != null ? o1 : {};
	    this.calcHeight = bind(this.calcHeight, this);
	    if (this.vars()) {
	      return;
	    }
	    this.createTween();
	    this;
	  }

	  MotionPath.prototype.vars = function() {
	    this.getScaler = h.bind(this.getScaler, this);
	    this.resize = resize;
	    this.props = h.cloneObj(this.defaults);
	    this.extendOptions(this.o);
	    this.isMotionBlurReset = h.isSafari || h.isIE;
	    this.isMotionBlurReset && (this.props.motionBlur = 0);
	    this.history = [h.cloneObj(this.props)];
	    return this.postVars();
	  };

	  MotionPath.prototype.curveToPath = function(o) {
	    var angle, curvature, curvatureX, curvatureY, curvePoint, curveXPoint, dX, dY, endPoint, path, percent, radius, start;
	    path = document.createElementNS(h.NS, 'path');
	    start = o.start;
	    endPoint = {
	      x: start.x + o.shift.x,
	      y: start.x + o.shift.y
	    };
	    curvature = o.curvature;
	    dX = o.shift.x;
	    dY = o.shift.y;
	    radius = Math.sqrt(dX * dX + dY * dY);
	    percent = radius / 100;
	    angle = Math.atan(dY / dX) * (180 / Math.PI) + 90;
	    if (o.shift.x < 0) {
	      angle = angle + 180;
	    }
	    curvatureX = h.parseUnit(curvature.x);
	    curvatureX = curvatureX.unit === '%' ? curvatureX.value * percent : curvatureX.value;
	    curveXPoint = h.getRadialPoint({
	      center: {
	        x: start.x,
	        y: start.y
	      },
	      radius: curvatureX,
	      angle: angle
	    });
	    curvatureY = h.parseUnit(curvature.y);
	    curvatureY = curvatureY.unit === '%' ? curvatureY.value * percent : curvatureY.value;
	    curvePoint = h.getRadialPoint({
	      center: {
	        x: curveXPoint.x,
	        y: curveXPoint.y
	      },
	      radius: curvatureY,
	      angle: angle + 90
	    });
	    path.setAttribute('d', "M" + start.x + "," + start.y + " Q" + curvePoint.x + "," + curvePoint.y + " " + endPoint.x + "," + endPoint.y);
	    return path;
	  };

	  MotionPath.prototype.postVars = function() {
	    this.props.pathStart = h.clamp(this.props.pathStart, 0, 1);
	    this.props.pathEnd = h.clamp(this.props.pathEnd, this.props.pathStart, 1);
	    this.angle = 0;
	    this.speedX = 0;
	    this.speedY = 0;
	    this.blurX = 0;
	    this.blurY = 0;
	    this.prevCoords = {};
	    this.blurAmount = 20;
	    this.props.motionBlur = h.clamp(this.props.motionBlur, 0, 1);
	    this.onUpdate = this.props.onUpdate;
	    if (!this.o.el) {
	      h.error('Missed "el" option. It could be a selector, DOMNode or another module.');
	      return true;
	    }
	    this.el = this.parseEl(this.props.el);
	    this.props.motionBlur > 0 && this.createFilter();
	    this.path = this.getPath();
	    if (!this.path.getAttribute('d')) {
	      h.error('Path has no coordinates to work with, aborting');
	      return true;
	    }
	    this.len = this.path.getTotalLength();
	    this.slicedLen = this.len * (this.props.pathEnd - this.props.pathStart);
	    this.startLen = this.props.pathStart * this.len;
	    this.fill = this.props.fill;
	    if (this.fill != null) {
	      this.container = this.parseEl(this.props.fill.container);
	      this.fillRule = this.props.fill.fillRule || 'all';
	      this.getScaler();
	      if (this.container != null) {
	        this.removeEvent(this.container, 'onresize', this.getScaler);
	        return this.addEvent(this.container, 'onresize', this.getScaler);
	      }
	    }
	  };

	  MotionPath.prototype.addEvent = function(el, type, handler) {
	    return el.addEventListener(type, handler, false);
	  };

	  MotionPath.prototype.removeEvent = function(el, type, handler) {
	    return el.removeEventListener(type, handler, false);
	  };

	  MotionPath.prototype.createFilter = function() {
	    var div, svg;
	    div = document.createElement('div');
	    this.filterID = "filter-" + (h.getUniqID());
	    div.innerHTML = "<svg id=\"svg-" + this.filterID + "\"\n    style=\"visibility:hidden; width:0px; height:0px\">\n  <filter id=\"" + this.filterID + "\" y=\"-20\" x=\"-20\" width=\"40\" height=\"40\">\n    <feOffset\n      id=\"blur-offset\" in=\"SourceGraphic\"\n      dx=\"0\" dy=\"0\" result=\"offset2\"></feOffset>\n    <feGaussianblur\n      id=\"blur\" in=\"offset2\"\n      stdDeviation=\"0,0\" result=\"blur2\"></feGaussianblur>\n    <feMerge>\n      <feMergeNode in=\"SourceGraphic\"></feMergeNode>\n      <feMergeNode in=\"blur2\"></feMergeNode>\n    </feMerge>\n  </filter>\n</svg>";
	    svg = div.querySelector("#svg-" + this.filterID);
	    this.filter = svg.querySelector('#blur');
	    this.filterOffset = svg.querySelector('#blur-offset');
	    document.body.insertBefore(svg, document.body.firstChild);
	    this.el.style['filter'] = "url(#" + this.filterID + ")";
	    return this.el.style[h.prefix.css + "filter"] = "url(#" + this.filterID + ")";
	  };

	  MotionPath.prototype.parseEl = function(el) {
	    if (typeof el === 'string') {
	      return document.querySelector(el);
	    }
	    if (el instanceof HTMLElement) {
	      return el;
	    }
	    if (el._setProp != null) {
	      this.isModule = true;
	      return el;
	    }
	  };

	  MotionPath.prototype.getPath = function() {
	    var path;
	    path = h.parsePath(this.props.path);
	    if (path) {
	      return path;
	    }
	    if (this.props.path.x || this.props.path.y) {
	      return this.curveToPath({
	        start: {
	          x: 0,
	          y: 0
	        },
	        shift: {
	          x: this.props.path.x || 0,
	          y: this.props.path.y || 0
	        },
	        curvature: {
	          x: this.props.curvature.x || this.defaults.curvature.x,
	          y: this.props.curvature.y || this.defaults.curvature.y
	        }
	      });
	    }
	  };

	  MotionPath.prototype.getScaler = function() {
	    var end, size, start;
	    this.cSize = {
	      width: this.container.offsetWidth || 0,
	      height: this.container.offsetHeight || 0
	    };
	    start = this.path.getPointAtLength(0);
	    end = this.path.getPointAtLength(this.len);
	    size = {};
	    this.scaler = {};
	    size.width = end.x >= start.x ? end.x - start.x : start.x - end.x;
	    size.height = end.y >= start.y ? end.y - start.y : start.y - end.y;
	    switch (this.fillRule) {
	      case 'all':
	        this.calcWidth(size);
	        return this.calcHeight(size);
	      case 'width':
	        this.calcWidth(size);
	        return this.scaler.y = this.scaler.x;
	      case 'height':
	        this.calcHeight(size);
	        return this.scaler.x = this.scaler.y;
	    }
	  };

	  MotionPath.prototype.calcWidth = function(size) {
	    this.scaler.x = this.cSize.width / size.width;
	    return !isFinite(this.scaler.x) && (this.scaler.x = 1);
	  };

	  MotionPath.prototype.calcHeight = function(size) {
	    this.scaler.y = this.cSize.height / size.height;
	    return !isFinite(this.scaler.y) && (this.scaler.y = 1);
	  };

	  MotionPath.prototype.run = function(o) {
	    var fistItem, key, value;
	    if (o) {
	      fistItem = this.history[0];
	      for (key in o) {
	        value = o[key];
	        if (h.callbacksMap[key] || h.tweenOptionMap[key]) {
	          h.warn("the property \"" + key + "\" property can not be overridden on run yet");
	          delete o[key];
	        } else {
	          this.history[0][key] = value;
	        }
	      }
	      this.tuneOptions(o);
	    }
	    return this.startTween();
	  };

	  MotionPath.prototype.createTween = function() {
	    this.tween = new Tween({
	      duration: this.props.duration,
	      delay: this.props.delay,
	      yoyo: this.props.yoyo,
	      repeat: this.props.repeat,
	      easing: this.props.easing,
	      onStart: (function(_this) {
	        return function() {
	          var ref;
	          return (ref = _this.props.onStart) != null ? ref.apply(_this) : void 0;
	        };
	      })(this),
	      onComplete: (function(_this) {
	        return function() {
	          var ref;
	          _this.props.motionBlur && _this.setBlur({
	            blur: {
	              x: 0,
	              y: 0
	            },
	            offset: {
	              x: 0,
	              y: 0
	            }
	          });
	          return (ref = _this.props.onComplete) != null ? ref.apply(_this) : void 0;
	        };
	      })(this),
	      onUpdate: (function(_this) {
	        return function(p) {
	          return _this.setProgress(p);
	        };
	      })(this),
	      onFirstUpdate: (function(_this) {
	        return function(isForward, isYoyo) {
	          if (!isForward) {
	            return _this.history.length > 1 && _this.tuneOptions(_this.history[0]);
	          }
	        };
	      })(this)
	    });
	    this.timeline = new Timeline;
	    this.timeline.add(this.tween);
	    !this.props.isRunLess && this.startTween();
	    return this.props.isPresetPosition && this.setProgress(0, true);
	  };

	  MotionPath.prototype.startTween = function() {
	    return setTimeout(((function(_this) {
	      return function() {
	        var ref;
	        return (ref = _this.timeline) != null ? ref.play() : void 0;
	      };
	    })(this)), 1);
	  };

	  MotionPath.prototype.setProgress = function(p, isInit) {
	    var len, point, x, y;
	    len = this.startLen + (!this.props.isReverse ? p * this.slicedLen : (1 - p) * this.slicedLen);
	    point = this.path.getPointAtLength(len);
	    x = point.x + this.props.offsetX;
	    y = point.y + this.props.offsetY;
	    this._getCurrentAngle(point, len, p);
	    this._setTransformOrigin(p);
	    this._setTransform(x, y, p, isInit);
	    return this.props.motionBlur && this.makeMotionBlur(x, y);
	  };

	  MotionPath.prototype.setElPosition = function(x, y, p) {
	    var composite, isComposite, rotate, transform;
	    rotate = this.angle !== 0 ? "rotate(" + this.angle + "deg)" : '';
	    isComposite = this.props.isCompositeLayer && h.is3d;
	    composite = isComposite ? 'translateZ(0)' : '';
	    transform = "translate(" + x + "px," + y + "px) " + rotate + " " + composite;
	    return h.setPrefixedStyle(this.el, 'transform', transform);
	  };

	  MotionPath.prototype.setModulePosition = function(x, y) {
	    this.el._setProp({
	      shiftX: x + "px",
	      shiftY: y + "px",
	      angle: this.angle
	    });
	    return this.el._draw();
	  };

	  MotionPath.prototype._getCurrentAngle = function(point, len, p) {
	    var atan, isTransformFunOrigin, prevPoint, x1, x2;
	    isTransformFunOrigin = typeof this.props.transformOrigin === 'function';
	    if (this.props.isAngle || (this.props.angleOffset != null) || isTransformFunOrigin) {
	      prevPoint = this.path.getPointAtLength(len - 1);
	      x1 = point.y - prevPoint.y;
	      x2 = point.x - prevPoint.x;
	      atan = Math.atan(x1 / x2);
	      !isFinite(atan) && (atan = 0);
	      this.angle = atan * h.RAD_TO_DEG;
	      if ((typeof this.props.angleOffset) !== 'function') {
	        return this.angle += this.props.angleOffset || 0;
	      } else {
	        return this.angle = this.props.angleOffset.call(this, this.angle, p);
	      }
	    } else {
	      return this.angle = 0;
	    }
	  };

	  MotionPath.prototype._setTransform = function(x, y, p, isInit) {
	    var transform;
	    if (this.scaler) {
	      x *= this.scaler.x;
	      y *= this.scaler.y;
	    }
	    transform = null;
	    if (!isInit) {
	      transform = typeof this.onUpdate === "function" ? this.onUpdate(p, {
	        x: x,
	        y: y,
	        angle: this.angle
	      }) : void 0;
	    }
	    if (this.isModule) {
	      return this.setModulePosition(x, y);
	    } else {
	      if (typeof transform !== 'string') {
	        return this.setElPosition(x, y, p);
	      } else {
	        return h.setPrefixedStyle(this.el, 'transform', transform);
	      }
	    }
	  };

	  MotionPath.prototype._setTransformOrigin = function(p) {
	    var isTransformFunOrigin, tOrigin;
	    if (this.props.transformOrigin) {
	      isTransformFunOrigin = typeof this.props.transformOrigin === 'function';
	      tOrigin = !isTransformFunOrigin ? this.props.transformOrigin : this.props.transformOrigin(this.angle, p);
	      return h.setPrefixedStyle(this.el, 'transform-origin', tOrigin);
	    }
	  };

	  MotionPath.prototype.makeMotionBlur = function(x, y) {
	    var absoluteAngle, coords, dX, dY, signX, signY, tailAngle;
	    tailAngle = 0;
	    signX = 1;
	    signY = 1;
	    if ((this.prevCoords.x == null) || (this.prevCoords.y == null)) {
	      this.speedX = 0;
	      this.speedY = 0;
	    } else {
	      dX = x - this.prevCoords.x;
	      dY = y - this.prevCoords.y;
	      if (dX > 0) {
	        signX = -1;
	      }
	      if (signX < 0) {
	        signY = -1;
	      }
	      this.speedX = Math.abs(dX);
	      this.speedY = Math.abs(dY);
	      tailAngle = Math.atan(dY / dX) * (180 / Math.PI) + 90;
	    }
	    absoluteAngle = tailAngle - this.angle;
	    coords = this.angToCoords(absoluteAngle);
	    this.blurX = h.clamp((this.speedX / 16) * this.props.motionBlur, 0, 1);
	    this.blurY = h.clamp((this.speedY / 16) * this.props.motionBlur, 0, 1);
	    this.setBlur({
	      blur: {
	        x: 3 * this.blurX * this.blurAmount * Math.abs(coords.x),
	        y: 3 * this.blurY * this.blurAmount * Math.abs(coords.y)
	      },
	      offset: {
	        x: 3 * signX * this.blurX * coords.x * this.blurAmount,
	        y: 3 * signY * this.blurY * coords.y * this.blurAmount
	      }
	    });
	    this.prevCoords.x = x;
	    return this.prevCoords.y = y;
	  };

	  MotionPath.prototype.setBlur = function(o) {
	    if (!this.isMotionBlurReset) {
	      this.filter.setAttribute('stdDeviation', o.blur.x + "," + o.blur.y);
	      this.filterOffset.setAttribute('dx', o.offset.x);
	      return this.filterOffset.setAttribute('dy', o.offset.y);
	    }
	  };

	  MotionPath.prototype.extendDefaults = function(o) {
	    var key, results, value;
	    results = [];
	    for (key in o) {
	      value = o[key];
	      results.push(this[key] = value);
	    }
	    return results;
	  };

	  MotionPath.prototype.extendOptions = function(o) {
	    var key, results, value;
	    results = [];
	    for (key in o) {
	      value = o[key];
	      results.push(this.props[key] = value);
	    }
	    return results;
	  };

	  MotionPath.prototype.then = function(o) {
	    var it, key, opts, prevOptions, value;
	    prevOptions = this.history[this.history.length - 1];
	    opts = {};
	    for (key in prevOptions) {
	      value = prevOptions[key];
	      if (!h.callbacksMap[key] && !h.tweenOptionMap[key] || key === 'duration') {
	        if (o[key] == null) {
	          o[key] = value;
	        }
	      } else {
	        if (o[key] == null) {
	          o[key] = void 0;
	        }
	      }
	      if (h.tweenOptionMap[key]) {
	        opts[key] = key !== 'duration' ? o[key] : o[key] != null ? o[key] : prevOptions[key];
	      }
	    }
	    this.history.push(o);
	    it = this;
	    opts.onUpdate = (function(_this) {
	      return function(p) {
	        return _this.setProgress(p);
	      };
	    })(this);
	    opts.onStart = (function(_this) {
	      return function() {
	        var ref;
	        return (ref = _this.props.onStart) != null ? ref.apply(_this) : void 0;
	      };
	    })(this);
	    opts.onComplete = (function(_this) {
	      return function() {
	        var ref;
	        return (ref = _this.props.onComplete) != null ? ref.apply(_this) : void 0;
	      };
	    })(this);
	    opts.onFirstUpdate = function() {
	      return it.tuneOptions(it.history[this.index]);
	    };
	    opts.isChained = !o.delay;
	    this.timeline.append(new Tween(opts));
	    return this;
	  };

	  MotionPath.prototype.tuneOptions = function(o) {
	    this.extendOptions(o);
	    return this.postVars();
	  };

	  MotionPath.prototype.angToCoords = function(angle) {
	    var radAngle, x, y;
	    angle = angle % 360;
	    radAngle = ((angle - 90) * Math.PI) / 180;
	    x = Math.cos(radAngle);
	    y = Math.sin(radAngle);
	    x = x < 0 ? Math.max(x, -0.7) : Math.min(x, .7);
	    y = y < 0 ? Math.max(y, -0.7) : Math.min(y, .7);
	    return {
	      x: x * 1.428571429,
	      y: y * 1.428571429
	    };
	  };

	  return MotionPath;

	})();

	module.exports = MotionPath;


/***/ }),
/* 130 */
/***/ (function(module, exports, __webpack_require__) {

	var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;
	/*!
	  LegoMushroom @legomushroom http://legomushroom.com
	  MIT License 2014
	 */

	/* istanbul ignore next */
	(function() {
	  var Main;
	  Main = (function() {
	    function Main(o) {
	      this.o = o != null ? o : {};
	      if (window.isAnyResizeEventInited) {
	        return;
	      }
	      this.vars();
	      this.redefineProto();
	    }

	    Main.prototype.vars = function() {
	      window.isAnyResizeEventInited = true;
	      this.allowedProtos = [HTMLDivElement, HTMLFormElement, HTMLLinkElement, HTMLBodyElement, HTMLParagraphElement, HTMLFieldSetElement, HTMLLegendElement, HTMLLabelElement, HTMLButtonElement, HTMLUListElement, HTMLOListElement, HTMLLIElement, HTMLHeadingElement, HTMLQuoteElement, HTMLPreElement, HTMLBRElement, HTMLFontElement, HTMLHRElement, HTMLModElement, HTMLParamElement, HTMLMapElement, HTMLTableElement, HTMLTableCaptionElement, HTMLImageElement, HTMLTableCellElement, HTMLSelectElement, HTMLInputElement, HTMLTextAreaElement, HTMLAnchorElement, HTMLObjectElement, HTMLTableColElement, HTMLTableSectionElement, HTMLTableRowElement];
	      return this.timerElements = {
	        img: 1,
	        textarea: 1,
	        input: 1,
	        embed: 1,
	        object: 1,
	        svg: 1,
	        canvas: 1,
	        tr: 1,
	        tbody: 1,
	        thead: 1,
	        tfoot: 1,
	        a: 1,
	        select: 1,
	        option: 1,
	        optgroup: 1,
	        dl: 1,
	        dt: 1,
	        br: 1,
	        basefont: 1,
	        font: 1,
	        col: 1,
	        iframe: 1
	      };
	    };

	    Main.prototype.redefineProto = function() {
	      var i, it, proto, t;
	      it = this;
	      return t = (function() {
	        var j, len, ref, results;
	        ref = this.allowedProtos;
	        results = [];
	        for (i = j = 0, len = ref.length; j < len; i = ++j) {
	          proto = ref[i];
	          if (proto.prototype == null) {
	            continue;
	          }
	          results.push((function(proto) {
	            var listener, remover;
	            listener = proto.prototype.addEventListener || proto.prototype.attachEvent;
	            (function(listener) {
	              var wrappedListener;
	              wrappedListener = function() {
	                var option;
	                if (this !== window || this !== document) {
	                  option = arguments[0] === 'onresize' && !this.isAnyResizeEventInited;
	                  option && it.handleResize({
	                    args: arguments,
	                    that: this
	                  });
	                }
	                return listener.apply(this, arguments);
	              };
	              if (proto.prototype.addEventListener) {
	                return proto.prototype.addEventListener = wrappedListener;
	              } else if (proto.prototype.attachEvent) {
	                return proto.prototype.attachEvent = wrappedListener;
	              }
	            })(listener);
	            remover = proto.prototype.removeEventListener || proto.prototype.detachEvent;
	            return (function(remover) {
	              var wrappedRemover;
	              wrappedRemover = function() {
	                this.isAnyResizeEventInited = false;
	                this.iframe && this.removeChild(this.iframe);
	                return remover.apply(this, arguments);
	              };
	              if (proto.prototype.removeEventListener) {
	                return proto.prototype.removeEventListener = wrappedRemover;
	              } else if (proto.prototype.detachEvent) {
	                return proto.prototype.detachEvent = wrappedListener;
	              }
	            })(remover);
	          })(proto));
	        }
	        return results;
	      }).call(this);
	    };

	    Main.prototype.handleResize = function(args) {
	      var computedStyle, el, iframe, isEmpty, isNoPos, isStatic, ref;
	      el = args.that;
	      if (!this.timerElements[el.tagName.toLowerCase()]) {
	        iframe = document.createElement('iframe');
	        el.appendChild(iframe);
	        iframe.style.width = '100%';
	        iframe.style.height = '100%';
	        iframe.style.position = 'absolute';
	        iframe.style.zIndex = -999;
	        iframe.style.opacity = 0;
	        iframe.style.top = 0;
	        iframe.style.left = 0;
	        computedStyle = window.getComputedStyle ? getComputedStyle(el) : el.currentStyle;
	        isNoPos = el.style.position === '';
	        isStatic = computedStyle.position === 'static' && isNoPos;
	        isEmpty = computedStyle.position === '' && el.style.position === '';
	        if (isStatic || isEmpty) {
	          el.style.position = 'relative';
	        }
	        if ((ref = iframe.contentWindow) != null) {
	          ref.onresize = (function(_this) {
	            return function(e) {
	              return _this.dispatchEvent(el);
	            };
	          })(this);
	        }
	        el.iframe = iframe;
	      } else {
	        this.initTimer(el);
	      }
	      return el.isAnyResizeEventInited = true;
	    };

	    Main.prototype.initTimer = function(el) {
	      var height, width;
	      width = 0;
	      height = 0;
	      return this.interval = setInterval((function(_this) {
	        return function() {
	          var newHeight, newWidth;
	          newWidth = el.offsetWidth;
	          newHeight = el.offsetHeight;
	          if (newWidth !== width || newHeight !== height) {
	            _this.dispatchEvent(el);
	            width = newWidth;
	            return height = newHeight;
	          }
	        };
	      })(this), this.o.interval || 62.5);
	    };

	    Main.prototype.dispatchEvent = function(el) {
	      var e;
	      if (document.createEvent) {
	        e = document.createEvent('HTMLEvents');
	        e.initEvent('onresize', false, false);
	        return el.dispatchEvent(e);
	      } else if (document.createEventObject) {
	        e = document.createEventObject();
	        return el.fireEvent('onresize', e);
	      } else {
	        return false;
	      }
	    };

	    Main.prototype.destroy = function() {
	      var i, it, j, len, proto, ref, results;
	      clearInterval(this.interval);
	      this.interval = null;
	      window.isAnyResizeEventInited = false;
	      it = this;
	      ref = this.allowedProtos;
	      results = [];
	      for (i = j = 0, len = ref.length; j < len; i = ++j) {
	        proto = ref[i];
	        if (proto.prototype == null) {
	          continue;
	        }
	        results.push((function(proto) {
	          var listener;
	          listener = proto.prototype.addEventListener || proto.prototype.attachEvent;
	          if (proto.prototype.addEventListener) {
	            proto.prototype.addEventListener = Element.prototype.addEventListener;
	          } else if (proto.prototype.attachEvent) {
	            proto.prototype.attachEvent = Element.prototype.attachEvent;
	          }
	          if (proto.prototype.removeEventListener) {
	            return proto.prototype.removeEventListener = Element.prototype.removeEventListener;
	          } else if (proto.prototype.detachEvent) {
	            return proto.prototype.detachEvent = Element.prototype.detachEvent;
	          }
	        })(proto));
	      }
	      return results;
	    };

	    return Main;

	  })();
	  if (true) {
	    return !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = function() {
	      return new Main;
	    }.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	  } else if ((typeof module === "object") && (typeof module.exports === "object")) {
	    return module.exports = new Main;
	  } else {
	    if (typeof window !== "undefined" && window !== null) {
	      window.AnyResizeEvent = Main;
	    }
	    return typeof window !== "undefined" && window !== null ? window.anyResizeEvent = new Main : void 0;
	  }
	})();


/***/ })
/******/ ])
});
;

/***/ }),
/* 11 */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(15)

var Component = __webpack_require__(13)(
  /* script */
  __webpack_require__(7),
  /* template */
  __webpack_require__(14),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/simonepozzobon/laravel/resources/assets/admin/js/components/VideoFormUpload.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] VideoFormUpload.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4b6830af", Component.options)
  } else {
    hotAPI.reload("data-v-4b6830af", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),
/* 13 */
/***/ (function(module, exports) {

// this module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  scopeId,
  cssModules
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  // inject cssModules
  if (cssModules) {
    var computed = Object.create(options.computed || null)
    Object.keys(cssModules).forEach(function (key) {
      var module = cssModules[key]
      computed[key] = function () { return module }
    })
    options.computed = computed
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "video-form-upload"
  }, [_c('div', {
    staticClass: "d-flex justify-content-around"
  }, [_c('button', {
    ref: "show-modal-btn",
    staticClass: "btn btn-lg btn-secondary btn-blue",
    attrs: {
      "type": "button",
      "name": "button"
    },
    on: {
      "click": _vm.showModal
    }
  }, [_vm._v("\n        Carica video " + _vm._s(_vm.diocane) + "\n    ")])]), _vm._v(" "), _c('div', {
    ref: "close-form-btn",
    staticClass: "d-flex justify-content-end close-btn",
    on: {
      "click": _vm.hideModal
    }
  }, [_vm._m(0)]), _vm._v(" "), _c('form', {
    ref: "this-form",
    attrs: {
      "method": "post",
      "enctype": "multipart/form-data"
    }
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm._token),
      expression: "_token"
    }],
    attrs: {
      "type": "hidden",
      "name": "_token"
    },
    domProps: {
      "value": (_vm._token)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm._token = $event.target.value
      }
    }
  }), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm._method),
      expression: "_method"
    }],
    attrs: {
      "type": "hidden",
      "name": "_method"
    },
    domProps: {
      "value": (_vm._method)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm._method = $event.target.value
      }
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-md-6 form-group"
  }, [_c('h6', [_vm._v("Titolo")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.title),
      expression: "title"
    }],
    staticClass: "form-control",
    attrs: {
      "type": "text",
      "name": "title"
    },
    domProps: {
      "value": (_vm.title)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.title = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "col-md-6 form-group"
  }, [_c('h6', [_vm._v("App")]), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.categories),
      expression: "categories"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "category"
    },
    on: {
      "change": function($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function(o) {
          return o.selected
        }).map(function(o) {
          var val = "_value" in o ? o._value : o.value;
          return val
        });
        _vm.categories = $event.target.multiple ? $$selectedVal : $$selectedVal[0]
      }
    }
  }, _vm._l((_vm.opts), function(opt) {
    return _c('option', {
      domProps: {
        "value": opt.value
      }
    }, [_vm._v("\n              " + _vm._s(opt.text) + "\n            ")])
  }))])]), _vm._v(" "), _vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "d-flex justify-content-around"
  }, [_c('button', {
    ref: "send-btn",
    staticClass: "btn btn-lg btn-secondary btn-blue",
    attrs: {
      "type": "button",
      "name": "button"
    },
    on: {
      "click": _vm.sendForm
    }
  }, [_vm._v("Aggiungi")])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('h3', [_c('i', {
    staticClass: "fa fa-times-circle"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "form-group"
  }, [_c('h6', [_vm._v("File")]), _vm._v(" "), _c('input', {
    staticClass: "form-control",
    attrs: {
      "type": "file",
      "name": "file"
    }
  })])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-4b6830af", module.exports)
  }
}

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(8);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(16)("92555516", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-4b6830af\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./VideoFormUpload.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-4b6830af\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./VideoFormUpload.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(17)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction) {
  isProduction = _isProduction

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[data-vue-ssr-id~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),
/* 17 */
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process, global) {/*!
 * Vue.js v2.4.4
 * (c) 2014-2017 Evan You
 * Released under the MIT License.
 */


/*  */

// these helpers produces better vm code in JS engines due to their
// explicitness and function inlining
function isUndef (v) {
  return v === undefined || v === null
}

function isDef (v) {
  return v !== undefined && v !== null
}

function isTrue (v) {
  return v === true
}

function isFalse (v) {
  return v === false
}

/**
 * Check if value is primitive
 */
function isPrimitive (value) {
  return (
    typeof value === 'string' ||
    typeof value === 'number' ||
    typeof value === 'boolean'
  )
}

/**
 * Quick object check - this is primarily used to tell
 * Objects from primitive values when we know the value
 * is a JSON-compliant type.
 */
function isObject (obj) {
  return obj !== null && typeof obj === 'object'
}

var _toString = Object.prototype.toString;

/**
 * Strict object type check. Only returns true
 * for plain JavaScript objects.
 */
function isPlainObject (obj) {
  return _toString.call(obj) === '[object Object]'
}

function isRegExp (v) {
  return _toString.call(v) === '[object RegExp]'
}

/**
 * Check if val is a valid array index.
 */
function isValidArrayIndex (val) {
  var n = parseFloat(val);
  return n >= 0 && Math.floor(n) === n && isFinite(val)
}

/**
 * Convert a value to a string that is actually rendered.
 */
function toString (val) {
  return val == null
    ? ''
    : typeof val === 'object'
      ? JSON.stringify(val, null, 2)
      : String(val)
}

/**
 * Convert a input value to a number for persistence.
 * If the conversion fails, return original string.
 */
function toNumber (val) {
  var n = parseFloat(val);
  return isNaN(n) ? val : n
}

/**
 * Make a map and return a function for checking if a key
 * is in that map.
 */
function makeMap (
  str,
  expectsLowerCase
) {
  var map = Object.create(null);
  var list = str.split(',');
  for (var i = 0; i < list.length; i++) {
    map[list[i]] = true;
  }
  return expectsLowerCase
    ? function (val) { return map[val.toLowerCase()]; }
    : function (val) { return map[val]; }
}

/**
 * Check if a tag is a built-in tag.
 */
var isBuiltInTag = makeMap('slot,component', true);

/**
 * Check if a attribute is a reserved attribute.
 */
var isReservedAttribute = makeMap('key,ref,slot,is');

/**
 * Remove an item from an array
 */
function remove (arr, item) {
  if (arr.length) {
    var index = arr.indexOf(item);
    if (index > -1) {
      return arr.splice(index, 1)
    }
  }
}

/**
 * Check whether the object has the property.
 */
var hasOwnProperty = Object.prototype.hasOwnProperty;
function hasOwn (obj, key) {
  return hasOwnProperty.call(obj, key)
}

/**
 * Create a cached version of a pure function.
 */
function cached (fn) {
  var cache = Object.create(null);
  return (function cachedFn (str) {
    var hit = cache[str];
    return hit || (cache[str] = fn(str))
  })
}

/**
 * Camelize a hyphen-delimited string.
 */
var camelizeRE = /-(\w)/g;
var camelize = cached(function (str) {
  return str.replace(camelizeRE, function (_, c) { return c ? c.toUpperCase() : ''; })
});

/**
 * Capitalize a string.
 */
var capitalize = cached(function (str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
});

/**
 * Hyphenate a camelCase string.
 */
var hyphenateRE = /\B([A-Z])/g;
var hyphenate = cached(function (str) {
  return str.replace(hyphenateRE, '-$1').toLowerCase()
});

/**
 * Simple bind, faster than native
 */
function bind (fn, ctx) {
  function boundFn (a) {
    var l = arguments.length;
    return l
      ? l > 1
        ? fn.apply(ctx, arguments)
        : fn.call(ctx, a)
      : fn.call(ctx)
  }
  // record original fn length
  boundFn._length = fn.length;
  return boundFn
}

/**
 * Convert an Array-like object to a real Array.
 */
function toArray (list, start) {
  start = start || 0;
  var i = list.length - start;
  var ret = new Array(i);
  while (i--) {
    ret[i] = list[i + start];
  }
  return ret
}

/**
 * Mix properties into target object.
 */
function extend (to, _from) {
  for (var key in _from) {
    to[key] = _from[key];
  }
  return to
}

/**
 * Merge an Array of Objects into a single Object.
 */
function toObject (arr) {
  var res = {};
  for (var i = 0; i < arr.length; i++) {
    if (arr[i]) {
      extend(res, arr[i]);
    }
  }
  return res
}

/**
 * Perform no operation.
 * Stubbing args to make Flow happy without leaving useless transpiled code
 * with ...rest (https://flow.org/blog/2017/05/07/Strict-Function-Call-Arity/)
 */
function noop (a, b, c) {}

/**
 * Always return false.
 */
var no = function (a, b, c) { return false; };

/**
 * Return same value
 */
var identity = function (_) { return _; };

/**
 * Generate a static keys string from compiler modules.
 */
function genStaticKeys (modules) {
  return modules.reduce(function (keys, m) {
    return keys.concat(m.staticKeys || [])
  }, []).join(',')
}

/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 */
function looseEqual (a, b) {
  if (a === b) { return true }
  var isObjectA = isObject(a);
  var isObjectB = isObject(b);
  if (isObjectA && isObjectB) {
    try {
      var isArrayA = Array.isArray(a);
      var isArrayB = Array.isArray(b);
      if (isArrayA && isArrayB) {
        return a.length === b.length && a.every(function (e, i) {
          return looseEqual(e, b[i])
        })
      } else if (!isArrayA && !isArrayB) {
        var keysA = Object.keys(a);
        var keysB = Object.keys(b);
        return keysA.length === keysB.length && keysA.every(function (key) {
          return looseEqual(a[key], b[key])
        })
      } else {
        /* istanbul ignore next */
        return false
      }
    } catch (e) {
      /* istanbul ignore next */
      return false
    }
  } else if (!isObjectA && !isObjectB) {
    return String(a) === String(b)
  } else {
    return false
  }
}

function looseIndexOf (arr, val) {
  for (var i = 0; i < arr.length; i++) {
    if (looseEqual(arr[i], val)) { return i }
  }
  return -1
}

/**
 * Ensure a function is called only once.
 */
function once (fn) {
  var called = false;
  return function () {
    if (!called) {
      called = true;
      fn.apply(this, arguments);
    }
  }
}

var SSR_ATTR = 'data-server-rendered';

var ASSET_TYPES = [
  'component',
  'directive',
  'filter'
];

var LIFECYCLE_HOOKS = [
  'beforeCreate',
  'created',
  'beforeMount',
  'mounted',
  'beforeUpdate',
  'updated',
  'beforeDestroy',
  'destroyed',
  'activated',
  'deactivated'
];

/*  */

var config = ({
  /**
   * Option merge strategies (used in core/util/options)
   */
  optionMergeStrategies: Object.create(null),

  /**
   * Whether to suppress warnings.
   */
  silent: false,

  /**
   * Show production mode tip message on boot?
   */
  productionTip: process.env.NODE_ENV !== 'production',

  /**
   * Whether to enable devtools
   */
  devtools: process.env.NODE_ENV !== 'production',

  /**
   * Whether to record perf
   */
  performance: false,

  /**
   * Error handler for watcher errors
   */
  errorHandler: null,

  /**
   * Warn handler for watcher warns
   */
  warnHandler: null,

  /**
   * Ignore certain custom elements
   */
  ignoredElements: [],

  /**
   * Custom user key aliases for v-on
   */
  keyCodes: Object.create(null),

  /**
   * Check if a tag is reserved so that it cannot be registered as a
   * component. This is platform-dependent and may be overwritten.
   */
  isReservedTag: no,

  /**
   * Check if an attribute is reserved so that it cannot be used as a component
   * prop. This is platform-dependent and may be overwritten.
   */
  isReservedAttr: no,

  /**
   * Check if a tag is an unknown element.
   * Platform-dependent.
   */
  isUnknownElement: no,

  /**
   * Get the namespace of an element
   */
  getTagNamespace: noop,

  /**
   * Parse the real tag name for the specific platform.
   */
  parsePlatformTagName: identity,

  /**
   * Check if an attribute must be bound using property, e.g. value
   * Platform-dependent.
   */
  mustUseProp: no,

  /**
   * Exposed for legacy reasons
   */
  _lifecycleHooks: LIFECYCLE_HOOKS
});

/*  */

var emptyObject = Object.freeze({});

/**
 * Check if a string starts with $ or _
 */
function isReserved (str) {
  var c = (str + '').charCodeAt(0);
  return c === 0x24 || c === 0x5F
}

/**
 * Define a property.
 */
function def (obj, key, val, enumerable) {
  Object.defineProperty(obj, key, {
    value: val,
    enumerable: !!enumerable,
    writable: true,
    configurable: true
  });
}

/**
 * Parse simple path.
 */
var bailRE = /[^\w.$]/;
function parsePath (path) {
  if (bailRE.test(path)) {
    return
  }
  var segments = path.split('.');
  return function (obj) {
    for (var i = 0; i < segments.length; i++) {
      if (!obj) { return }
      obj = obj[segments[i]];
    }
    return obj
  }
}

/*  */

var warn = noop;
var tip = noop;
var formatComponentName = (null); // work around flow check

if (process.env.NODE_ENV !== 'production') {
  var hasConsole = typeof console !== 'undefined';
  var classifyRE = /(?:^|[-_])(\w)/g;
  var classify = function (str) { return str
    .replace(classifyRE, function (c) { return c.toUpperCase(); })
    .replace(/[-_]/g, ''); };

  warn = function (msg, vm) {
    var trace = vm ? generateComponentTrace(vm) : '';

    if (config.warnHandler) {
      config.warnHandler.call(null, msg, vm, trace);
    } else if (hasConsole && (!config.silent)) {
      console.error(("[Vue warn]: " + msg + trace));
    }
  };

  tip = function (msg, vm) {
    if (hasConsole && (!config.silent)) {
      console.warn("[Vue tip]: " + msg + (
        vm ? generateComponentTrace(vm) : ''
      ));
    }
  };

  formatComponentName = function (vm, includeFile) {
    if (vm.$root === vm) {
      return '<Root>'
    }
    var name = typeof vm === 'string'
      ? vm
      : typeof vm === 'function' && vm.options
        ? vm.options.name
        : vm._isVue
          ? vm.$options.name || vm.$options._componentTag
          : vm.name;

    var file = vm._isVue && vm.$options.__file;
    if (!name && file) {
      var match = file.match(/([^/\\]+)\.vue$/);
      name = match && match[1];
    }

    return (
      (name ? ("<" + (classify(name)) + ">") : "<Anonymous>") +
      (file && includeFile !== false ? (" at " + file) : '')
    )
  };

  var repeat = function (str, n) {
    var res = '';
    while (n) {
      if (n % 2 === 1) { res += str; }
      if (n > 1) { str += str; }
      n >>= 1;
    }
    return res
  };

  var generateComponentTrace = function (vm) {
    if (vm._isVue && vm.$parent) {
      var tree = [];
      var currentRecursiveSequence = 0;
      while (vm) {
        if (tree.length > 0) {
          var last = tree[tree.length - 1];
          if (last.constructor === vm.constructor) {
            currentRecursiveSequence++;
            vm = vm.$parent;
            continue
          } else if (currentRecursiveSequence > 0) {
            tree[tree.length - 1] = [last, currentRecursiveSequence];
            currentRecursiveSequence = 0;
          }
        }
        tree.push(vm);
        vm = vm.$parent;
      }
      return '\n\nfound in\n\n' + tree
        .map(function (vm, i) { return ("" + (i === 0 ? '---> ' : repeat(' ', 5 + i * 2)) + (Array.isArray(vm)
            ? ((formatComponentName(vm[0])) + "... (" + (vm[1]) + " recursive calls)")
            : formatComponentName(vm))); })
        .join('\n')
    } else {
      return ("\n\n(found in " + (formatComponentName(vm)) + ")")
    }
  };
}

/*  */

function handleError (err, vm, info) {
  if (config.errorHandler) {
    config.errorHandler.call(null, err, vm, info);
  } else {
    if (process.env.NODE_ENV !== 'production') {
      warn(("Error in " + info + ": \"" + (err.toString()) + "\""), vm);
    }
    /* istanbul ignore else */
    if (inBrowser && typeof console !== 'undefined') {
      console.error(err);
    } else {
      throw err
    }
  }
}

/*  */
/* globals MutationObserver */

// can we use __proto__?
var hasProto = '__proto__' in {};

// Browser environment sniffing
var inBrowser = typeof window !== 'undefined';
var UA = inBrowser && window.navigator.userAgent.toLowerCase();
var isIE = UA && /msie|trident/.test(UA);
var isIE9 = UA && UA.indexOf('msie 9.0') > 0;
var isEdge = UA && UA.indexOf('edge/') > 0;
var isAndroid = UA && UA.indexOf('android') > 0;
var isIOS = UA && /iphone|ipad|ipod|ios/.test(UA);
var isChrome = UA && /chrome\/\d+/.test(UA) && !isEdge;

// Firefox has a "watch" function on Object.prototype...
var nativeWatch = ({}).watch;

var supportsPassive = false;
if (inBrowser) {
  try {
    var opts = {};
    Object.defineProperty(opts, 'passive', ({
      get: function get () {
        /* istanbul ignore next */
        supportsPassive = true;
      }
    })); // https://github.com/facebook/flow/issues/285
    window.addEventListener('test-passive', null, opts);
  } catch (e) {}
}

// this needs to be lazy-evaled because vue may be required before
// vue-server-renderer can set VUE_ENV
var _isServer;
var isServerRendering = function () {
  if (_isServer === undefined) {
    /* istanbul ignore if */
    if (!inBrowser && typeof global !== 'undefined') {
      // detect presence of vue-server-renderer and avoid
      // Webpack shimming the process
      _isServer = global['process'].env.VUE_ENV === 'server';
    } else {
      _isServer = false;
    }
  }
  return _isServer
};

// detect devtools
var devtools = inBrowser && window.__VUE_DEVTOOLS_GLOBAL_HOOK__;

/* istanbul ignore next */
function isNative (Ctor) {
  return typeof Ctor === 'function' && /native code/.test(Ctor.toString())
}

var hasSymbol =
  typeof Symbol !== 'undefined' && isNative(Symbol) &&
  typeof Reflect !== 'undefined' && isNative(Reflect.ownKeys);

/**
 * Defer a task to execute it asynchronously.
 */
var nextTick = (function () {
  var callbacks = [];
  var pending = false;
  var timerFunc;

  function nextTickHandler () {
    pending = false;
    var copies = callbacks.slice(0);
    callbacks.length = 0;
    for (var i = 0; i < copies.length; i++) {
      copies[i]();
    }
  }

  // the nextTick behavior leverages the microtask queue, which can be accessed
  // via either native Promise.then or MutationObserver.
  // MutationObserver has wider support, however it is seriously bugged in
  // UIWebView in iOS >= 9.3.3 when triggered in touch event handlers. It
  // completely stops working after triggering a few times... so, if native
  // Promise is available, we will use it:
  /* istanbul ignore if */
  if (typeof Promise !== 'undefined' && isNative(Promise)) {
    var p = Promise.resolve();
    var logError = function (err) { console.error(err); };
    timerFunc = function () {
      p.then(nextTickHandler).catch(logError);
      // in problematic UIWebViews, Promise.then doesn't completely break, but
      // it can get stuck in a weird state where callbacks are pushed into the
      // microtask queue but the queue isn't being flushed, until the browser
      // needs to do some other work, e.g. handle a timer. Therefore we can
      // "force" the microtask queue to be flushed by adding an empty timer.
      if (isIOS) { setTimeout(noop); }
    };
  } else if (!isIE && typeof MutationObserver !== 'undefined' && (
    isNative(MutationObserver) ||
    // PhantomJS and iOS 7.x
    MutationObserver.toString() === '[object MutationObserverConstructor]'
  )) {
    // use MutationObserver where native Promise is not available,
    // e.g. PhantomJS, iOS7, Android 4.4
    var counter = 1;
    var observer = new MutationObserver(nextTickHandler);
    var textNode = document.createTextNode(String(counter));
    observer.observe(textNode, {
      characterData: true
    });
    timerFunc = function () {
      counter = (counter + 1) % 2;
      textNode.data = String(counter);
    };
  } else {
    // fallback to setTimeout
    /* istanbul ignore next */
    timerFunc = function () {
      setTimeout(nextTickHandler, 0);
    };
  }

  return function queueNextTick (cb, ctx) {
    var _resolve;
    callbacks.push(function () {
      if (cb) {
        try {
          cb.call(ctx);
        } catch (e) {
          handleError(e, ctx, 'nextTick');
        }
      } else if (_resolve) {
        _resolve(ctx);
      }
    });
    if (!pending) {
      pending = true;
      timerFunc();
    }
    if (!cb && typeof Promise !== 'undefined') {
      return new Promise(function (resolve, reject) {
        _resolve = resolve;
      })
    }
  }
})();

var _Set;
/* istanbul ignore if */
if (typeof Set !== 'undefined' && isNative(Set)) {
  // use native Set when available.
  _Set = Set;
} else {
  // a non-standard Set polyfill that only works with primitive keys.
  _Set = (function () {
    function Set () {
      this.set = Object.create(null);
    }
    Set.prototype.has = function has (key) {
      return this.set[key] === true
    };
    Set.prototype.add = function add (key) {
      this.set[key] = true;
    };
    Set.prototype.clear = function clear () {
      this.set = Object.create(null);
    };

    return Set;
  }());
}

/*  */


var uid = 0;

/**
 * A dep is an observable that can have multiple
 * directives subscribing to it.
 */
var Dep = function Dep () {
  this.id = uid++;
  this.subs = [];
};

Dep.prototype.addSub = function addSub (sub) {
  this.subs.push(sub);
};

Dep.prototype.removeSub = function removeSub (sub) {
  remove(this.subs, sub);
};

Dep.prototype.depend = function depend () {
  if (Dep.target) {
    Dep.target.addDep(this);
  }
};

Dep.prototype.notify = function notify () {
  // stabilize the subscriber list first
  var subs = this.subs.slice();
  for (var i = 0, l = subs.length; i < l; i++) {
    subs[i].update();
  }
};

// the current target watcher being evaluated.
// this is globally unique because there could be only one
// watcher being evaluated at any time.
Dep.target = null;
var targetStack = [];

function pushTarget (_target) {
  if (Dep.target) { targetStack.push(Dep.target); }
  Dep.target = _target;
}

function popTarget () {
  Dep.target = targetStack.pop();
}

/*
 * not type checking this file because flow doesn't play well with
 * dynamically accessing methods on Array prototype
 */

var arrayProto = Array.prototype;
var arrayMethods = Object.create(arrayProto);[
  'push',
  'pop',
  'shift',
  'unshift',
  'splice',
  'sort',
  'reverse'
]
.forEach(function (method) {
  // cache original method
  var original = arrayProto[method];
  def(arrayMethods, method, function mutator () {
    var args = [], len = arguments.length;
    while ( len-- ) args[ len ] = arguments[ len ];

    var result = original.apply(this, args);
    var ob = this.__ob__;
    var inserted;
    switch (method) {
      case 'push':
      case 'unshift':
        inserted = args;
        break
      case 'splice':
        inserted = args.slice(2);
        break
    }
    if (inserted) { ob.observeArray(inserted); }
    // notify change
    ob.dep.notify();
    return result
  });
});

/*  */

var arrayKeys = Object.getOwnPropertyNames(arrayMethods);

/**
 * By default, when a reactive property is set, the new value is
 * also converted to become reactive. However when passing down props,
 * we don't want to force conversion because the value may be a nested value
 * under a frozen data structure. Converting it would defeat the optimization.
 */
var observerState = {
  shouldConvert: true
};

/**
 * Observer class that are attached to each observed
 * object. Once attached, the observer converts target
 * object's property keys into getter/setters that
 * collect dependencies and dispatches updates.
 */
var Observer = function Observer (value) {
  this.value = value;
  this.dep = new Dep();
  this.vmCount = 0;
  def(value, '__ob__', this);
  if (Array.isArray(value)) {
    var augment = hasProto
      ? protoAugment
      : copyAugment;
    augment(value, arrayMethods, arrayKeys);
    this.observeArray(value);
  } else {
    this.walk(value);
  }
};

/**
 * Walk through each property and convert them into
 * getter/setters. This method should only be called when
 * value type is Object.
 */
Observer.prototype.walk = function walk (obj) {
  var keys = Object.keys(obj);
  for (var i = 0; i < keys.length; i++) {
    defineReactive$$1(obj, keys[i], obj[keys[i]]);
  }
};

/**
 * Observe a list of Array items.
 */
Observer.prototype.observeArray = function observeArray (items) {
  for (var i = 0, l = items.length; i < l; i++) {
    observe(items[i]);
  }
};

// helpers

/**
 * Augment an target Object or Array by intercepting
 * the prototype chain using __proto__
 */
function protoAugment (target, src, keys) {
  /* eslint-disable no-proto */
  target.__proto__ = src;
  /* eslint-enable no-proto */
}

/**
 * Augment an target Object or Array by defining
 * hidden properties.
 */
/* istanbul ignore next */
function copyAugment (target, src, keys) {
  for (var i = 0, l = keys.length; i < l; i++) {
    var key = keys[i];
    def(target, key, src[key]);
  }
}

/**
 * Attempt to create an observer instance for a value,
 * returns the new observer if successfully observed,
 * or the existing observer if the value already has one.
 */
function observe (value, asRootData) {
  if (!isObject(value)) {
    return
  }
  var ob;
  if (hasOwn(value, '__ob__') && value.__ob__ instanceof Observer) {
    ob = value.__ob__;
  } else if (
    observerState.shouldConvert &&
    !isServerRendering() &&
    (Array.isArray(value) || isPlainObject(value)) &&
    Object.isExtensible(value) &&
    !value._isVue
  ) {
    ob = new Observer(value);
  }
  if (asRootData && ob) {
    ob.vmCount++;
  }
  return ob
}

/**
 * Define a reactive property on an Object.
 */
function defineReactive$$1 (
  obj,
  key,
  val,
  customSetter,
  shallow
) {
  var dep = new Dep();

  var property = Object.getOwnPropertyDescriptor(obj, key);
  if (property && property.configurable === false) {
    return
  }

  // cater for pre-defined getter/setters
  var getter = property && property.get;
  var setter = property && property.set;

  var childOb = !shallow && observe(val);
  Object.defineProperty(obj, key, {
    enumerable: true,
    configurable: true,
    get: function reactiveGetter () {
      var value = getter ? getter.call(obj) : val;
      if (Dep.target) {
        dep.depend();
        if (childOb) {
          childOb.dep.depend();
          if (Array.isArray(value)) {
            dependArray(value);
          }
        }
      }
      return value
    },
    set: function reactiveSetter (newVal) {
      var value = getter ? getter.call(obj) : val;
      /* eslint-disable no-self-compare */
      if (newVal === value || (newVal !== newVal && value !== value)) {
        return
      }
      /* eslint-enable no-self-compare */
      if (process.env.NODE_ENV !== 'production' && customSetter) {
        customSetter();
      }
      if (setter) {
        setter.call(obj, newVal);
      } else {
        val = newVal;
      }
      childOb = !shallow && observe(newVal);
      dep.notify();
    }
  });
}

/**
 * Set a property on an object. Adds the new property and
 * triggers change notification if the property doesn't
 * already exist.
 */
function set (target, key, val) {
  if (Array.isArray(target) && isValidArrayIndex(key)) {
    target.length = Math.max(target.length, key);
    target.splice(key, 1, val);
    return val
  }
  if (hasOwn(target, key)) {
    target[key] = val;
    return val
  }
  var ob = (target).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    process.env.NODE_ENV !== 'production' && warn(
      'Avoid adding reactive properties to a Vue instance or its root $data ' +
      'at runtime - declare it upfront in the data option.'
    );
    return val
  }
  if (!ob) {
    target[key] = val;
    return val
  }
  defineReactive$$1(ob.value, key, val);
  ob.dep.notify();
  return val
}

/**
 * Delete a property and trigger change if necessary.
 */
function del (target, key) {
  if (Array.isArray(target) && isValidArrayIndex(key)) {
    target.splice(key, 1);
    return
  }
  var ob = (target).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    process.env.NODE_ENV !== 'production' && warn(
      'Avoid deleting properties on a Vue instance or its root $data ' +
      '- just set it to null.'
    );
    return
  }
  if (!hasOwn(target, key)) {
    return
  }
  delete target[key];
  if (!ob) {
    return
  }
  ob.dep.notify();
}

/**
 * Collect dependencies on array elements when the array is touched, since
 * we cannot intercept array element access like property getters.
 */
function dependArray (value) {
  for (var e = (void 0), i = 0, l = value.length; i < l; i++) {
    e = value[i];
    e && e.__ob__ && e.__ob__.dep.depend();
    if (Array.isArray(e)) {
      dependArray(e);
    }
  }
}

/*  */

/**
 * Option overwriting strategies are functions that handle
 * how to merge a parent option value and a child option
 * value into the final value.
 */
var strats = config.optionMergeStrategies;

/**
 * Options with restrictions
 */
if (process.env.NODE_ENV !== 'production') {
  strats.el = strats.propsData = function (parent, child, vm, key) {
    if (!vm) {
      warn(
        "option \"" + key + "\" can only be used during instance " +
        'creation with the `new` keyword.'
      );
    }
    return defaultStrat(parent, child)
  };
}

/**
 * Helper that recursively merges two data objects together.
 */
function mergeData (to, from) {
  if (!from) { return to }
  var key, toVal, fromVal;
  var keys = Object.keys(from);
  for (var i = 0; i < keys.length; i++) {
    key = keys[i];
    toVal = to[key];
    fromVal = from[key];
    if (!hasOwn(to, key)) {
      set(to, key, fromVal);
    } else if (isPlainObject(toVal) && isPlainObject(fromVal)) {
      mergeData(toVal, fromVal);
    }
  }
  return to
}

/**
 * Data
 */
function mergeDataOrFn (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    // in a Vue.extend merge, both should be functions
    if (!childVal) {
      return parentVal
    }
    if (!parentVal) {
      return childVal
    }
    // when parentVal & childVal are both present,
    // we need to return a function that returns the
    // merged result of both functions... no need to
    // check if parentVal is a function here because
    // it has to be a function to pass previous merges.
    return function mergedDataFn () {
      return mergeData(
        typeof childVal === 'function' ? childVal.call(this) : childVal,
        typeof parentVal === 'function' ? parentVal.call(this) : parentVal
      )
    }
  } else if (parentVal || childVal) {
    return function mergedInstanceDataFn () {
      // instance merge
      var instanceData = typeof childVal === 'function'
        ? childVal.call(vm)
        : childVal;
      var defaultData = typeof parentVal === 'function'
        ? parentVal.call(vm)
        : parentVal;
      if (instanceData) {
        return mergeData(instanceData, defaultData)
      } else {
        return defaultData
      }
    }
  }
}

strats.data = function (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    if (childVal && typeof childVal !== 'function') {
      process.env.NODE_ENV !== 'production' && warn(
        'The "data" option should be a function ' +
        'that returns a per-instance value in component ' +
        'definitions.',
        vm
      );

      return parentVal
    }
    return mergeDataOrFn.call(this, parentVal, childVal)
  }

  return mergeDataOrFn(parentVal, childVal, vm)
};

/**
 * Hooks and props are merged as arrays.
 */
function mergeHook (
  parentVal,
  childVal
) {
  return childVal
    ? parentVal
      ? parentVal.concat(childVal)
      : Array.isArray(childVal)
        ? childVal
        : [childVal]
    : parentVal
}

LIFECYCLE_HOOKS.forEach(function (hook) {
  strats[hook] = mergeHook;
});

/**
 * Assets
 *
 * When a vm is present (instance creation), we need to do
 * a three-way merge between constructor options, instance
 * options and parent options.
 */
function mergeAssets (parentVal, childVal) {
  var res = Object.create(parentVal || null);
  return childVal
    ? extend(res, childVal)
    : res
}

ASSET_TYPES.forEach(function (type) {
  strats[type + 's'] = mergeAssets;
});

/**
 * Watchers.
 *
 * Watchers hashes should not overwrite one
 * another, so we merge them as arrays.
 */
strats.watch = function (parentVal, childVal) {
  // work around Firefox's Object.prototype.watch...
  if (parentVal === nativeWatch) { parentVal = undefined; }
  if (childVal === nativeWatch) { childVal = undefined; }
  /* istanbul ignore if */
  if (!childVal) { return Object.create(parentVal || null) }
  if (!parentVal) { return childVal }
  var ret = {};
  extend(ret, parentVal);
  for (var key in childVal) {
    var parent = ret[key];
    var child = childVal[key];
    if (parent && !Array.isArray(parent)) {
      parent = [parent];
    }
    ret[key] = parent
      ? parent.concat(child)
      : Array.isArray(child) ? child : [child];
  }
  return ret
};

/**
 * Other object hashes.
 */
strats.props =
strats.methods =
strats.inject =
strats.computed = function (parentVal, childVal) {
  if (!parentVal) { return childVal }
  var ret = Object.create(null);
  extend(ret, parentVal);
  if (childVal) { extend(ret, childVal); }
  return ret
};
strats.provide = mergeDataOrFn;

/**
 * Default strategy.
 */
var defaultStrat = function (parentVal, childVal) {
  return childVal === undefined
    ? parentVal
    : childVal
};

/**
 * Validate component names
 */
function checkComponents (options) {
  for (var key in options.components) {
    var lower = key.toLowerCase();
    if (isBuiltInTag(lower) || config.isReservedTag(lower)) {
      warn(
        'Do not use built-in or reserved HTML elements as component ' +
        'id: ' + key
      );
    }
  }
}

/**
 * Ensure all props option syntax are normalized into the
 * Object-based format.
 */
function normalizeProps (options) {
  var props = options.props;
  if (!props) { return }
  var res = {};
  var i, val, name;
  if (Array.isArray(props)) {
    i = props.length;
    while (i--) {
      val = props[i];
      if (typeof val === 'string') {
        name = camelize(val);
        res[name] = { type: null };
      } else if (process.env.NODE_ENV !== 'production') {
        warn('props must be strings when using array syntax.');
      }
    }
  } else if (isPlainObject(props)) {
    for (var key in props) {
      val = props[key];
      name = camelize(key);
      res[name] = isPlainObject(val)
        ? val
        : { type: val };
    }
  }
  options.props = res;
}

/**
 * Normalize all injections into Object-based format
 */
function normalizeInject (options) {
  var inject = options.inject;
  if (Array.isArray(inject)) {
    var normalized = options.inject = {};
    for (var i = 0; i < inject.length; i++) {
      normalized[inject[i]] = inject[i];
    }
  }
}

/**
 * Normalize raw function directives into object format.
 */
function normalizeDirectives (options) {
  var dirs = options.directives;
  if (dirs) {
    for (var key in dirs) {
      var def = dirs[key];
      if (typeof def === 'function') {
        dirs[key] = { bind: def, update: def };
      }
    }
  }
}

/**
 * Merge two option objects into a new one.
 * Core utility used in both instantiation and inheritance.
 */
function mergeOptions (
  parent,
  child,
  vm
) {
  if (process.env.NODE_ENV !== 'production') {
    checkComponents(child);
  }

  if (typeof child === 'function') {
    child = child.options;
  }

  normalizeProps(child);
  normalizeInject(child);
  normalizeDirectives(child);
  var extendsFrom = child.extends;
  if (extendsFrom) {
    parent = mergeOptions(parent, extendsFrom, vm);
  }
  if (child.mixins) {
    for (var i = 0, l = child.mixins.length; i < l; i++) {
      parent = mergeOptions(parent, child.mixins[i], vm);
    }
  }
  var options = {};
  var key;
  for (key in parent) {
    mergeField(key);
  }
  for (key in child) {
    if (!hasOwn(parent, key)) {
      mergeField(key);
    }
  }
  function mergeField (key) {
    var strat = strats[key] || defaultStrat;
    options[key] = strat(parent[key], child[key], vm, key);
  }
  return options
}

/**
 * Resolve an asset.
 * This function is used because child instances need access
 * to assets defined in its ancestor chain.
 */
function resolveAsset (
  options,
  type,
  id,
  warnMissing
) {
  /* istanbul ignore if */
  if (typeof id !== 'string') {
    return
  }
  var assets = options[type];
  // check local registration variations first
  if (hasOwn(assets, id)) { return assets[id] }
  var camelizedId = camelize(id);
  if (hasOwn(assets, camelizedId)) { return assets[camelizedId] }
  var PascalCaseId = capitalize(camelizedId);
  if (hasOwn(assets, PascalCaseId)) { return assets[PascalCaseId] }
  // fallback to prototype chain
  var res = assets[id] || assets[camelizedId] || assets[PascalCaseId];
  if (process.env.NODE_ENV !== 'production' && warnMissing && !res) {
    warn(
      'Failed to resolve ' + type.slice(0, -1) + ': ' + id,
      options
    );
  }
  return res
}

/*  */

function validateProp (
  key,
  propOptions,
  propsData,
  vm
) {
  var prop = propOptions[key];
  var absent = !hasOwn(propsData, key);
  var value = propsData[key];
  // handle boolean props
  if (isType(Boolean, prop.type)) {
    if (absent && !hasOwn(prop, 'default')) {
      value = false;
    } else if (!isType(String, prop.type) && (value === '' || value === hyphenate(key))) {
      value = true;
    }
  }
  // check default value
  if (value === undefined) {
    value = getPropDefaultValue(vm, prop, key);
    // since the default value is a fresh copy,
    // make sure to observe it.
    var prevShouldConvert = observerState.shouldConvert;
    observerState.shouldConvert = true;
    observe(value);
    observerState.shouldConvert = prevShouldConvert;
  }
  if (process.env.NODE_ENV !== 'production') {
    assertProp(prop, key, value, vm, absent);
  }
  return value
}

/**
 * Get the default value of a prop.
 */
function getPropDefaultValue (vm, prop, key) {
  // no default, return undefined
  if (!hasOwn(prop, 'default')) {
    return undefined
  }
  var def = prop.default;
  // warn against non-factory defaults for Object & Array
  if (process.env.NODE_ENV !== 'production' && isObject(def)) {
    warn(
      'Invalid default value for prop "' + key + '": ' +
      'Props with type Object/Array must use a factory function ' +
      'to return the default value.',
      vm
    );
  }
  // the raw prop value was also undefined from previous render,
  // return previous default value to avoid unnecessary watcher trigger
  if (vm && vm.$options.propsData &&
    vm.$options.propsData[key] === undefined &&
    vm._props[key] !== undefined
  ) {
    return vm._props[key]
  }
  // call factory function for non-Function types
  // a value is Function if its prototype is function even across different execution context
  return typeof def === 'function' && getType(prop.type) !== 'Function'
    ? def.call(vm)
    : def
}

/**
 * Assert whether a prop is valid.
 */
function assertProp (
  prop,
  name,
  value,
  vm,
  absent
) {
  if (prop.required && absent) {
    warn(
      'Missing required prop: "' + name + '"',
      vm
    );
    return
  }
  if (value == null && !prop.required) {
    return
  }
  var type = prop.type;
  var valid = !type || type === true;
  var expectedTypes = [];
  if (type) {
    if (!Array.isArray(type)) {
      type = [type];
    }
    for (var i = 0; i < type.length && !valid; i++) {
      var assertedType = assertType(value, type[i]);
      expectedTypes.push(assertedType.expectedType || '');
      valid = assertedType.valid;
    }
  }
  if (!valid) {
    warn(
      'Invalid prop: type check failed for prop "' + name + '".' +
      ' Expected ' + expectedTypes.map(capitalize).join(', ') +
      ', got ' + Object.prototype.toString.call(value).slice(8, -1) + '.',
      vm
    );
    return
  }
  var validator = prop.validator;
  if (validator) {
    if (!validator(value)) {
      warn(
        'Invalid prop: custom validator check failed for prop "' + name + '".',
        vm
      );
    }
  }
}

var simpleCheckRE = /^(String|Number|Boolean|Function|Symbol)$/;

function assertType (value, type) {
  var valid;
  var expectedType = getType(type);
  if (simpleCheckRE.test(expectedType)) {
    var t = typeof value;
    valid = t === expectedType.toLowerCase();
    // for primitive wrapper objects
    if (!valid && t === 'object') {
      valid = value instanceof type;
    }
  } else if (expectedType === 'Object') {
    valid = isPlainObject(value);
  } else if (expectedType === 'Array') {
    valid = Array.isArray(value);
  } else {
    valid = value instanceof type;
  }
  return {
    valid: valid,
    expectedType: expectedType
  }
}

/**
 * Use function string name to check built-in types,
 * because a simple equality check will fail when running
 * across different vms / iframes.
 */
function getType (fn) {
  var match = fn && fn.toString().match(/^\s*function (\w+)/);
  return match ? match[1] : ''
}

function isType (type, fn) {
  if (!Array.isArray(fn)) {
    return getType(fn) === getType(type)
  }
  for (var i = 0, len = fn.length; i < len; i++) {
    if (getType(fn[i]) === getType(type)) {
      return true
    }
  }
  /* istanbul ignore next */
  return false
}

/*  */

var mark;
var measure;

if (process.env.NODE_ENV !== 'production') {
  var perf = inBrowser && window.performance;
  /* istanbul ignore if */
  if (
    perf &&
    perf.mark &&
    perf.measure &&
    perf.clearMarks &&
    perf.clearMeasures
  ) {
    mark = function (tag) { return perf.mark(tag); };
    measure = function (name, startTag, endTag) {
      perf.measure(name, startTag, endTag);
      perf.clearMarks(startTag);
      perf.clearMarks(endTag);
      perf.clearMeasures(name);
    };
  }
}

/* not type checking this file because flow doesn't play well with Proxy */

var initProxy;

if (process.env.NODE_ENV !== 'production') {
  var allowedGlobals = makeMap(
    'Infinity,undefined,NaN,isFinite,isNaN,' +
    'parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,' +
    'Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,' +
    'require' // for Webpack/Browserify
  );

  var warnNonPresent = function (target, key) {
    warn(
      "Property or method \"" + key + "\" is not defined on the instance but " +
      "referenced during render. Make sure to declare reactive data " +
      "properties in the data option.",
      target
    );
  };

  var hasProxy =
    typeof Proxy !== 'undefined' &&
    Proxy.toString().match(/native code/);

  if (hasProxy) {
    var isBuiltInModifier = makeMap('stop,prevent,self,ctrl,shift,alt,meta');
    config.keyCodes = new Proxy(config.keyCodes, {
      set: function set (target, key, value) {
        if (isBuiltInModifier(key)) {
          warn(("Avoid overwriting built-in modifier in config.keyCodes: ." + key));
          return false
        } else {
          target[key] = value;
          return true
        }
      }
    });
  }

  var hasHandler = {
    has: function has (target, key) {
      var has = key in target;
      var isAllowed = allowedGlobals(key) || key.charAt(0) === '_';
      if (!has && !isAllowed) {
        warnNonPresent(target, key);
      }
      return has || !isAllowed
    }
  };

  var getHandler = {
    get: function get (target, key) {
      if (typeof key === 'string' && !(key in target)) {
        warnNonPresent(target, key);
      }
      return target[key]
    }
  };

  initProxy = function initProxy (vm) {
    if (hasProxy) {
      // determine which proxy handler to use
      var options = vm.$options;
      var handlers = options.render && options.render._withStripped
        ? getHandler
        : hasHandler;
      vm._renderProxy = new Proxy(vm, handlers);
    } else {
      vm._renderProxy = vm;
    }
  };
}

/*  */

var VNode = function VNode (
  tag,
  data,
  children,
  text,
  elm,
  context,
  componentOptions,
  asyncFactory
) {
  this.tag = tag;
  this.data = data;
  this.children = children;
  this.text = text;
  this.elm = elm;
  this.ns = undefined;
  this.context = context;
  this.functionalContext = undefined;
  this.key = data && data.key;
  this.componentOptions = componentOptions;
  this.componentInstance = undefined;
  this.parent = undefined;
  this.raw = false;
  this.isStatic = false;
  this.isRootInsert = true;
  this.isComment = false;
  this.isCloned = false;
  this.isOnce = false;
  this.asyncFactory = asyncFactory;
  this.asyncMeta = undefined;
  this.isAsyncPlaceholder = false;
};

var prototypeAccessors = { child: {} };

// DEPRECATED: alias for componentInstance for backwards compat.
/* istanbul ignore next */
prototypeAccessors.child.get = function () {
  return this.componentInstance
};

Object.defineProperties( VNode.prototype, prototypeAccessors );

var createEmptyVNode = function (text) {
  if ( text === void 0 ) text = '';

  var node = new VNode();
  node.text = text;
  node.isComment = true;
  return node
};

function createTextVNode (val) {
  return new VNode(undefined, undefined, undefined, String(val))
}

// optimized shallow clone
// used for static nodes and slot nodes because they may be reused across
// multiple renders, cloning them avoids errors when DOM manipulations rely
// on their elm reference.
function cloneVNode (vnode, deep) {
  var cloned = new VNode(
    vnode.tag,
    vnode.data,
    vnode.children,
    vnode.text,
    vnode.elm,
    vnode.context,
    vnode.componentOptions,
    vnode.asyncFactory
  );
  cloned.ns = vnode.ns;
  cloned.isStatic = vnode.isStatic;
  cloned.key = vnode.key;
  cloned.isComment = vnode.isComment;
  cloned.isCloned = true;
  if (deep && vnode.children) {
    cloned.children = cloneVNodes(vnode.children);
  }
  return cloned
}

function cloneVNodes (vnodes, deep) {
  var len = vnodes.length;
  var res = new Array(len);
  for (var i = 0; i < len; i++) {
    res[i] = cloneVNode(vnodes[i], deep);
  }
  return res
}

/*  */

var normalizeEvent = cached(function (name) {
  var passive = name.charAt(0) === '&';
  name = passive ? name.slice(1) : name;
  var once$$1 = name.charAt(0) === '~'; // Prefixed last, checked first
  name = once$$1 ? name.slice(1) : name;
  var capture = name.charAt(0) === '!';
  name = capture ? name.slice(1) : name;
  var plain = !(passive || once$$1 || capture);
  return {
    name: name,
    plain: plain,
    once: once$$1,
    capture: capture,
    passive: passive
  }
});

function createFnInvoker (fns) {
  function invoker () {
    var arguments$1 = arguments;

    var fns = invoker.fns;
    if (Array.isArray(fns)) {
      var cloned = fns.slice();
      for (var i = 0; i < cloned.length; i++) {
        cloned[i].apply(null, arguments$1);
      }
    } else {
      // return handler return value for single handlers
      return fns.apply(null, arguments)
    }
  }
  invoker.fns = fns;
  return invoker
}

// #6552
function prioritizePlainEvents (a, b) {
  return a.plain ? -1 : b.plain ? 1 : 0
}

function updateListeners (
  on,
  oldOn,
  add,
  remove$$1,
  vm
) {
  var name, cur, old, event;
  var toAdd = [];
  var hasModifier = false;
  for (name in on) {
    cur = on[name];
    old = oldOn[name];
    event = normalizeEvent(name);
    if (!event.plain) { hasModifier = true; }
    if (isUndef(cur)) {
      process.env.NODE_ENV !== 'production' && warn(
        "Invalid handler for event \"" + (event.name) + "\": got " + String(cur),
        vm
      );
    } else if (isUndef(old)) {
      if (isUndef(cur.fns)) {
        cur = on[name] = createFnInvoker(cur);
      }
      event.handler = cur;
      toAdd.push(event);
    } else if (cur !== old) {
      old.fns = cur;
      on[name] = old;
    }
  }
  if (toAdd.length) {
    if (hasModifier) { toAdd.sort(prioritizePlainEvents); }
    for (var i = 0; i < toAdd.length; i++) {
      var event$1 = toAdd[i];
      add(event$1.name, event$1.handler, event$1.once, event$1.capture, event$1.passive);
    }
  }
  for (name in oldOn) {
    if (isUndef(on[name])) {
      event = normalizeEvent(name);
      remove$$1(event.name, oldOn[name], event.capture);
    }
  }
}

/*  */

function mergeVNodeHook (def, hookKey, hook) {
  var invoker;
  var oldHook = def[hookKey];

  function wrappedHook () {
    hook.apply(this, arguments);
    // important: remove merged hook to ensure it's called only once
    // and prevent memory leak
    remove(invoker.fns, wrappedHook);
  }

  if (isUndef(oldHook)) {
    // no existing hook
    invoker = createFnInvoker([wrappedHook]);
  } else {
    /* istanbul ignore if */
    if (isDef(oldHook.fns) && isTrue(oldHook.merged)) {
      // already a merged invoker
      invoker = oldHook;
      invoker.fns.push(wrappedHook);
    } else {
      // existing plain hook
      invoker = createFnInvoker([oldHook, wrappedHook]);
    }
  }

  invoker.merged = true;
  def[hookKey] = invoker;
}

/*  */

function extractPropsFromVNodeData (
  data,
  Ctor,
  tag
) {
  // we are only extracting raw values here.
  // validation and default values are handled in the child
  // component itself.
  var propOptions = Ctor.options.props;
  if (isUndef(propOptions)) {
    return
  }
  var res = {};
  var attrs = data.attrs;
  var props = data.props;
  if (isDef(attrs) || isDef(props)) {
    for (var key in propOptions) {
      var altKey = hyphenate(key);
      if (process.env.NODE_ENV !== 'production') {
        var keyInLowerCase = key.toLowerCase();
        if (
          key !== keyInLowerCase &&
          attrs && hasOwn(attrs, keyInLowerCase)
        ) {
          tip(
            "Prop \"" + keyInLowerCase + "\" is passed to component " +
            (formatComponentName(tag || Ctor)) + ", but the declared prop name is" +
            " \"" + key + "\". " +
            "Note that HTML attributes are case-insensitive and camelCased " +
            "props need to use their kebab-case equivalents when using in-DOM " +
            "templates. You should probably use \"" + altKey + "\" instead of \"" + key + "\"."
          );
        }
      }
      checkProp(res, props, key, altKey, true) ||
      checkProp(res, attrs, key, altKey, false);
    }
  }
  return res
}

function checkProp (
  res,
  hash,
  key,
  altKey,
  preserve
) {
  if (isDef(hash)) {
    if (hasOwn(hash, key)) {
      res[key] = hash[key];
      if (!preserve) {
        delete hash[key];
      }
      return true
    } else if (hasOwn(hash, altKey)) {
      res[key] = hash[altKey];
      if (!preserve) {
        delete hash[altKey];
      }
      return true
    }
  }
  return false
}

/*  */

// The template compiler attempts to minimize the need for normalization by
// statically analyzing the template at compile time.
//
// For plain HTML markup, normalization can be completely skipped because the
// generated render function is guaranteed to return Array<VNode>. There are
// two cases where extra normalization is needed:

// 1. When the children contains components - because a functional component
// may return an Array instead of a single root. In this case, just a simple
// normalization is needed - if any child is an Array, we flatten the whole
// thing with Array.prototype.concat. It is guaranteed to be only 1-level deep
// because functional components already normalize their own children.
function simpleNormalizeChildren (children) {
  for (var i = 0; i < children.length; i++) {
    if (Array.isArray(children[i])) {
      return Array.prototype.concat.apply([], children)
    }
  }
  return children
}

// 2. When the children contains constructs that always generated nested Arrays,
// e.g. <template>, <slot>, v-for, or when the children is provided by user
// with hand-written render functions / JSX. In such cases a full normalization
// is needed to cater to all possible types of children values.
function normalizeChildren (children) {
  return isPrimitive(children)
    ? [createTextVNode(children)]
    : Array.isArray(children)
      ? normalizeArrayChildren(children)
      : undefined
}

function isTextNode (node) {
  return isDef(node) && isDef(node.text) && isFalse(node.isComment)
}

function normalizeArrayChildren (children, nestedIndex) {
  var res = [];
  var i, c, last;
  for (i = 0; i < children.length; i++) {
    c = children[i];
    if (isUndef(c) || typeof c === 'boolean') { continue }
    last = res[res.length - 1];
    //  nested
    if (Array.isArray(c)) {
      res.push.apply(res, normalizeArrayChildren(c, ((nestedIndex || '') + "_" + i)));
    } else if (isPrimitive(c)) {
      if (isTextNode(last)) {
        // merge adjacent text nodes
        // this is necessary for SSR hydration because text nodes are
        // essentially merged when rendered to HTML strings
        (last).text += String(c);
      } else if (c !== '') {
        // convert primitive to vnode
        res.push(createTextVNode(c));
      }
    } else {
      if (isTextNode(c) && isTextNode(last)) {
        // merge adjacent text nodes
        res[res.length - 1] = createTextVNode(last.text + c.text);
      } else {
        // default key for nested array children (likely generated by v-for)
        if (isTrue(children._isVList) &&
          isDef(c.tag) &&
          isUndef(c.key) &&
          isDef(nestedIndex)) {
          c.key = "__vlist" + nestedIndex + "_" + i + "__";
        }
        res.push(c);
      }
    }
  }
  return res
}

/*  */

function ensureCtor (comp, base) {
  if (comp.__esModule && comp.default) {
    comp = comp.default;
  }
  return isObject(comp)
    ? base.extend(comp)
    : comp
}

function createAsyncPlaceholder (
  factory,
  data,
  context,
  children,
  tag
) {
  var node = createEmptyVNode();
  node.asyncFactory = factory;
  node.asyncMeta = { data: data, context: context, children: children, tag: tag };
  return node
}

function resolveAsyncComponent (
  factory,
  baseCtor,
  context
) {
  if (isTrue(factory.error) && isDef(factory.errorComp)) {
    return factory.errorComp
  }

  if (isDef(factory.resolved)) {
    return factory.resolved
  }

  if (isTrue(factory.loading) && isDef(factory.loadingComp)) {
    return factory.loadingComp
  }

  if (isDef(factory.contexts)) {
    // already pending
    factory.contexts.push(context);
  } else {
    var contexts = factory.contexts = [context];
    var sync = true;

    var forceRender = function () {
      for (var i = 0, l = contexts.length; i < l; i++) {
        contexts[i].$forceUpdate();
      }
    };

    var resolve = once(function (res) {
      // cache resolved
      factory.resolved = ensureCtor(res, baseCtor);
      // invoke callbacks only if this is not a synchronous resolve
      // (async resolves are shimmed as synchronous during SSR)
      if (!sync) {
        forceRender();
      }
    });

    var reject = once(function (reason) {
      process.env.NODE_ENV !== 'production' && warn(
        "Failed to resolve async component: " + (String(factory)) +
        (reason ? ("\nReason: " + reason) : '')
      );
      if (isDef(factory.errorComp)) {
        factory.error = true;
        forceRender();
      }
    });

    var res = factory(resolve, reject);

    if (isObject(res)) {
      if (typeof res.then === 'function') {
        // () => Promise
        if (isUndef(factory.resolved)) {
          res.then(resolve, reject);
        }
      } else if (isDef(res.component) && typeof res.component.then === 'function') {
        res.component.then(resolve, reject);

        if (isDef(res.error)) {
          factory.errorComp = ensureCtor(res.error, baseCtor);
        }

        if (isDef(res.loading)) {
          factory.loadingComp = ensureCtor(res.loading, baseCtor);
          if (res.delay === 0) {
            factory.loading = true;
          } else {
            setTimeout(function () {
              if (isUndef(factory.resolved) && isUndef(factory.error)) {
                factory.loading = true;
                forceRender();
              }
            }, res.delay || 200);
          }
        }

        if (isDef(res.timeout)) {
          setTimeout(function () {
            if (isUndef(factory.resolved)) {
              reject(
                process.env.NODE_ENV !== 'production'
                  ? ("timeout (" + (res.timeout) + "ms)")
                  : null
              );
            }
          }, res.timeout);
        }
      }
    }

    sync = false;
    // return in case resolved synchronously
    return factory.loading
      ? factory.loadingComp
      : factory.resolved
  }
}

/*  */

function isAsyncPlaceholder (node) {
  return node.isComment && node.asyncFactory
}

/*  */

function getFirstComponentChild (children) {
  if (Array.isArray(children)) {
    for (var i = 0; i < children.length; i++) {
      var c = children[i];
      if (isDef(c) && (isDef(c.componentOptions) || isAsyncPlaceholder(c))) {
        return c
      }
    }
  }
}

/*  */

/*  */

function initEvents (vm) {
  vm._events = Object.create(null);
  vm._hasHookEvent = false;
  // init parent attached events
  var listeners = vm.$options._parentListeners;
  if (listeners) {
    updateComponentListeners(vm, listeners);
  }
}

var target;

function add (event, fn, once$$1) {
  if (once$$1) {
    target.$once(event, fn);
  } else {
    target.$on(event, fn);
  }
}

function remove$1 (event, fn) {
  target.$off(event, fn);
}

function updateComponentListeners (
  vm,
  listeners,
  oldListeners
) {
  target = vm;
  updateListeners(listeners, oldListeners || {}, add, remove$1, vm);
}

function eventsMixin (Vue) {
  var hookRE = /^hook:/;
  Vue.prototype.$on = function (event, fn) {
    var this$1 = this;

    var vm = this;
    if (Array.isArray(event)) {
      for (var i = 0, l = event.length; i < l; i++) {
        this$1.$on(event[i], fn);
      }
    } else {
      (vm._events[event] || (vm._events[event] = [])).push(fn);
      // optimize hook:event cost by using a boolean flag marked at registration
      // instead of a hash lookup
      if (hookRE.test(event)) {
        vm._hasHookEvent = true;
      }
    }
    return vm
  };

  Vue.prototype.$once = function (event, fn) {
    var vm = this;
    function on () {
      vm.$off(event, on);
      fn.apply(vm, arguments);
    }
    on.fn = fn;
    vm.$on(event, on);
    return vm
  };

  Vue.prototype.$off = function (event, fn) {
    var this$1 = this;

    var vm = this;
    // all
    if (!arguments.length) {
      vm._events = Object.create(null);
      return vm
    }
    // array of events
    if (Array.isArray(event)) {
      for (var i = 0, l = event.length; i < l; i++) {
        this$1.$off(event[i], fn);
      }
      return vm
    }
    // specific event
    var cbs = vm._events[event];
    if (!cbs) {
      return vm
    }
    if (arguments.length === 1) {
      vm._events[event] = null;
      return vm
    }
    if (fn) {
      // specific handler
      var cb;
      var i$1 = cbs.length;
      while (i$1--) {
        cb = cbs[i$1];
        if (cb === fn || cb.fn === fn) {
          cbs.splice(i$1, 1);
          break
        }
      }
    }
    return vm
  };

  Vue.prototype.$emit = function (event) {
    var vm = this;
    if (process.env.NODE_ENV !== 'production') {
      var lowerCaseEvent = event.toLowerCase();
      if (lowerCaseEvent !== event && vm._events[lowerCaseEvent]) {
        tip(
          "Event \"" + lowerCaseEvent + "\" is emitted in component " +
          (formatComponentName(vm)) + " but the handler is registered for \"" + event + "\". " +
          "Note that HTML attributes are case-insensitive and you cannot use " +
          "v-on to listen to camelCase events when using in-DOM templates. " +
          "You should probably use \"" + (hyphenate(event)) + "\" instead of \"" + event + "\"."
        );
      }
    }
    var cbs = vm._events[event];
    if (cbs) {
      cbs = cbs.length > 1 ? toArray(cbs) : cbs;
      var args = toArray(arguments, 1);
      for (var i = 0, l = cbs.length; i < l; i++) {
        try {
          cbs[i].apply(vm, args);
        } catch (e) {
          handleError(e, vm, ("event handler for \"" + event + "\""));
        }
      }
    }
    return vm
  };
}

/*  */

/**
 * Runtime helper for resolving raw children VNodes into a slot object.
 */
function resolveSlots (
  children,
  context
) {
  var slots = {};
  if (!children) {
    return slots
  }
  var defaultSlot = [];
  for (var i = 0, l = children.length; i < l; i++) {
    var child = children[i];
    var data = child.data;
    // remove slot attribute if the node is resolved as a Vue slot node
    if (data && data.attrs && data.attrs.slot) {
      delete data.attrs.slot;
    }
    // named slots should only be respected if the vnode was rendered in the
    // same context.
    if ((child.context === context || child.functionalContext === context) &&
      data && data.slot != null
    ) {
      var name = child.data.slot;
      var slot = (slots[name] || (slots[name] = []));
      if (child.tag === 'template') {
        slot.push.apply(slot, child.children);
      } else {
        slot.push(child);
      }
    } else {
      defaultSlot.push(child);
    }
  }
  // ignore whitespace
  if (!defaultSlot.every(isWhitespace)) {
    slots.default = defaultSlot;
  }
  return slots
}

function isWhitespace (node) {
  return node.isComment || node.text === ' '
}

function resolveScopedSlots (
  fns, // see flow/vnode
  res
) {
  res = res || {};
  for (var i = 0; i < fns.length; i++) {
    if (Array.isArray(fns[i])) {
      resolveScopedSlots(fns[i], res);
    } else {
      res[fns[i].key] = fns[i].fn;
    }
  }
  return res
}

/*  */

var activeInstance = null;
var isUpdatingChildComponent = false;

function initLifecycle (vm) {
  var options = vm.$options;

  // locate first non-abstract parent
  var parent = options.parent;
  if (parent && !options.abstract) {
    while (parent.$options.abstract && parent.$parent) {
      parent = parent.$parent;
    }
    parent.$children.push(vm);
  }

  vm.$parent = parent;
  vm.$root = parent ? parent.$root : vm;

  vm.$children = [];
  vm.$refs = {};

  vm._watcher = null;
  vm._inactive = null;
  vm._directInactive = false;
  vm._isMounted = false;
  vm._isDestroyed = false;
  vm._isBeingDestroyed = false;
}

function lifecycleMixin (Vue) {
  Vue.prototype._update = function (vnode, hydrating) {
    var vm = this;
    if (vm._isMounted) {
      callHook(vm, 'beforeUpdate');
    }
    var prevEl = vm.$el;
    var prevVnode = vm._vnode;
    var prevActiveInstance = activeInstance;
    activeInstance = vm;
    vm._vnode = vnode;
    // Vue.prototype.__patch__ is injected in entry points
    // based on the rendering backend used.
    if (!prevVnode) {
      // initial render
      vm.$el = vm.__patch__(
        vm.$el, vnode, hydrating, false /* removeOnly */,
        vm.$options._parentElm,
        vm.$options._refElm
      );
      // no need for the ref nodes after initial patch
      // this prevents keeping a detached DOM tree in memory (#5851)
      vm.$options._parentElm = vm.$options._refElm = null;
    } else {
      // updates
      vm.$el = vm.__patch__(prevVnode, vnode);
    }
    activeInstance = prevActiveInstance;
    // update __vue__ reference
    if (prevEl) {
      prevEl.__vue__ = null;
    }
    if (vm.$el) {
      vm.$el.__vue__ = vm;
    }
    // if parent is an HOC, update its $el as well
    if (vm.$vnode && vm.$parent && vm.$vnode === vm.$parent._vnode) {
      vm.$parent.$el = vm.$el;
    }
    // updated hook is called by the scheduler to ensure that children are
    // updated in a parent's updated hook.
  };

  Vue.prototype.$forceUpdate = function () {
    var vm = this;
    if (vm._watcher) {
      vm._watcher.update();
    }
  };

  Vue.prototype.$destroy = function () {
    var vm = this;
    if (vm._isBeingDestroyed) {
      return
    }
    callHook(vm, 'beforeDestroy');
    vm._isBeingDestroyed = true;
    // remove self from parent
    var parent = vm.$parent;
    if (parent && !parent._isBeingDestroyed && !vm.$options.abstract) {
      remove(parent.$children, vm);
    }
    // teardown watchers
    if (vm._watcher) {
      vm._watcher.teardown();
    }
    var i = vm._watchers.length;
    while (i--) {
      vm._watchers[i].teardown();
    }
    // remove reference from data ob
    // frozen object may not have observer.
    if (vm._data.__ob__) {
      vm._data.__ob__.vmCount--;
    }
    // call the last hook...
    vm._isDestroyed = true;
    // invoke destroy hooks on current rendered tree
    vm.__patch__(vm._vnode, null);
    // fire destroyed hook
    callHook(vm, 'destroyed');
    // turn off all instance listeners.
    vm.$off();
    // remove __vue__ reference
    if (vm.$el) {
      vm.$el.__vue__ = null;
    }
  };
}

function mountComponent (
  vm,
  el,
  hydrating
) {
  vm.$el = el;
  if (!vm.$options.render) {
    vm.$options.render = createEmptyVNode;
    if (process.env.NODE_ENV !== 'production') {
      /* istanbul ignore if */
      if ((vm.$options.template && vm.$options.template.charAt(0) !== '#') ||
        vm.$options.el || el) {
        warn(
          'You are using the runtime-only build of Vue where the template ' +
          'compiler is not available. Either pre-compile the templates into ' +
          'render functions, or use the compiler-included build.',
          vm
        );
      } else {
        warn(
          'Failed to mount component: template or render function not defined.',
          vm
        );
      }
    }
  }
  callHook(vm, 'beforeMount');

  var updateComponent;
  /* istanbul ignore if */
  if (process.env.NODE_ENV !== 'production' && config.performance && mark) {
    updateComponent = function () {
      var name = vm._name;
      var id = vm._uid;
      var startTag = "vue-perf-start:" + id;
      var endTag = "vue-perf-end:" + id;

      mark(startTag);
      var vnode = vm._render();
      mark(endTag);
      measure((name + " render"), startTag, endTag);

      mark(startTag);
      vm._update(vnode, hydrating);
      mark(endTag);
      measure((name + " patch"), startTag, endTag);
    };
  } else {
    updateComponent = function () {
      vm._update(vm._render(), hydrating);
    };
  }

  vm._watcher = new Watcher(vm, updateComponent, noop);
  hydrating = false;

  // manually mounted instance, call mounted on self
  // mounted is called for render-created child components in its inserted hook
  if (vm.$vnode == null) {
    vm._isMounted = true;
    callHook(vm, 'mounted');
  }
  return vm
}

function updateChildComponent (
  vm,
  propsData,
  listeners,
  parentVnode,
  renderChildren
) {
  if (process.env.NODE_ENV !== 'production') {
    isUpdatingChildComponent = true;
  }

  // determine whether component has slot children
  // we need to do this before overwriting $options._renderChildren
  var hasChildren = !!(
    renderChildren ||               // has new static slots
    vm.$options._renderChildren ||  // has old static slots
    parentVnode.data.scopedSlots || // has new scoped slots
    vm.$scopedSlots !== emptyObject // has old scoped slots
  );

  vm.$options._parentVnode = parentVnode;
  vm.$vnode = parentVnode; // update vm's placeholder node without re-render

  if (vm._vnode) { // update child tree's parent
    vm._vnode.parent = parentVnode;
  }
  vm.$options._renderChildren = renderChildren;

  // update $attrs and $listeners hash
  // these are also reactive so they may trigger child update if the child
  // used them during render
  vm.$attrs = (parentVnode.data && parentVnode.data.attrs) || emptyObject;
  vm.$listeners = listeners || emptyObject;

  // update props
  if (propsData && vm.$options.props) {
    observerState.shouldConvert = false;
    var props = vm._props;
    var propKeys = vm.$options._propKeys || [];
    for (var i = 0; i < propKeys.length; i++) {
      var key = propKeys[i];
      props[key] = validateProp(key, vm.$options.props, propsData, vm);
    }
    observerState.shouldConvert = true;
    // keep a copy of raw propsData
    vm.$options.propsData = propsData;
  }

  // update listeners
  if (listeners) {
    var oldListeners = vm.$options._parentListeners;
    vm.$options._parentListeners = listeners;
    updateComponentListeners(vm, listeners, oldListeners);
  }
  // resolve slots + force update if has children
  if (hasChildren) {
    vm.$slots = resolveSlots(renderChildren, parentVnode.context);
    vm.$forceUpdate();
  }

  if (process.env.NODE_ENV !== 'production') {
    isUpdatingChildComponent = false;
  }
}

function isInInactiveTree (vm) {
  while (vm && (vm = vm.$parent)) {
    if (vm._inactive) { return true }
  }
  return false
}

function activateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = false;
    if (isInInactiveTree(vm)) {
      return
    }
  } else if (vm._directInactive) {
    return
  }
  if (vm._inactive || vm._inactive === null) {
    vm._inactive = false;
    for (var i = 0; i < vm.$children.length; i++) {
      activateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'activated');
  }
}

function deactivateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = true;
    if (isInInactiveTree(vm)) {
      return
    }
  }
  if (!vm._inactive) {
    vm._inactive = true;
    for (var i = 0; i < vm.$children.length; i++) {
      deactivateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'deactivated');
  }
}

function callHook (vm, hook) {
  var handlers = vm.$options[hook];
  if (handlers) {
    for (var i = 0, j = handlers.length; i < j; i++) {
      try {
        handlers[i].call(vm);
      } catch (e) {
        handleError(e, vm, (hook + " hook"));
      }
    }
  }
  if (vm._hasHookEvent) {
    vm.$emit('hook:' + hook);
  }
}

/*  */


var MAX_UPDATE_COUNT = 100;

var queue = [];
var activatedChildren = [];
var has = {};
var circular = {};
var waiting = false;
var flushing = false;
var index = 0;

/**
 * Reset the scheduler's state.
 */
function resetSchedulerState () {
  index = queue.length = activatedChildren.length = 0;
  has = {};
  if (process.env.NODE_ENV !== 'production') {
    circular = {};
  }
  waiting = flushing = false;
}

/**
 * Flush both queues and run the watchers.
 */
function flushSchedulerQueue () {
  flushing = true;
  var watcher, id;

  // Sort queue before flush.
  // This ensures that:
  // 1. Components are updated from parent to child. (because parent is always
  //    created before the child)
  // 2. A component's user watchers are run before its render watcher (because
  //    user watchers are created before the render watcher)
  // 3. If a component is destroyed during a parent component's watcher run,
  //    its watchers can be skipped.
  queue.sort(function (a, b) { return a.id - b.id; });

  // do not cache length because more watchers might be pushed
  // as we run existing watchers
  for (index = 0; index < queue.length; index++) {
    watcher = queue[index];
    id = watcher.id;
    has[id] = null;
    watcher.run();
    // in dev build, check and stop circular updates.
    if (process.env.NODE_ENV !== 'production' && has[id] != null) {
      circular[id] = (circular[id] || 0) + 1;
      if (circular[id] > MAX_UPDATE_COUNT) {
        warn(
          'You may have an infinite update loop ' + (
            watcher.user
              ? ("in watcher with expression \"" + (watcher.expression) + "\"")
              : "in a component render function."
          ),
          watcher.vm
        );
        break
      }
    }
  }

  // keep copies of post queues before resetting state
  var activatedQueue = activatedChildren.slice();
  var updatedQueue = queue.slice();

  resetSchedulerState();

  // call component updated and activated hooks
  callActivatedHooks(activatedQueue);
  callUpdatedHooks(updatedQueue);

  // devtool hook
  /* istanbul ignore if */
  if (devtools && config.devtools) {
    devtools.emit('flush');
  }
}

function callUpdatedHooks (queue) {
  var i = queue.length;
  while (i--) {
    var watcher = queue[i];
    var vm = watcher.vm;
    if (vm._watcher === watcher && vm._isMounted) {
      callHook(vm, 'updated');
    }
  }
}

/**
 * Queue a kept-alive component that was activated during patch.
 * The queue will be processed after the entire tree has been patched.
 */
function queueActivatedComponent (vm) {
  // setting _inactive to false here so that a render function can
  // rely on checking whether it's in an inactive tree (e.g. router-view)
  vm._inactive = false;
  activatedChildren.push(vm);
}

function callActivatedHooks (queue) {
  for (var i = 0; i < queue.length; i++) {
    queue[i]._inactive = true;
    activateChildComponent(queue[i], true /* true */);
  }
}

/**
 * Push a watcher into the watcher queue.
 * Jobs with duplicate IDs will be skipped unless it's
 * pushed when the queue is being flushed.
 */
function queueWatcher (watcher) {
  var id = watcher.id;
  if (has[id] == null) {
    has[id] = true;
    if (!flushing) {
      queue.push(watcher);
    } else {
      // if already flushing, splice the watcher based on its id
      // if already past its id, it will be run next immediately.
      var i = queue.length - 1;
      while (i > index && queue[i].id > watcher.id) {
        i--;
      }
      queue.splice(i + 1, 0, watcher);
    }
    // queue the flush
    if (!waiting) {
      waiting = true;
      nextTick(flushSchedulerQueue);
    }
  }
}

/*  */

var uid$2 = 0;

/**
 * A watcher parses an expression, collects dependencies,
 * and fires callback when the expression value changes.
 * This is used for both the $watch() api and directives.
 */
var Watcher = function Watcher (
  vm,
  expOrFn,
  cb,
  options
) {
  this.vm = vm;
  vm._watchers.push(this);
  // options
  if (options) {
    this.deep = !!options.deep;
    this.user = !!options.user;
    this.lazy = !!options.lazy;
    this.sync = !!options.sync;
  } else {
    this.deep = this.user = this.lazy = this.sync = false;
  }
  this.cb = cb;
  this.id = ++uid$2; // uid for batching
  this.active = true;
  this.dirty = this.lazy; // for lazy watchers
  this.deps = [];
  this.newDeps = [];
  this.depIds = new _Set();
  this.newDepIds = new _Set();
  this.expression = process.env.NODE_ENV !== 'production'
    ? expOrFn.toString()
    : '';
  // parse expression for getter
  if (typeof expOrFn === 'function') {
    this.getter = expOrFn;
  } else {
    this.getter = parsePath(expOrFn);
    if (!this.getter) {
      this.getter = function () {};
      process.env.NODE_ENV !== 'production' && warn(
        "Failed watching path: \"" + expOrFn + "\" " +
        'Watcher only accepts simple dot-delimited paths. ' +
        'For full control, use a function instead.',
        vm
      );
    }
  }
  this.value = this.lazy
    ? undefined
    : this.get();
};

/**
 * Evaluate the getter, and re-collect dependencies.
 */
Watcher.prototype.get = function get () {
  pushTarget(this);
  var value;
  var vm = this.vm;
  try {
    value = this.getter.call(vm, vm);
  } catch (e) {
    if (this.user) {
      handleError(e, vm, ("getter for watcher \"" + (this.expression) + "\""));
    } else {
      throw e
    }
  } finally {
    // "touch" every property so they are all tracked as
    // dependencies for deep watching
    if (this.deep) {
      traverse(value);
    }
    popTarget();
    this.cleanupDeps();
  }
  return value
};

/**
 * Add a dependency to this directive.
 */
Watcher.prototype.addDep = function addDep (dep) {
  var id = dep.id;
  if (!this.newDepIds.has(id)) {
    this.newDepIds.add(id);
    this.newDeps.push(dep);
    if (!this.depIds.has(id)) {
      dep.addSub(this);
    }
  }
};

/**
 * Clean up for dependency collection.
 */
Watcher.prototype.cleanupDeps = function cleanupDeps () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    var dep = this$1.deps[i];
    if (!this$1.newDepIds.has(dep.id)) {
      dep.removeSub(this$1);
    }
  }
  var tmp = this.depIds;
  this.depIds = this.newDepIds;
  this.newDepIds = tmp;
  this.newDepIds.clear();
  tmp = this.deps;
  this.deps = this.newDeps;
  this.newDeps = tmp;
  this.newDeps.length = 0;
};

/**
 * Subscriber interface.
 * Will be called when a dependency changes.
 */
Watcher.prototype.update = function update () {
  /* istanbul ignore else */
  if (this.lazy) {
    this.dirty = true;
  } else if (this.sync) {
    this.run();
  } else {
    queueWatcher(this);
  }
};

/**
 * Scheduler job interface.
 * Will be called by the scheduler.
 */
Watcher.prototype.run = function run () {
  if (this.active) {
    var value = this.get();
    if (
      value !== this.value ||
      // Deep watchers and watchers on Object/Arrays should fire even
      // when the value is the same, because the value may
      // have mutated.
      isObject(value) ||
      this.deep
    ) {
      // set new value
      var oldValue = this.value;
      this.value = value;
      if (this.user) {
        try {
          this.cb.call(this.vm, value, oldValue);
        } catch (e) {
          handleError(e, this.vm, ("callback for watcher \"" + (this.expression) + "\""));
        }
      } else {
        this.cb.call(this.vm, value, oldValue);
      }
    }
  }
};

/**
 * Evaluate the value of the watcher.
 * This only gets called for lazy watchers.
 */
Watcher.prototype.evaluate = function evaluate () {
  this.value = this.get();
  this.dirty = false;
};

/**
 * Depend on all deps collected by this watcher.
 */
Watcher.prototype.depend = function depend () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    this$1.deps[i].depend();
  }
};

/**
 * Remove self from all dependencies' subscriber list.
 */
Watcher.prototype.teardown = function teardown () {
    var this$1 = this;

  if (this.active) {
    // remove self from vm's watcher list
    // this is a somewhat expensive operation so we skip it
    // if the vm is being destroyed.
    if (!this.vm._isBeingDestroyed) {
      remove(this.vm._watchers, this);
    }
    var i = this.deps.length;
    while (i--) {
      this$1.deps[i].removeSub(this$1);
    }
    this.active = false;
  }
};

/**
 * Recursively traverse an object to evoke all converted
 * getters, so that every nested property inside the object
 * is collected as a "deep" dependency.
 */
var seenObjects = new _Set();
function traverse (val) {
  seenObjects.clear();
  _traverse(val, seenObjects);
}

function _traverse (val, seen) {
  var i, keys;
  var isA = Array.isArray(val);
  if ((!isA && !isObject(val)) || !Object.isExtensible(val)) {
    return
  }
  if (val.__ob__) {
    var depId = val.__ob__.dep.id;
    if (seen.has(depId)) {
      return
    }
    seen.add(depId);
  }
  if (isA) {
    i = val.length;
    while (i--) { _traverse(val[i], seen); }
  } else {
    keys = Object.keys(val);
    i = keys.length;
    while (i--) { _traverse(val[keys[i]], seen); }
  }
}

/*  */

var sharedPropertyDefinition = {
  enumerable: true,
  configurable: true,
  get: noop,
  set: noop
};

function proxy (target, sourceKey, key) {
  sharedPropertyDefinition.get = function proxyGetter () {
    return this[sourceKey][key]
  };
  sharedPropertyDefinition.set = function proxySetter (val) {
    this[sourceKey][key] = val;
  };
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function initState (vm) {
  vm._watchers = [];
  var opts = vm.$options;
  if (opts.props) { initProps(vm, opts.props); }
  if (opts.methods) { initMethods(vm, opts.methods); }
  if (opts.data) {
    initData(vm);
  } else {
    observe(vm._data = {}, true /* asRootData */);
  }
  if (opts.computed) { initComputed(vm, opts.computed); }
  if (opts.watch && opts.watch !== nativeWatch) {
    initWatch(vm, opts.watch);
  }
}

function checkOptionType (vm, name) {
  var option = vm.$options[name];
  if (!isPlainObject(option)) {
    warn(
      ("component option \"" + name + "\" should be an object."),
      vm
    );
  }
}

function initProps (vm, propsOptions) {
  var propsData = vm.$options.propsData || {};
  var props = vm._props = {};
  // cache prop keys so that future props updates can iterate using Array
  // instead of dynamic object key enumeration.
  var keys = vm.$options._propKeys = [];
  var isRoot = !vm.$parent;
  // root instance props should be converted
  observerState.shouldConvert = isRoot;
  var loop = function ( key ) {
    keys.push(key);
    var value = validateProp(key, propsOptions, propsData, vm);
    /* istanbul ignore else */
    if (process.env.NODE_ENV !== 'production') {
      if (isReservedAttribute(key) || config.isReservedAttr(key)) {
        warn(
          ("\"" + key + "\" is a reserved attribute and cannot be used as component prop."),
          vm
        );
      }
      defineReactive$$1(props, key, value, function () {
        if (vm.$parent && !isUpdatingChildComponent) {
          warn(
            "Avoid mutating a prop directly since the value will be " +
            "overwritten whenever the parent component re-renders. " +
            "Instead, use a data or computed property based on the prop's " +
            "value. Prop being mutated: \"" + key + "\"",
            vm
          );
        }
      });
    } else {
      defineReactive$$1(props, key, value);
    }
    // static props are already proxied on the component's prototype
    // during Vue.extend(). We only need to proxy props defined at
    // instantiation here.
    if (!(key in vm)) {
      proxy(vm, "_props", key);
    }
  };

  for (var key in propsOptions) loop( key );
  observerState.shouldConvert = true;
}

function initData (vm) {
  var data = vm.$options.data;
  data = vm._data = typeof data === 'function'
    ? getData(data, vm)
    : data || {};
  if (!isPlainObject(data)) {
    data = {};
    process.env.NODE_ENV !== 'production' && warn(
      'data functions should return an object:\n' +
      'https://vuejs.org/v2/guide/components.html#data-Must-Be-a-Function',
      vm
    );
  }
  // proxy data on instance
  var keys = Object.keys(data);
  var props = vm.$options.props;
  var methods = vm.$options.methods;
  var i = keys.length;
  while (i--) {
    var key = keys[i];
    if (process.env.NODE_ENV !== 'production') {
      if (methods && hasOwn(methods, key)) {
        warn(
          ("Method \"" + key + "\" has already been defined as a data property."),
          vm
        );
      }
    }
    if (props && hasOwn(props, key)) {
      process.env.NODE_ENV !== 'production' && warn(
        "The data property \"" + key + "\" is already declared as a prop. " +
        "Use prop default value instead.",
        vm
      );
    } else if (!isReserved(key)) {
      proxy(vm, "_data", key);
    }
  }
  // observe data
  observe(data, true /* asRootData */);
}

function getData (data, vm) {
  try {
    return data.call(vm)
  } catch (e) {
    handleError(e, vm, "data()");
    return {}
  }
}

var computedWatcherOptions = { lazy: true };

function initComputed (vm, computed) {
  process.env.NODE_ENV !== 'production' && checkOptionType(vm, 'computed');
  var watchers = vm._computedWatchers = Object.create(null);
  // computed properties are just getters during SSR
  var isSSR = isServerRendering();

  for (var key in computed) {
    var userDef = computed[key];
    var getter = typeof userDef === 'function' ? userDef : userDef.get;
    if (process.env.NODE_ENV !== 'production' && getter == null) {
      warn(
        ("Getter is missing for computed property \"" + key + "\"."),
        vm
      );
    }

    if (!isSSR) {
      // create internal watcher for the computed property.
      watchers[key] = new Watcher(
        vm,
        getter || noop,
        noop,
        computedWatcherOptions
      );
    }

    // component-defined computed properties are already defined on the
    // component prototype. We only need to define computed properties defined
    // at instantiation here.
    if (!(key in vm)) {
      defineComputed(vm, key, userDef);
    } else if (process.env.NODE_ENV !== 'production') {
      if (key in vm.$data) {
        warn(("The computed property \"" + key + "\" is already defined in data."), vm);
      } else if (vm.$options.props && key in vm.$options.props) {
        warn(("The computed property \"" + key + "\" is already defined as a prop."), vm);
      }
    }
  }
}

function defineComputed (
  target,
  key,
  userDef
) {
  var shouldCache = !isServerRendering();
  if (typeof userDef === 'function') {
    sharedPropertyDefinition.get = shouldCache
      ? createComputedGetter(key)
      : userDef;
    sharedPropertyDefinition.set = noop;
  } else {
    sharedPropertyDefinition.get = userDef.get
      ? shouldCache && userDef.cache !== false
        ? createComputedGetter(key)
        : userDef.get
      : noop;
    sharedPropertyDefinition.set = userDef.set
      ? userDef.set
      : noop;
  }
  if (process.env.NODE_ENV !== 'production' &&
      sharedPropertyDefinition.set === noop) {
    sharedPropertyDefinition.set = function () {
      warn(
        ("Computed property \"" + key + "\" was assigned to but it has no setter."),
        this
      );
    };
  }
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function createComputedGetter (key) {
  return function computedGetter () {
    var watcher = this._computedWatchers && this._computedWatchers[key];
    if (watcher) {
      if (watcher.dirty) {
        watcher.evaluate();
      }
      if (Dep.target) {
        watcher.depend();
      }
      return watcher.value
    }
  }
}

function initMethods (vm, methods) {
  process.env.NODE_ENV !== 'production' && checkOptionType(vm, 'methods');
  var props = vm.$options.props;
  for (var key in methods) {
    if (process.env.NODE_ENV !== 'production') {
      if (methods[key] == null) {
        warn(
          "Method \"" + key + "\" has an undefined value in the component definition. " +
          "Did you reference the function correctly?",
          vm
        );
      }
      if (props && hasOwn(props, key)) {
        warn(
          ("Method \"" + key + "\" has already been defined as a prop."),
          vm
        );
      }
      if ((key in vm) && isReserved(key)) {
        warn(
          "Method \"" + key + "\" conflicts with an existing Vue instance method. " +
          "Avoid defining component methods that start with _ or $."
        );
      }
    }
    vm[key] = methods[key] == null ? noop : bind(methods[key], vm);
  }
}

function initWatch (vm, watch) {
  process.env.NODE_ENV !== 'production' && checkOptionType(vm, 'watch');
  for (var key in watch) {
    var handler = watch[key];
    if (Array.isArray(handler)) {
      for (var i = 0; i < handler.length; i++) {
        createWatcher(vm, key, handler[i]);
      }
    } else {
      createWatcher(vm, key, handler);
    }
  }
}

function createWatcher (
  vm,
  keyOrFn,
  handler,
  options
) {
  if (isPlainObject(handler)) {
    options = handler;
    handler = handler.handler;
  }
  if (typeof handler === 'string') {
    handler = vm[handler];
  }
  return vm.$watch(keyOrFn, handler, options)
}

function stateMixin (Vue) {
  // flow somehow has problems with directly declared definition object
  // when using Object.defineProperty, so we have to procedurally build up
  // the object here.
  var dataDef = {};
  dataDef.get = function () { return this._data };
  var propsDef = {};
  propsDef.get = function () { return this._props };
  if (process.env.NODE_ENV !== 'production') {
    dataDef.set = function (newData) {
      warn(
        'Avoid replacing instance root $data. ' +
        'Use nested data properties instead.',
        this
      );
    };
    propsDef.set = function () {
      warn("$props is readonly.", this);
    };
  }
  Object.defineProperty(Vue.prototype, '$data', dataDef);
  Object.defineProperty(Vue.prototype, '$props', propsDef);

  Vue.prototype.$set = set;
  Vue.prototype.$delete = del;

  Vue.prototype.$watch = function (
    expOrFn,
    cb,
    options
  ) {
    var vm = this;
    if (isPlainObject(cb)) {
      return createWatcher(vm, expOrFn, cb, options)
    }
    options = options || {};
    options.user = true;
    var watcher = new Watcher(vm, expOrFn, cb, options);
    if (options.immediate) {
      cb.call(vm, watcher.value);
    }
    return function unwatchFn () {
      watcher.teardown();
    }
  };
}

/*  */

function initProvide (vm) {
  var provide = vm.$options.provide;
  if (provide) {
    vm._provided = typeof provide === 'function'
      ? provide.call(vm)
      : provide;
  }
}

function initInjections (vm) {
  var result = resolveInject(vm.$options.inject, vm);
  if (result) {
    observerState.shouldConvert = false;
    Object.keys(result).forEach(function (key) {
      /* istanbul ignore else */
      if (process.env.NODE_ENV !== 'production') {
        defineReactive$$1(vm, key, result[key], function () {
          warn(
            "Avoid mutating an injected value directly since the changes will be " +
            "overwritten whenever the provided component re-renders. " +
            "injection being mutated: \"" + key + "\"",
            vm
          );
        });
      } else {
        defineReactive$$1(vm, key, result[key]);
      }
    });
    observerState.shouldConvert = true;
  }
}

function resolveInject (inject, vm) {
  if (inject) {
    // inject is :any because flow is not smart enough to figure out cached
    var result = Object.create(null);
    var keys = hasSymbol
        ? Reflect.ownKeys(inject).filter(function (key) {
          /* istanbul ignore next */
          return Object.getOwnPropertyDescriptor(inject, key).enumerable
        })
        : Object.keys(inject);

    for (var i = 0; i < keys.length; i++) {
      var key = keys[i];
      var provideKey = inject[key];
      var source = vm;
      while (source) {
        if (source._provided && provideKey in source._provided) {
          result[key] = source._provided[provideKey];
          break
        }
        source = source.$parent;
      }
      if (process.env.NODE_ENV !== 'production' && !source) {
        warn(("Injection \"" + key + "\" not found"), vm);
      }
    }
    return result
  }
}

/*  */

function createFunctionalComponent (
  Ctor,
  propsData,
  data,
  context,
  children
) {
  var props = {};
  var propOptions = Ctor.options.props;
  if (isDef(propOptions)) {
    for (var key in propOptions) {
      props[key] = validateProp(key, propOptions, propsData || emptyObject);
    }
  } else {
    if (isDef(data.attrs)) { mergeProps(props, data.attrs); }
    if (isDef(data.props)) { mergeProps(props, data.props); }
  }
  // ensure the createElement function in functional components
  // gets a unique context - this is necessary for correct named slot check
  var _context = Object.create(context);
  var h = function (a, b, c, d) { return createElement(_context, a, b, c, d, true); };
  var vnode = Ctor.options.render.call(null, h, {
    data: data,
    props: props,
    children: children,
    parent: context,
    listeners: data.on || emptyObject,
    injections: resolveInject(Ctor.options.inject, context),
    slots: function () { return resolveSlots(children, context); }
  });
  if (vnode instanceof VNode) {
    vnode.functionalContext = context;
    vnode.functionalOptions = Ctor.options;
    if (data.slot) {
      (vnode.data || (vnode.data = {})).slot = data.slot;
    }
  }
  return vnode
}

function mergeProps (to, from) {
  for (var key in from) {
    to[camelize(key)] = from[key];
  }
}

/*  */

// hooks to be invoked on component VNodes during patch
var componentVNodeHooks = {
  init: function init (
    vnode,
    hydrating,
    parentElm,
    refElm
  ) {
    if (!vnode.componentInstance || vnode.componentInstance._isDestroyed) {
      var child = vnode.componentInstance = createComponentInstanceForVnode(
        vnode,
        activeInstance,
        parentElm,
        refElm
      );
      child.$mount(hydrating ? vnode.elm : undefined, hydrating);
    } else if (vnode.data.keepAlive) {
      // kept-alive components, treat as a patch
      var mountedNode = vnode; // work around flow
      componentVNodeHooks.prepatch(mountedNode, mountedNode);
    }
  },

  prepatch: function prepatch (oldVnode, vnode) {
    var options = vnode.componentOptions;
    var child = vnode.componentInstance = oldVnode.componentInstance;
    updateChildComponent(
      child,
      options.propsData, // updated props
      options.listeners, // updated listeners
      vnode, // new parent vnode
      options.children // new children
    );
  },

  insert: function insert (vnode) {
    var context = vnode.context;
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isMounted) {
      componentInstance._isMounted = true;
      callHook(componentInstance, 'mounted');
    }
    if (vnode.data.keepAlive) {
      if (context._isMounted) {
        // vue-router#1212
        // During updates, a kept-alive component's child components may
        // change, so directly walking the tree here may call activated hooks
        // on incorrect children. Instead we push them into a queue which will
        // be processed after the whole patch process ended.
        queueActivatedComponent(componentInstance);
      } else {
        activateChildComponent(componentInstance, true /* direct */);
      }
    }
  },

  destroy: function destroy (vnode) {
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isDestroyed) {
      if (!vnode.data.keepAlive) {
        componentInstance.$destroy();
      } else {
        deactivateChildComponent(componentInstance, true /* direct */);
      }
    }
  }
};

var hooksToMerge = Object.keys(componentVNodeHooks);

function createComponent (
  Ctor,
  data,
  context,
  children,
  tag
) {
  if (isUndef(Ctor)) {
    return
  }

  var baseCtor = context.$options._base;

  // plain options object: turn it into a constructor
  if (isObject(Ctor)) {
    Ctor = baseCtor.extend(Ctor);
  }

  // if at this stage it's not a constructor or an async component factory,
  // reject.
  if (typeof Ctor !== 'function') {
    if (process.env.NODE_ENV !== 'production') {
      warn(("Invalid Component definition: " + (String(Ctor))), context);
    }
    return
  }

  // async component
  var asyncFactory;
  if (isUndef(Ctor.cid)) {
    asyncFactory = Ctor;
    Ctor = resolveAsyncComponent(asyncFactory, baseCtor, context);
    if (Ctor === undefined) {
      // return a placeholder node for async component, which is rendered
      // as a comment node but preserves all the raw information for the node.
      // the information will be used for async server-rendering and hydration.
      return createAsyncPlaceholder(
        asyncFactory,
        data,
        context,
        children,
        tag
      )
    }
  }

  data = data || {};

  // resolve constructor options in case global mixins are applied after
  // component constructor creation
  resolveConstructorOptions(Ctor);

  // transform component v-model data into props & events
  if (isDef(data.model)) {
    transformModel(Ctor.options, data);
  }

  // extract props
  var propsData = extractPropsFromVNodeData(data, Ctor, tag);

  // functional component
  if (isTrue(Ctor.options.functional)) {
    return createFunctionalComponent(Ctor, propsData, data, context, children)
  }

  // extract listeners, since these needs to be treated as
  // child component listeners instead of DOM listeners
  var listeners = data.on;
  // replace with listeners with .native modifier
  // so it gets processed during parent component patch.
  data.on = data.nativeOn;

  if (isTrue(Ctor.options.abstract)) {
    // abstract components do not keep anything
    // other than props & listeners & slot

    // work around flow
    var slot = data.slot;
    data = {};
    if (slot) {
      data.slot = slot;
    }
  }

  // merge component management hooks onto the placeholder node
  mergeHooks(data);

  // return a placeholder vnode
  var name = Ctor.options.name || tag;
  var vnode = new VNode(
    ("vue-component-" + (Ctor.cid) + (name ? ("-" + name) : '')),
    data, undefined, undefined, undefined, context,
    { Ctor: Ctor, propsData: propsData, listeners: listeners, tag: tag, children: children },
    asyncFactory
  );
  return vnode
}

function createComponentInstanceForVnode (
  vnode, // we know it's MountedComponentVNode but flow doesn't
  parent, // activeInstance in lifecycle state
  parentElm,
  refElm
) {
  var vnodeComponentOptions = vnode.componentOptions;
  var options = {
    _isComponent: true,
    parent: parent,
    propsData: vnodeComponentOptions.propsData,
    _componentTag: vnodeComponentOptions.tag,
    _parentVnode: vnode,
    _parentListeners: vnodeComponentOptions.listeners,
    _renderChildren: vnodeComponentOptions.children,
    _parentElm: parentElm || null,
    _refElm: refElm || null
  };
  // check inline-template render functions
  var inlineTemplate = vnode.data.inlineTemplate;
  if (isDef(inlineTemplate)) {
    options.render = inlineTemplate.render;
    options.staticRenderFns = inlineTemplate.staticRenderFns;
  }
  return new vnodeComponentOptions.Ctor(options)
}

function mergeHooks (data) {
  if (!data.hook) {
    data.hook = {};
  }
  for (var i = 0; i < hooksToMerge.length; i++) {
    var key = hooksToMerge[i];
    var fromParent = data.hook[key];
    var ours = componentVNodeHooks[key];
    data.hook[key] = fromParent ? mergeHook$1(ours, fromParent) : ours;
  }
}

function mergeHook$1 (one, two) {
  return function (a, b, c, d) {
    one(a, b, c, d);
    two(a, b, c, d);
  }
}

// transform component v-model info (value and callback) into
// prop and event handler respectively.
function transformModel (options, data) {
  var prop = (options.model && options.model.prop) || 'value';
  var event = (options.model && options.model.event) || 'input';(data.props || (data.props = {}))[prop] = data.model.value;
  var on = data.on || (data.on = {});
  if (isDef(on[event])) {
    on[event] = [data.model.callback].concat(on[event]);
  } else {
    on[event] = data.model.callback;
  }
}

/*  */

var SIMPLE_NORMALIZE = 1;
var ALWAYS_NORMALIZE = 2;

// wrapper function for providing a more flexible interface
// without getting yelled at by flow
function createElement (
  context,
  tag,
  data,
  children,
  normalizationType,
  alwaysNormalize
) {
  if (Array.isArray(data) || isPrimitive(data)) {
    normalizationType = children;
    children = data;
    data = undefined;
  }
  if (isTrue(alwaysNormalize)) {
    normalizationType = ALWAYS_NORMALIZE;
  }
  return _createElement(context, tag, data, children, normalizationType)
}

function _createElement (
  context,
  tag,
  data,
  children,
  normalizationType
) {
  if (isDef(data) && isDef((data).__ob__)) {
    process.env.NODE_ENV !== 'production' && warn(
      "Avoid using observed data object as vnode data: " + (JSON.stringify(data)) + "\n" +
      'Always create fresh vnode data objects in each render!',
      context
    );
    return createEmptyVNode()
  }
  // object syntax in v-bind
  if (isDef(data) && isDef(data.is)) {
    tag = data.is;
  }
  if (!tag) {
    // in case of component :is set to falsy value
    return createEmptyVNode()
  }
  // warn against non-primitive key
  if (process.env.NODE_ENV !== 'production' &&
    isDef(data) && isDef(data.key) && !isPrimitive(data.key)
  ) {
    warn(
      'Avoid using non-primitive value as key, ' +
      'use string/number value instead.',
      context
    );
  }
  // support single function children as default scoped slot
  if (Array.isArray(children) &&
    typeof children[0] === 'function'
  ) {
    data = data || {};
    data.scopedSlots = { default: children[0] };
    children.length = 0;
  }
  if (normalizationType === ALWAYS_NORMALIZE) {
    children = normalizeChildren(children);
  } else if (normalizationType === SIMPLE_NORMALIZE) {
    children = simpleNormalizeChildren(children);
  }
  var vnode, ns;
  if (typeof tag === 'string') {
    var Ctor;
    ns = (context.$vnode && context.$vnode.ns) || config.getTagNamespace(tag);
    if (config.isReservedTag(tag)) {
      // platform built-in elements
      vnode = new VNode(
        config.parsePlatformTagName(tag), data, children,
        undefined, undefined, context
      );
    } else if (isDef(Ctor = resolveAsset(context.$options, 'components', tag))) {
      // component
      vnode = createComponent(Ctor, data, context, children, tag);
    } else {
      // unknown or unlisted namespaced elements
      // check at runtime because it may get assigned a namespace when its
      // parent normalizes children
      vnode = new VNode(
        tag, data, children,
        undefined, undefined, context
      );
    }
  } else {
    // direct component options / constructor
    vnode = createComponent(tag, data, context, children);
  }
  if (isDef(vnode)) {
    if (ns) { applyNS(vnode, ns); }
    return vnode
  } else {
    return createEmptyVNode()
  }
}

function applyNS (vnode, ns) {
  vnode.ns = ns;
  if (vnode.tag === 'foreignObject') {
    // use default namespace inside foreignObject
    return
  }
  if (isDef(vnode.children)) {
    for (var i = 0, l = vnode.children.length; i < l; i++) {
      var child = vnode.children[i];
      if (isDef(child.tag) && isUndef(child.ns)) {
        applyNS(child, ns);
      }
    }
  }
}

/*  */

/**
 * Runtime helper for rendering v-for lists.
 */
function renderList (
  val,
  render
) {
  var ret, i, l, keys, key;
  if (Array.isArray(val) || typeof val === 'string') {
    ret = new Array(val.length);
    for (i = 0, l = val.length; i < l; i++) {
      ret[i] = render(val[i], i);
    }
  } else if (typeof val === 'number') {
    ret = new Array(val);
    for (i = 0; i < val; i++) {
      ret[i] = render(i + 1, i);
    }
  } else if (isObject(val)) {
    keys = Object.keys(val);
    ret = new Array(keys.length);
    for (i = 0, l = keys.length; i < l; i++) {
      key = keys[i];
      ret[i] = render(val[key], key, i);
    }
  }
  if (isDef(ret)) {
    (ret)._isVList = true;
  }
  return ret
}

/*  */

/**
 * Runtime helper for rendering <slot>
 */
function renderSlot (
  name,
  fallback,
  props,
  bindObject
) {
  var scopedSlotFn = this.$scopedSlots[name];
  if (scopedSlotFn) { // scoped slot
    props = props || {};
    if (bindObject) {
      props = extend(extend({}, bindObject), props);
    }
    return scopedSlotFn(props) || fallback
  } else {
    var slotNodes = this.$slots[name];
    // warn duplicate slot usage
    if (slotNodes && process.env.NODE_ENV !== 'production') {
      slotNodes._rendered && warn(
        "Duplicate presence of slot \"" + name + "\" found in the same render tree " +
        "- this will likely cause render errors.",
        this
      );
      slotNodes._rendered = true;
    }
    return slotNodes || fallback
  }
}

/*  */

/**
 * Runtime helper for resolving filters
 */
function resolveFilter (id) {
  return resolveAsset(this.$options, 'filters', id, true) || identity
}

/*  */

/**
 * Runtime helper for checking keyCodes from config.
 */
function checkKeyCodes (
  eventKeyCode,
  key,
  builtInAlias
) {
  var keyCodes = config.keyCodes[key] || builtInAlias;
  if (Array.isArray(keyCodes)) {
    return keyCodes.indexOf(eventKeyCode) === -1
  } else {
    return keyCodes !== eventKeyCode
  }
}

/*  */

/**
 * Runtime helper for merging v-bind="object" into a VNode's data.
 */
function bindObjectProps (
  data,
  tag,
  value,
  asProp,
  isSync
) {
  if (value) {
    if (!isObject(value)) {
      process.env.NODE_ENV !== 'production' && warn(
        'v-bind without argument expects an Object or Array value',
        this
      );
    } else {
      if (Array.isArray(value)) {
        value = toObject(value);
      }
      var hash;
      var loop = function ( key ) {
        if (
          key === 'class' ||
          key === 'style' ||
          isReservedAttribute(key)
        ) {
          hash = data;
        } else {
          var type = data.attrs && data.attrs.type;
          hash = asProp || config.mustUseProp(tag, type, key)
            ? data.domProps || (data.domProps = {})
            : data.attrs || (data.attrs = {});
        }
        if (!(key in hash)) {
          hash[key] = value[key];

          if (isSync) {
            var on = data.on || (data.on = {});
            on[("update:" + key)] = function ($event) {
              value[key] = $event;
            };
          }
        }
      };

      for (var key in value) loop( key );
    }
  }
  return data
}

/*  */

/**
 * Runtime helper for rendering static trees.
 */
function renderStatic (
  index,
  isInFor
) {
  var tree = this._staticTrees[index];
  // if has already-rendered static tree and not inside v-for,
  // we can reuse the same tree by doing a shallow clone.
  if (tree && !isInFor) {
    return Array.isArray(tree)
      ? cloneVNodes(tree)
      : cloneVNode(tree)
  }
  // otherwise, render a fresh tree.
  tree = this._staticTrees[index] =
    this.$options.staticRenderFns[index].call(this._renderProxy);
  markStatic(tree, ("__static__" + index), false);
  return tree
}

/**
 * Runtime helper for v-once.
 * Effectively it means marking the node as static with a unique key.
 */
function markOnce (
  tree,
  index,
  key
) {
  markStatic(tree, ("__once__" + index + (key ? ("_" + key) : "")), true);
  return tree
}

function markStatic (
  tree,
  key,
  isOnce
) {
  if (Array.isArray(tree)) {
    for (var i = 0; i < tree.length; i++) {
      if (tree[i] && typeof tree[i] !== 'string') {
        markStaticNode(tree[i], (key + "_" + i), isOnce);
      }
    }
  } else {
    markStaticNode(tree, key, isOnce);
  }
}

function markStaticNode (node, key, isOnce) {
  node.isStatic = true;
  node.key = key;
  node.isOnce = isOnce;
}

/*  */

function bindObjectListeners (data, value) {
  if (value) {
    if (!isPlainObject(value)) {
      process.env.NODE_ENV !== 'production' && warn(
        'v-on without argument expects an Object value',
        this
      );
    } else {
      var on = data.on = data.on ? extend({}, data.on) : {};
      for (var key in value) {
        var existing = on[key];
        var ours = value[key];
        on[key] = existing ? [].concat(ours, existing) : ours;
      }
    }
  }
  return data
}

/*  */

function initRender (vm) {
  vm._vnode = null; // the root of the child tree
  vm._staticTrees = null;
  var parentVnode = vm.$vnode = vm.$options._parentVnode; // the placeholder node in parent tree
  var renderContext = parentVnode && parentVnode.context;
  vm.$slots = resolveSlots(vm.$options._renderChildren, renderContext);
  vm.$scopedSlots = emptyObject;
  // bind the createElement fn to this instance
  // so that we get proper render context inside it.
  // args order: tag, data, children, normalizationType, alwaysNormalize
  // internal version is used by render functions compiled from templates
  vm._c = function (a, b, c, d) { return createElement(vm, a, b, c, d, false); };
  // normalization is always applied for the public version, used in
  // user-written render functions.
  vm.$createElement = function (a, b, c, d) { return createElement(vm, a, b, c, d, true); };

  // $attrs & $listeners are exposed for easier HOC creation.
  // they need to be reactive so that HOCs using them are always updated
  var parentData = parentVnode && parentVnode.data;

  /* istanbul ignore else */
  if (process.env.NODE_ENV !== 'production') {
    defineReactive$$1(vm, '$attrs', parentData && parentData.attrs || emptyObject, function () {
      !isUpdatingChildComponent && warn("$attrs is readonly.", vm);
    }, true);
    defineReactive$$1(vm, '$listeners', vm.$options._parentListeners || emptyObject, function () {
      !isUpdatingChildComponent && warn("$listeners is readonly.", vm);
    }, true);
  } else {
    defineReactive$$1(vm, '$attrs', parentData && parentData.attrs || emptyObject, null, true);
    defineReactive$$1(vm, '$listeners', vm.$options._parentListeners || emptyObject, null, true);
  }
}

function renderMixin (Vue) {
  Vue.prototype.$nextTick = function (fn) {
    return nextTick(fn, this)
  };

  Vue.prototype._render = function () {
    var vm = this;
    var ref = vm.$options;
    var render = ref.render;
    var staticRenderFns = ref.staticRenderFns;
    var _parentVnode = ref._parentVnode;

    if (vm._isMounted) {
      // if the parent didn't update, the slot nodes will be the ones from
      // last render. They need to be cloned to ensure "freshness" for this render.
      for (var key in vm.$slots) {
        var slot = vm.$slots[key];
        if (slot._rendered) {
          vm.$slots[key] = cloneVNodes(slot, true /* deep */);
        }
      }
    }

    vm.$scopedSlots = (_parentVnode && _parentVnode.data.scopedSlots) || emptyObject;

    if (staticRenderFns && !vm._staticTrees) {
      vm._staticTrees = [];
    }
    // set parent vnode. this allows render functions to have access
    // to the data on the placeholder node.
    vm.$vnode = _parentVnode;
    // render self
    var vnode;
    try {
      vnode = render.call(vm._renderProxy, vm.$createElement);
    } catch (e) {
      handleError(e, vm, "render function");
      // return error render result,
      // or previous vnode to prevent render error causing blank component
      /* istanbul ignore else */
      if (process.env.NODE_ENV !== 'production') {
        vnode = vm.$options.renderError
          ? vm.$options.renderError.call(vm._renderProxy, vm.$createElement, e)
          : vm._vnode;
      } else {
        vnode = vm._vnode;
      }
    }
    // return empty vnode in case the render function errored out
    if (!(vnode instanceof VNode)) {
      if (process.env.NODE_ENV !== 'production' && Array.isArray(vnode)) {
        warn(
          'Multiple root nodes returned from render function. Render function ' +
          'should return a single root node.',
          vm
        );
      }
      vnode = createEmptyVNode();
    }
    // set parent
    vnode.parent = _parentVnode;
    return vnode
  };

  // internal render helpers.
  // these are exposed on the instance prototype to reduce generated render
  // code size.
  Vue.prototype._o = markOnce;
  Vue.prototype._n = toNumber;
  Vue.prototype._s = toString;
  Vue.prototype._l = renderList;
  Vue.prototype._t = renderSlot;
  Vue.prototype._q = looseEqual;
  Vue.prototype._i = looseIndexOf;
  Vue.prototype._m = renderStatic;
  Vue.prototype._f = resolveFilter;
  Vue.prototype._k = checkKeyCodes;
  Vue.prototype._b = bindObjectProps;
  Vue.prototype._v = createTextVNode;
  Vue.prototype._e = createEmptyVNode;
  Vue.prototype._u = resolveScopedSlots;
  Vue.prototype._g = bindObjectListeners;
}

/*  */

var uid$1 = 0;

function initMixin (Vue) {
  Vue.prototype._init = function (options) {
    var vm = this;
    // a uid
    vm._uid = uid$1++;

    var startTag, endTag;
    /* istanbul ignore if */
    if (process.env.NODE_ENV !== 'production' && config.performance && mark) {
      startTag = "vue-perf-init:" + (vm._uid);
      endTag = "vue-perf-end:" + (vm._uid);
      mark(startTag);
    }

    // a flag to avoid this being observed
    vm._isVue = true;
    // merge options
    if (options && options._isComponent) {
      // optimize internal component instantiation
      // since dynamic options merging is pretty slow, and none of the
      // internal component options needs special treatment.
      initInternalComponent(vm, options);
    } else {
      vm.$options = mergeOptions(
        resolveConstructorOptions(vm.constructor),
        options || {},
        vm
      );
    }
    /* istanbul ignore else */
    if (process.env.NODE_ENV !== 'production') {
      initProxy(vm);
    } else {
      vm._renderProxy = vm;
    }
    // expose real self
    vm._self = vm;
    initLifecycle(vm);
    initEvents(vm);
    initRender(vm);
    callHook(vm, 'beforeCreate');
    initInjections(vm); // resolve injections before data/props
    initState(vm);
    initProvide(vm); // resolve provide after data/props
    callHook(vm, 'created');

    /* istanbul ignore if */
    if (process.env.NODE_ENV !== 'production' && config.performance && mark) {
      vm._name = formatComponentName(vm, false);
      mark(endTag);
      measure(((vm._name) + " init"), startTag, endTag);
    }

    if (vm.$options.el) {
      vm.$mount(vm.$options.el);
    }
  };
}

function initInternalComponent (vm, options) {
  var opts = vm.$options = Object.create(vm.constructor.options);
  // doing this because it's faster than dynamic enumeration.
  opts.parent = options.parent;
  opts.propsData = options.propsData;
  opts._parentVnode = options._parentVnode;
  opts._parentListeners = options._parentListeners;
  opts._renderChildren = options._renderChildren;
  opts._componentTag = options._componentTag;
  opts._parentElm = options._parentElm;
  opts._refElm = options._refElm;
  if (options.render) {
    opts.render = options.render;
    opts.staticRenderFns = options.staticRenderFns;
  }
}

function resolveConstructorOptions (Ctor) {
  var options = Ctor.options;
  if (Ctor.super) {
    var superOptions = resolveConstructorOptions(Ctor.super);
    var cachedSuperOptions = Ctor.superOptions;
    if (superOptions !== cachedSuperOptions) {
      // super option changed,
      // need to resolve new options.
      Ctor.superOptions = superOptions;
      // check if there are any late-modified/attached options (#4976)
      var modifiedOptions = resolveModifiedOptions(Ctor);
      // update base extend options
      if (modifiedOptions) {
        extend(Ctor.extendOptions, modifiedOptions);
      }
      options = Ctor.options = mergeOptions(superOptions, Ctor.extendOptions);
      if (options.name) {
        options.components[options.name] = Ctor;
      }
    }
  }
  return options
}

function resolveModifiedOptions (Ctor) {
  var modified;
  var latest = Ctor.options;
  var extended = Ctor.extendOptions;
  var sealed = Ctor.sealedOptions;
  for (var key in latest) {
    if (latest[key] !== sealed[key]) {
      if (!modified) { modified = {}; }
      modified[key] = dedupe(latest[key], extended[key], sealed[key]);
    }
  }
  return modified
}

function dedupe (latest, extended, sealed) {
  // compare latest and sealed to ensure lifecycle hooks won't be duplicated
  // between merges
  if (Array.isArray(latest)) {
    var res = [];
    sealed = Array.isArray(sealed) ? sealed : [sealed];
    extended = Array.isArray(extended) ? extended : [extended];
    for (var i = 0; i < latest.length; i++) {
      // push original options and not sealed options to exclude duplicated options
      if (extended.indexOf(latest[i]) >= 0 || sealed.indexOf(latest[i]) < 0) {
        res.push(latest[i]);
      }
    }
    return res
  } else {
    return latest
  }
}

function Vue$3 (options) {
  if (process.env.NODE_ENV !== 'production' &&
    !(this instanceof Vue$3)
  ) {
    warn('Vue is a constructor and should be called with the `new` keyword');
  }
  this._init(options);
}

initMixin(Vue$3);
stateMixin(Vue$3);
eventsMixin(Vue$3);
lifecycleMixin(Vue$3);
renderMixin(Vue$3);

/*  */

function initUse (Vue) {
  Vue.use = function (plugin) {
    var installedPlugins = (this._installedPlugins || (this._installedPlugins = []));
    if (installedPlugins.indexOf(plugin) > -1) {
      return this
    }

    // additional parameters
    var args = toArray(arguments, 1);
    args.unshift(this);
    if (typeof plugin.install === 'function') {
      plugin.install.apply(plugin, args);
    } else if (typeof plugin === 'function') {
      plugin.apply(null, args);
    }
    installedPlugins.push(plugin);
    return this
  };
}

/*  */

function initMixin$1 (Vue) {
  Vue.mixin = function (mixin) {
    this.options = mergeOptions(this.options, mixin);
    return this
  };
}

/*  */

function initExtend (Vue) {
  /**
   * Each instance constructor, including Vue, has a unique
   * cid. This enables us to create wrapped "child
   * constructors" for prototypal inheritance and cache them.
   */
  Vue.cid = 0;
  var cid = 1;

  /**
   * Class inheritance
   */
  Vue.extend = function (extendOptions) {
    extendOptions = extendOptions || {};
    var Super = this;
    var SuperId = Super.cid;
    var cachedCtors = extendOptions._Ctor || (extendOptions._Ctor = {});
    if (cachedCtors[SuperId]) {
      return cachedCtors[SuperId]
    }

    var name = extendOptions.name || Super.options.name;
    if (process.env.NODE_ENV !== 'production') {
      if (!/^[a-zA-Z][\w-]*$/.test(name)) {
        warn(
          'Invalid component name: "' + name + '". Component names ' +
          'can only contain alphanumeric characters and the hyphen, ' +
          'and must start with a letter.'
        );
      }
    }

    var Sub = function VueComponent (options) {
      this._init(options);
    };
    Sub.prototype = Object.create(Super.prototype);
    Sub.prototype.constructor = Sub;
    Sub.cid = cid++;
    Sub.options = mergeOptions(
      Super.options,
      extendOptions
    );
    Sub['super'] = Super;

    // For props and computed properties, we define the proxy getters on
    // the Vue instances at extension time, on the extended prototype. This
    // avoids Object.defineProperty calls for each instance created.
    if (Sub.options.props) {
      initProps$1(Sub);
    }
    if (Sub.options.computed) {
      initComputed$1(Sub);
    }

    // allow further extension/mixin/plugin usage
    Sub.extend = Super.extend;
    Sub.mixin = Super.mixin;
    Sub.use = Super.use;

    // create asset registers, so extended classes
    // can have their private assets too.
    ASSET_TYPES.forEach(function (type) {
      Sub[type] = Super[type];
    });
    // enable recursive self-lookup
    if (name) {
      Sub.options.components[name] = Sub;
    }

    // keep a reference to the super options at extension time.
    // later at instantiation we can check if Super's options have
    // been updated.
    Sub.superOptions = Super.options;
    Sub.extendOptions = extendOptions;
    Sub.sealedOptions = extend({}, Sub.options);

    // cache constructor
    cachedCtors[SuperId] = Sub;
    return Sub
  };
}

function initProps$1 (Comp) {
  var props = Comp.options.props;
  for (var key in props) {
    proxy(Comp.prototype, "_props", key);
  }
}

function initComputed$1 (Comp) {
  var computed = Comp.options.computed;
  for (var key in computed) {
    defineComputed(Comp.prototype, key, computed[key]);
  }
}

/*  */

function initAssetRegisters (Vue) {
  /**
   * Create asset registration methods.
   */
  ASSET_TYPES.forEach(function (type) {
    Vue[type] = function (
      id,
      definition
    ) {
      if (!definition) {
        return this.options[type + 's'][id]
      } else {
        /* istanbul ignore if */
        if (process.env.NODE_ENV !== 'production') {
          if (type === 'component' && config.isReservedTag(id)) {
            warn(
              'Do not use built-in or reserved HTML elements as component ' +
              'id: ' + id
            );
          }
        }
        if (type === 'component' && isPlainObject(definition)) {
          definition.name = definition.name || id;
          definition = this.options._base.extend(definition);
        }
        if (type === 'directive' && typeof definition === 'function') {
          definition = { bind: definition, update: definition };
        }
        this.options[type + 's'][id] = definition;
        return definition
      }
    };
  });
}

/*  */

var patternTypes = [String, RegExp, Array];

function getComponentName (opts) {
  return opts && (opts.Ctor.options.name || opts.tag)
}

function matches (pattern, name) {
  if (Array.isArray(pattern)) {
    return pattern.indexOf(name) > -1
  } else if (typeof pattern === 'string') {
    return pattern.split(',').indexOf(name) > -1
  } else if (isRegExp(pattern)) {
    return pattern.test(name)
  }
  /* istanbul ignore next */
  return false
}

function pruneCache (cache, current, filter) {
  for (var key in cache) {
    var cachedNode = cache[key];
    if (cachedNode) {
      var name = getComponentName(cachedNode.componentOptions);
      if (name && !filter(name)) {
        if (cachedNode !== current) {
          pruneCacheEntry(cachedNode);
        }
        cache[key] = null;
      }
    }
  }
}

function pruneCacheEntry (vnode) {
  if (vnode) {
    vnode.componentInstance.$destroy();
  }
}

var KeepAlive = {
  name: 'keep-alive',
  abstract: true,

  props: {
    include: patternTypes,
    exclude: patternTypes
  },

  created: function created () {
    this.cache = Object.create(null);
  },

  destroyed: function destroyed () {
    var this$1 = this;

    for (var key in this$1.cache) {
      pruneCacheEntry(this$1.cache[key]);
    }
  },

  watch: {
    include: function include (val) {
      pruneCache(this.cache, this._vnode, function (name) { return matches(val, name); });
    },
    exclude: function exclude (val) {
      pruneCache(this.cache, this._vnode, function (name) { return !matches(val, name); });
    }
  },

  render: function render () {
    var vnode = getFirstComponentChild(this.$slots.default);
    var componentOptions = vnode && vnode.componentOptions;
    if (componentOptions) {
      // check pattern
      var name = getComponentName(componentOptions);
      if (name && (
        (this.include && !matches(this.include, name)) ||
        (this.exclude && matches(this.exclude, name))
      )) {
        return vnode
      }
      var key = vnode.key == null
        // same constructor may get registered as different local components
        // so cid alone is not enough (#3269)
        ? componentOptions.Ctor.cid + (componentOptions.tag ? ("::" + (componentOptions.tag)) : '')
        : vnode.key;
      if (this.cache[key]) {
        vnode.componentInstance = this.cache[key].componentInstance;
      } else {
        this.cache[key] = vnode;
      }
      vnode.data.keepAlive = true;
    }
    return vnode
  }
};

var builtInComponents = {
  KeepAlive: KeepAlive
};

/*  */

function initGlobalAPI (Vue) {
  // config
  var configDef = {};
  configDef.get = function () { return config; };
  if (process.env.NODE_ENV !== 'production') {
    configDef.set = function () {
      warn(
        'Do not replace the Vue.config object, set individual fields instead.'
      );
    };
  }
  Object.defineProperty(Vue, 'config', configDef);

  // exposed util methods.
  // NOTE: these are not considered part of the public API - avoid relying on
  // them unless you are aware of the risk.
  Vue.util = {
    warn: warn,
    extend: extend,
    mergeOptions: mergeOptions,
    defineReactive: defineReactive$$1
  };

  Vue.set = set;
  Vue.delete = del;
  Vue.nextTick = nextTick;

  Vue.options = Object.create(null);
  ASSET_TYPES.forEach(function (type) {
    Vue.options[type + 's'] = Object.create(null);
  });

  // this is used to identify the "base" constructor to extend all plain-object
  // components with in Weex's multi-instance scenarios.
  Vue.options._base = Vue;

  extend(Vue.options.components, builtInComponents);

  initUse(Vue);
  initMixin$1(Vue);
  initExtend(Vue);
  initAssetRegisters(Vue);
}

initGlobalAPI(Vue$3);

Object.defineProperty(Vue$3.prototype, '$isServer', {
  get: isServerRendering
});

Object.defineProperty(Vue$3.prototype, '$ssrContext', {
  get: function get () {
    /* istanbul ignore next */
    return this.$vnode && this.$vnode.ssrContext
  }
});

Vue$3.version = '2.4.4';

/*  */

// these are reserved for web because they are directly compiled away
// during template compilation
var isReservedAttr = makeMap('style,class');

// attributes that should be using props for binding
var acceptValue = makeMap('input,textarea,option,select,progress');
var mustUseProp = function (tag, type, attr) {
  return (
    (attr === 'value' && acceptValue(tag)) && type !== 'button' ||
    (attr === 'selected' && tag === 'option') ||
    (attr === 'checked' && tag === 'input') ||
    (attr === 'muted' && tag === 'video')
  )
};

var isEnumeratedAttr = makeMap('contenteditable,draggable,spellcheck');

var isBooleanAttr = makeMap(
  'allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,' +
  'default,defaultchecked,defaultmuted,defaultselected,defer,disabled,' +
  'enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,' +
  'muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,' +
  'required,reversed,scoped,seamless,selected,sortable,translate,' +
  'truespeed,typemustmatch,visible'
);

var xlinkNS = 'http://www.w3.org/1999/xlink';

var isXlink = function (name) {
  return name.charAt(5) === ':' && name.slice(0, 5) === 'xlink'
};

var getXlinkProp = function (name) {
  return isXlink(name) ? name.slice(6, name.length) : ''
};

var isFalsyAttrValue = function (val) {
  return val == null || val === false
};

/*  */

function genClassForVnode (vnode) {
  var data = vnode.data;
  var parentNode = vnode;
  var childNode = vnode;
  while (isDef(childNode.componentInstance)) {
    childNode = childNode.componentInstance._vnode;
    if (childNode.data) {
      data = mergeClassData(childNode.data, data);
    }
  }
  while (isDef(parentNode = parentNode.parent)) {
    if (parentNode.data) {
      data = mergeClassData(data, parentNode.data);
    }
  }
  return renderClass(data.staticClass, data.class)
}

function mergeClassData (child, parent) {
  return {
    staticClass: concat(child.staticClass, parent.staticClass),
    class: isDef(child.class)
      ? [child.class, parent.class]
      : parent.class
  }
}

function renderClass (
  staticClass,
  dynamicClass
) {
  if (isDef(staticClass) || isDef(dynamicClass)) {
    return concat(staticClass, stringifyClass(dynamicClass))
  }
  /* istanbul ignore next */
  return ''
}

function concat (a, b) {
  return a ? b ? (a + ' ' + b) : a : (b || '')
}

function stringifyClass (value) {
  if (Array.isArray(value)) {
    return stringifyArray(value)
  }
  if (isObject(value)) {
    return stringifyObject(value)
  }
  if (typeof value === 'string') {
    return value
  }
  /* istanbul ignore next */
  return ''
}

function stringifyArray (value) {
  var res = '';
  var stringified;
  for (var i = 0, l = value.length; i < l; i++) {
    if (isDef(stringified = stringifyClass(value[i])) && stringified !== '') {
      if (res) { res += ' '; }
      res += stringified;
    }
  }
  return res
}

function stringifyObject (value) {
  var res = '';
  for (var key in value) {
    if (value[key]) {
      if (res) { res += ' '; }
      res += key;
    }
  }
  return res
}

/*  */

var namespaceMap = {
  svg: 'http://www.w3.org/2000/svg',
  math: 'http://www.w3.org/1998/Math/MathML'
};

var isHTMLTag = makeMap(
  'html,body,base,head,link,meta,style,title,' +
  'address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,' +
  'div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,' +
  'a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,' +
  's,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,' +
  'embed,object,param,source,canvas,script,noscript,del,ins,' +
  'caption,col,colgroup,table,thead,tbody,td,th,tr,' +
  'button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,' +
  'output,progress,select,textarea,' +
  'details,dialog,menu,menuitem,summary,' +
  'content,element,shadow,template,blockquote,iframe,tfoot'
);

// this map is intentionally selective, only covering SVG elements that may
// contain child elements.
var isSVG = makeMap(
  'svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font-face,' +
  'foreignObject,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,' +
  'polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view',
  true
);

var isPreTag = function (tag) { return tag === 'pre'; };

var isReservedTag = function (tag) {
  return isHTMLTag(tag) || isSVG(tag)
};

function getTagNamespace (tag) {
  if (isSVG(tag)) {
    return 'svg'
  }
  // basic support for MathML
  // note it doesn't support other MathML elements being component roots
  if (tag === 'math') {
    return 'math'
  }
}

var unknownElementCache = Object.create(null);
function isUnknownElement (tag) {
  /* istanbul ignore if */
  if (!inBrowser) {
    return true
  }
  if (isReservedTag(tag)) {
    return false
  }
  tag = tag.toLowerCase();
  /* istanbul ignore if */
  if (unknownElementCache[tag] != null) {
    return unknownElementCache[tag]
  }
  var el = document.createElement(tag);
  if (tag.indexOf('-') > -1) {
    // http://stackoverflow.com/a/28210364/1070244
    return (unknownElementCache[tag] = (
      el.constructor === window.HTMLUnknownElement ||
      el.constructor === window.HTMLElement
    ))
  } else {
    return (unknownElementCache[tag] = /HTMLUnknownElement/.test(el.toString()))
  }
}

var isTextInputType = makeMap('text,number,password,search,email,tel,url');

/*  */

/**
 * Query an element selector if it's not an element already.
 */
function query (el) {
  if (typeof el === 'string') {
    var selected = document.querySelector(el);
    if (!selected) {
      process.env.NODE_ENV !== 'production' && warn(
        'Cannot find element: ' + el
      );
      return document.createElement('div')
    }
    return selected
  } else {
    return el
  }
}

/*  */

function createElement$1 (tagName, vnode) {
  var elm = document.createElement(tagName);
  if (tagName !== 'select') {
    return elm
  }
  // false or null will remove the attribute but undefined will not
  if (vnode.data && vnode.data.attrs && vnode.data.attrs.multiple !== undefined) {
    elm.setAttribute('multiple', 'multiple');
  }
  return elm
}

function createElementNS (namespace, tagName) {
  return document.createElementNS(namespaceMap[namespace], tagName)
}

function createTextNode (text) {
  return document.createTextNode(text)
}

function createComment (text) {
  return document.createComment(text)
}

function insertBefore (parentNode, newNode, referenceNode) {
  parentNode.insertBefore(newNode, referenceNode);
}

function removeChild (node, child) {
  node.removeChild(child);
}

function appendChild (node, child) {
  node.appendChild(child);
}

function parentNode (node) {
  return node.parentNode
}

function nextSibling (node) {
  return node.nextSibling
}

function tagName (node) {
  return node.tagName
}

function setTextContent (node, text) {
  node.textContent = text;
}

function setAttribute (node, key, val) {
  node.setAttribute(key, val);
}


var nodeOps = Object.freeze({
	createElement: createElement$1,
	createElementNS: createElementNS,
	createTextNode: createTextNode,
	createComment: createComment,
	insertBefore: insertBefore,
	removeChild: removeChild,
	appendChild: appendChild,
	parentNode: parentNode,
	nextSibling: nextSibling,
	tagName: tagName,
	setTextContent: setTextContent,
	setAttribute: setAttribute
});

/*  */

var ref = {
  create: function create (_, vnode) {
    registerRef(vnode);
  },
  update: function update (oldVnode, vnode) {
    if (oldVnode.data.ref !== vnode.data.ref) {
      registerRef(oldVnode, true);
      registerRef(vnode);
    }
  },
  destroy: function destroy (vnode) {
    registerRef(vnode, true);
  }
};

function registerRef (vnode, isRemoval) {
  var key = vnode.data.ref;
  if (!key) { return }

  var vm = vnode.context;
  var ref = vnode.componentInstance || vnode.elm;
  var refs = vm.$refs;
  if (isRemoval) {
    if (Array.isArray(refs[key])) {
      remove(refs[key], ref);
    } else if (refs[key] === ref) {
      refs[key] = undefined;
    }
  } else {
    if (vnode.data.refInFor) {
      if (!Array.isArray(refs[key])) {
        refs[key] = [ref];
      } else if (refs[key].indexOf(ref) < 0) {
        // $flow-disable-line
        refs[key].push(ref);
      }
    } else {
      refs[key] = ref;
    }
  }
}

/**
 * Virtual DOM patching algorithm based on Snabbdom by
 * Simon Friis Vindum (@paldepind)
 * Licensed under the MIT License
 * https://github.com/paldepind/snabbdom/blob/master/LICENSE
 *
 * modified by Evan You (@yyx990803)
 *
 * Not type-checking this because this file is perf-critical and the cost
 * of making flow understand it is not worth it.
 */

var emptyNode = new VNode('', {}, []);

var hooks = ['create', 'activate', 'update', 'remove', 'destroy'];

function sameVnode (a, b) {
  return (
    a.key === b.key && (
      (
        a.tag === b.tag &&
        a.isComment === b.isComment &&
        isDef(a.data) === isDef(b.data) &&
        sameInputType(a, b)
      ) || (
        isTrue(a.isAsyncPlaceholder) &&
        a.asyncFactory === b.asyncFactory &&
        isUndef(b.asyncFactory.error)
      )
    )
  )
}

function sameInputType (a, b) {
  if (a.tag !== 'input') { return true }
  var i;
  var typeA = isDef(i = a.data) && isDef(i = i.attrs) && i.type;
  var typeB = isDef(i = b.data) && isDef(i = i.attrs) && i.type;
  return typeA === typeB || isTextInputType(typeA) && isTextInputType(typeB)
}

function createKeyToOldIdx (children, beginIdx, endIdx) {
  var i, key;
  var map = {};
  for (i = beginIdx; i <= endIdx; ++i) {
    key = children[i].key;
    if (isDef(key)) { map[key] = i; }
  }
  return map
}

function createPatchFunction (backend) {
  var i, j;
  var cbs = {};

  var modules = backend.modules;
  var nodeOps = backend.nodeOps;

  for (i = 0; i < hooks.length; ++i) {
    cbs[hooks[i]] = [];
    for (j = 0; j < modules.length; ++j) {
      if (isDef(modules[j][hooks[i]])) {
        cbs[hooks[i]].push(modules[j][hooks[i]]);
      }
    }
  }

  function emptyNodeAt (elm) {
    return new VNode(nodeOps.tagName(elm).toLowerCase(), {}, [], undefined, elm)
  }

  function createRmCb (childElm, listeners) {
    function remove$$1 () {
      if (--remove$$1.listeners === 0) {
        removeNode(childElm);
      }
    }
    remove$$1.listeners = listeners;
    return remove$$1
  }

  function removeNode (el) {
    var parent = nodeOps.parentNode(el);
    // element may have already been removed due to v-html / v-text
    if (isDef(parent)) {
      nodeOps.removeChild(parent, el);
    }
  }

  var inPre = 0;
  function createElm (vnode, insertedVnodeQueue, parentElm, refElm, nested) {
    vnode.isRootInsert = !nested; // for transition enter check
    if (createComponent(vnode, insertedVnodeQueue, parentElm, refElm)) {
      return
    }

    var data = vnode.data;
    var children = vnode.children;
    var tag = vnode.tag;
    if (isDef(tag)) {
      if (process.env.NODE_ENV !== 'production') {
        if (data && data.pre) {
          inPre++;
        }
        if (
          !inPre &&
          !vnode.ns &&
          !(config.ignoredElements.length && config.ignoredElements.indexOf(tag) > -1) &&
          config.isUnknownElement(tag)
        ) {
          warn(
            'Unknown custom element: <' + tag + '> - did you ' +
            'register the component correctly? For recursive components, ' +
            'make sure to provide the "name" option.',
            vnode.context
          );
        }
      }
      vnode.elm = vnode.ns
        ? nodeOps.createElementNS(vnode.ns, tag)
        : nodeOps.createElement(tag, vnode);
      setScope(vnode);

      /* istanbul ignore if */
      {
        createChildren(vnode, children, insertedVnodeQueue);
        if (isDef(data)) {
          invokeCreateHooks(vnode, insertedVnodeQueue);
        }
        insert(parentElm, vnode.elm, refElm);
      }

      if (process.env.NODE_ENV !== 'production' && data && data.pre) {
        inPre--;
      }
    } else if (isTrue(vnode.isComment)) {
      vnode.elm = nodeOps.createComment(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    } else {
      vnode.elm = nodeOps.createTextNode(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    }
  }

  function createComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i = vnode.data;
    if (isDef(i)) {
      var isReactivated = isDef(vnode.componentInstance) && i.keepAlive;
      if (isDef(i = i.hook) && isDef(i = i.init)) {
        i(vnode, false /* hydrating */, parentElm, refElm);
      }
      // after calling the init hook, if the vnode is a child component
      // it should've created a child instance and mounted it. the child
      // component also has set the placeholder vnode's elm.
      // in that case we can just return the element and be done.
      if (isDef(vnode.componentInstance)) {
        initComponent(vnode, insertedVnodeQueue);
        if (isTrue(isReactivated)) {
          reactivateComponent(vnode, insertedVnodeQueue, parentElm, refElm);
        }
        return true
      }
    }
  }

  function initComponent (vnode, insertedVnodeQueue) {
    if (isDef(vnode.data.pendingInsert)) {
      insertedVnodeQueue.push.apply(insertedVnodeQueue, vnode.data.pendingInsert);
      vnode.data.pendingInsert = null;
    }
    vnode.elm = vnode.componentInstance.$el;
    if (isPatchable(vnode)) {
      invokeCreateHooks(vnode, insertedVnodeQueue);
      setScope(vnode);
    } else {
      // empty component root.
      // skip all element-related modules except for ref (#3455)
      registerRef(vnode);
      // make sure to invoke the insert hook
      insertedVnodeQueue.push(vnode);
    }
  }

  function reactivateComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i;
    // hack for #4339: a reactivated component with inner transition
    // does not trigger because the inner node's created hooks are not called
    // again. It's not ideal to involve module-specific logic in here but
    // there doesn't seem to be a better way to do it.
    var innerNode = vnode;
    while (innerNode.componentInstance) {
      innerNode = innerNode.componentInstance._vnode;
      if (isDef(i = innerNode.data) && isDef(i = i.transition)) {
        for (i = 0; i < cbs.activate.length; ++i) {
          cbs.activate[i](emptyNode, innerNode);
        }
        insertedVnodeQueue.push(innerNode);
        break
      }
    }
    // unlike a newly created component,
    // a reactivated keep-alive component doesn't insert itself
    insert(parentElm, vnode.elm, refElm);
  }

  function insert (parent, elm, ref$$1) {
    if (isDef(parent)) {
      if (isDef(ref$$1)) {
        if (ref$$1.parentNode === parent) {
          nodeOps.insertBefore(parent, elm, ref$$1);
        }
      } else {
        nodeOps.appendChild(parent, elm);
      }
    }
  }

  function createChildren (vnode, children, insertedVnodeQueue) {
    if (Array.isArray(children)) {
      for (var i = 0; i < children.length; ++i) {
        createElm(children[i], insertedVnodeQueue, vnode.elm, null, true);
      }
    } else if (isPrimitive(vnode.text)) {
      nodeOps.appendChild(vnode.elm, nodeOps.createTextNode(vnode.text));
    }
  }

  function isPatchable (vnode) {
    while (vnode.componentInstance) {
      vnode = vnode.componentInstance._vnode;
    }
    return isDef(vnode.tag)
  }

  function invokeCreateHooks (vnode, insertedVnodeQueue) {
    for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
      cbs.create[i$1](emptyNode, vnode);
    }
    i = vnode.data.hook; // Reuse variable
    if (isDef(i)) {
      if (isDef(i.create)) { i.create(emptyNode, vnode); }
      if (isDef(i.insert)) { insertedVnodeQueue.push(vnode); }
    }
  }

  // set scope id attribute for scoped CSS.
  // this is implemented as a special case to avoid the overhead
  // of going through the normal attribute patching process.
  function setScope (vnode) {
    var i;
    var ancestor = vnode;
    while (ancestor) {
      if (isDef(i = ancestor.context) && isDef(i = i.$options._scopeId)) {
        nodeOps.setAttribute(vnode.elm, i, '');
      }
      ancestor = ancestor.parent;
    }
    // for slot content they should also get the scopeId from the host instance.
    if (isDef(i = activeInstance) &&
      i !== vnode.context &&
      isDef(i = i.$options._scopeId)
    ) {
      nodeOps.setAttribute(vnode.elm, i, '');
    }
  }

  function addVnodes (parentElm, refElm, vnodes, startIdx, endIdx, insertedVnodeQueue) {
    for (; startIdx <= endIdx; ++startIdx) {
      createElm(vnodes[startIdx], insertedVnodeQueue, parentElm, refElm);
    }
  }

  function invokeDestroyHook (vnode) {
    var i, j;
    var data = vnode.data;
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.destroy)) { i(vnode); }
      for (i = 0; i < cbs.destroy.length; ++i) { cbs.destroy[i](vnode); }
    }
    if (isDef(i = vnode.children)) {
      for (j = 0; j < vnode.children.length; ++j) {
        invokeDestroyHook(vnode.children[j]);
      }
    }
  }

  function removeVnodes (parentElm, vnodes, startIdx, endIdx) {
    for (; startIdx <= endIdx; ++startIdx) {
      var ch = vnodes[startIdx];
      if (isDef(ch)) {
        if (isDef(ch.tag)) {
          removeAndInvokeRemoveHook(ch);
          invokeDestroyHook(ch);
        } else { // Text node
          removeNode(ch.elm);
        }
      }
    }
  }

  function removeAndInvokeRemoveHook (vnode, rm) {
    if (isDef(rm) || isDef(vnode.data)) {
      var i;
      var listeners = cbs.remove.length + 1;
      if (isDef(rm)) {
        // we have a recursively passed down rm callback
        // increase the listeners count
        rm.listeners += listeners;
      } else {
        // directly removing
        rm = createRmCb(vnode.elm, listeners);
      }
      // recursively invoke hooks on child component root node
      if (isDef(i = vnode.componentInstance) && isDef(i = i._vnode) && isDef(i.data)) {
        removeAndInvokeRemoveHook(i, rm);
      }
      for (i = 0; i < cbs.remove.length; ++i) {
        cbs.remove[i](vnode, rm);
      }
      if (isDef(i = vnode.data.hook) && isDef(i = i.remove)) {
        i(vnode, rm);
      } else {
        rm();
      }
    } else {
      removeNode(vnode.elm);
    }
  }

  function updateChildren (parentElm, oldCh, newCh, insertedVnodeQueue, removeOnly) {
    var oldStartIdx = 0;
    var newStartIdx = 0;
    var oldEndIdx = oldCh.length - 1;
    var oldStartVnode = oldCh[0];
    var oldEndVnode = oldCh[oldEndIdx];
    var newEndIdx = newCh.length - 1;
    var newStartVnode = newCh[0];
    var newEndVnode = newCh[newEndIdx];
    var oldKeyToIdx, idxInOld, elmToMove, refElm;

    // removeOnly is a special flag used only by <transition-group>
    // to ensure removed elements stay in correct relative positions
    // during leaving transitions
    var canMove = !removeOnly;

    while (oldStartIdx <= oldEndIdx && newStartIdx <= newEndIdx) {
      if (isUndef(oldStartVnode)) {
        oldStartVnode = oldCh[++oldStartIdx]; // Vnode has been moved left
      } else if (isUndef(oldEndVnode)) {
        oldEndVnode = oldCh[--oldEndIdx];
      } else if (sameVnode(oldStartVnode, newStartVnode)) {
        patchVnode(oldStartVnode, newStartVnode, insertedVnodeQueue);
        oldStartVnode = oldCh[++oldStartIdx];
        newStartVnode = newCh[++newStartIdx];
      } else if (sameVnode(oldEndVnode, newEndVnode)) {
        patchVnode(oldEndVnode, newEndVnode, insertedVnodeQueue);
        oldEndVnode = oldCh[--oldEndIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldStartVnode, newEndVnode)) { // Vnode moved right
        patchVnode(oldStartVnode, newEndVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldStartVnode.elm, nodeOps.nextSibling(oldEndVnode.elm));
        oldStartVnode = oldCh[++oldStartIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldEndVnode, newStartVnode)) { // Vnode moved left
        patchVnode(oldEndVnode, newStartVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldEndVnode.elm, oldStartVnode.elm);
        oldEndVnode = oldCh[--oldEndIdx];
        newStartVnode = newCh[++newStartIdx];
      } else {
        if (isUndef(oldKeyToIdx)) { oldKeyToIdx = createKeyToOldIdx(oldCh, oldStartIdx, oldEndIdx); }
        idxInOld = isDef(newStartVnode.key)
          ? oldKeyToIdx[newStartVnode.key]
          : findIdxInOld(newStartVnode, oldCh, oldStartIdx, oldEndIdx);
        if (isUndef(idxInOld)) { // New element
          createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm);
        } else {
          elmToMove = oldCh[idxInOld];
          /* istanbul ignore if */
          if (process.env.NODE_ENV !== 'production' && !elmToMove) {
            warn(
              'It seems there are duplicate keys that is causing an update error. ' +
              'Make sure each v-for item has a unique key.'
            );
          }
          if (sameVnode(elmToMove, newStartVnode)) {
            patchVnode(elmToMove, newStartVnode, insertedVnodeQueue);
            oldCh[idxInOld] = undefined;
            canMove && nodeOps.insertBefore(parentElm, elmToMove.elm, oldStartVnode.elm);
          } else {
            // same key but different element. treat as new element
            createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm);
          }
        }
        newStartVnode = newCh[++newStartIdx];
      }
    }
    if (oldStartIdx > oldEndIdx) {
      refElm = isUndef(newCh[newEndIdx + 1]) ? null : newCh[newEndIdx + 1].elm;
      addVnodes(parentElm, refElm, newCh, newStartIdx, newEndIdx, insertedVnodeQueue);
    } else if (newStartIdx > newEndIdx) {
      removeVnodes(parentElm, oldCh, oldStartIdx, oldEndIdx);
    }
  }

  function findIdxInOld (node, oldCh, start, end) {
    for (var i = start; i < end; i++) {
      var c = oldCh[i];
      if (isDef(c) && sameVnode(node, c)) { return i }
    }
  }

  function patchVnode (oldVnode, vnode, insertedVnodeQueue, removeOnly) {
    if (oldVnode === vnode) {
      return
    }

    var elm = vnode.elm = oldVnode.elm;

    if (isTrue(oldVnode.isAsyncPlaceholder)) {
      if (isDef(vnode.asyncFactory.resolved)) {
        hydrate(oldVnode.elm, vnode, insertedVnodeQueue);
      } else {
        vnode.isAsyncPlaceholder = true;
      }
      return
    }

    // reuse element for static trees.
    // note we only do this if the vnode is cloned -
    // if the new node is not cloned it means the render functions have been
    // reset by the hot-reload-api and we need to do a proper re-render.
    if (isTrue(vnode.isStatic) &&
      isTrue(oldVnode.isStatic) &&
      vnode.key === oldVnode.key &&
      (isTrue(vnode.isCloned) || isTrue(vnode.isOnce))
    ) {
      vnode.componentInstance = oldVnode.componentInstance;
      return
    }

    var i;
    var data = vnode.data;
    if (isDef(data) && isDef(i = data.hook) && isDef(i = i.prepatch)) {
      i(oldVnode, vnode);
    }

    var oldCh = oldVnode.children;
    var ch = vnode.children;
    if (isDef(data) && isPatchable(vnode)) {
      for (i = 0; i < cbs.update.length; ++i) { cbs.update[i](oldVnode, vnode); }
      if (isDef(i = data.hook) && isDef(i = i.update)) { i(oldVnode, vnode); }
    }
    if (isUndef(vnode.text)) {
      if (isDef(oldCh) && isDef(ch)) {
        if (oldCh !== ch) { updateChildren(elm, oldCh, ch, insertedVnodeQueue, removeOnly); }
      } else if (isDef(ch)) {
        if (isDef(oldVnode.text)) { nodeOps.setTextContent(elm, ''); }
        addVnodes(elm, null, ch, 0, ch.length - 1, insertedVnodeQueue);
      } else if (isDef(oldCh)) {
        removeVnodes(elm, oldCh, 0, oldCh.length - 1);
      } else if (isDef(oldVnode.text)) {
        nodeOps.setTextContent(elm, '');
      }
    } else if (oldVnode.text !== vnode.text) {
      nodeOps.setTextContent(elm, vnode.text);
    }
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.postpatch)) { i(oldVnode, vnode); }
    }
  }

  function invokeInsertHook (vnode, queue, initial) {
    // delay insert hooks for component root nodes, invoke them after the
    // element is really inserted
    if (isTrue(initial) && isDef(vnode.parent)) {
      vnode.parent.data.pendingInsert = queue;
    } else {
      for (var i = 0; i < queue.length; ++i) {
        queue[i].data.hook.insert(queue[i]);
      }
    }
  }

  var bailed = false;
  // list of modules that can skip create hook during hydration because they
  // are already rendered on the client or has no need for initialization
  var isRenderedModule = makeMap('attrs,style,class,staticClass,staticStyle,key');

  // Note: this is a browser-only function so we can assume elms are DOM nodes.
  function hydrate (elm, vnode, insertedVnodeQueue) {
    if (isTrue(vnode.isComment) && isDef(vnode.asyncFactory)) {
      vnode.elm = elm;
      vnode.isAsyncPlaceholder = true;
      return true
    }
    if (process.env.NODE_ENV !== 'production') {
      if (!assertNodeMatch(elm, vnode)) {
        return false
      }
    }
    vnode.elm = elm;
    var tag = vnode.tag;
    var data = vnode.data;
    var children = vnode.children;
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.init)) { i(vnode, true /* hydrating */); }
      if (isDef(i = vnode.componentInstance)) {
        // child component. it should have hydrated its own tree.
        initComponent(vnode, insertedVnodeQueue);
        return true
      }
    }
    if (isDef(tag)) {
      if (isDef(children)) {
        // empty element, allow client to pick up and populate children
        if (!elm.hasChildNodes()) {
          createChildren(vnode, children, insertedVnodeQueue);
        } else {
          // v-html and domProps: innerHTML
          if (isDef(i = data) && isDef(i = i.domProps) && isDef(i = i.innerHTML)) {
            if (i !== elm.innerHTML) {
              /* istanbul ignore if */
              if (process.env.NODE_ENV !== 'production' &&
                typeof console !== 'undefined' &&
                !bailed
              ) {
                bailed = true;
                console.warn('Parent: ', elm);
                console.warn('server innerHTML: ', i);
                console.warn('client innerHTML: ', elm.innerHTML);
              }
              return false
            }
          } else {
            // iterate and compare children lists
            var childrenMatch = true;
            var childNode = elm.firstChild;
            for (var i$1 = 0; i$1 < children.length; i$1++) {
              if (!childNode || !hydrate(childNode, children[i$1], insertedVnodeQueue)) {
                childrenMatch = false;
                break
              }
              childNode = childNode.nextSibling;
            }
            // if childNode is not null, it means the actual childNodes list is
            // longer than the virtual children list.
            if (!childrenMatch || childNode) {
              /* istanbul ignore if */
              if (process.env.NODE_ENV !== 'production' &&
                typeof console !== 'undefined' &&
                !bailed
              ) {
                bailed = true;
                console.warn('Parent: ', elm);
                console.warn('Mismatching childNodes vs. VNodes: ', elm.childNodes, children);
              }
              return false
            }
          }
        }
      }
      if (isDef(data)) {
        for (var key in data) {
          if (!isRenderedModule(key)) {
            invokeCreateHooks(vnode, insertedVnodeQueue);
            break
          }
        }
      }
    } else if (elm.data !== vnode.text) {
      elm.data = vnode.text;
    }
    return true
  }

  function assertNodeMatch (node, vnode) {
    if (isDef(vnode.tag)) {
      return (
        vnode.tag.indexOf('vue-component') === 0 ||
        vnode.tag.toLowerCase() === (node.tagName && node.tagName.toLowerCase())
      )
    } else {
      return node.nodeType === (vnode.isComment ? 8 : 3)
    }
  }

  return function patch (oldVnode, vnode, hydrating, removeOnly, parentElm, refElm) {
    if (isUndef(vnode)) {
      if (isDef(oldVnode)) { invokeDestroyHook(oldVnode); }
      return
    }

    var isInitialPatch = false;
    var insertedVnodeQueue = [];

    if (isUndef(oldVnode)) {
      // empty mount (likely as component), create new root element
      isInitialPatch = true;
      createElm(vnode, insertedVnodeQueue, parentElm, refElm);
    } else {
      var isRealElement = isDef(oldVnode.nodeType);
      if (!isRealElement && sameVnode(oldVnode, vnode)) {
        // patch existing root node
        patchVnode(oldVnode, vnode, insertedVnodeQueue, removeOnly);
      } else {
        if (isRealElement) {
          // mounting to a real element
          // check if this is server-rendered content and if we can perform
          // a successful hydration.
          if (oldVnode.nodeType === 1 && oldVnode.hasAttribute(SSR_ATTR)) {
            oldVnode.removeAttribute(SSR_ATTR);
            hydrating = true;
          }
          if (isTrue(hydrating)) {
            if (hydrate(oldVnode, vnode, insertedVnodeQueue)) {
              invokeInsertHook(vnode, insertedVnodeQueue, true);
              return oldVnode
            } else if (process.env.NODE_ENV !== 'production') {
              warn(
                'The client-side rendered virtual DOM tree is not matching ' +
                'server-rendered content. This is likely caused by incorrect ' +
                'HTML markup, for example nesting block-level elements inside ' +
                '<p>, or missing <tbody>. Bailing hydration and performing ' +
                'full client-side render.'
              );
            }
          }
          // either not server-rendered, or hydration failed.
          // create an empty node and replace it
          oldVnode = emptyNodeAt(oldVnode);
        }
        // replacing existing element
        var oldElm = oldVnode.elm;
        var parentElm$1 = nodeOps.parentNode(oldElm);
        createElm(
          vnode,
          insertedVnodeQueue,
          // extremely rare edge case: do not insert if old element is in a
          // leaving transition. Only happens when combining transition +
          // keep-alive + HOCs. (#4590)
          oldElm._leaveCb ? null : parentElm$1,
          nodeOps.nextSibling(oldElm)
        );

        if (isDef(vnode.parent)) {
          // component root element replaced.
          // update parent placeholder node element, recursively
          var ancestor = vnode.parent;
          var patchable = isPatchable(vnode);
          while (ancestor) {
            for (var i = 0; i < cbs.destroy.length; ++i) {
              cbs.destroy[i](ancestor);
            }
            ancestor.elm = vnode.elm;
            if (patchable) {
              for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
                cbs.create[i$1](emptyNode, ancestor);
              }
              // #6513
              // invoke insert hooks that may have been merged by create hooks.
              // e.g. for directives that uses the "inserted" hook.
              var insert = ancestor.data.hook.insert;
              if (insert.merged) {
                // start at index 1 to avoid re-invoking component mounted hook
                for (var i$2 = 1; i$2 < insert.fns.length; i$2++) {
                  insert.fns[i$2]();
                }
              }
            }
            ancestor = ancestor.parent;
          }
        }

        if (isDef(parentElm$1)) {
          removeVnodes(parentElm$1, [oldVnode], 0, 0);
        } else if (isDef(oldVnode.tag)) {
          invokeDestroyHook(oldVnode);
        }
      }
    }

    invokeInsertHook(vnode, insertedVnodeQueue, isInitialPatch);
    return vnode.elm
  }
}

/*  */

var directives = {
  create: updateDirectives,
  update: updateDirectives,
  destroy: function unbindDirectives (vnode) {
    updateDirectives(vnode, emptyNode);
  }
};

function updateDirectives (oldVnode, vnode) {
  if (oldVnode.data.directives || vnode.data.directives) {
    _update(oldVnode, vnode);
  }
}

function _update (oldVnode, vnode) {
  var isCreate = oldVnode === emptyNode;
  var isDestroy = vnode === emptyNode;
  var oldDirs = normalizeDirectives$1(oldVnode.data.directives, oldVnode.context);
  var newDirs = normalizeDirectives$1(vnode.data.directives, vnode.context);

  var dirsWithInsert = [];
  var dirsWithPostpatch = [];

  var key, oldDir, dir;
  for (key in newDirs) {
    oldDir = oldDirs[key];
    dir = newDirs[key];
    if (!oldDir) {
      // new directive, bind
      callHook$1(dir, 'bind', vnode, oldVnode);
      if (dir.def && dir.def.inserted) {
        dirsWithInsert.push(dir);
      }
    } else {
      // existing directive, update
      dir.oldValue = oldDir.value;
      callHook$1(dir, 'update', vnode, oldVnode);
      if (dir.def && dir.def.componentUpdated) {
        dirsWithPostpatch.push(dir);
      }
    }
  }

  if (dirsWithInsert.length) {
    var callInsert = function () {
      for (var i = 0; i < dirsWithInsert.length; i++) {
        callHook$1(dirsWithInsert[i], 'inserted', vnode, oldVnode);
      }
    };
    if (isCreate) {
      mergeVNodeHook(vnode.data.hook || (vnode.data.hook = {}), 'insert', callInsert);
    } else {
      callInsert();
    }
  }

  if (dirsWithPostpatch.length) {
    mergeVNodeHook(vnode.data.hook || (vnode.data.hook = {}), 'postpatch', function () {
      for (var i = 0; i < dirsWithPostpatch.length; i++) {
        callHook$1(dirsWithPostpatch[i], 'componentUpdated', vnode, oldVnode);
      }
    });
  }

  if (!isCreate) {
    for (key in oldDirs) {
      if (!newDirs[key]) {
        // no longer present, unbind
        callHook$1(oldDirs[key], 'unbind', oldVnode, oldVnode, isDestroy);
      }
    }
  }
}

var emptyModifiers = Object.create(null);

function normalizeDirectives$1 (
  dirs,
  vm
) {
  var res = Object.create(null);
  if (!dirs) {
    return res
  }
  var i, dir;
  for (i = 0; i < dirs.length; i++) {
    dir = dirs[i];
    if (!dir.modifiers) {
      dir.modifiers = emptyModifiers;
    }
    res[getRawDirName(dir)] = dir;
    dir.def = resolveAsset(vm.$options, 'directives', dir.name, true);
  }
  return res
}

function getRawDirName (dir) {
  return dir.rawName || ((dir.name) + "." + (Object.keys(dir.modifiers || {}).join('.')))
}

function callHook$1 (dir, hook, vnode, oldVnode, isDestroy) {
  var fn = dir.def && dir.def[hook];
  if (fn) {
    try {
      fn(vnode.elm, dir, vnode, oldVnode, isDestroy);
    } catch (e) {
      handleError(e, vnode.context, ("directive " + (dir.name) + " " + hook + " hook"));
    }
  }
}

var baseModules = [
  ref,
  directives
];

/*  */

function updateAttrs (oldVnode, vnode) {
  var opts = vnode.componentOptions;
  if (isDef(opts) && opts.Ctor.options.inheritAttrs === false) {
    return
  }
  if (isUndef(oldVnode.data.attrs) && isUndef(vnode.data.attrs)) {
    return
  }
  var key, cur, old;
  var elm = vnode.elm;
  var oldAttrs = oldVnode.data.attrs || {};
  var attrs = vnode.data.attrs || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(attrs.__ob__)) {
    attrs = vnode.data.attrs = extend({}, attrs);
  }

  for (key in attrs) {
    cur = attrs[key];
    old = oldAttrs[key];
    if (old !== cur) {
      setAttr(elm, key, cur);
    }
  }
  // #4391: in IE9, setting type can reset value for input[type=radio]
  /* istanbul ignore if */
  if (isIE9 && attrs.value !== oldAttrs.value) {
    setAttr(elm, 'value', attrs.value);
  }
  for (key in oldAttrs) {
    if (isUndef(attrs[key])) {
      if (isXlink(key)) {
        elm.removeAttributeNS(xlinkNS, getXlinkProp(key));
      } else if (!isEnumeratedAttr(key)) {
        elm.removeAttribute(key);
      }
    }
  }
}

function setAttr (el, key, value) {
  if (isBooleanAttr(key)) {
    // set attribute for blank value
    // e.g. <option disabled>Select one</option>
    if (isFalsyAttrValue(value)) {
      el.removeAttribute(key);
    } else {
      // technically allowfullscreen is a boolean attribute for <iframe>,
      // but Flash expects a value of "true" when used on <embed> tag
      value = key === 'allowfullscreen' && el.tagName === 'EMBED'
        ? 'true'
        : key;
      el.setAttribute(key, value);
    }
  } else if (isEnumeratedAttr(key)) {
    el.setAttribute(key, isFalsyAttrValue(value) || value === 'false' ? 'false' : 'true');
  } else if (isXlink(key)) {
    if (isFalsyAttrValue(value)) {
      el.removeAttributeNS(xlinkNS, getXlinkProp(key));
    } else {
      el.setAttributeNS(xlinkNS, key, value);
    }
  } else {
    if (isFalsyAttrValue(value)) {
      el.removeAttribute(key);
    } else {
      el.setAttribute(key, value);
    }
  }
}

var attrs = {
  create: updateAttrs,
  update: updateAttrs
};

/*  */

function updateClass (oldVnode, vnode) {
  var el = vnode.elm;
  var data = vnode.data;
  var oldData = oldVnode.data;
  if (
    isUndef(data.staticClass) &&
    isUndef(data.class) && (
      isUndef(oldData) || (
        isUndef(oldData.staticClass) &&
        isUndef(oldData.class)
      )
    )
  ) {
    return
  }

  var cls = genClassForVnode(vnode);

  // handle transition classes
  var transitionClass = el._transitionClasses;
  if (isDef(transitionClass)) {
    cls = concat(cls, stringifyClass(transitionClass));
  }

  // set the class
  if (cls !== el._prevClass) {
    el.setAttribute('class', cls);
    el._prevClass = cls;
  }
}

var klass = {
  create: updateClass,
  update: updateClass
};

/*  */

var validDivisionCharRE = /[\w).+\-_$\]]/;

function parseFilters (exp) {
  var inSingle = false;
  var inDouble = false;
  var inTemplateString = false;
  var inRegex = false;
  var curly = 0;
  var square = 0;
  var paren = 0;
  var lastFilterIndex = 0;
  var c, prev, i, expression, filters;

  for (i = 0; i < exp.length; i++) {
    prev = c;
    c = exp.charCodeAt(i);
    if (inSingle) {
      if (c === 0x27 && prev !== 0x5C) { inSingle = false; }
    } else if (inDouble) {
      if (c === 0x22 && prev !== 0x5C) { inDouble = false; }
    } else if (inTemplateString) {
      if (c === 0x60 && prev !== 0x5C) { inTemplateString = false; }
    } else if (inRegex) {
      if (c === 0x2f && prev !== 0x5C) { inRegex = false; }
    } else if (
      c === 0x7C && // pipe
      exp.charCodeAt(i + 1) !== 0x7C &&
      exp.charCodeAt(i - 1) !== 0x7C &&
      !curly && !square && !paren
    ) {
      if (expression === undefined) {
        // first filter, end of expression
        lastFilterIndex = i + 1;
        expression = exp.slice(0, i).trim();
      } else {
        pushFilter();
      }
    } else {
      switch (c) {
        case 0x22: inDouble = true; break         // "
        case 0x27: inSingle = true; break         // '
        case 0x60: inTemplateString = true; break // `
        case 0x28: paren++; break                 // (
        case 0x29: paren--; break                 // )
        case 0x5B: square++; break                // [
        case 0x5D: square--; break                // ]
        case 0x7B: curly++; break                 // {
        case 0x7D: curly--; break                 // }
      }
      if (c === 0x2f) { // /
        var j = i - 1;
        var p = (void 0);
        // find first non-whitespace prev char
        for (; j >= 0; j--) {
          p = exp.charAt(j);
          if (p !== ' ') { break }
        }
        if (!p || !validDivisionCharRE.test(p)) {
          inRegex = true;
        }
      }
    }
  }

  if (expression === undefined) {
    expression = exp.slice(0, i).trim();
  } else if (lastFilterIndex !== 0) {
    pushFilter();
  }

  function pushFilter () {
    (filters || (filters = [])).push(exp.slice(lastFilterIndex, i).trim());
    lastFilterIndex = i + 1;
  }

  if (filters) {
    for (i = 0; i < filters.length; i++) {
      expression = wrapFilter(expression, filters[i]);
    }
  }

  return expression
}

function wrapFilter (exp, filter) {
  var i = filter.indexOf('(');
  if (i < 0) {
    // _f: resolveFilter
    return ("_f(\"" + filter + "\")(" + exp + ")")
  } else {
    var name = filter.slice(0, i);
    var args = filter.slice(i + 1);
    return ("_f(\"" + name + "\")(" + exp + "," + args)
  }
}

/*  */

function baseWarn (msg) {
  console.error(("[Vue compiler]: " + msg));
}

function pluckModuleFunction (
  modules,
  key
) {
  return modules
    ? modules.map(function (m) { return m[key]; }).filter(function (_) { return _; })
    : []
}

function addProp (el, name, value) {
  (el.props || (el.props = [])).push({ name: name, value: value });
}

function addAttr (el, name, value) {
  (el.attrs || (el.attrs = [])).push({ name: name, value: value });
}

function addDirective (
  el,
  name,
  rawName,
  value,
  arg,
  modifiers
) {
  (el.directives || (el.directives = [])).push({ name: name, rawName: rawName, value: value, arg: arg, modifiers: modifiers });
}

function addHandler (
  el,
  name,
  value,
  modifiers,
  important,
  warn
) {
  // warn prevent and passive modifier
  /* istanbul ignore if */
  if (
    process.env.NODE_ENV !== 'production' && warn &&
    modifiers && modifiers.prevent && modifiers.passive
  ) {
    warn(
      'passive and prevent can\'t be used together. ' +
      'Passive handler can\'t prevent default event.'
    );
  }
  // check capture modifier
  if (modifiers && modifiers.capture) {
    delete modifiers.capture;
    name = '!' + name; // mark the event as captured
  }
  if (modifiers && modifiers.once) {
    delete modifiers.once;
    name = '~' + name; // mark the event as once
  }
  /* istanbul ignore if */
  if (modifiers && modifiers.passive) {
    delete modifiers.passive;
    name = '&' + name; // mark the event as passive
  }
  var events;
  if (modifiers && modifiers.native) {
    delete modifiers.native;
    events = el.nativeEvents || (el.nativeEvents = {});
  } else {
    events = el.events || (el.events = {});
  }
  var newHandler = { value: value, modifiers: modifiers };
  var handlers = events[name];
  /* istanbul ignore if */
  if (Array.isArray(handlers)) {
    important ? handlers.unshift(newHandler) : handlers.push(newHandler);
  } else if (handlers) {
    events[name] = important ? [newHandler, handlers] : [handlers, newHandler];
  } else {
    events[name] = newHandler;
  }
}

function getBindingAttr (
  el,
  name,
  getStatic
) {
  var dynamicValue =
    getAndRemoveAttr(el, ':' + name) ||
    getAndRemoveAttr(el, 'v-bind:' + name);
  if (dynamicValue != null) {
    return parseFilters(dynamicValue)
  } else if (getStatic !== false) {
    var staticValue = getAndRemoveAttr(el, name);
    if (staticValue != null) {
      return JSON.stringify(staticValue)
    }
  }
}

function getAndRemoveAttr (el, name) {
  var val;
  if ((val = el.attrsMap[name]) != null) {
    var list = el.attrsList;
    for (var i = 0, l = list.length; i < l; i++) {
      if (list[i].name === name) {
        list.splice(i, 1);
        break
      }
    }
  }
  return val
}

/*  */

/**
 * Cross-platform code generation for component v-model
 */
function genComponentModel (
  el,
  value,
  modifiers
) {
  var ref = modifiers || {};
  var number = ref.number;
  var trim = ref.trim;

  var baseValueExpression = '$$v';
  var valueExpression = baseValueExpression;
  if (trim) {
    valueExpression =
      "(typeof " + baseValueExpression + " === 'string'" +
        "? " + baseValueExpression + ".trim()" +
        ": " + baseValueExpression + ")";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }
  var assignment = genAssignmentCode(value, valueExpression);

  el.model = {
    value: ("(" + value + ")"),
    expression: ("\"" + value + "\""),
    callback: ("function (" + baseValueExpression + ") {" + assignment + "}")
  };
}

/**
 * Cross-platform codegen helper for generating v-model value assignment code.
 */
function genAssignmentCode (
  value,
  assignment
) {
  var modelRs = parseModel(value);
  if (modelRs.idx === null) {
    return (value + "=" + assignment)
  } else {
    return ("$set(" + (modelRs.exp) + ", " + (modelRs.idx) + ", " + assignment + ")")
  }
}

/**
 * parse directive model to do the array update transform. a[idx] = val => $$a.splice($$idx, 1, val)
 *
 * for loop possible cases:
 *
 * - test
 * - test[idx]
 * - test[test1[idx]]
 * - test["a"][idx]
 * - xxx.test[a[a].test1[idx]]
 * - test.xxx.a["asa"][test1[idx]]
 *
 */

var len;
var str;
var chr;
var index$1;
var expressionPos;
var expressionEndPos;

function parseModel (val) {
  str = val;
  len = str.length;
  index$1 = expressionPos = expressionEndPos = 0;

  if (val.indexOf('[') < 0 || val.lastIndexOf(']') < len - 1) {
    return {
      exp: val,
      idx: null
    }
  }

  while (!eof()) {
    chr = next();
    /* istanbul ignore if */
    if (isStringStart(chr)) {
      parseString(chr);
    } else if (chr === 0x5B) {
      parseBracket(chr);
    }
  }

  return {
    exp: val.substring(0, expressionPos),
    idx: val.substring(expressionPos + 1, expressionEndPos)
  }
}

function next () {
  return str.charCodeAt(++index$1)
}

function eof () {
  return index$1 >= len
}

function isStringStart (chr) {
  return chr === 0x22 || chr === 0x27
}

function parseBracket (chr) {
  var inBracket = 1;
  expressionPos = index$1;
  while (!eof()) {
    chr = next();
    if (isStringStart(chr)) {
      parseString(chr);
      continue
    }
    if (chr === 0x5B) { inBracket++; }
    if (chr === 0x5D) { inBracket--; }
    if (inBracket === 0) {
      expressionEndPos = index$1;
      break
    }
  }
}

function parseString (chr) {
  var stringQuote = chr;
  while (!eof()) {
    chr = next();
    if (chr === stringQuote) {
      break
    }
  }
}

/*  */

var warn$1;

// in some cases, the event used has to be determined at runtime
// so we used some reserved tokens during compile.
var RANGE_TOKEN = '__r';
var CHECKBOX_RADIO_TOKEN = '__c';

function model (
  el,
  dir,
  _warn
) {
  warn$1 = _warn;
  var value = dir.value;
  var modifiers = dir.modifiers;
  var tag = el.tag;
  var type = el.attrsMap.type;

  if (process.env.NODE_ENV !== 'production') {
    var dynamicType = el.attrsMap['v-bind:type'] || el.attrsMap[':type'];
    if (tag === 'input' && dynamicType) {
      warn$1(
        "<input :type=\"" + dynamicType + "\" v-model=\"" + value + "\">:\n" +
        "v-model does not support dynamic input types. Use v-if branches instead."
      );
    }
    // inputs with type="file" are read only and setting the input's
    // value will throw an error.
    if (tag === 'input' && type === 'file') {
      warn$1(
        "<" + (el.tag) + " v-model=\"" + value + "\" type=\"file\">:\n" +
        "File inputs are read only. Use a v-on:change listener instead."
      );
    }
  }

  if (el.component) {
    genComponentModel(el, value, modifiers);
    // component v-model doesn't need extra runtime
    return false
  } else if (tag === 'select') {
    genSelect(el, value, modifiers);
  } else if (tag === 'input' && type === 'checkbox') {
    genCheckboxModel(el, value, modifiers);
  } else if (tag === 'input' && type === 'radio') {
    genRadioModel(el, value, modifiers);
  } else if (tag === 'input' || tag === 'textarea') {
    genDefaultModel(el, value, modifiers);
  } else if (!config.isReservedTag(tag)) {
    genComponentModel(el, value, modifiers);
    // component v-model doesn't need extra runtime
    return false
  } else if (process.env.NODE_ENV !== 'production') {
    warn$1(
      "<" + (el.tag) + " v-model=\"" + value + "\">: " +
      "v-model is not supported on this element type. " +
      'If you are working with contenteditable, it\'s recommended to ' +
      'wrap a library dedicated for that purpose inside a custom component.'
    );
  }

  // ensure runtime directive metadata
  return true
}

function genCheckboxModel (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  var trueValueBinding = getBindingAttr(el, 'true-value') || 'true';
  var falseValueBinding = getBindingAttr(el, 'false-value') || 'false';
  addProp(el, 'checked',
    "Array.isArray(" + value + ")" +
      "?_i(" + value + "," + valueBinding + ")>-1" + (
        trueValueBinding === 'true'
          ? (":(" + value + ")")
          : (":_q(" + value + "," + trueValueBinding + ")")
      )
  );
  addHandler(el, CHECKBOX_RADIO_TOKEN,
    "var $$a=" + value + "," +
        '$$el=$event.target,' +
        "$$c=$$el.checked?(" + trueValueBinding + "):(" + falseValueBinding + ");" +
    'if(Array.isArray($$a)){' +
      "var $$v=" + (number ? '_n(' + valueBinding + ')' : valueBinding) + "," +
          '$$i=_i($$a,$$v);' +
      "if($$el.checked){$$i<0&&(" + value + "=$$a.concat([$$v]))}" +
      "else{$$i>-1&&(" + value + "=$$a.slice(0,$$i).concat($$a.slice($$i+1)))}" +
    "}else{" + (genAssignmentCode(value, '$$c')) + "}",
    null, true
  );
}

function genRadioModel (
    el,
    value,
    modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  valueBinding = number ? ("_n(" + valueBinding + ")") : valueBinding;
  addProp(el, 'checked', ("_q(" + value + "," + valueBinding + ")"));
  addHandler(el, CHECKBOX_RADIO_TOKEN, genAssignmentCode(value, valueBinding), null, true);
}

function genSelect (
    el,
    value,
    modifiers
) {
  var number = modifiers && modifiers.number;
  var selectedVal = "Array.prototype.filter" +
    ".call($event.target.options,function(o){return o.selected})" +
    ".map(function(o){var val = \"_value\" in o ? o._value : o.value;" +
    "return " + (number ? '_n(val)' : 'val') + "})";

  var assignment = '$event.target.multiple ? $$selectedVal : $$selectedVal[0]';
  var code = "var $$selectedVal = " + selectedVal + ";";
  code = code + " " + (genAssignmentCode(value, assignment));
  addHandler(el, 'change', code, null, true);
}

function genDefaultModel (
  el,
  value,
  modifiers
) {
  var type = el.attrsMap.type;
  var ref = modifiers || {};
  var lazy = ref.lazy;
  var number = ref.number;
  var trim = ref.trim;
  var needCompositionGuard = !lazy && type !== 'range';
  var event = lazy
    ? 'change'
    : type === 'range'
      ? RANGE_TOKEN
      : 'input';

  var valueExpression = '$event.target.value';
  if (trim) {
    valueExpression = "$event.target.value.trim()";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }

  var code = genAssignmentCode(value, valueExpression);
  if (needCompositionGuard) {
    code = "if($event.target.composing)return;" + code;
  }

  addProp(el, 'value', ("(" + value + ")"));
  addHandler(el, event, code, null, true);
  if (trim || number) {
    addHandler(el, 'blur', '$forceUpdate()');
  }
}

/*  */

// normalize v-model event tokens that can only be determined at runtime.
// it's important to place the event as the first in the array because
// the whole point is ensuring the v-model callback gets called before
// user-attached handlers.
function normalizeEvents (on) {
  var event;
  /* istanbul ignore if */
  if (isDef(on[RANGE_TOKEN])) {
    // IE input[type=range] only supports `change` event
    event = isIE ? 'change' : 'input';
    on[event] = [].concat(on[RANGE_TOKEN], on[event] || []);
    delete on[RANGE_TOKEN];
  }
  if (isDef(on[CHECKBOX_RADIO_TOKEN])) {
    // Chrome fires microtasks in between click/change, leads to #4521
    event = isChrome ? 'click' : 'change';
    on[event] = [].concat(on[CHECKBOX_RADIO_TOKEN], on[event] || []);
    delete on[CHECKBOX_RADIO_TOKEN];
  }
}

var target$1;

function add$1 (
  event,
  handler,
  once$$1,
  capture,
  passive
) {
  if (once$$1) {
    var oldHandler = handler;
    var _target = target$1; // save current target element in closure
    handler = function (ev) {
      var res = arguments.length === 1
        ? oldHandler(ev)
        : oldHandler.apply(null, arguments);
      if (res !== null) {
        remove$2(event, handler, capture, _target);
      }
    };
  }
  target$1.addEventListener(
    event,
    handler,
    supportsPassive
      ? { capture: capture, passive: passive }
      : capture
  );
}

function remove$2 (
  event,
  handler,
  capture,
  _target
) {
  (_target || target$1).removeEventListener(event, handler, capture);
}

function updateDOMListeners (oldVnode, vnode) {
  if (isUndef(oldVnode.data.on) && isUndef(vnode.data.on)) {
    return
  }
  var on = vnode.data.on || {};
  var oldOn = oldVnode.data.on || {};
  target$1 = vnode.elm;
  normalizeEvents(on);
  updateListeners(on, oldOn, add$1, remove$2, vnode.context);
}

var events = {
  create: updateDOMListeners,
  update: updateDOMListeners
};

/*  */

function updateDOMProps (oldVnode, vnode) {
  if (isUndef(oldVnode.data.domProps) && isUndef(vnode.data.domProps)) {
    return
  }
  var key, cur;
  var elm = vnode.elm;
  var oldProps = oldVnode.data.domProps || {};
  var props = vnode.data.domProps || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(props.__ob__)) {
    props = vnode.data.domProps = extend({}, props);
  }

  for (key in oldProps) {
    if (isUndef(props[key])) {
      elm[key] = '';
    }
  }
  for (key in props) {
    cur = props[key];
    // ignore children if the node has textContent or innerHTML,
    // as these will throw away existing DOM nodes and cause removal errors
    // on subsequent patches (#3360)
    if (key === 'textContent' || key === 'innerHTML') {
      if (vnode.children) { vnode.children.length = 0; }
      if (cur === oldProps[key]) { continue }
    }

    if (key === 'value') {
      // store value as _value as well since
      // non-string values will be stringified
      elm._value = cur;
      // avoid resetting cursor position when value is the same
      var strCur = isUndef(cur) ? '' : String(cur);
      if (shouldUpdateValue(elm, vnode, strCur)) {
        elm.value = strCur;
      }
    } else {
      elm[key] = cur;
    }
  }
}

// check platforms/web/util/attrs.js acceptValue


function shouldUpdateValue (
  elm,
  vnode,
  checkVal
) {
  return (!elm.composing && (
    vnode.tag === 'option' ||
    isDirty(elm, checkVal) ||
    isInputChanged(elm, checkVal)
  ))
}

function isDirty (elm, checkVal) {
  // return true when textbox (.number and .trim) loses focus and its value is
  // not equal to the updated value
  var notInFocus = true;
  // #6157
  // work around IE bug when accessing document.activeElement in an iframe
  try { notInFocus = document.activeElement !== elm; } catch (e) {}
  return notInFocus && elm.value !== checkVal
}

function isInputChanged (elm, newVal) {
  var value = elm.value;
  var modifiers = elm._vModifiers; // injected by v-model runtime
  if (isDef(modifiers) && modifiers.number) {
    return toNumber(value) !== toNumber(newVal)
  }
  if (isDef(modifiers) && modifiers.trim) {
    return value.trim() !== newVal.trim()
  }
  return value !== newVal
}

var domProps = {
  create: updateDOMProps,
  update: updateDOMProps
};

/*  */

var parseStyleText = cached(function (cssText) {
  var res = {};
  var listDelimiter = /;(?![^(]*\))/g;
  var propertyDelimiter = /:(.+)/;
  cssText.split(listDelimiter).forEach(function (item) {
    if (item) {
      var tmp = item.split(propertyDelimiter);
      tmp.length > 1 && (res[tmp[0].trim()] = tmp[1].trim());
    }
  });
  return res
});

// merge static and dynamic style data on the same vnode
function normalizeStyleData (data) {
  var style = normalizeStyleBinding(data.style);
  // static style is pre-processed into an object during compilation
  // and is always a fresh object, so it's safe to merge into it
  return data.staticStyle
    ? extend(data.staticStyle, style)
    : style
}

// normalize possible array / string values into Object
function normalizeStyleBinding (bindingStyle) {
  if (Array.isArray(bindingStyle)) {
    return toObject(bindingStyle)
  }
  if (typeof bindingStyle === 'string') {
    return parseStyleText(bindingStyle)
  }
  return bindingStyle
}

/**
 * parent component style should be after child's
 * so that parent component's style could override it
 */
function getStyle (vnode, checkChild) {
  var res = {};
  var styleData;

  if (checkChild) {
    var childNode = vnode;
    while (childNode.componentInstance) {
      childNode = childNode.componentInstance._vnode;
      if (childNode.data && (styleData = normalizeStyleData(childNode.data))) {
        extend(res, styleData);
      }
    }
  }

  if ((styleData = normalizeStyleData(vnode.data))) {
    extend(res, styleData);
  }

  var parentNode = vnode;
  while ((parentNode = parentNode.parent)) {
    if (parentNode.data && (styleData = normalizeStyleData(parentNode.data))) {
      extend(res, styleData);
    }
  }
  return res
}

/*  */

var cssVarRE = /^--/;
var importantRE = /\s*!important$/;
var setProp = function (el, name, val) {
  /* istanbul ignore if */
  if (cssVarRE.test(name)) {
    el.style.setProperty(name, val);
  } else if (importantRE.test(val)) {
    el.style.setProperty(name, val.replace(importantRE, ''), 'important');
  } else {
    var normalizedName = normalize(name);
    if (Array.isArray(val)) {
      // Support values array created by autoprefixer, e.g.
      // {display: ["-webkit-box", "-ms-flexbox", "flex"]}
      // Set them one by one, and the browser will only set those it can recognize
      for (var i = 0, len = val.length; i < len; i++) {
        el.style[normalizedName] = val[i];
      }
    } else {
      el.style[normalizedName] = val;
    }
  }
};

var vendorNames = ['Webkit', 'Moz', 'ms'];

var emptyStyle;
var normalize = cached(function (prop) {
  emptyStyle = emptyStyle || document.createElement('div').style;
  prop = camelize(prop);
  if (prop !== 'filter' && (prop in emptyStyle)) {
    return prop
  }
  var capName = prop.charAt(0).toUpperCase() + prop.slice(1);
  for (var i = 0; i < vendorNames.length; i++) {
    var name = vendorNames[i] + capName;
    if (name in emptyStyle) {
      return name
    }
  }
});

function updateStyle (oldVnode, vnode) {
  var data = vnode.data;
  var oldData = oldVnode.data;

  if (isUndef(data.staticStyle) && isUndef(data.style) &&
    isUndef(oldData.staticStyle) && isUndef(oldData.style)
  ) {
    return
  }

  var cur, name;
  var el = vnode.elm;
  var oldStaticStyle = oldData.staticStyle;
  var oldStyleBinding = oldData.normalizedStyle || oldData.style || {};

  // if static style exists, stylebinding already merged into it when doing normalizeStyleData
  var oldStyle = oldStaticStyle || oldStyleBinding;

  var style = normalizeStyleBinding(vnode.data.style) || {};

  // store normalized style under a different key for next diff
  // make sure to clone it if it's reactive, since the user likely wants
  // to mutate it.
  vnode.data.normalizedStyle = isDef(style.__ob__)
    ? extend({}, style)
    : style;

  var newStyle = getStyle(vnode, true);

  for (name in oldStyle) {
    if (isUndef(newStyle[name])) {
      setProp(el, name, '');
    }
  }
  for (name in newStyle) {
    cur = newStyle[name];
    if (cur !== oldStyle[name]) {
      // ie9 setting to null has no effect, must use empty string
      setProp(el, name, cur == null ? '' : cur);
    }
  }
}

var style = {
  create: updateStyle,
  update: updateStyle
};

/*  */

/**
 * Add class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function addClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.add(c); });
    } else {
      el.classList.add(cls);
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    if (cur.indexOf(' ' + cls + ' ') < 0) {
      el.setAttribute('class', (cur + cls).trim());
    }
  }
}

/**
 * Remove class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function removeClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.remove(c); });
    } else {
      el.classList.remove(cls);
    }
    if (!el.classList.length) {
      el.removeAttribute('class');
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    var tar = ' ' + cls + ' ';
    while (cur.indexOf(tar) >= 0) {
      cur = cur.replace(tar, ' ');
    }
    cur = cur.trim();
    if (cur) {
      el.setAttribute('class', cur);
    } else {
      el.removeAttribute('class');
    }
  }
}

/*  */

function resolveTransition (def$$1) {
  if (!def$$1) {
    return
  }
  /* istanbul ignore else */
  if (typeof def$$1 === 'object') {
    var res = {};
    if (def$$1.css !== false) {
      extend(res, autoCssTransition(def$$1.name || 'v'));
    }
    extend(res, def$$1);
    return res
  } else if (typeof def$$1 === 'string') {
    return autoCssTransition(def$$1)
  }
}

var autoCssTransition = cached(function (name) {
  return {
    enterClass: (name + "-enter"),
    enterToClass: (name + "-enter-to"),
    enterActiveClass: (name + "-enter-active"),
    leaveClass: (name + "-leave"),
    leaveToClass: (name + "-leave-to"),
    leaveActiveClass: (name + "-leave-active")
  }
});

var hasTransition = inBrowser && !isIE9;
var TRANSITION = 'transition';
var ANIMATION = 'animation';

// Transition property/event sniffing
var transitionProp = 'transition';
var transitionEndEvent = 'transitionend';
var animationProp = 'animation';
var animationEndEvent = 'animationend';
if (hasTransition) {
  /* istanbul ignore if */
  if (window.ontransitionend === undefined &&
    window.onwebkittransitionend !== undefined
  ) {
    transitionProp = 'WebkitTransition';
    transitionEndEvent = 'webkitTransitionEnd';
  }
  if (window.onanimationend === undefined &&
    window.onwebkitanimationend !== undefined
  ) {
    animationProp = 'WebkitAnimation';
    animationEndEvent = 'webkitAnimationEnd';
  }
}

// binding to window is necessary to make hot reload work in IE in strict mode
var raf = inBrowser && window.requestAnimationFrame
  ? window.requestAnimationFrame.bind(window)
  : setTimeout;

function nextFrame (fn) {
  raf(function () {
    raf(fn);
  });
}

function addTransitionClass (el, cls) {
  var transitionClasses = el._transitionClasses || (el._transitionClasses = []);
  if (transitionClasses.indexOf(cls) < 0) {
    transitionClasses.push(cls);
    addClass(el, cls);
  }
}

function removeTransitionClass (el, cls) {
  if (el._transitionClasses) {
    remove(el._transitionClasses, cls);
  }
  removeClass(el, cls);
}

function whenTransitionEnds (
  el,
  expectedType,
  cb
) {
  var ref = getTransitionInfo(el, expectedType);
  var type = ref.type;
  var timeout = ref.timeout;
  var propCount = ref.propCount;
  if (!type) { return cb() }
  var event = type === TRANSITION ? transitionEndEvent : animationEndEvent;
  var ended = 0;
  var end = function () {
    el.removeEventListener(event, onEnd);
    cb();
  };
  var onEnd = function (e) {
    if (e.target === el) {
      if (++ended >= propCount) {
        end();
      }
    }
  };
  setTimeout(function () {
    if (ended < propCount) {
      end();
    }
  }, timeout + 1);
  el.addEventListener(event, onEnd);
}

var transformRE = /\b(transform|all)(,|$)/;

function getTransitionInfo (el, expectedType) {
  var styles = window.getComputedStyle(el);
  var transitionDelays = styles[transitionProp + 'Delay'].split(', ');
  var transitionDurations = styles[transitionProp + 'Duration'].split(', ');
  var transitionTimeout = getTimeout(transitionDelays, transitionDurations);
  var animationDelays = styles[animationProp + 'Delay'].split(', ');
  var animationDurations = styles[animationProp + 'Duration'].split(', ');
  var animationTimeout = getTimeout(animationDelays, animationDurations);

  var type;
  var timeout = 0;
  var propCount = 0;
  /* istanbul ignore if */
  if (expectedType === TRANSITION) {
    if (transitionTimeout > 0) {
      type = TRANSITION;
      timeout = transitionTimeout;
      propCount = transitionDurations.length;
    }
  } else if (expectedType === ANIMATION) {
    if (animationTimeout > 0) {
      type = ANIMATION;
      timeout = animationTimeout;
      propCount = animationDurations.length;
    }
  } else {
    timeout = Math.max(transitionTimeout, animationTimeout);
    type = timeout > 0
      ? transitionTimeout > animationTimeout
        ? TRANSITION
        : ANIMATION
      : null;
    propCount = type
      ? type === TRANSITION
        ? transitionDurations.length
        : animationDurations.length
      : 0;
  }
  var hasTransform =
    type === TRANSITION &&
    transformRE.test(styles[transitionProp + 'Property']);
  return {
    type: type,
    timeout: timeout,
    propCount: propCount,
    hasTransform: hasTransform
  }
}

function getTimeout (delays, durations) {
  /* istanbul ignore next */
  while (delays.length < durations.length) {
    delays = delays.concat(delays);
  }

  return Math.max.apply(null, durations.map(function (d, i) {
    return toMs(d) + toMs(delays[i])
  }))
}

function toMs (s) {
  return Number(s.slice(0, -1)) * 1000
}

/*  */

function enter (vnode, toggleDisplay) {
  var el = vnode.elm;

  // call leave callback now
  if (isDef(el._leaveCb)) {
    el._leaveCb.cancelled = true;
    el._leaveCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data)) {
    return
  }

  /* istanbul ignore if */
  if (isDef(el._enterCb) || el.nodeType !== 1) {
    return
  }

  var css = data.css;
  var type = data.type;
  var enterClass = data.enterClass;
  var enterToClass = data.enterToClass;
  var enterActiveClass = data.enterActiveClass;
  var appearClass = data.appearClass;
  var appearToClass = data.appearToClass;
  var appearActiveClass = data.appearActiveClass;
  var beforeEnter = data.beforeEnter;
  var enter = data.enter;
  var afterEnter = data.afterEnter;
  var enterCancelled = data.enterCancelled;
  var beforeAppear = data.beforeAppear;
  var appear = data.appear;
  var afterAppear = data.afterAppear;
  var appearCancelled = data.appearCancelled;
  var duration = data.duration;

  // activeInstance will always be the <transition> component managing this
  // transition. One edge case to check is when the <transition> is placed
  // as the root node of a child component. In that case we need to check
  // <transition>'s parent for appear check.
  var context = activeInstance;
  var transitionNode = activeInstance.$vnode;
  while (transitionNode && transitionNode.parent) {
    transitionNode = transitionNode.parent;
    context = transitionNode.context;
  }

  var isAppear = !context._isMounted || !vnode.isRootInsert;

  if (isAppear && !appear && appear !== '') {
    return
  }

  var startClass = isAppear && appearClass
    ? appearClass
    : enterClass;
  var activeClass = isAppear && appearActiveClass
    ? appearActiveClass
    : enterActiveClass;
  var toClass = isAppear && appearToClass
    ? appearToClass
    : enterToClass;

  var beforeEnterHook = isAppear
    ? (beforeAppear || beforeEnter)
    : beforeEnter;
  var enterHook = isAppear
    ? (typeof appear === 'function' ? appear : enter)
    : enter;
  var afterEnterHook = isAppear
    ? (afterAppear || afterEnter)
    : afterEnter;
  var enterCancelledHook = isAppear
    ? (appearCancelled || enterCancelled)
    : enterCancelled;

  var explicitEnterDuration = toNumber(
    isObject(duration)
      ? duration.enter
      : duration
  );

  if (process.env.NODE_ENV !== 'production' && explicitEnterDuration != null) {
    checkDuration(explicitEnterDuration, 'enter', vnode);
  }

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(enterHook);

  var cb = el._enterCb = once(function () {
    if (expectsCSS) {
      removeTransitionClass(el, toClass);
      removeTransitionClass(el, activeClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, startClass);
      }
      enterCancelledHook && enterCancelledHook(el);
    } else {
      afterEnterHook && afterEnterHook(el);
    }
    el._enterCb = null;
  });

  if (!vnode.data.show) {
    // remove pending leave element on enter by injecting an insert hook
    mergeVNodeHook(vnode.data.hook || (vnode.data.hook = {}), 'insert', function () {
      var parent = el.parentNode;
      var pendingNode = parent && parent._pending && parent._pending[vnode.key];
      if (pendingNode &&
        pendingNode.tag === vnode.tag &&
        pendingNode.elm._leaveCb
      ) {
        pendingNode.elm._leaveCb();
      }
      enterHook && enterHook(el, cb);
    });
  }

  // start enter transition
  beforeEnterHook && beforeEnterHook(el);
  if (expectsCSS) {
    addTransitionClass(el, startClass);
    addTransitionClass(el, activeClass);
    nextFrame(function () {
      addTransitionClass(el, toClass);
      removeTransitionClass(el, startClass);
      if (!cb.cancelled && !userWantsControl) {
        if (isValidDuration(explicitEnterDuration)) {
          setTimeout(cb, explicitEnterDuration);
        } else {
          whenTransitionEnds(el, type, cb);
        }
      }
    });
  }

  if (vnode.data.show) {
    toggleDisplay && toggleDisplay();
    enterHook && enterHook(el, cb);
  }

  if (!expectsCSS && !userWantsControl) {
    cb();
  }
}

function leave (vnode, rm) {
  var el = vnode.elm;

  // call enter callback now
  if (isDef(el._enterCb)) {
    el._enterCb.cancelled = true;
    el._enterCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data)) {
    return rm()
  }

  /* istanbul ignore if */
  if (isDef(el._leaveCb) || el.nodeType !== 1) {
    return
  }

  var css = data.css;
  var type = data.type;
  var leaveClass = data.leaveClass;
  var leaveToClass = data.leaveToClass;
  var leaveActiveClass = data.leaveActiveClass;
  var beforeLeave = data.beforeLeave;
  var leave = data.leave;
  var afterLeave = data.afterLeave;
  var leaveCancelled = data.leaveCancelled;
  var delayLeave = data.delayLeave;
  var duration = data.duration;

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(leave);

  var explicitLeaveDuration = toNumber(
    isObject(duration)
      ? duration.leave
      : duration
  );

  if (process.env.NODE_ENV !== 'production' && isDef(explicitLeaveDuration)) {
    checkDuration(explicitLeaveDuration, 'leave', vnode);
  }

  var cb = el._leaveCb = once(function () {
    if (el.parentNode && el.parentNode._pending) {
      el.parentNode._pending[vnode.key] = null;
    }
    if (expectsCSS) {
      removeTransitionClass(el, leaveToClass);
      removeTransitionClass(el, leaveActiveClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, leaveClass);
      }
      leaveCancelled && leaveCancelled(el);
    } else {
      rm();
      afterLeave && afterLeave(el);
    }
    el._leaveCb = null;
  });

  if (delayLeave) {
    delayLeave(performLeave);
  } else {
    performLeave();
  }

  function performLeave () {
    // the delayed leave may have already been cancelled
    if (cb.cancelled) {
      return
    }
    // record leaving element
    if (!vnode.data.show) {
      (el.parentNode._pending || (el.parentNode._pending = {}))[(vnode.key)] = vnode;
    }
    beforeLeave && beforeLeave(el);
    if (expectsCSS) {
      addTransitionClass(el, leaveClass);
      addTransitionClass(el, leaveActiveClass);
      nextFrame(function () {
        addTransitionClass(el, leaveToClass);
        removeTransitionClass(el, leaveClass);
        if (!cb.cancelled && !userWantsControl) {
          if (isValidDuration(explicitLeaveDuration)) {
            setTimeout(cb, explicitLeaveDuration);
          } else {
            whenTransitionEnds(el, type, cb);
          }
        }
      });
    }
    leave && leave(el, cb);
    if (!expectsCSS && !userWantsControl) {
      cb();
    }
  }
}

// only used in dev mode
function checkDuration (val, name, vnode) {
  if (typeof val !== 'number') {
    warn(
      "<transition> explicit " + name + " duration is not a valid number - " +
      "got " + (JSON.stringify(val)) + ".",
      vnode.context
    );
  } else if (isNaN(val)) {
    warn(
      "<transition> explicit " + name + " duration is NaN - " +
      'the duration expression might be incorrect.',
      vnode.context
    );
  }
}

function isValidDuration (val) {
  return typeof val === 'number' && !isNaN(val)
}

/**
 * Normalize a transition hook's argument length. The hook may be:
 * - a merged hook (invoker) with the original in .fns
 * - a wrapped component method (check ._length)
 * - a plain function (.length)
 */
function getHookArgumentsLength (fn) {
  if (isUndef(fn)) {
    return false
  }
  var invokerFns = fn.fns;
  if (isDef(invokerFns)) {
    // invoker
    return getHookArgumentsLength(
      Array.isArray(invokerFns)
        ? invokerFns[0]
        : invokerFns
    )
  } else {
    return (fn._length || fn.length) > 1
  }
}

function _enter (_, vnode) {
  if (vnode.data.show !== true) {
    enter(vnode);
  }
}

var transition = inBrowser ? {
  create: _enter,
  activate: _enter,
  remove: function remove$$1 (vnode, rm) {
    /* istanbul ignore else */
    if (vnode.data.show !== true) {
      leave(vnode, rm);
    } else {
      rm();
    }
  }
} : {};

var platformModules = [
  attrs,
  klass,
  events,
  domProps,
  style,
  transition
];

/*  */

// the directive module should be applied last, after all
// built-in modules have been applied.
var modules = platformModules.concat(baseModules);

var patch = createPatchFunction({ nodeOps: nodeOps, modules: modules });

/**
 * Not type checking this file because flow doesn't like attaching
 * properties to Elements.
 */

/* istanbul ignore if */
if (isIE9) {
  // http://www.matts411.com/post/internet-explorer-9-oninput/
  document.addEventListener('selectionchange', function () {
    var el = document.activeElement;
    if (el && el.vmodel) {
      trigger(el, 'input');
    }
  });
}

var model$1 = {
  inserted: function inserted (el, binding, vnode) {
    if (vnode.tag === 'select') {
      setSelected(el, binding, vnode.context);
      el._vOptions = [].map.call(el.options, getValue);
    } else if (vnode.tag === 'textarea' || isTextInputType(el.type)) {
      el._vModifiers = binding.modifiers;
      if (!binding.modifiers.lazy) {
        // Safari < 10.2 & UIWebView doesn't fire compositionend when
        // switching focus before confirming composition choice
        // this also fixes the issue where some browsers e.g. iOS Chrome
        // fires "change" instead of "input" on autocomplete.
        el.addEventListener('change', onCompositionEnd);
        if (!isAndroid) {
          el.addEventListener('compositionstart', onCompositionStart);
          el.addEventListener('compositionend', onCompositionEnd);
        }
        /* istanbul ignore if */
        if (isIE9) {
          el.vmodel = true;
        }
      }
    }
  },
  componentUpdated: function componentUpdated (el, binding, vnode) {
    if (vnode.tag === 'select') {
      setSelected(el, binding, vnode.context);
      // in case the options rendered by v-for have changed,
      // it's possible that the value is out-of-sync with the rendered options.
      // detect such cases and filter out values that no longer has a matching
      // option in the DOM.
      var prevOptions = el._vOptions;
      var curOptions = el._vOptions = [].map.call(el.options, getValue);
      if (curOptions.some(function (o, i) { return !looseEqual(o, prevOptions[i]); })) {
        // trigger change event if
        // no matching option found for at least one value
        var needReset = el.multiple
          ? binding.value.some(function (v) { return hasNoMatchingOption(v, curOptions); })
          : binding.value !== binding.oldValue && hasNoMatchingOption(binding.value, curOptions);
        if (needReset) {
          trigger(el, 'change');
        }
      }
    }
  }
};

function setSelected (el, binding, vm) {
  actuallySetSelected(el, binding, vm);
  /* istanbul ignore if */
  if (isIE || isEdge) {
    setTimeout(function () {
      actuallySetSelected(el, binding, vm);
    }, 0);
  }
}

function actuallySetSelected (el, binding, vm) {
  var value = binding.value;
  var isMultiple = el.multiple;
  if (isMultiple && !Array.isArray(value)) {
    process.env.NODE_ENV !== 'production' && warn(
      "<select multiple v-model=\"" + (binding.expression) + "\"> " +
      "expects an Array value for its binding, but got " + (Object.prototype.toString.call(value).slice(8, -1)),
      vm
    );
    return
  }
  var selected, option;
  for (var i = 0, l = el.options.length; i < l; i++) {
    option = el.options[i];
    if (isMultiple) {
      selected = looseIndexOf(value, getValue(option)) > -1;
      if (option.selected !== selected) {
        option.selected = selected;
      }
    } else {
      if (looseEqual(getValue(option), value)) {
        if (el.selectedIndex !== i) {
          el.selectedIndex = i;
        }
        return
      }
    }
  }
  if (!isMultiple) {
    el.selectedIndex = -1;
  }
}

function hasNoMatchingOption (value, options) {
  return options.every(function (o) { return !looseEqual(o, value); })
}

function getValue (option) {
  return '_value' in option
    ? option._value
    : option.value
}

function onCompositionStart (e) {
  e.target.composing = true;
}

function onCompositionEnd (e) {
  // prevent triggering an input event for no reason
  if (!e.target.composing) { return }
  e.target.composing = false;
  trigger(e.target, 'input');
}

function trigger (el, type) {
  var e = document.createEvent('HTMLEvents');
  e.initEvent(type, true, true);
  el.dispatchEvent(e);
}

/*  */

// recursively search for possible transition defined inside the component root
function locateNode (vnode) {
  return vnode.componentInstance && (!vnode.data || !vnode.data.transition)
    ? locateNode(vnode.componentInstance._vnode)
    : vnode
}

var show = {
  bind: function bind (el, ref, vnode) {
    var value = ref.value;

    vnode = locateNode(vnode);
    var transition$$1 = vnode.data && vnode.data.transition;
    var originalDisplay = el.__vOriginalDisplay =
      el.style.display === 'none' ? '' : el.style.display;
    if (value && transition$$1) {
      vnode.data.show = true;
      enter(vnode, function () {
        el.style.display = originalDisplay;
      });
    } else {
      el.style.display = value ? originalDisplay : 'none';
    }
  },

  update: function update (el, ref, vnode) {
    var value = ref.value;
    var oldValue = ref.oldValue;

    /* istanbul ignore if */
    if (value === oldValue) { return }
    vnode = locateNode(vnode);
    var transition$$1 = vnode.data && vnode.data.transition;
    if (transition$$1) {
      vnode.data.show = true;
      if (value) {
        enter(vnode, function () {
          el.style.display = el.__vOriginalDisplay;
        });
      } else {
        leave(vnode, function () {
          el.style.display = 'none';
        });
      }
    } else {
      el.style.display = value ? el.__vOriginalDisplay : 'none';
    }
  },

  unbind: function unbind (
    el,
    binding,
    vnode,
    oldVnode,
    isDestroy
  ) {
    if (!isDestroy) {
      el.style.display = el.__vOriginalDisplay;
    }
  }
};

var platformDirectives = {
  model: model$1,
  show: show
};

/*  */

// Provides transition support for a single element/component.
// supports transition mode (out-in / in-out)

var transitionProps = {
  name: String,
  appear: Boolean,
  css: Boolean,
  mode: String,
  type: String,
  enterClass: String,
  leaveClass: String,
  enterToClass: String,
  leaveToClass: String,
  enterActiveClass: String,
  leaveActiveClass: String,
  appearClass: String,
  appearActiveClass: String,
  appearToClass: String,
  duration: [Number, String, Object]
};

// in case the child is also an abstract component, e.g. <keep-alive>
// we want to recursively retrieve the real component to be rendered
function getRealChild (vnode) {
  var compOptions = vnode && vnode.componentOptions;
  if (compOptions && compOptions.Ctor.options.abstract) {
    return getRealChild(getFirstComponentChild(compOptions.children))
  } else {
    return vnode
  }
}

function extractTransitionData (comp) {
  var data = {};
  var options = comp.$options;
  // props
  for (var key in options.propsData) {
    data[key] = comp[key];
  }
  // events.
  // extract listeners and pass them directly to the transition methods
  var listeners = options._parentListeners;
  for (var key$1 in listeners) {
    data[camelize(key$1)] = listeners[key$1];
  }
  return data
}

function placeholder (h, rawChild) {
  if (/\d-keep-alive$/.test(rawChild.tag)) {
    return h('keep-alive', {
      props: rawChild.componentOptions.propsData
    })
  }
}

function hasParentTransition (vnode) {
  while ((vnode = vnode.parent)) {
    if (vnode.data.transition) {
      return true
    }
  }
}

function isSameChild (child, oldChild) {
  return oldChild.key === child.key && oldChild.tag === child.tag
}

var Transition = {
  name: 'transition',
  props: transitionProps,
  abstract: true,

  render: function render (h) {
    var this$1 = this;

    var children = this.$options._renderChildren;
    if (!children) {
      return
    }

    // filter out text nodes (possible whitespaces)
    children = children.filter(function (c) { return c.tag || isAsyncPlaceholder(c); });
    /* istanbul ignore if */
    if (!children.length) {
      return
    }

    // warn multiple elements
    if (process.env.NODE_ENV !== 'production' && children.length > 1) {
      warn(
        '<transition> can only be used on a single element. Use ' +
        '<transition-group> for lists.',
        this.$parent
      );
    }

    var mode = this.mode;

    // warn invalid mode
    if (process.env.NODE_ENV !== 'production' &&
      mode && mode !== 'in-out' && mode !== 'out-in'
    ) {
      warn(
        'invalid <transition> mode: ' + mode,
        this.$parent
      );
    }

    var rawChild = children[0];

    // if this is a component root node and the component's
    // parent container node also has transition, skip.
    if (hasParentTransition(this.$vnode)) {
      return rawChild
    }

    // apply transition data to child
    // use getRealChild() to ignore abstract components e.g. keep-alive
    var child = getRealChild(rawChild);
    /* istanbul ignore if */
    if (!child) {
      return rawChild
    }

    if (this._leaving) {
      return placeholder(h, rawChild)
    }

    // ensure a key that is unique to the vnode type and to this transition
    // component instance. This key will be used to remove pending leaving nodes
    // during entering.
    var id = "__transition-" + (this._uid) + "-";
    child.key = child.key == null
      ? child.isComment
        ? id + 'comment'
        : id + child.tag
      : isPrimitive(child.key)
        ? (String(child.key).indexOf(id) === 0 ? child.key : id + child.key)
        : child.key;

    var data = (child.data || (child.data = {})).transition = extractTransitionData(this);
    var oldRawChild = this._vnode;
    var oldChild = getRealChild(oldRawChild);

    // mark v-show
    // so that the transition module can hand over the control to the directive
    if (child.data.directives && child.data.directives.some(function (d) { return d.name === 'show'; })) {
      child.data.show = true;
    }

    if (
      oldChild &&
      oldChild.data &&
      !isSameChild(child, oldChild) &&
      !isAsyncPlaceholder(oldChild)
    ) {
      // replace old child transition data with fresh one
      // important for dynamic transitions!
      var oldData = oldChild && (oldChild.data.transition = extend({}, data));
      // handle transition mode
      if (mode === 'out-in') {
        // return placeholder node and queue update when leave finishes
        this._leaving = true;
        mergeVNodeHook(oldData, 'afterLeave', function () {
          this$1._leaving = false;
          this$1.$forceUpdate();
        });
        return placeholder(h, rawChild)
      } else if (mode === 'in-out') {
        if (isAsyncPlaceholder(child)) {
          return oldRawChild
        }
        var delayedLeave;
        var performLeave = function () { delayedLeave(); };
        mergeVNodeHook(data, 'afterEnter', performLeave);
        mergeVNodeHook(data, 'enterCancelled', performLeave);
        mergeVNodeHook(oldData, 'delayLeave', function (leave) { delayedLeave = leave; });
      }
    }

    return rawChild
  }
};

/*  */

// Provides transition support for list items.
// supports move transitions using the FLIP technique.

// Because the vdom's children update algorithm is "unstable" - i.e.
// it doesn't guarantee the relative positioning of removed elements,
// we force transition-group to update its children into two passes:
// in the first pass, we remove all nodes that need to be removed,
// triggering their leaving transition; in the second pass, we insert/move
// into the final desired state. This way in the second pass removed
// nodes will remain where they should be.

var props = extend({
  tag: String,
  moveClass: String
}, transitionProps);

delete props.mode;

var TransitionGroup = {
  props: props,

  render: function render (h) {
    var tag = this.tag || this.$vnode.data.tag || 'span';
    var map = Object.create(null);
    var prevChildren = this.prevChildren = this.children;
    var rawChildren = this.$slots.default || [];
    var children = this.children = [];
    var transitionData = extractTransitionData(this);

    for (var i = 0; i < rawChildren.length; i++) {
      var c = rawChildren[i];
      if (c.tag) {
        if (c.key != null && String(c.key).indexOf('__vlist') !== 0) {
          children.push(c);
          map[c.key] = c
          ;(c.data || (c.data = {})).transition = transitionData;
        } else if (process.env.NODE_ENV !== 'production') {
          var opts = c.componentOptions;
          var name = opts ? (opts.Ctor.options.name || opts.tag || '') : c.tag;
          warn(("<transition-group> children must be keyed: <" + name + ">"));
        }
      }
    }

    if (prevChildren) {
      var kept = [];
      var removed = [];
      for (var i$1 = 0; i$1 < prevChildren.length; i$1++) {
        var c$1 = prevChildren[i$1];
        c$1.data.transition = transitionData;
        c$1.data.pos = c$1.elm.getBoundingClientRect();
        if (map[c$1.key]) {
          kept.push(c$1);
        } else {
          removed.push(c$1);
        }
      }
      this.kept = h(tag, null, kept);
      this.removed = removed;
    }

    return h(tag, null, children)
  },

  beforeUpdate: function beforeUpdate () {
    // force removing pass
    this.__patch__(
      this._vnode,
      this.kept,
      false, // hydrating
      true // removeOnly (!important, avoids unnecessary moves)
    );
    this._vnode = this.kept;
  },

  updated: function updated () {
    var children = this.prevChildren;
    var moveClass = this.moveClass || ((this.name || 'v') + '-move');
    if (!children.length || !this.hasMove(children[0].elm, moveClass)) {
      return
    }

    // we divide the work into three loops to avoid mixing DOM reads and writes
    // in each iteration - which helps prevent layout thrashing.
    children.forEach(callPendingCbs);
    children.forEach(recordPosition);
    children.forEach(applyTranslation);

    // force reflow to put everything in position
    var body = document.body;
    var f = body.offsetHeight; // eslint-disable-line

    children.forEach(function (c) {
      if (c.data.moved) {
        var el = c.elm;
        var s = el.style;
        addTransitionClass(el, moveClass);
        s.transform = s.WebkitTransform = s.transitionDuration = '';
        el.addEventListener(transitionEndEvent, el._moveCb = function cb (e) {
          if (!e || /transform$/.test(e.propertyName)) {
            el.removeEventListener(transitionEndEvent, cb);
            el._moveCb = null;
            removeTransitionClass(el, moveClass);
          }
        });
      }
    });
  },

  methods: {
    hasMove: function hasMove (el, moveClass) {
      /* istanbul ignore if */
      if (!hasTransition) {
        return false
      }
      /* istanbul ignore if */
      if (this._hasMove) {
        return this._hasMove
      }
      // Detect whether an element with the move class applied has
      // CSS transitions. Since the element may be inside an entering
      // transition at this very moment, we make a clone of it and remove
      // all other transition classes applied to ensure only the move class
      // is applied.
      var clone = el.cloneNode();
      if (el._transitionClasses) {
        el._transitionClasses.forEach(function (cls) { removeClass(clone, cls); });
      }
      addClass(clone, moveClass);
      clone.style.display = 'none';
      this.$el.appendChild(clone);
      var info = getTransitionInfo(clone);
      this.$el.removeChild(clone);
      return (this._hasMove = info.hasTransform)
    }
  }
};

function callPendingCbs (c) {
  /* istanbul ignore if */
  if (c.elm._moveCb) {
    c.elm._moveCb();
  }
  /* istanbul ignore if */
  if (c.elm._enterCb) {
    c.elm._enterCb();
  }
}

function recordPosition (c) {
  c.data.newPos = c.elm.getBoundingClientRect();
}

function applyTranslation (c) {
  var oldPos = c.data.pos;
  var newPos = c.data.newPos;
  var dx = oldPos.left - newPos.left;
  var dy = oldPos.top - newPos.top;
  if (dx || dy) {
    c.data.moved = true;
    var s = c.elm.style;
    s.transform = s.WebkitTransform = "translate(" + dx + "px," + dy + "px)";
    s.transitionDuration = '0s';
  }
}

var platformComponents = {
  Transition: Transition,
  TransitionGroup: TransitionGroup
};

/*  */

// install platform specific utils
Vue$3.config.mustUseProp = mustUseProp;
Vue$3.config.isReservedTag = isReservedTag;
Vue$3.config.isReservedAttr = isReservedAttr;
Vue$3.config.getTagNamespace = getTagNamespace;
Vue$3.config.isUnknownElement = isUnknownElement;

// install platform runtime directives & components
extend(Vue$3.options.directives, platformDirectives);
extend(Vue$3.options.components, platformComponents);

// install platform patch function
Vue$3.prototype.__patch__ = inBrowser ? patch : noop;

// public mount method
Vue$3.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && inBrowser ? query(el) : undefined;
  return mountComponent(this, el, hydrating)
};

// devtools global hook
/* istanbul ignore next */
setTimeout(function () {
  if (config.devtools) {
    if (devtools) {
      devtools.emit('init', Vue$3);
    } else if (process.env.NODE_ENV !== 'production' && isChrome) {
      console[console.info ? 'info' : 'log'](
        'Download the Vue Devtools extension for a better development experience:\n' +
        'https://github.com/vuejs/vue-devtools'
      );
    }
  }
  if (process.env.NODE_ENV !== 'production' &&
    config.productionTip !== false &&
    inBrowser && typeof console !== 'undefined'
  ) {
    console[console.info ? 'info' : 'log'](
      "You are running Vue in development mode.\n" +
      "Make sure to turn on production mode when deploying for production.\n" +
      "See more tips at https://vuejs.org/guide/deployment.html"
    );
  }
}, 0);

/*  */

// check whether current browser encodes a char inside attribute values
function shouldDecode (content, encoded) {
  var div = document.createElement('div');
  div.innerHTML = "<div a=\"" + content + "\"/>";
  return div.innerHTML.indexOf(encoded) > 0
}

// #3663
// IE encodes newlines inside attribute values while other browsers don't
var shouldDecodeNewlines = inBrowser ? shouldDecode('\n', '&#10;') : false;

/*  */

var defaultTagRE = /\{\{((?:.|\n)+?)\}\}/g;
var regexEscapeRE = /[-.*+?^${}()|[\]\/\\]/g;

var buildRegex = cached(function (delimiters) {
  var open = delimiters[0].replace(regexEscapeRE, '\\$&');
  var close = delimiters[1].replace(regexEscapeRE, '\\$&');
  return new RegExp(open + '((?:.|\\n)+?)' + close, 'g')
});

function parseText (
  text,
  delimiters
) {
  var tagRE = delimiters ? buildRegex(delimiters) : defaultTagRE;
  if (!tagRE.test(text)) {
    return
  }
  var tokens = [];
  var lastIndex = tagRE.lastIndex = 0;
  var match, index;
  while ((match = tagRE.exec(text))) {
    index = match.index;
    // push text token
    if (index > lastIndex) {
      tokens.push(JSON.stringify(text.slice(lastIndex, index)));
    }
    // tag token
    var exp = parseFilters(match[1].trim());
    tokens.push(("_s(" + exp + ")"));
    lastIndex = index + match[0].length;
  }
  if (lastIndex < text.length) {
    tokens.push(JSON.stringify(text.slice(lastIndex)));
  }
  return tokens.join('+')
}

/*  */

function transformNode (el, options) {
  var warn = options.warn || baseWarn;
  var staticClass = getAndRemoveAttr(el, 'class');
  if (process.env.NODE_ENV !== 'production' && staticClass) {
    var expression = parseText(staticClass, options.delimiters);
    if (expression) {
      warn(
        "class=\"" + staticClass + "\": " +
        'Interpolation inside attributes has been removed. ' +
        'Use v-bind or the colon shorthand instead. For example, ' +
        'instead of <div class="{{ val }}">, use <div :class="val">.'
      );
    }
  }
  if (staticClass) {
    el.staticClass = JSON.stringify(staticClass);
  }
  var classBinding = getBindingAttr(el, 'class', false /* getStatic */);
  if (classBinding) {
    el.classBinding = classBinding;
  }
}

function genData (el) {
  var data = '';
  if (el.staticClass) {
    data += "staticClass:" + (el.staticClass) + ",";
  }
  if (el.classBinding) {
    data += "class:" + (el.classBinding) + ",";
  }
  return data
}

var klass$1 = {
  staticKeys: ['staticClass'],
  transformNode: transformNode,
  genData: genData
};

/*  */

function transformNode$1 (el, options) {
  var warn = options.warn || baseWarn;
  var staticStyle = getAndRemoveAttr(el, 'style');
  if (staticStyle) {
    /* istanbul ignore if */
    if (process.env.NODE_ENV !== 'production') {
      var expression = parseText(staticStyle, options.delimiters);
      if (expression) {
        warn(
          "style=\"" + staticStyle + "\": " +
          'Interpolation inside attributes has been removed. ' +
          'Use v-bind or the colon shorthand instead. For example, ' +
          'instead of <div style="{{ val }}">, use <div :style="val">.'
        );
      }
    }
    el.staticStyle = JSON.stringify(parseStyleText(staticStyle));
  }

  var styleBinding = getBindingAttr(el, 'style', false /* getStatic */);
  if (styleBinding) {
    el.styleBinding = styleBinding;
  }
}

function genData$1 (el) {
  var data = '';
  if (el.staticStyle) {
    data += "staticStyle:" + (el.staticStyle) + ",";
  }
  if (el.styleBinding) {
    data += "style:(" + (el.styleBinding) + "),";
  }
  return data
}

var style$1 = {
  staticKeys: ['staticStyle'],
  transformNode: transformNode$1,
  genData: genData$1
};

var modules$1 = [
  klass$1,
  style$1
];

/*  */

function text (el, dir) {
  if (dir.value) {
    addProp(el, 'textContent', ("_s(" + (dir.value) + ")"));
  }
}

/*  */

function html (el, dir) {
  if (dir.value) {
    addProp(el, 'innerHTML', ("_s(" + (dir.value) + ")"));
  }
}

var directives$1 = {
  model: model,
  text: text,
  html: html
};

/*  */

var isUnaryTag = makeMap(
  'area,base,br,col,embed,frame,hr,img,input,isindex,keygen,' +
  'link,meta,param,source,track,wbr'
);

// Elements that you can, intentionally, leave open
// (and which close themselves)
var canBeLeftOpenTag = makeMap(
  'colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr,source'
);

// HTML5 tags https://html.spec.whatwg.org/multipage/indices.html#elements-3
// Phrasing Content https://html.spec.whatwg.org/multipage/dom.html#phrasing-content
var isNonPhrasingTag = makeMap(
  'address,article,aside,base,blockquote,body,caption,col,colgroup,dd,' +
  'details,dialog,div,dl,dt,fieldset,figcaption,figure,footer,form,' +
  'h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,legend,li,menuitem,meta,' +
  'optgroup,option,param,rp,rt,source,style,summary,tbody,td,tfoot,th,thead,' +
  'title,tr,track'
);

/*  */

var baseOptions = {
  expectHTML: true,
  modules: modules$1,
  directives: directives$1,
  isPreTag: isPreTag,
  isUnaryTag: isUnaryTag,
  mustUseProp: mustUseProp,
  canBeLeftOpenTag: canBeLeftOpenTag,
  isReservedTag: isReservedTag,
  getTagNamespace: getTagNamespace,
  staticKeys: genStaticKeys(modules$1)
};

/*  */

var decoder;

var he = {
  decode: function decode (html) {
    decoder = decoder || document.createElement('div');
    decoder.innerHTML = html;
    return decoder.textContent
  }
};

/**
 * Not type-checking this file because it's mostly vendor code.
 */

/*!
 * HTML Parser By John Resig (ejohn.org)
 * Modified by Juriy "kangax" Zaytsev
 * Original code by Erik Arvidsson, Mozilla Public License
 * http://erik.eae.net/simplehtmlparser/simplehtmlparser.js
 */

// Regular Expressions for parsing tags and attributes
var attribute = /^\s*([^\s"'<>\/=]+)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/;
// could use https://www.w3.org/TR/1999/REC-xml-names-19990114/#NT-QName
// but for Vue templates we can enforce a simple charset
var ncname = '[a-zA-Z_][\\w\\-\\.]*';
var qnameCapture = "((?:" + ncname + "\\:)?" + ncname + ")";
var startTagOpen = new RegExp(("^<" + qnameCapture));
var startTagClose = /^\s*(\/?)>/;
var endTag = new RegExp(("^<\\/" + qnameCapture + "[^>]*>"));
var doctype = /^<!DOCTYPE [^>]+>/i;
var comment = /^<!--/;
var conditionalComment = /^<!\[/;

var IS_REGEX_CAPTURING_BROKEN = false;
'x'.replace(/x(.)?/g, function (m, g) {
  IS_REGEX_CAPTURING_BROKEN = g === '';
});

// Special Elements (can contain anything)
var isPlainTextElement = makeMap('script,style,textarea', true);
var reCache = {};

var decodingMap = {
  '&lt;': '<',
  '&gt;': '>',
  '&quot;': '"',
  '&amp;': '&',
  '&#10;': '\n'
};
var encodedAttr = /&(?:lt|gt|quot|amp);/g;
var encodedAttrWithNewLines = /&(?:lt|gt|quot|amp|#10);/g;

// #5992
var isIgnoreNewlineTag = makeMap('pre,textarea', true);
var shouldIgnoreFirstNewline = function (tag, html) { return tag && isIgnoreNewlineTag(tag) && html[0] === '\n'; };

function decodeAttr (value, shouldDecodeNewlines) {
  var re = shouldDecodeNewlines ? encodedAttrWithNewLines : encodedAttr;
  return value.replace(re, function (match) { return decodingMap[match]; })
}

function parseHTML (html, options) {
  var stack = [];
  var expectHTML = options.expectHTML;
  var isUnaryTag$$1 = options.isUnaryTag || no;
  var canBeLeftOpenTag$$1 = options.canBeLeftOpenTag || no;
  var index = 0;
  var last, lastTag;
  while (html) {
    last = html;
    // Make sure we're not in a plaintext content element like script/style
    if (!lastTag || !isPlainTextElement(lastTag)) {
      var textEnd = html.indexOf('<');
      if (textEnd === 0) {
        // Comment:
        if (comment.test(html)) {
          var commentEnd = html.indexOf('-->');

          if (commentEnd >= 0) {
            if (options.shouldKeepComment) {
              options.comment(html.substring(4, commentEnd));
            }
            advance(commentEnd + 3);
            continue
          }
        }

        // http://en.wikipedia.org/wiki/Conditional_comment#Downlevel-revealed_conditional_comment
        if (conditionalComment.test(html)) {
          var conditionalEnd = html.indexOf(']>');

          if (conditionalEnd >= 0) {
            advance(conditionalEnd + 2);
            continue
          }
        }

        // Doctype:
        var doctypeMatch = html.match(doctype);
        if (doctypeMatch) {
          advance(doctypeMatch[0].length);
          continue
        }

        // End tag:
        var endTagMatch = html.match(endTag);
        if (endTagMatch) {
          var curIndex = index;
          advance(endTagMatch[0].length);
          parseEndTag(endTagMatch[1], curIndex, index);
          continue
        }

        // Start tag:
        var startTagMatch = parseStartTag();
        if (startTagMatch) {
          handleStartTag(startTagMatch);
          if (shouldIgnoreFirstNewline(lastTag, html)) {
            advance(1);
          }
          continue
        }
      }

      var text = (void 0), rest = (void 0), next = (void 0);
      if (textEnd >= 0) {
        rest = html.slice(textEnd);
        while (
          !endTag.test(rest) &&
          !startTagOpen.test(rest) &&
          !comment.test(rest) &&
          !conditionalComment.test(rest)
        ) {
          // < in plain text, be forgiving and treat it as text
          next = rest.indexOf('<', 1);
          if (next < 0) { break }
          textEnd += next;
          rest = html.slice(textEnd);
        }
        text = html.substring(0, textEnd);
        advance(textEnd);
      }

      if (textEnd < 0) {
        text = html;
        html = '';
      }

      if (options.chars && text) {
        options.chars(text);
      }
    } else {
      var endTagLength = 0;
      var stackedTag = lastTag.toLowerCase();
      var reStackedTag = reCache[stackedTag] || (reCache[stackedTag] = new RegExp('([\\s\\S]*?)(</' + stackedTag + '[^>]*>)', 'i'));
      var rest$1 = html.replace(reStackedTag, function (all, text, endTag) {
        endTagLength = endTag.length;
        if (!isPlainTextElement(stackedTag) && stackedTag !== 'noscript') {
          text = text
            .replace(/<!--([\s\S]*?)-->/g, '$1')
            .replace(/<!\[CDATA\[([\s\S]*?)]]>/g, '$1');
        }
        if (shouldIgnoreFirstNewline(stackedTag, text)) {
          text = text.slice(1);
        }
        if (options.chars) {
          options.chars(text);
        }
        return ''
      });
      index += html.length - rest$1.length;
      html = rest$1;
      parseEndTag(stackedTag, index - endTagLength, index);
    }

    if (html === last) {
      options.chars && options.chars(html);
      if (process.env.NODE_ENV !== 'production' && !stack.length && options.warn) {
        options.warn(("Mal-formatted tag at end of template: \"" + html + "\""));
      }
      break
    }
  }

  // Clean up any remaining tags
  parseEndTag();

  function advance (n) {
    index += n;
    html = html.substring(n);
  }

  function parseStartTag () {
    var start = html.match(startTagOpen);
    if (start) {
      var match = {
        tagName: start[1],
        attrs: [],
        start: index
      };
      advance(start[0].length);
      var end, attr;
      while (!(end = html.match(startTagClose)) && (attr = html.match(attribute))) {
        advance(attr[0].length);
        match.attrs.push(attr);
      }
      if (end) {
        match.unarySlash = end[1];
        advance(end[0].length);
        match.end = index;
        return match
      }
    }
  }

  function handleStartTag (match) {
    var tagName = match.tagName;
    var unarySlash = match.unarySlash;

    if (expectHTML) {
      if (lastTag === 'p' && isNonPhrasingTag(tagName)) {
        parseEndTag(lastTag);
      }
      if (canBeLeftOpenTag$$1(tagName) && lastTag === tagName) {
        parseEndTag(tagName);
      }
    }

    var unary = isUnaryTag$$1(tagName) || !!unarySlash;

    var l = match.attrs.length;
    var attrs = new Array(l);
    for (var i = 0; i < l; i++) {
      var args = match.attrs[i];
      // hackish work around FF bug https://bugzilla.mozilla.org/show_bug.cgi?id=369778
      if (IS_REGEX_CAPTURING_BROKEN && args[0].indexOf('""') === -1) {
        if (args[3] === '') { delete args[3]; }
        if (args[4] === '') { delete args[4]; }
        if (args[5] === '') { delete args[5]; }
      }
      var value = args[3] || args[4] || args[5] || '';
      attrs[i] = {
        name: args[1],
        value: decodeAttr(
          value,
          options.shouldDecodeNewlines
        )
      };
    }

    if (!unary) {
      stack.push({ tag: tagName, lowerCasedTag: tagName.toLowerCase(), attrs: attrs });
      lastTag = tagName;
    }

    if (options.start) {
      options.start(tagName, attrs, unary, match.start, match.end);
    }
  }

  function parseEndTag (tagName, start, end) {
    var pos, lowerCasedTagName;
    if (start == null) { start = index; }
    if (end == null) { end = index; }

    if (tagName) {
      lowerCasedTagName = tagName.toLowerCase();
    }

    // Find the closest opened tag of the same type
    if (tagName) {
      for (pos = stack.length - 1; pos >= 0; pos--) {
        if (stack[pos].lowerCasedTag === lowerCasedTagName) {
          break
        }
      }
    } else {
      // If no tag name is provided, clean shop
      pos = 0;
    }

    if (pos >= 0) {
      // Close all the open elements, up the stack
      for (var i = stack.length - 1; i >= pos; i--) {
        if (process.env.NODE_ENV !== 'production' &&
          (i > pos || !tagName) &&
          options.warn
        ) {
          options.warn(
            ("tag <" + (stack[i].tag) + "> has no matching end tag.")
          );
        }
        if (options.end) {
          options.end(stack[i].tag, start, end);
        }
      }

      // Remove the open elements from the stack
      stack.length = pos;
      lastTag = pos && stack[pos - 1].tag;
    } else if (lowerCasedTagName === 'br') {
      if (options.start) {
        options.start(tagName, [], true, start, end);
      }
    } else if (lowerCasedTagName === 'p') {
      if (options.start) {
        options.start(tagName, [], false, start, end);
      }
      if (options.end) {
        options.end(tagName, start, end);
      }
    }
  }
}

/*  */

var onRE = /^@|^v-on:/;
var dirRE = /^v-|^@|^:/;
var forAliasRE = /(.*?)\s+(?:in|of)\s+(.*)/;
var forIteratorRE = /\((\{[^}]*\}|[^,]*),([^,]*)(?:,([^,]*))?\)/;

var argRE = /:(.*)$/;
var bindRE = /^:|^v-bind:/;
var modifierRE = /\.[^.]+/g;

var decodeHTMLCached = cached(he.decode);

// configurable state
var warn$2;
var delimiters;
var transforms;
var preTransforms;
var postTransforms;
var platformIsPreTag;
var platformMustUseProp;
var platformGetTagNamespace;

/**
 * Convert HTML string to AST.
 */
function parse (
  template,
  options
) {
  warn$2 = options.warn || baseWarn;

  platformIsPreTag = options.isPreTag || no;
  platformMustUseProp = options.mustUseProp || no;
  platformGetTagNamespace = options.getTagNamespace || no;

  transforms = pluckModuleFunction(options.modules, 'transformNode');
  preTransforms = pluckModuleFunction(options.modules, 'preTransformNode');
  postTransforms = pluckModuleFunction(options.modules, 'postTransformNode');

  delimiters = options.delimiters;

  var stack = [];
  var preserveWhitespace = options.preserveWhitespace !== false;
  var root;
  var currentParent;
  var inVPre = false;
  var inPre = false;
  var warned = false;

  function warnOnce (msg) {
    if (!warned) {
      warned = true;
      warn$2(msg);
    }
  }

  function endPre (element) {
    // check pre state
    if (element.pre) {
      inVPre = false;
    }
    if (platformIsPreTag(element.tag)) {
      inPre = false;
    }
  }

  parseHTML(template, {
    warn: warn$2,
    expectHTML: options.expectHTML,
    isUnaryTag: options.isUnaryTag,
    canBeLeftOpenTag: options.canBeLeftOpenTag,
    shouldDecodeNewlines: options.shouldDecodeNewlines,
    shouldKeepComment: options.comments,
    start: function start (tag, attrs, unary) {
      // check namespace.
      // inherit parent ns if there is one
      var ns = (currentParent && currentParent.ns) || platformGetTagNamespace(tag);

      // handle IE svg bug
      /* istanbul ignore if */
      if (isIE && ns === 'svg') {
        attrs = guardIESVGBug(attrs);
      }

      var element = {
        type: 1,
        tag: tag,
        attrsList: attrs,
        attrsMap: makeAttrsMap(attrs),
        parent: currentParent,
        children: []
      };
      if (ns) {
        element.ns = ns;
      }

      if (isForbiddenTag(element) && !isServerRendering()) {
        element.forbidden = true;
        process.env.NODE_ENV !== 'production' && warn$2(
          'Templates should only be responsible for mapping the state to the ' +
          'UI. Avoid placing tags with side-effects in your templates, such as ' +
          "<" + tag + ">" + ', as they will not be parsed.'
        );
      }

      // apply pre-transforms
      for (var i = 0; i < preTransforms.length; i++) {
        preTransforms[i](element, options);
      }

      if (!inVPre) {
        processPre(element);
        if (element.pre) {
          inVPre = true;
        }
      }
      if (platformIsPreTag(element.tag)) {
        inPre = true;
      }
      if (inVPre) {
        processRawAttrs(element);
      } else {
        processFor(element);
        processIf(element);
        processOnce(element);
        processKey(element);

        // determine whether this is a plain element after
        // removing structural attributes
        element.plain = !element.key && !attrs.length;

        processRef(element);
        processSlot(element);
        processComponent(element);
        for (var i$1 = 0; i$1 < transforms.length; i$1++) {
          transforms[i$1](element, options);
        }
        processAttrs(element);
      }

      function checkRootConstraints (el) {
        if (process.env.NODE_ENV !== 'production') {
          if (el.tag === 'slot' || el.tag === 'template') {
            warnOnce(
              "Cannot use <" + (el.tag) + "> as component root element because it may " +
              'contain multiple nodes.'
            );
          }
          if (el.attrsMap.hasOwnProperty('v-for')) {
            warnOnce(
              'Cannot use v-for on stateful component root element because ' +
              'it renders multiple elements.'
            );
          }
        }
      }

      // tree management
      if (!root) {
        root = element;
        checkRootConstraints(root);
      } else if (!stack.length) {
        // allow root elements with v-if, v-else-if and v-else
        if (root.if && (element.elseif || element.else)) {
          checkRootConstraints(element);
          addIfCondition(root, {
            exp: element.elseif,
            block: element
          });
        } else if (process.env.NODE_ENV !== 'production') {
          warnOnce(
            "Component template should contain exactly one root element. " +
            "If you are using v-if on multiple elements, " +
            "use v-else-if to chain them instead."
          );
        }
      }
      if (currentParent && !element.forbidden) {
        if (element.elseif || element.else) {
          processIfConditions(element, currentParent);
        } else if (element.slotScope) { // scoped slot
          currentParent.plain = false;
          var name = element.slotTarget || '"default"';(currentParent.scopedSlots || (currentParent.scopedSlots = {}))[name] = element;
        } else {
          currentParent.children.push(element);
          element.parent = currentParent;
        }
      }
      if (!unary) {
        currentParent = element;
        stack.push(element);
      } else {
        endPre(element);
      }
      // apply post-transforms
      for (var i$2 = 0; i$2 < postTransforms.length; i$2++) {
        postTransforms[i$2](element, options);
      }
    },

    end: function end () {
      // remove trailing whitespace
      var element = stack[stack.length - 1];
      var lastNode = element.children[element.children.length - 1];
      if (lastNode && lastNode.type === 3 && lastNode.text === ' ' && !inPre) {
        element.children.pop();
      }
      // pop stack
      stack.length -= 1;
      currentParent = stack[stack.length - 1];
      endPre(element);
    },

    chars: function chars (text) {
      if (!currentParent) {
        if (process.env.NODE_ENV !== 'production') {
          if (text === template) {
            warnOnce(
              'Component template requires a root element, rather than just text.'
            );
          } else if ((text = text.trim())) {
            warnOnce(
              ("text \"" + text + "\" outside root element will be ignored.")
            );
          }
        }
        return
      }
      // IE textarea placeholder bug
      /* istanbul ignore if */
      if (isIE &&
        currentParent.tag === 'textarea' &&
        currentParent.attrsMap.placeholder === text
      ) {
        return
      }
      var children = currentParent.children;
      text = inPre || text.trim()
        ? isTextTag(currentParent) ? text : decodeHTMLCached(text)
        // only preserve whitespace if its not right after a starting tag
        : preserveWhitespace && children.length ? ' ' : '';
      if (text) {
        var expression;
        if (!inVPre && text !== ' ' && (expression = parseText(text, delimiters))) {
          children.push({
            type: 2,
            expression: expression,
            text: text
          });
        } else if (text !== ' ' || !children.length || children[children.length - 1].text !== ' ') {
          children.push({
            type: 3,
            text: text
          });
        }
      }
    },
    comment: function comment (text) {
      currentParent.children.push({
        type: 3,
        text: text,
        isComment: true
      });
    }
  });
  return root
}

function processPre (el) {
  if (getAndRemoveAttr(el, 'v-pre') != null) {
    el.pre = true;
  }
}

function processRawAttrs (el) {
  var l = el.attrsList.length;
  if (l) {
    var attrs = el.attrs = new Array(l);
    for (var i = 0; i < l; i++) {
      attrs[i] = {
        name: el.attrsList[i].name,
        value: JSON.stringify(el.attrsList[i].value)
      };
    }
  } else if (!el.pre) {
    // non root node in pre blocks with no attributes
    el.plain = true;
  }
}

function processKey (el) {
  var exp = getBindingAttr(el, 'key');
  if (exp) {
    if (process.env.NODE_ENV !== 'production' && el.tag === 'template') {
      warn$2("<template> cannot be keyed. Place the key on real elements instead.");
    }
    el.key = exp;
  }
}

function processRef (el) {
  var ref = getBindingAttr(el, 'ref');
  if (ref) {
    el.ref = ref;
    el.refInFor = checkInFor(el);
  }
}

function processFor (el) {
  var exp;
  if ((exp = getAndRemoveAttr(el, 'v-for'))) {
    var inMatch = exp.match(forAliasRE);
    if (!inMatch) {
      process.env.NODE_ENV !== 'production' && warn$2(
        ("Invalid v-for expression: " + exp)
      );
      return
    }
    el.for = inMatch[2].trim();
    var alias = inMatch[1].trim();
    var iteratorMatch = alias.match(forIteratorRE);
    if (iteratorMatch) {
      el.alias = iteratorMatch[1].trim();
      el.iterator1 = iteratorMatch[2].trim();
      if (iteratorMatch[3]) {
        el.iterator2 = iteratorMatch[3].trim();
      }
    } else {
      el.alias = alias;
    }
  }
}

function processIf (el) {
  var exp = getAndRemoveAttr(el, 'v-if');
  if (exp) {
    el.if = exp;
    addIfCondition(el, {
      exp: exp,
      block: el
    });
  } else {
    if (getAndRemoveAttr(el, 'v-else') != null) {
      el.else = true;
    }
    var elseif = getAndRemoveAttr(el, 'v-else-if');
    if (elseif) {
      el.elseif = elseif;
    }
  }
}

function processIfConditions (el, parent) {
  var prev = findPrevElement(parent.children);
  if (prev && prev.if) {
    addIfCondition(prev, {
      exp: el.elseif,
      block: el
    });
  } else if (process.env.NODE_ENV !== 'production') {
    warn$2(
      "v-" + (el.elseif ? ('else-if="' + el.elseif + '"') : 'else') + " " +
      "used on element <" + (el.tag) + "> without corresponding v-if."
    );
  }
}

function findPrevElement (children) {
  var i = children.length;
  while (i--) {
    if (children[i].type === 1) {
      return children[i]
    } else {
      if (process.env.NODE_ENV !== 'production' && children[i].text !== ' ') {
        warn$2(
          "text \"" + (children[i].text.trim()) + "\" between v-if and v-else(-if) " +
          "will be ignored."
        );
      }
      children.pop();
    }
  }
}

function addIfCondition (el, condition) {
  if (!el.ifConditions) {
    el.ifConditions = [];
  }
  el.ifConditions.push(condition);
}

function processOnce (el) {
  var once$$1 = getAndRemoveAttr(el, 'v-once');
  if (once$$1 != null) {
    el.once = true;
  }
}

function processSlot (el) {
  if (el.tag === 'slot') {
    el.slotName = getBindingAttr(el, 'name');
    if (process.env.NODE_ENV !== 'production' && el.key) {
      warn$2(
        "`key` does not work on <slot> because slots are abstract outlets " +
        "and can possibly expand into multiple elements. " +
        "Use the key on a wrapping element instead."
      );
    }
  } else {
    var slotTarget = getBindingAttr(el, 'slot');
    if (slotTarget) {
      el.slotTarget = slotTarget === '""' ? '"default"' : slotTarget;
      // preserve slot as an attribute for native shadow DOM compat
      addAttr(el, 'slot', slotTarget);
    }
    if (el.tag === 'template') {
      el.slotScope = getAndRemoveAttr(el, 'scope');
    }
  }
}

function processComponent (el) {
  var binding;
  if ((binding = getBindingAttr(el, 'is'))) {
    el.component = binding;
  }
  if (getAndRemoveAttr(el, 'inline-template') != null) {
    el.inlineTemplate = true;
  }
}

function processAttrs (el) {
  var list = el.attrsList;
  var i, l, name, rawName, value, modifiers, isProp;
  for (i = 0, l = list.length; i < l; i++) {
    name = rawName = list[i].name;
    value = list[i].value;
    if (dirRE.test(name)) {
      // mark element as dynamic
      el.hasBindings = true;
      // modifiers
      modifiers = parseModifiers(name);
      if (modifiers) {
        name = name.replace(modifierRE, '');
      }
      if (bindRE.test(name)) { // v-bind
        name = name.replace(bindRE, '');
        value = parseFilters(value);
        isProp = false;
        if (modifiers) {
          if (modifiers.prop) {
            isProp = true;
            name = camelize(name);
            if (name === 'innerHtml') { name = 'innerHTML'; }
          }
          if (modifiers.camel) {
            name = camelize(name);
          }
          if (modifiers.sync) {
            addHandler(
              el,
              ("update:" + (camelize(name))),
              genAssignmentCode(value, "$event")
            );
          }
        }
        if (isProp || (
          !el.component && platformMustUseProp(el.tag, el.attrsMap.type, name)
        )) {
          addProp(el, name, value);
        } else {
          addAttr(el, name, value);
        }
      } else if (onRE.test(name)) { // v-on
        name = name.replace(onRE, '');
        addHandler(el, name, value, modifiers, false, warn$2);
      } else { // normal directives
        name = name.replace(dirRE, '');
        // parse arg
        var argMatch = name.match(argRE);
        var arg = argMatch && argMatch[1];
        if (arg) {
          name = name.slice(0, -(arg.length + 1));
        }
        addDirective(el, name, rawName, value, arg, modifiers);
        if (process.env.NODE_ENV !== 'production' && name === 'model') {
          checkForAliasModel(el, value);
        }
      }
    } else {
      // literal attribute
      if (process.env.NODE_ENV !== 'production') {
        var expression = parseText(value, delimiters);
        if (expression) {
          warn$2(
            name + "=\"" + value + "\": " +
            'Interpolation inside attributes has been removed. ' +
            'Use v-bind or the colon shorthand instead. For example, ' +
            'instead of <div id="{{ val }}">, use <div :id="val">.'
          );
        }
      }
      addAttr(el, name, JSON.stringify(value));
    }
  }
}

function checkInFor (el) {
  var parent = el;
  while (parent) {
    if (parent.for !== undefined) {
      return true
    }
    parent = parent.parent;
  }
  return false
}

function parseModifiers (name) {
  var match = name.match(modifierRE);
  if (match) {
    var ret = {};
    match.forEach(function (m) { ret[m.slice(1)] = true; });
    return ret
  }
}

function makeAttrsMap (attrs) {
  var map = {};
  for (var i = 0, l = attrs.length; i < l; i++) {
    if (
      process.env.NODE_ENV !== 'production' &&
      map[attrs[i].name] && !isIE && !isEdge
    ) {
      warn$2('duplicate attribute: ' + attrs[i].name);
    }
    map[attrs[i].name] = attrs[i].value;
  }
  return map
}

// for script (e.g. type="x/template") or style, do not decode content
function isTextTag (el) {
  return el.tag === 'script' || el.tag === 'style'
}

function isForbiddenTag (el) {
  return (
    el.tag === 'style' ||
    (el.tag === 'script' && (
      !el.attrsMap.type ||
      el.attrsMap.type === 'text/javascript'
    ))
  )
}

var ieNSBug = /^xmlns:NS\d+/;
var ieNSPrefix = /^NS\d+:/;

/* istanbul ignore next */
function guardIESVGBug (attrs) {
  var res = [];
  for (var i = 0; i < attrs.length; i++) {
    var attr = attrs[i];
    if (!ieNSBug.test(attr.name)) {
      attr.name = attr.name.replace(ieNSPrefix, '');
      res.push(attr);
    }
  }
  return res
}

function checkForAliasModel (el, value) {
  var _el = el;
  while (_el) {
    if (_el.for && _el.alias === value) {
      warn$2(
        "<" + (el.tag) + " v-model=\"" + value + "\">: " +
        "You are binding v-model directly to a v-for iteration alias. " +
        "This will not be able to modify the v-for source array because " +
        "writing to the alias is like modifying a function local variable. " +
        "Consider using an array of objects and use v-model on an object property instead."
      );
    }
    _el = _el.parent;
  }
}

/*  */

var isStaticKey;
var isPlatformReservedTag;

var genStaticKeysCached = cached(genStaticKeys$1);

/**
 * Goal of the optimizer: walk the generated template AST tree
 * and detect sub-trees that are purely static, i.e. parts of
 * the DOM that never needs to change.
 *
 * Once we detect these sub-trees, we can:
 *
 * 1. Hoist them into constants, so that we no longer need to
 *    create fresh nodes for them on each re-render;
 * 2. Completely skip them in the patching process.
 */
function optimize (root, options) {
  if (!root) { return }
  isStaticKey = genStaticKeysCached(options.staticKeys || '');
  isPlatformReservedTag = options.isReservedTag || no;
  // first pass: mark all non-static nodes.
  markStatic$1(root);
  // second pass: mark static roots.
  markStaticRoots(root, false);
}

function genStaticKeys$1 (keys) {
  return makeMap(
    'type,tag,attrsList,attrsMap,plain,parent,children,attrs' +
    (keys ? ',' + keys : '')
  )
}

function markStatic$1 (node) {
  node.static = isStatic(node);
  if (node.type === 1) {
    // do not make component slot content static. this avoids
    // 1. components not able to mutate slot nodes
    // 2. static slot content fails for hot-reloading
    if (
      !isPlatformReservedTag(node.tag) &&
      node.tag !== 'slot' &&
      node.attrsMap['inline-template'] == null
    ) {
      return
    }
    for (var i = 0, l = node.children.length; i < l; i++) {
      var child = node.children[i];
      markStatic$1(child);
      if (!child.static) {
        node.static = false;
      }
    }
    if (node.ifConditions) {
      for (var i$1 = 1, l$1 = node.ifConditions.length; i$1 < l$1; i$1++) {
        var block = node.ifConditions[i$1].block;
        markStatic$1(block);
        if (!block.static) {
          node.static = false;
        }
      }
    }
  }
}

function markStaticRoots (node, isInFor) {
  if (node.type === 1) {
    if (node.static || node.once) {
      node.staticInFor = isInFor;
    }
    // For a node to qualify as a static root, it should have children that
    // are not just static text. Otherwise the cost of hoisting out will
    // outweigh the benefits and it's better off to just always render it fresh.
    if (node.static && node.children.length && !(
      node.children.length === 1 &&
      node.children[0].type === 3
    )) {
      node.staticRoot = true;
      return
    } else {
      node.staticRoot = false;
    }
    if (node.children) {
      for (var i = 0, l = node.children.length; i < l; i++) {
        markStaticRoots(node.children[i], isInFor || !!node.for);
      }
    }
    if (node.ifConditions) {
      for (var i$1 = 1, l$1 = node.ifConditions.length; i$1 < l$1; i$1++) {
        markStaticRoots(node.ifConditions[i$1].block, isInFor);
      }
    }
  }
}

function isStatic (node) {
  if (node.type === 2) { // expression
    return false
  }
  if (node.type === 3) { // text
    return true
  }
  return !!(node.pre || (
    !node.hasBindings && // no dynamic bindings
    !node.if && !node.for && // not v-if or v-for or v-else
    !isBuiltInTag(node.tag) && // not a built-in
    isPlatformReservedTag(node.tag) && // not a component
    !isDirectChildOfTemplateFor(node) &&
    Object.keys(node).every(isStaticKey)
  ))
}

function isDirectChildOfTemplateFor (node) {
  while (node.parent) {
    node = node.parent;
    if (node.tag !== 'template') {
      return false
    }
    if (node.for) {
      return true
    }
  }
  return false
}

/*  */

var fnExpRE = /^\s*([\w$_]+|\([^)]*?\))\s*=>|^function\s*\(/;
var simplePathRE = /^\s*[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['.*?']|\[".*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*\s*$/;

// keyCode aliases
var keyCodes = {
  esc: 27,
  tab: 9,
  enter: 13,
  space: 32,
  up: 38,
  left: 37,
  right: 39,
  down: 40,
  'delete': [8, 46]
};

// #4868: modifiers that prevent the execution of the listener
// need to explicitly return null so that we can determine whether to remove
// the listener for .once
var genGuard = function (condition) { return ("if(" + condition + ")return null;"); };

var modifierCode = {
  stop: '$event.stopPropagation();',
  prevent: '$event.preventDefault();',
  self: genGuard("$event.target !== $event.currentTarget"),
  ctrl: genGuard("!$event.ctrlKey"),
  shift: genGuard("!$event.shiftKey"),
  alt: genGuard("!$event.altKey"),
  meta: genGuard("!$event.metaKey"),
  left: genGuard("'button' in $event && $event.button !== 0"),
  middle: genGuard("'button' in $event && $event.button !== 1"),
  right: genGuard("'button' in $event && $event.button !== 2")
};

function genHandlers (
  events,
  isNative,
  warn
) {
  var res = isNative ? 'nativeOn:{' : 'on:{';
  for (var name in events) {
    var handler = events[name];
    // #5330: warn click.right, since right clicks do not actually fire click events.
    if (process.env.NODE_ENV !== 'production' &&
      name === 'click' &&
      handler && handler.modifiers && handler.modifiers.right
    ) {
      warn(
        "Use \"contextmenu\" instead of \"click.right\" since right clicks " +
        "do not actually fire \"click\" events."
      );
    }
    res += "\"" + name + "\":" + (genHandler(name, handler)) + ",";
  }
  return res.slice(0, -1) + '}'
}

function genHandler (
  name,
  handler
) {
  if (!handler) {
    return 'function(){}'
  }

  if (Array.isArray(handler)) {
    return ("[" + (handler.map(function (handler) { return genHandler(name, handler); }).join(',')) + "]")
  }

  var isMethodPath = simplePathRE.test(handler.value);
  var isFunctionExpression = fnExpRE.test(handler.value);

  if (!handler.modifiers) {
    return isMethodPath || isFunctionExpression
      ? handler.value
      : ("function($event){" + (handler.value) + "}") // inline statement
  } else {
    var code = '';
    var genModifierCode = '';
    var keys = [];
    for (var key in handler.modifiers) {
      if (modifierCode[key]) {
        genModifierCode += modifierCode[key];
        // left/right
        if (keyCodes[key]) {
          keys.push(key);
        }
      } else {
        keys.push(key);
      }
    }
    if (keys.length) {
      code += genKeyFilter(keys);
    }
    // Make sure modifiers like prevent and stop get executed after key filtering
    if (genModifierCode) {
      code += genModifierCode;
    }
    var handlerCode = isMethodPath
      ? handler.value + '($event)'
      : isFunctionExpression
        ? ("(" + (handler.value) + ")($event)")
        : handler.value;
    return ("function($event){" + code + handlerCode + "}")
  }
}

function genKeyFilter (keys) {
  return ("if(!('button' in $event)&&" + (keys.map(genFilterCode).join('&&')) + ")return null;")
}

function genFilterCode (key) {
  var keyVal = parseInt(key, 10);
  if (keyVal) {
    return ("$event.keyCode!==" + keyVal)
  }
  var alias = keyCodes[key];
  return ("_k($event.keyCode," + (JSON.stringify(key)) + (alias ? ',' + JSON.stringify(alias) : '') + ")")
}

/*  */

function on (el, dir) {
  if (process.env.NODE_ENV !== 'production' && dir.modifiers) {
    warn("v-on without argument does not support modifiers.");
  }
  el.wrapListeners = function (code) { return ("_g(" + code + "," + (dir.value) + ")"); };
}

/*  */

function bind$1 (el, dir) {
  el.wrapData = function (code) {
    return ("_b(" + code + ",'" + (el.tag) + "'," + (dir.value) + "," + (dir.modifiers && dir.modifiers.prop ? 'true' : 'false') + (dir.modifiers && dir.modifiers.sync ? ',true' : '') + ")")
  };
}

/*  */

var baseDirectives = {
  on: on,
  bind: bind$1,
  cloak: noop
};

/*  */

var CodegenState = function CodegenState (options) {
  this.options = options;
  this.warn = options.warn || baseWarn;
  this.transforms = pluckModuleFunction(options.modules, 'transformCode');
  this.dataGenFns = pluckModuleFunction(options.modules, 'genData');
  this.directives = extend(extend({}, baseDirectives), options.directives);
  var isReservedTag = options.isReservedTag || no;
  this.maybeComponent = function (el) { return !isReservedTag(el.tag); };
  this.onceId = 0;
  this.staticRenderFns = [];
};



function generate (
  ast,
  options
) {
  var state = new CodegenState(options);
  var code = ast ? genElement(ast, state) : '_c("div")';
  return {
    render: ("with(this){return " + code + "}"),
    staticRenderFns: state.staticRenderFns
  }
}

function genElement (el, state) {
  if (el.staticRoot && !el.staticProcessed) {
    return genStatic(el, state)
  } else if (el.once && !el.onceProcessed) {
    return genOnce(el, state)
  } else if (el.for && !el.forProcessed) {
    return genFor(el, state)
  } else if (el.if && !el.ifProcessed) {
    return genIf(el, state)
  } else if (el.tag === 'template' && !el.slotTarget) {
    return genChildren(el, state) || 'void 0'
  } else if (el.tag === 'slot') {
    return genSlot(el, state)
  } else {
    // component or element
    var code;
    if (el.component) {
      code = genComponent(el.component, el, state);
    } else {
      var data = el.plain ? undefined : genData$2(el, state);

      var children = el.inlineTemplate ? null : genChildren(el, state, true);
      code = "_c('" + (el.tag) + "'" + (data ? ("," + data) : '') + (children ? ("," + children) : '') + ")";
    }
    // module transforms
    for (var i = 0; i < state.transforms.length; i++) {
      code = state.transforms[i](el, code);
    }
    return code
  }
}

// hoist static sub-trees out
function genStatic (el, state) {
  el.staticProcessed = true;
  state.staticRenderFns.push(("with(this){return " + (genElement(el, state)) + "}"));
  return ("_m(" + (state.staticRenderFns.length - 1) + (el.staticInFor ? ',true' : '') + ")")
}

// v-once
function genOnce (el, state) {
  el.onceProcessed = true;
  if (el.if && !el.ifProcessed) {
    return genIf(el, state)
  } else if (el.staticInFor) {
    var key = '';
    var parent = el.parent;
    while (parent) {
      if (parent.for) {
        key = parent.key;
        break
      }
      parent = parent.parent;
    }
    if (!key) {
      process.env.NODE_ENV !== 'production' && state.warn(
        "v-once can only be used inside v-for that is keyed. "
      );
      return genElement(el, state)
    }
    return ("_o(" + (genElement(el, state)) + "," + (state.onceId++) + "," + key + ")")
  } else {
    return genStatic(el, state)
  }
}

function genIf (
  el,
  state,
  altGen,
  altEmpty
) {
  el.ifProcessed = true; // avoid recursion
  return genIfConditions(el.ifConditions.slice(), state, altGen, altEmpty)
}

function genIfConditions (
  conditions,
  state,
  altGen,
  altEmpty
) {
  if (!conditions.length) {
    return altEmpty || '_e()'
  }

  var condition = conditions.shift();
  if (condition.exp) {
    return ("(" + (condition.exp) + ")?" + (genTernaryExp(condition.block)) + ":" + (genIfConditions(conditions, state, altGen, altEmpty)))
  } else {
    return ("" + (genTernaryExp(condition.block)))
  }

  // v-if with v-once should generate code like (a)?_m(0):_m(1)
  function genTernaryExp (el) {
    return altGen
      ? altGen(el, state)
      : el.once
        ? genOnce(el, state)
        : genElement(el, state)
  }
}

function genFor (
  el,
  state,
  altGen,
  altHelper
) {
  var exp = el.for;
  var alias = el.alias;
  var iterator1 = el.iterator1 ? ("," + (el.iterator1)) : '';
  var iterator2 = el.iterator2 ? ("," + (el.iterator2)) : '';

  if (process.env.NODE_ENV !== 'production' &&
    state.maybeComponent(el) &&
    el.tag !== 'slot' &&
    el.tag !== 'template' &&
    !el.key
  ) {
    state.warn(
      "<" + (el.tag) + " v-for=\"" + alias + " in " + exp + "\">: component lists rendered with " +
      "v-for should have explicit keys. " +
      "See https://vuejs.org/guide/list.html#key for more info.",
      true /* tip */
    );
  }

  el.forProcessed = true; // avoid recursion
  return (altHelper || '_l') + "((" + exp + ")," +
    "function(" + alias + iterator1 + iterator2 + "){" +
      "return " + ((altGen || genElement)(el, state)) +
    '})'
}

function genData$2 (el, state) {
  var data = '{';

  // directives first.
  // directives may mutate the el's other properties before they are generated.
  var dirs = genDirectives(el, state);
  if (dirs) { data += dirs + ','; }

  // key
  if (el.key) {
    data += "key:" + (el.key) + ",";
  }
  // ref
  if (el.ref) {
    data += "ref:" + (el.ref) + ",";
  }
  if (el.refInFor) {
    data += "refInFor:true,";
  }
  // pre
  if (el.pre) {
    data += "pre:true,";
  }
  // record original tag name for components using "is" attribute
  if (el.component) {
    data += "tag:\"" + (el.tag) + "\",";
  }
  // module data generation functions
  for (var i = 0; i < state.dataGenFns.length; i++) {
    data += state.dataGenFns[i](el);
  }
  // attributes
  if (el.attrs) {
    data += "attrs:{" + (genProps(el.attrs)) + "},";
  }
  // DOM props
  if (el.props) {
    data += "domProps:{" + (genProps(el.props)) + "},";
  }
  // event handlers
  if (el.events) {
    data += (genHandlers(el.events, false, state.warn)) + ",";
  }
  if (el.nativeEvents) {
    data += (genHandlers(el.nativeEvents, true, state.warn)) + ",";
  }
  // slot target
  if (el.slotTarget) {
    data += "slot:" + (el.slotTarget) + ",";
  }
  // scoped slots
  if (el.scopedSlots) {
    data += (genScopedSlots(el.scopedSlots, state)) + ",";
  }
  // component v-model
  if (el.model) {
    data += "model:{value:" + (el.model.value) + ",callback:" + (el.model.callback) + ",expression:" + (el.model.expression) + "},";
  }
  // inline-template
  if (el.inlineTemplate) {
    var inlineTemplate = genInlineTemplate(el, state);
    if (inlineTemplate) {
      data += inlineTemplate + ",";
    }
  }
  data = data.replace(/,$/, '') + '}';
  // v-bind data wrap
  if (el.wrapData) {
    data = el.wrapData(data);
  }
  // v-on data wrap
  if (el.wrapListeners) {
    data = el.wrapListeners(data);
  }
  return data
}

function genDirectives (el, state) {
  var dirs = el.directives;
  if (!dirs) { return }
  var res = 'directives:[';
  var hasRuntime = false;
  var i, l, dir, needRuntime;
  for (i = 0, l = dirs.length; i < l; i++) {
    dir = dirs[i];
    needRuntime = true;
    var gen = state.directives[dir.name];
    if (gen) {
      // compile-time directive that manipulates AST.
      // returns true if it also needs a runtime counterpart.
      needRuntime = !!gen(el, dir, state.warn);
    }
    if (needRuntime) {
      hasRuntime = true;
      res += "{name:\"" + (dir.name) + "\",rawName:\"" + (dir.rawName) + "\"" + (dir.value ? (",value:(" + (dir.value) + "),expression:" + (JSON.stringify(dir.value))) : '') + (dir.arg ? (",arg:\"" + (dir.arg) + "\"") : '') + (dir.modifiers ? (",modifiers:" + (JSON.stringify(dir.modifiers))) : '') + "},";
    }
  }
  if (hasRuntime) {
    return res.slice(0, -1) + ']'
  }
}

function genInlineTemplate (el, state) {
  var ast = el.children[0];
  if (process.env.NODE_ENV !== 'production' && (
    el.children.length > 1 || ast.type !== 1
  )) {
    state.warn('Inline-template components must have exactly one child element.');
  }
  if (ast.type === 1) {
    var inlineRenderFns = generate(ast, state.options);
    return ("inlineTemplate:{render:function(){" + (inlineRenderFns.render) + "},staticRenderFns:[" + (inlineRenderFns.staticRenderFns.map(function (code) { return ("function(){" + code + "}"); }).join(',')) + "]}")
  }
}

function genScopedSlots (
  slots,
  state
) {
  return ("scopedSlots:_u([" + (Object.keys(slots).map(function (key) {
      return genScopedSlot(key, slots[key], state)
    }).join(',')) + "])")
}

function genScopedSlot (
  key,
  el,
  state
) {
  if (el.for && !el.forProcessed) {
    return genForScopedSlot(key, el, state)
  }
  return "{key:" + key + ",fn:function(" + (String(el.attrsMap.scope)) + "){" +
    "return " + (el.tag === 'template'
      ? genChildren(el, state) || 'void 0'
      : genElement(el, state)) + "}}"
}

function genForScopedSlot (
  key,
  el,
  state
) {
  var exp = el.for;
  var alias = el.alias;
  var iterator1 = el.iterator1 ? ("," + (el.iterator1)) : '';
  var iterator2 = el.iterator2 ? ("," + (el.iterator2)) : '';
  el.forProcessed = true; // avoid recursion
  return "_l((" + exp + ")," +
    "function(" + alias + iterator1 + iterator2 + "){" +
      "return " + (genScopedSlot(key, el, state)) +
    '})'
}

function genChildren (
  el,
  state,
  checkSkip,
  altGenElement,
  altGenNode
) {
  var children = el.children;
  if (children.length) {
    var el$1 = children[0];
    // optimize single v-for
    if (children.length === 1 &&
      el$1.for &&
      el$1.tag !== 'template' &&
      el$1.tag !== 'slot'
    ) {
      return (altGenElement || genElement)(el$1, state)
    }
    var normalizationType = checkSkip
      ? getNormalizationType(children, state.maybeComponent)
      : 0;
    var gen = altGenNode || genNode;
    return ("[" + (children.map(function (c) { return gen(c, state); }).join(',')) + "]" + (normalizationType ? ("," + normalizationType) : ''))
  }
}

// determine the normalization needed for the children array.
// 0: no normalization needed
// 1: simple normalization needed (possible 1-level deep nested array)
// 2: full normalization needed
function getNormalizationType (
  children,
  maybeComponent
) {
  var res = 0;
  for (var i = 0; i < children.length; i++) {
    var el = children[i];
    if (el.type !== 1) {
      continue
    }
    if (needsNormalization(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return needsNormalization(c.block); }))) {
      res = 2;
      break
    }
    if (maybeComponent(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return maybeComponent(c.block); }))) {
      res = 1;
    }
  }
  return res
}

function needsNormalization (el) {
  return el.for !== undefined || el.tag === 'template' || el.tag === 'slot'
}

function genNode (node, state) {
  if (node.type === 1) {
    return genElement(node, state)
  } if (node.type === 3 && node.isComment) {
    return genComment(node)
  } else {
    return genText(node)
  }
}

function genText (text) {
  return ("_v(" + (text.type === 2
    ? text.expression // no need for () because already wrapped in _s()
    : transformSpecialNewlines(JSON.stringify(text.text))) + ")")
}

function genComment (comment) {
  return ("_e(" + (JSON.stringify(comment.text)) + ")")
}

function genSlot (el, state) {
  var slotName = el.slotName || '"default"';
  var children = genChildren(el, state);
  var res = "_t(" + slotName + (children ? ("," + children) : '');
  var attrs = el.attrs && ("{" + (el.attrs.map(function (a) { return ((camelize(a.name)) + ":" + (a.value)); }).join(',')) + "}");
  var bind$$1 = el.attrsMap['v-bind'];
  if ((attrs || bind$$1) && !children) {
    res += ",null";
  }
  if (attrs) {
    res += "," + attrs;
  }
  if (bind$$1) {
    res += (attrs ? '' : ',null') + "," + bind$$1;
  }
  return res + ')'
}

// componentName is el.component, take it as argument to shun flow's pessimistic refinement
function genComponent (
  componentName,
  el,
  state
) {
  var children = el.inlineTemplate ? null : genChildren(el, state, true);
  return ("_c(" + componentName + "," + (genData$2(el, state)) + (children ? ("," + children) : '') + ")")
}

function genProps (props) {
  var res = '';
  for (var i = 0; i < props.length; i++) {
    var prop = props[i];
    res += "\"" + (prop.name) + "\":" + (transformSpecialNewlines(prop.value)) + ",";
  }
  return res.slice(0, -1)
}

// #3895, #4268
function transformSpecialNewlines (text) {
  return text
    .replace(/\u2028/g, '\\u2028')
    .replace(/\u2029/g, '\\u2029')
}

/*  */

// these keywords should not appear inside expressions, but operators like
// typeof, instanceof and in are allowed
var prohibitedKeywordRE = new RegExp('\\b' + (
  'do,if,for,let,new,try,var,case,else,with,await,break,catch,class,const,' +
  'super,throw,while,yield,delete,export,import,return,switch,default,' +
  'extends,finally,continue,debugger,function,arguments'
).split(',').join('\\b|\\b') + '\\b');

// these unary operators should not be used as property/method names
var unaryOperatorsRE = new RegExp('\\b' + (
  'delete,typeof,void'
).split(',').join('\\s*\\([^\\)]*\\)|\\b') + '\\s*\\([^\\)]*\\)');

// check valid identifier for v-for
var identRE = /[A-Za-z_$][\w$]*/;

// strip strings in expressions
var stripStringRE = /'(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*"|`(?:[^`\\]|\\.)*\$\{|\}(?:[^`\\]|\\.)*`|`(?:[^`\\]|\\.)*`/g;

// detect problematic expressions in a template
function detectErrors (ast) {
  var errors = [];
  if (ast) {
    checkNode(ast, errors);
  }
  return errors
}

function checkNode (node, errors) {
  if (node.type === 1) {
    for (var name in node.attrsMap) {
      if (dirRE.test(name)) {
        var value = node.attrsMap[name];
        if (value) {
          if (name === 'v-for') {
            checkFor(node, ("v-for=\"" + value + "\""), errors);
          } else if (onRE.test(name)) {
            checkEvent(value, (name + "=\"" + value + "\""), errors);
          } else {
            checkExpression(value, (name + "=\"" + value + "\""), errors);
          }
        }
      }
    }
    if (node.children) {
      for (var i = 0; i < node.children.length; i++) {
        checkNode(node.children[i], errors);
      }
    }
  } else if (node.type === 2) {
    checkExpression(node.expression, node.text, errors);
  }
}

function checkEvent (exp, text, errors) {
  var stipped = exp.replace(stripStringRE, '');
  var keywordMatch = stipped.match(unaryOperatorsRE);
  if (keywordMatch && stipped.charAt(keywordMatch.index - 1) !== '$') {
    errors.push(
      "avoid using JavaScript unary operator as property name: " +
      "\"" + (keywordMatch[0]) + "\" in expression " + (text.trim())
    );
  }
  checkExpression(exp, text, errors);
}

function checkFor (node, text, errors) {
  checkExpression(node.for || '', text, errors);
  checkIdentifier(node.alias, 'v-for alias', text, errors);
  checkIdentifier(node.iterator1, 'v-for iterator', text, errors);
  checkIdentifier(node.iterator2, 'v-for iterator', text, errors);
}

function checkIdentifier (ident, type, text, errors) {
  if (typeof ident === 'string' && !identRE.test(ident)) {
    errors.push(("invalid " + type + " \"" + ident + "\" in expression: " + (text.trim())));
  }
}

function checkExpression (exp, text, errors) {
  try {
    new Function(("return " + exp));
  } catch (e) {
    var keywordMatch = exp.replace(stripStringRE, '').match(prohibitedKeywordRE);
    if (keywordMatch) {
      errors.push(
        "avoid using JavaScript keyword as property name: " +
        "\"" + (keywordMatch[0]) + "\" in expression " + (text.trim())
      );
    } else {
      errors.push(("invalid expression: " + (text.trim())));
    }
  }
}

/*  */

function createFunction (code, errors) {
  try {
    return new Function(code)
  } catch (err) {
    errors.push({ err: err, code: code });
    return noop
  }
}

function createCompileToFunctionFn (compile) {
  var cache = Object.create(null);

  return function compileToFunctions (
    template,
    options,
    vm
  ) {
    options = options || {};

    /* istanbul ignore if */
    if (process.env.NODE_ENV !== 'production') {
      // detect possible CSP restriction
      try {
        new Function('return 1');
      } catch (e) {
        if (e.toString().match(/unsafe-eval|CSP/)) {
          warn(
            'It seems you are using the standalone build of Vue.js in an ' +
            'environment with Content Security Policy that prohibits unsafe-eval. ' +
            'The template compiler cannot work in this environment. Consider ' +
            'relaxing the policy to allow unsafe-eval or pre-compiling your ' +
            'templates into render functions.'
          );
        }
      }
    }

    // check cache
    var key = options.delimiters
      ? String(options.delimiters) + template
      : template;
    if (cache[key]) {
      return cache[key]
    }

    // compile
    var compiled = compile(template, options);

    // check compilation errors/tips
    if (process.env.NODE_ENV !== 'production') {
      if (compiled.errors && compiled.errors.length) {
        warn(
          "Error compiling template:\n\n" + template + "\n\n" +
          compiled.errors.map(function (e) { return ("- " + e); }).join('\n') + '\n',
          vm
        );
      }
      if (compiled.tips && compiled.tips.length) {
        compiled.tips.forEach(function (msg) { return tip(msg, vm); });
      }
    }

    // turn code into functions
    var res = {};
    var fnGenErrors = [];
    res.render = createFunction(compiled.render, fnGenErrors);
    res.staticRenderFns = compiled.staticRenderFns.map(function (code) {
      return createFunction(code, fnGenErrors)
    });

    // check function generation errors.
    // this should only happen if there is a bug in the compiler itself.
    // mostly for codegen development use
    /* istanbul ignore if */
    if (process.env.NODE_ENV !== 'production') {
      if ((!compiled.errors || !compiled.errors.length) && fnGenErrors.length) {
        warn(
          "Failed to generate render function:\n\n" +
          fnGenErrors.map(function (ref) {
            var err = ref.err;
            var code = ref.code;

            return ((err.toString()) + " in\n\n" + code + "\n");
        }).join('\n'),
          vm
        );
      }
    }

    return (cache[key] = res)
  }
}

/*  */

function createCompilerCreator (baseCompile) {
  return function createCompiler (baseOptions) {
    function compile (
      template,
      options
    ) {
      var finalOptions = Object.create(baseOptions);
      var errors = [];
      var tips = [];
      finalOptions.warn = function (msg, tip) {
        (tip ? tips : errors).push(msg);
      };

      if (options) {
        // merge custom modules
        if (options.modules) {
          finalOptions.modules =
            (baseOptions.modules || []).concat(options.modules);
        }
        // merge custom directives
        if (options.directives) {
          finalOptions.directives = extend(
            Object.create(baseOptions.directives),
            options.directives
          );
        }
        // copy other options
        for (var key in options) {
          if (key !== 'modules' && key !== 'directives') {
            finalOptions[key] = options[key];
          }
        }
      }

      var compiled = baseCompile(template, finalOptions);
      if (process.env.NODE_ENV !== 'production') {
        errors.push.apply(errors, detectErrors(compiled.ast));
      }
      compiled.errors = errors;
      compiled.tips = tips;
      return compiled
    }

    return {
      compile: compile,
      compileToFunctions: createCompileToFunctionFn(compile)
    }
  }
}

/*  */

// `createCompilerCreator` allows creating compilers that use alternative
// parser/optimizer/codegen, e.g the SSR optimizing compiler.
// Here we just export a default compiler using the default parts.
var createCompiler = createCompilerCreator(function baseCompile (
  template,
  options
) {
  var ast = parse(template.trim(), options);
  optimize(ast, options);
  var code = generate(ast, options);
  return {
    ast: ast,
    render: code.render,
    staticRenderFns: code.staticRenderFns
  }
});

/*  */

var ref$1 = createCompiler(baseOptions);
var compileToFunctions = ref$1.compileToFunctions;

/*  */

var idToTemplate = cached(function (id) {
  var el = query(id);
  return el && el.innerHTML
});

var mount = Vue$3.prototype.$mount;
Vue$3.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && query(el);

  /* istanbul ignore if */
  if (el === document.body || el === document.documentElement) {
    process.env.NODE_ENV !== 'production' && warn(
      "Do not mount Vue to <html> or <body> - mount to normal elements instead."
    );
    return this
  }

  var options = this.$options;
  // resolve template/el and convert to render function
  if (!options.render) {
    var template = options.template;
    if (template) {
      if (typeof template === 'string') {
        if (template.charAt(0) === '#') {
          template = idToTemplate(template);
          /* istanbul ignore if */
          if (process.env.NODE_ENV !== 'production' && !template) {
            warn(
              ("Template element not found or is empty: " + (options.template)),
              this
            );
          }
        }
      } else if (template.nodeType) {
        template = template.innerHTML;
      } else {
        if (process.env.NODE_ENV !== 'production') {
          warn('invalid template option:' + template, this);
        }
        return this
      }
    } else if (el) {
      template = getOuterHTML(el);
    }
    if (template) {
      /* istanbul ignore if */
      if (process.env.NODE_ENV !== 'production' && config.performance && mark) {
        mark('compile');
      }

      var ref = compileToFunctions(template, {
        shouldDecodeNewlines: shouldDecodeNewlines,
        delimiters: options.delimiters,
        comments: options.comments
      }, this);
      var render = ref.render;
      var staticRenderFns = ref.staticRenderFns;
      options.render = render;
      options.staticRenderFns = staticRenderFns;

      /* istanbul ignore if */
      if (process.env.NODE_ENV !== 'production' && config.performance && mark) {
        mark('compile end');
        measure(((this._name) + " compile"), 'compile', 'compile end');
      }
    }
  }
  return mount.call(this, el, hydrating)
};

/**
 * Get outerHTML of elements, taking care
 * of SVG elements in IE as well.
 */
function getOuterHTML (el) {
  if (el.outerHTML) {
    return el.outerHTML
  } else {
    var container = document.createElement('div');
    container.appendChild(el.cloneNode(true));
    return container.innerHTML
  }
}

Vue$3.compile = compileToFunctions;

module.exports = Vue$3;

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(11), __webpack_require__(19)))

/***/ }),
/* 19 */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),
/* 20 */,
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(4);


/***/ })
],[21]);