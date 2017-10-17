import Vue from 'vue';
import mojs from 'mo-js';
import axios from 'axios';

import ImageFormUpload from './components/ImageFormUpload.vue';
import ImageCrud from './components/ImageCrud.vue';

const app = new Vue({
  el: '#app',
  components: {
      ImageFormUpload,
      ImageCrud
  }
})
