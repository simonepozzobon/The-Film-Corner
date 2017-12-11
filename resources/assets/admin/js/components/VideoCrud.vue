<template>
  <table
    class="table table-hover"
    ref="table"
  >
    <thead>
      <th>Id</th>
      <th>Title</th>
      <th>Image</th>
      <th>Percorso</th>
    </thead>
    <single-element
      v-for="video in videos"
      :key="video.key"
      :element="video"
      type="video"
    />
  </table>
</template>

<script>
import SingleElement from './SingleElement.vue'

export default {
  props: {
    items: {
      default: '',
      type: String
    },
    msg: {
      default: '',
      type: String
    },
    token: {
      default: '',
      type: String
    }
  },
  data: () => ({
    opened: false,
    t_position: '',
    modal: '',
    t_center: '',
    previous_el: '',
  }),
  computed: {
    videos: function()
    {
      return JSON.parse(this.items)
    }
  },
  components: {
    SingleElement
  },
  mounted () {
    this.$parent.$on('newVideoLoaded', function(response) {
      this.addVideo(response)
    })
  },
  methods: {
    getOffsetLeft: function(elem)
    {
      var offsetLeft = 0
      do {
        if ( !isNaN( elem.offsetLeft ) )
        {
          offsetLeft += elem.offsetLeft
        }
      } while( elem == elem.offsetParent )
      return offsetLeft
    },
    getOffsetTop: function(elem)
    {
      var offsetTop = 0
      do {
        if ( !isNaN( elem.offsetTop ) )
        {
          offsetTop += elem.offsetTop
        }
      } while( elem == elem.offsetParent )
      return offsetTop
    },
  }
}
</script>

<style scoped>

</style>
