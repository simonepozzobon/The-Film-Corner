import Vue from 'vue'
import VueSocketio from 'vue-socket.io'

Vue.use(VueSocketio, 'http://'+ window.location.hostname +':6001')
import tfcChat from './components/tfcChat.vue'


new Vue({
  el: '#app',
  components: {
    tfcChat
  }
})
