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

// verifico se ci sono librerie
var libraryEls = document.querySelectorAll('.library');
if (libraryEls.length > 0) {
    // Creo la funzione per impostare la dimensione del wrapper / assets
    function initScroll(e)
    {
        // Le dimensioni che dovrà avere la libreria
        var height = Math.round($(e.target).height()),
            width = Math.round($(e.target).width()),
            wrappers = $('.assets');

        wrappers.each(function(index, el) {
          $(el).css('height', height);
          $(el).css('width', width);
          $(el).css('position', 'relative');
          $(el).css('overflow', 'hidden');

          var scroller = $(el).find('.scroller');
          scroller.css('position', 'absolute');
        });
    }

    // catturo l'evento per le dimensioni della libreria
    document.addEventListener('library-resized', initScroll, false)

    // inizializzo la variabile contenitore per le instance di Iscroll
    var scrollEl;

    // quando attivo il tab (evento Bootstrap)
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

      // Elimino l'instance di Iscroll
      if (typeof(scrollEl) != 'undefined' || scrollEl != null) {
        console.log('esiste');
        scrollEl.destroy();
        scrollEl = null;
      }

      // inizializzo la nuova instance di Iscroll
      scrollEl = new IScroll(e.target.hash, {
        scrollbars: true,
        mouseWheel: true,
        shrinkScrollbars: 'scale',
      });

    })
}
