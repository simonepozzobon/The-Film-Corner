import Vue from 'vue';
import mojs from 'mo-js';

import VideoFormUpload from './components/VideoFormUpload.vue'

const app = new Vue({
  el: '#app',
  data: {
      content: '',
  },
  methods: {

  },
  components: {
      VideoFormUpload
  }
})
