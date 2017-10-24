import Vue from 'vue'
import VueSocketio from 'vue-socket.io'
import axios from 'axios'
import $ from 'jquery';

Vue.use(VueSocketio, 'http://localhost:6001')
import tfcChat from './components/tfcChat.vue'


const app = new Vue({
  el: '#teacher-chat',
  components: {
    tfcChat
  }
});