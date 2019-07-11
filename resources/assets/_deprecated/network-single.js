import Vue from 'vue'
import axios from 'axios'
import $ from 'jquery'

import CommentNew from './components/CommentNew.vue'
import CommentList from './components/CommentList.vue'

const app = new Vue({
  el: '#main',
  components: {
    CommentNew,
    CommentList
  }
});
