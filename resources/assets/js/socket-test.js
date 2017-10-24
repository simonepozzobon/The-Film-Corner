import Vue from 'vue'
import VueSocketio from 'vue-socket.io'
import axios from 'axios'
import $ from 'jquery';

Vue.use(VueSocketio, window.location.hostname+':6001')
import tfcChat from './components/tfcChat.vue'


const app = new Vue({
  el: '#app',
  components: {
    tfcChat
  }
});
