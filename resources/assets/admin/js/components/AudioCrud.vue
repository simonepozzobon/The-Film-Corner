<template>
  <!-- <input type="text" name="_token" :value="token"> -->
  <table class="table table-hover" ref="table">
    <thead>
      <th>Id</th>
      <th>Title</th>
      <th>Duration</th>
      <th>Percorso</th>
    </thead>
    <single-element
      v-for="audio in audios"
      :key="audio.key"
      :element="audio"
    />
  </table>
</template>

<script>
import mojs from 'mo-js'
import axios from 'axios'
import SingleElement from './SingleElement.vue'

export default {
  props: ['items', 'msg', 'token'],
  components: {
    SingleElement
  },
  data () {
    return {
      opened: false,
      t_position: '',
      modal: '',
      t_center: '',
      previous_el: '',

    }
  },
  computed: {
    audios: function()
    {
      return JSON.parse(this.items)
    }
  },
  mounted () {
    var vue = this

    this.$parent.$on('newAudioLoaded', function(response) {
      vue.addAudio(response)
    })

    // this.audios = JSON.parse(this.items)
    console.log(this.$refs['table'])
    this.t_center = this.$refs['table'].offsetWidth / 2 * -1

  },
  methods: {
    addAudio (response)
    {
      console.log('triggered method inside')
      console.log(response)
      var newAudio = {
        id: response.audio.id,
        title: response.audio.title,
        duration: response.audio.duration,
        path: response.audio.path
      }
      this.audios.unshift(newAudio)
    },

    deleteAudio (id)
    {
      var vue = this
      var formData = new FormData()
      formData.append('_token', this.token)

      axios({
        method: 'delete',
        url: '/api/apps/audio/'+id,
        data: formData
      })
        .then(function(response){
          console.log(response)
          vue.closeModal(id)
          vue.deleteRow(id)
        })
        .catch(function(error){
          console.log(error)
        })
    },

    toggleModal (el)
    {
      // Da modificare
      var button = document.getElementById('button-'+el)
      var opened = this.opened
      var t_center = this.t_center

      var vue = this
      var modal = document.getElementById('modal-'+el)
      this.modal = modal
      // Get the position of the button relative to the window
      var b_position = button.getBoundingClientRect()
      var b_width = button.offsetWidth
      var b_center = b_width / 2
      var b_y = button.offsetHeight / 2 * -1

      var b_left = this.getOffsetLeft(button)
      var b_top = this.getOffsetTop(button)

      if (this.opened == false) {
        modal.style.display = 'inherit'
        var modal_y = modal.offsetHeight *-1 / 2

        // Get the size of the Modal
        var m_center_x = modal.offsetWidth / 2

        let burst = new mojs.Burst({
          count: 10,
          duration: 300,
          radius: {40 : 80},
          y: 0,
          x: 0,
          left: b_left + b_center,
          top: b_top + b_center,
          origin: '0 100%',
          children: {
            shape: 'line',
            stroke: '#e8a360',
            stroke: '#e8a360',
            strokeWidth: 2,
          },
          onComplete() {
            vue.deleteEl(burst.el)
          }
        })

        let modalElOpen = new mojs.Html({
          el: '#modal-'+el,
          opacity: {0 : 1},
          scaleY: {0.1 : 1},
          scaleX: {0 : 1.5},
          // top: 0,
          // left: 0,
          x: {[-m_center_x + b_center] : t_center + m_center_x},
          y: modal_y + b_y,
          easing: 'sin.in',
          duration: 150,
          delay: 150,
        })
          .then({
            scaleY: {1 : 1.1},
            scaleX: {1.5 : 1.1},
            duration: 50,
            easing: 'sin.in.out'
          })
          .then({
            scaleY: {1.1 : 1},
            scaleX: {1.1 : 1},
            duration: 50,
            easing: 'sin.out'
          })

        let timelineOpen = new mojs.Timeline().add(burst, modalElOpen).play()
        this.opened = true
        this.previous_el = el
      }
      else {
        this.closeModal(this.previous_el)
      }
    },

    closeModal (el)
    {

      var t_center = this.t_center

      var button = document.getElementById('button-'+el)
      var b_center = button.offsetWidth / 2
      var b_y = button.offsetHeight / 2 * -1

      var modal = this.modal
      var modal_y = modal.offsetHeight *-1 / 2
      var m_center_x = modal.offsetWidth / 2

      let modalElClose = new mojs.Html({
        el: '#modal-'+el,
        scaleX: {1 : 1.1},
        scaleY: {1 : 1.1},
        x: t_center + m_center_x,
        y: modal_y + b_y,
        duration : 50,
        easing: 'sin.in.out',
      })
        .then({
          opacity: {1 : 0},
          scaleX: {1.1 : 0},
          scaleY: {1.1 : 0},
          x: {[t_center + m_center_x] : (-m_center_x + b_center)},
          duration: 100,
          easing: 'sin.in.out',
          onComplete() {
            modal.style.display = 'none'
          }
        }).play()
      this.opened = false
    },

    deleteRow(el)
    {
      var rowHeight = document.getElementById('row-'+el)
      var vue = this
      let row = new mojs.Html({
        el: '#row-'+el,
        height: {100 : 0},
        opacity: {1 : 0},
        onComplete() {
          vue.deleteEl(row.el)
        }
      }).play()
    },

    getOffsetLeft (elem)
    {
      var offsetLeft = 0
      do {
        if ( !isNaN( elem.offsetLeft ) )
        {
          offsetLeft += elem.offsetLeft
        }
      } while( elem = elem.offsetParent )
      return offsetLeft
    },

    getOffsetTop (elem)
    {
      var offsetTop = 0
      do {
        if ( !isNaN( elem.offsetTop ) )
        {
          offsetTop += elem.offsetTop
        }
      } while( elem = elem.offsetParent )
      return offsetTop
    },

    deleteEl(el) {
      if (el) {
        el.parentNode.removeChild(el)
      }
    },
  }
}
</script>

<style scoped>

</style>
