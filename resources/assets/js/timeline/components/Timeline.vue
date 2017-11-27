<template>
  <div id="timeline" class="container">
    <timeline-track v-for="track in tracks" :key="track.key" :track="track"></timeline-track>
  </div>
</template>
<script>
import TimelineTrack from './TimelineTrack.vue'

export default {
  name: "timeline",
  data: () => ({
      tracks: [
        {
          'title': 'Titolo 1',
          'duration': 100,
          'start': 0,
          'src': 'file'
        }
      ]
  }),
  components: {
    TimelineTrack
  }
}
</script>
<style lang="scss" scoped>

  #timeline {
    background: rgb(93, 94, 227)
  }

</style>
