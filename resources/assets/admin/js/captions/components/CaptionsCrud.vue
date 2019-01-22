<template>
  <div
    id="captions-crud"
    class="container"
  >
    <div class="box blue">
      <div class="box-header">
        <div class="title">
          New Caption
        </div>
        <div
          class="btns"
          v-if="this.status"
          @click="togglePanel"
        >
          <i class="fa fa-times"/>
        </div>
      </div>
      <div
        id="edit_panel"
        ref="edit_panel"
        class="box-body"
      >
        <div class="form-group">
          <!-- Video, Audio o Immagine -->
          <select
            class="form-control"
            v-model="type"
          >
            <option value="1">Video</option>
            <option value="2">Audio</option>
            <option value="3">Image</option>
          </select>
        </div>
        <table
          class="table table-hover"
          v-if="videos.length > 0 || audios.length > 0 || images.length > 0"
        >
          <thead>
            <th>Title</th>
            <th>Image</th>
            <th>Path</th>
          </thead>
          <single-element
            v-if="type == 1"
            v-for="video in videos"
            :key="video.key"
            :element="video"
          />
          <single-element
            v-else-if="type == 2"
            v-for="audio in audios"
            :key="audio.key"
            :element="audio"
          />
          <single-element
            v-else-if="type == 3"
            v-for="image in images"
            :key="image.key"
            :element="image"
          />
        </table>
        <div v-else>
          No Exaples found.
        </div>
      </div>
      <div
        id="add_caption"
        ref="add_caption"
        class="box-body"
      >
        <div class="form-group">
          <label>Title:</label>
          <input
            type="text"
            class="form-control"
            v-model="caption.title"
          >
        </div>
        <div class="form-group">
          <label>Description:</label>
          <textarea
            class="form-control"
            v-model="caption.description"
          ></textarea>
        </div>
        <div class="btns pt">
          <button
            class="btn btn-blue"
            @click="saveCaption"
          >
            <i class="fa fa-floppy-o"/> Save
          </button>
        </div>
      </div>
      <div class="box-btns pt">
        <button
          class="btn btn-blue"
          @click="togglePanel"
          ref="caption_btn"
        >
          <i class="fa fa-floppy-o"/> New Caption
        </button>
      </div>
    </div>
    <div class="box orange mt">
      <div class="box-header">
        Captions
      </div>
      <div class="box-body">
        <table class="table table-hover">
          <thead>
            <th>Title</th>
            <th>Type</th>
            <th>Image</th>
            <th>Description</th>
          </thead>
          <caption-single
            v-for="caption in captions"
            :key="caption.key"
            :caption="caption"
          />
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import {TimelineMax, Power4} from 'gsap'
import axios from 'axios'
import {EventBus} from '_js/EventBus'
import SingleElement from './SingleElement.vue'
import CaptionSingle from './CaptionSingle.vue'

export default {
  name: 'CaptionsCrud',
  components: {
    SingleElement,
    CaptionSingle
  },
  data: () => ({
    status: false,
    type: '',
    videos: [],
    audios: [],
    images: [],
    caption: {
      title: '',
      description: '',
      element: {},
      status: false
    },
    captions: []
  }),
  computed: {
    typeToString: function()
    {
      if (this.type == 1) {
        return 'video'
      } else if (this.type == 2) {
        return 'audio'
      } else if (this.type == 3) {
        return 'image'
      }
    }
  },
  watch: {
    type: function(newvalue)
    {
      if (newvalue == 1) {
        this.getVideos()
      } else if (newvalue == 2) {
        this.getAudios()
      } else {
        this.getImages()
      }
    }
  },
  methods: {
    getCaptions: function()
    {
      axios.get('/admin/apps/captions/get_captions')
        .then(response => {
          this.captions = response.data
        })
    },
    togglePanel: function()
    {
      if (!this.status) {
        this.openPanel()
      } else {
        this.closePanel()
      }
    },
    openPanel: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.edit_panel, .4, {
        opacity: 1,
        display: 'block',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.caption_btn, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t2)
      master.add(t1, .4)
      master.play()

      this.status = true
    },
    closePanel: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.edit_panel, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.caption_btn, .4, {
        opacity: 1,
        display: 'block',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2, .4)
      master.play()

      this.status = false
    },
    getVideos: function()
    {
      axios.get('/admin/get-videos')
        .then(response => {
          this.videos = response.data
        })
    },
    getAudios: function()
    {
      axios.get('/admin/get-audios')
        .then(response => {
          this.audios = response.data
        })
    },
    getImages: function()
    {
      axios.get('/admin/get-images')
        .then(response => {
          this.images = response.data
        })
    },
    toggleCaption: function(element)
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.edit_panel, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.add_caption, .4, {
        opacity: 1,
        display: 'flex',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2, .4)
      master.play()

      this.caption.element = element
    },
    closeCaption: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.add_caption, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      this.caption.title = ''
      this.caption.description = ''
      this.caption.element = {}
    },
    saveCaption: function()
    {
      var data = new FormData()
      data.append('id', this.caption.element.id)
      data.append('type', this.typeToString)
      data.append('title', this.caption.title)
      data.append('description', this.caption.description)

      var vue = this
      axios.post('/admin/apps/captions/store_caption', data)
        .then(() => {
          vue.closeCaption()
          vue.closePanel()
          vue.getCaptions()
        })
    }
  },
  mounted()
  {
    EventBus.$on('admin-captions-row-selected', element => {
      this.toggleCaption(element)
    })
    this.getCaptions()
  }
}
</script>
<style lang="scss" scoped>
  @import '~styles/shared';

  #edit_panel {
    display: none;
    opacity: 0;

    > .tool {

    }
  }

  #add_caption {
    // display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    display: none;
    opacity: 0;

    > .form-group {
      width: 80%;

      > .form-control {
      }
    }
  }

</style>
