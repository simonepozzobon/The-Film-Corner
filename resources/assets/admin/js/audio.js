import Vue from 'vue';
import mojs from 'mo-js';
import axios from 'axios';

import AudioFormUpload from './components/AudioFormUpload.vue';
import AudioCrud from './components/AudioCrud.vue';

const app = new Vue({
  el: '#app',
  components: {
      AudioFormUpload,
      AudioCrud
  }
})
