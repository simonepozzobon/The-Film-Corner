/**
 * Importo anche Tooltip.js per i tooltip (usati specialmente nel menu delle applicazioni)
 */

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


/**
 * Setup di Iscroll per le librerie nelle app
 */

// import IScroll from 'iscroll'
// import $ from 'jquery'
//
// // verifico se ci sono librerie
// var libraryEls = document.querySelectorAll('.library')
// if (libraryEls.length > 0) {
//   // inizializzo la variabile contenitore per le instance di Iscroll
//   var scrollEl
//
//   // catturo l'evento per le dimensioni della libreria
//   document.addEventListener('library-resized', initScroll, false)
//
//   // quando attivo il tab (evento Bootstrap)
//   $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
//
//     // Elimino l'instance di Iscroll
//     if (typeof(scrollEl) != 'undefined' || scrollEl != null) {
//       scrollEl.destroy()
//       scrollEl = null
//     }
//
//     // inizializzo la nuova instance di Iscroll
//     scrollEl = new IScroll(e.target.hash, {
//       scrollbars: true,
//       mouseWheel: true,
//       shrinkScrollbars: 'scale',
//     })
//
//     // Adattamento per droppable -> App 14
//     if (typeof(droppable) != 'undefined') {
//       scrollEl.on('beforeScrollStart', droppable)
//     }
//   })
// }
//
// // Creo la funzione per impostare la dimensione del wrapper / assets
// function initScroll(e)
// {
//   // Le dimensioni che dovrà avere la libreria
//   var height = Math.round($(e.target).height()),
//     width = Math.round($(e.target).width()) + 32,
//     wrappers = $('.assets')
//
//   wrappers.each(function(index, el) {
//     $(el).css('height', height)
//     $(el).css('width', width)
//     $(el).css('position', 'relative')
//     $(el).css('overflow', 'hidden')
//
//     var scroller = $(el).find('.scroller')
//     scroller.css('position', 'absolute')
//     scroller.css('width', '100%')
//   })
//
//   // inizializzo IScroll sul primo tab attivo
//   var firstEl = $('.assets.active').attr('id')
//   if (typeof(firstEl) != 'undefined' || firstEl != null) {
//     scrollEl = new IScroll('#'+firstEl, {
//       scrollbars: true,
//       mouseWheel: true,
//       shrinkScrollbars: 'scale',
//     })
//
//     // Adattamento per droppable -> App 14
//     if (typeof(droppable) != 'undefined') {
//       scrollEl.on('beforeScrollStart', droppable)
//     }
//
//   }
// }
