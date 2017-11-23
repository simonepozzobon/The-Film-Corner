import Vue from 'vue'
import axios from 'axios'
import $ from 'jquery';

import WelcomeForm from './components/welcome/WelcomeForm.vue'

const app = new Vue({
  el: '#app',
  components: {
    WelcomeForm
  }
});
