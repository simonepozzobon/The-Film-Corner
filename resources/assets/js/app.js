/**
 * Activate Jquery globally and add Tether for Bootstrap js e importo anche any-resize-event
 */

window.$ = window.jQuery = require('jquery')
window.Tether = require('tether')
require('any-resize-event')


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


/**
 * Laravel Echo per le notifiche e gli eventi in real time. Con il client di socket io altrimenti genera il bug.
 */

import Echo from 'laravel-echo'
window.io = require('socket.io-client');
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});


/**
 * Importo anche Tooltip.js per i tooltip (usati specialmente nel menu delle applicazioni)
 */

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


/**
 * Setup di Iscroll per le librerie nelle app
 */

import IScroll from 'iscroll'

var libraryEls = document.querySelectorAll('.library-container');
if (libraryEls.length > 0) {
  var libraryScroll = new IScroll('.library-container');
}
