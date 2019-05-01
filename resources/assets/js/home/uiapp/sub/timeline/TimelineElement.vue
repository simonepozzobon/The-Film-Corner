<template>
  <div id="timeline-element" :style="'width: '+track.duration+'px'">
    testo
  </div>
</template>
<script>
export default {
  name: "timeline-element",
  props: ['track'],
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>

  #timeline-element {
    background: rgb(169, 180, 42);
  }

</style>
