import Vue from 'vue'

import FeedbackPopup from './components/FeedbackPopup.vue'

const app = new Vue({
  el: '#image',
  mounted() {
    //do something after mounting vue instance
    this.$on('modalOpen', function(id) {
      this.modalOpen(id);
    });
  },
  methods: {
    modalOpen(id)
    {
        $(id).modal('show');
    }
  },
  components: {
    FeedbackPopup
  }
});
