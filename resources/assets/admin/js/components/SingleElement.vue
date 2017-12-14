<template>
  <tbody id="single-element">
    <tr @click="toggleEdit">
      <td>{{ element.id }}</td>
      <td>{{ element.title }}</td>
      <td>
        <img
          :src="element.img"
          class="img-fluid"
          width="57"
        >
      </td>
      <td>{{ element.path }}</td>
    </tr>
    <tr
      id="edit_panel"
      ref="edit_panel"
    >
      <td colspan="4">
        <div
          id="video"
          v-if="type == 'video'"
          class="edit-form"
        >
          <div class="form-group">
            <!-- Video Category: {{ this.response }} -->
          </div>
          <div class="form-group">
            <label>Title:</label>
            <input
              type="text"
              class="form-control"
              v-model="video.title"
            >
          </div>
          <div class="btns">
            <button
              class="btn btn-orange"
              @click="saveVideoEdit"
            >
              <i class="fa fa-floppy-o"/>
              Save
            </button>
          </div>
        </div>
        <div
          id="audio"
          v-else-if="type == 'audio'"
          class="edit-form"
        >
          <div class="form-group">
            Audio Category: {{ this.response }}
          </div>
          <div class="form-group">
            <label>Title:</label>
            <input
              type="text"
              class="form-control"
              v-model="audio.title"
            >
          </div>
          <div class="btns">
            <button
              class="btn btn-orange"
              @click="saveAudioEdit"
            >
              <i class="fa fa-floppy-o"/>
              Save
            </button>
          </div>
        </div>
        <div
          id="image"
          v-else-if="type == 'image'"
          class="edit-form"
        >
          <div class="form-group">
            <label>Categoria Immagine:</label>
            <select class="form-control" v-model="image.category.id">
              <option value="0"></option>
              <option value="1">General</option>
              <option value="2">App</option>
              <option value="3">Example</option>
            </select>
          </div>
          <div class="form-group">
            <label>Title:</label>
            <input
              type="text"
              class="form-control"
              v-model="image.title"
            />
          </div>
          <div class="form-group">
            <label>File:</label>
            <input
              type="file"
              @change='onFilechange'
            >
          </div>
          <div class="btns">
            <button
              class="btn btn-orange"
              @click="saveImageEdit"
            >
              <i class="fa fa-floppy-o"/>
              Save
            </button>
          </div>
        </div>
      </td>
    </tr>
  </tbody>
</template>
<script>
import {TweenMax, Power4} from 'gsap'
import axios from 'axios'
import SinglePath from './SinglePath.vue'

export default {
  name: 'SingleElement',
  components: {
    SinglePath
  },
  props: {
    element: {
      default: function() {},
      type: Object
    },
    type: {
      default: '',
      type: String
    }
  },
  computed: {
    mediaCategory: function()
    {
      return this.response.category
    }
  },
  data: () => ({
    status: false,
    video: {
      title: ''
    },
    audio: {
      title: ''
    },
    image: {
      title: '',
      category: {
        id:''
      }
    },
    paths: [],
    response: '',
    fileList: []
  }),
  methods: {
    onFilechange: function(event)
    {
      this.fileList = event.target.files
    },
    toggleEdit: function()
    {
      if (!this.status) {
        this.openPanel()
      } else {
        this.closePanel()
      }
    },
    openPanel: function()
    {
      this.getPaths()
      TweenMax.to(this.$refs.edit_panel, .4, {
        opacity: 1,
        display: 'table-row',
        easing: Power4.easeInOut
      })
      this.status = true
    },
    closePanel: function()
    {
      TweenMax.to(this.$refs.edit_panel, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })
      this.status = false
    },
    getPaths: function()
    {
      axios.get('/admin/get-media-paths/'+this.type+'/'+this.element.id)
        .then(response => {
          this.response = response.data
          if (this.type == 'video') {
            this.video = response.data
          } else if (this.type == 'audio') {
            this.audio = response.data
          } else if (this.type == 'image') {
            this.image = response.data
            if (this.image.category == null) {
              this.image.category = {}
              this.image.category.id = 0
            }
          }
        })
    },
    saveVideoEdit: function()
    {
      var data = new FormData()
      data.append('id', this.video.id)
      data.append('title', this.video.title)
      axios.post('/admin/save-video', data)
        .then(() => {
          this.element.title = this.video.title
          this.toggleEdit()
        })
    },
    saveAudioEdit: function()
    {
      var data = new FormData()
      data.append('id', this.audio.id)
      data.append('title', this.audio.title)
      axios.post('/admin/save-audio', data)
        .then(() => {
          this.element.title = this.video.title
          this.toggleEdit()
        })
    },
    saveImageEdit: function()
    {
      var data = new FormData()
      data.append('id', this.image.id)
      data.append('title', this.image.title)
      axios.post('/admin/save-image', data)
        .then(() => {
          this.element.title = this.video.title
          this.toggleEdit()
        })
    }
  }
}
</script>
<style lang="scss" scoped>
  @import '~styles/variables';

  #edit_panel {
    opacity: 0;
    display: none;
  }

  .edit-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    width: 100%;

    > .form-group {
      width: 80%;
      margin-bottom: $spacer;
    }
  }

</style>
