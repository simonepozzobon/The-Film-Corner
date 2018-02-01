import Vue from 'vue'

import Timeline from './components/Timeline.vue'
import VideoPreview from './components/VideoPreview.vue'

import VueVideoPlayer from 'vue-video-player'
Vue.use(VueVideoPlayer)

new Vue({
  el: '#timeline',
  components: {
    Timeline,
    VideoPreview,
  }
})
