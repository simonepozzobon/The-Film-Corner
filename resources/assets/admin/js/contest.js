import Vue from 'vue'
import $ from 'jquery'

window.$ = window.jQuery = require('jquery')

import List from './contest/list.vue'

const app = new Vue({
  el: '#app',
  components: {
    List,
  }
})
