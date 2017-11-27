<template>
  <div id="timeline-track">
    <div id="heading" class="row">
      <div class="col-md-2">
        {{track.title}}
      </div>
      <div id="media" class="col-md-10">
        <timeline-element :track="track"></timeline-element>
      </div>
    </div>
  </div>
</template>
<script>
import TimelineElement from './TimelineElement.vue'
export default {
  name: "timeline-track",
  props: ['track'],
  data: () => ({

  }),
  components: {
    TimelineElement
  }
}
</script>
<style lang="scss" scoped>

  #heading {
    background: rgb(173, 16, 53);
  }

  #media {
    background: rgb(87, 134, 68);
  }

</style>
