import Vue from 'vue'

import TranslatePanel from './components/TranslatePanel.vue'

const app = new Vue({
  el: '#app',
  data: () => ({
    'options': [
      {'title': 'title'},
      {'title': 'slug'},
      {'title': 'description'},
    ],
  }),
  components: {
    TranslatePanel
  }
});
