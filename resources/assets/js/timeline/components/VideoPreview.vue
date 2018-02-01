<template>
  <div id="video-player">
    <video-player
      class="video-player-box"
      ref="videoPlayer"
      :options="playerOptions"
      :playsinline="true"
      >
  </video-player>
  </div>
</template>
<script>
import 'video.js/dist/video-js.css'
import { videoPlayer } from 'vue-video-player'

export default {
  name: 'VideoPreview',
  data: () => ({
    playerOptions: {
      aspectRatio: '16:9',
      sources: [{
        type: 'video/mp4',
        src: '/img/test-app/oceans.mp4'
      }],
      poster: '/img/test-app/1.png',
    }
  })
}
</script>
<style lang="scss" scoped>
</style>
