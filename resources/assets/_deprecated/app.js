import $ from 'jquery'

/**
 * Activate Jquery globally and add Tether for Bootstrap js e importo anche any-resize-event
 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')


/**
 * Laravel Echo per le notifiche e gli eventi in real time. Con il client di socket io altrimenti genera il bug.
 */

// import Echo from 'laravel-echo'
// window.io = require('socket.io-client')
// window.Echo = new Echo({
//   broadcaster: 'socket.io',
//   host: window.location.protocol + '//' + window.location.hostname + ':6001',
//   secure: true,
// })

// console.log('debug ' + window.location.protocol + '//' + window.location.hostname + ':6001')
// console.log('debug', window.Echo)

/**
 * require bootstrap-fileinput
 */

// require('bootstrap-fileinput')
