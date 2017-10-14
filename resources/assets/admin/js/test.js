import Vue from 'vue';
import mojs from 'mo-js';
import axios from 'axios';

import VideoFormUpload from './components/VideoFormUpload.vue';
import VideoCrud from './components/VideoCrud.vue';

const app = new Vue({
  el: '#app',
  components: {
      VideoFormUpload,
      VideoCrud
  }
})
