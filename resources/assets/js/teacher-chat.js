import Vue from 'vue'
import axios from 'axios'
import $ from 'jquery';

import tfcChat from './components/tfcChat.vue'

const app = new Vue({
  el: '#teacher-chat',
  components: {
    tfcChat
  }
});
