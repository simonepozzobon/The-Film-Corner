<template>
  <!-- <input type="text" name="_token" :value="token"> -->
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
      v-for="image in images"
      :key="image.key"
      :element="image"
      type="image"
    />
  </table>
</template>

<script>
import SingleElement from './SingleElement.vue'

import mojs from 'mo-js'
import axios from 'axios'

export default {
  props: {
    items:{
      default: '',
      type: String
    },
    msg:{
      default: '',
      type: String
    },
    token:{
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
  components: {
    SingleElement
  },
  computed: {
    images: function()
    {
      return JSON.parse(this.items)
    }
  },
  mounted () {
  },
  methods: {
    addImage: function(response)
    {
      var newImage = {
        id: response.image.id,
        title: response.image.title,
        img: response.image.img,
        path: response.image.path
      }
      this.images.unshift(newImage)
    },

    deleteImage: function(id)
    {
      var vue = this
      var formData = new FormData()
      formData.append('_token', this.token)

      axios({
        method: 'delete',
        url: '/api/apps/image/'+id,
        data: formData
      })
        .then(function(){
          vue.closeModal(id)
          vue.deleteRow(id)
        })
    },

    toggleModal: function(el)
    {
      // Da modificare
      var button = document.getElementById('button-'+el)
      var t_center = this.t_center

      var vue = this
      var modal = document.getElementById('modal-'+el)
      this.modal = modal
      // Get the position of the button relative to the window
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

    closeModal: function(el)
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

    deleteRow: function(el)
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

    deleteEl: function(el)
    {
      if (el) {
        el.parentNode.removeChild(el)
      }
    },
  }
}
</script>

<style scoped>

</style>
