<template>
  <div
    id="main-panel"
    class="container"
  >
    <div class="box green">
      <div class="box-header">
        Edit Footer
      </div>
      <div class="box-body">
        <select
          class="form-control"
          v-model="edit"
        >
          <option value="1">Credits</option>
          <option value="2">Filmography</option>
        </select>
      </div>
      <div class="box-btns">
        <button
          class="btn btn-green"
          @click="changePanel"
        >
          Edit
        </button>
      </div>
    </div>


    <div
      id="panelCredits"
      class="box blue mt"
      ref="panelCredits"
    >
      <div class="box-header">
        <div class="title">
          Credits
        </div>
        <div
          class="btns"
          @click="closePanel"
        >
          <i class="fa fa-times"/>
        </div>
      </div>
      <div class="box-body">
        <div class="box-tools">
          <div class="box-tools">
            <button
              class="btn btn-blue"
              @click="addCredit"
            >
              <i class="fa fa-plus" /> Add Credit
            </button>
            <button
              class="btn btn-blue"
              @click="undoCredit"
            >
              <i class="fa fa-undo"/> Undo
            </button>
            <div
              id="add_panel_credit"
              class="box-form mt"
              ref="add_panel_credit"
            >
              <label>Name:</label>
              <input
                type="text"
                class="form-control mb"
                v-model="credit.name"
              >
              <label>Role:</label>
              <input
                type="text"
                class="form-control mb"
                v-model="credit.role"
              >
              <button
                class="btn btn-blue"
                @click="saveCredit"
              >
                <i class="fa fa-floppy-o"/> Save
              </button>
            </div>
          </div>
        </div>
        <div class="box-content">
          <table class="table table-hover">
            <thead>
              <th>Name</th>
              <th>Role</th>
            </thead>
            <element-single
              v-for="credit in this.credits"
              :key="credit.key"
              field_1="Name"
              :col_1="credit.name"
              field_2="Role"
              :col_2="credit.role"
              :element="credit"
              type="credit"
            />
          </table>
        </div>
      </div>
    </div>


    <div
      id="panelFilmography"
      class="box blue mt"
      ref="panelFilmography"
    >
      <div class="box-header">
        <div class="title">
          Filmography
        </div>
        <div
          class="btns"
          @click="closePanel"
        >
          <i class="fa fa-times"/>
        </div>
      </div>
      <div class="box-body">
        <!-- Add Film -->
        <div class="box-tools">
          <button
            class="btn btn-blue"
            @click="addFilm"
          >
            <i class="fa fa-plus" /> Add Film
          </button>
          <button
            class="btn btn-blue"
            @click="undoFilm"
          >
            <i class="fa fa-undo"/> Undo
          </button>
          <div
            id="add_panel_film"
            class="box-form mt"
            ref="add_panel_film"
          >
            <label>Title:</label>
            <input
              type="text"
              class="form-control mb"
              v-model="film.title"
            >
            <label>Description:</label>
            <textarea
              rows="8"
              class="form-control mb"
              v-model="film.description"
            />
            <button
              class="btn btn-blue"
              @click="saveFilm"
            >
              <i class="fa fa-floppy-o"/> Save
            </button>
          </div>
        <!-- End Add Film -->
        </div>
        <div class="box-content">
          <!-- Start of the list for filmography -->
          <table class="table table-hover">
            <thead>
              <th>Title</th>
              <th>Description</th>
            </thead>
            <element-single
              v-for="filmography in this.filmographies"
              :key="filmography.key"
              field_1="Title"
              :col_1="filmography.title"
              field_2="Description"
              :col_2="filmography.description"
              :element="filmography"
              type="filmography"
            />
          </table>
        <!-- end of the list -->
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {TweenMax, Power4} from 'gsap'
import axios from 'axios'

import ElementSingle from './ElementSingle.vue'

export default {
  name: 'MainPanel',
  data: () => ({
    edit: 1,
    status: false,
    panel: '',
    filmographies: [],
    credits: [],
    film: {
      title: '',
      description: ''
    },
    credit: {
      role: '',
      name: ''
    }
  }),
  methods: {
    changePanel: function()
    {
      if (!this.status) {
        // Open panel
        if (this.edit == 1) {
          this.panel = 'credits'
          this.getCredits()
          this.openPanel()
        } else {
          this.panel = 'filmography'
          this.getFilmography()
          this.openPanel()
        }
      } else {
        // Close panel
        this.closePanel()
      }
    },
    getCredits: function()
    {
      axios.get('/admin/footer/get_credits')
        .then(response => {
          this.credits = response.data
        })
    },
    getFilmography: function()
    {
      axios.get('/admin/footer/get_filmography')
        .then(response => {
          this.filmographies = response.data
        })
    },
    openPanel: function()
    {
      if (this.panel == 'filmography') {
        TweenMax.to(this.$refs.panelFilmography, .4, {
          opacity: 1,
          display: 'block',
          easing: Power4.easeInOut
        })
      } else if (this.panel == 'credits') {
        TweenMax.to(this.$refs.panelCredits, .4, {
          opacity: 1,
          display: 'block',
          easing: Power4.easeInOut
        })
      }
      this.status = true
    },
    closePanel: function()
    {
      if (this.panel == 'filmography') {
        TweenMax.to(this.$refs.panelFilmography, .4, {
          opacity: 0,
          display: 'none',
          easing: Power4.easeInOut
        })
      } else if (this.panel == 'credits') {
        TweenMax.to(this.$refs.panelCredits, .4, {
          opacity: 0,
          display: 'none',
          easing: Power4.easeInOut
        })
      }
      this.status = false
    },
    addCredit: function()
    {
      // Show form Credit
      TweenMax.to(this.$refs.add_panel_credit, .4, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })
    },
    addFilm: function()
    {
      // Show form Film
      TweenMax.to(this.$refs.add_panel_film, .4, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })
    },
    undoCredit: function()
    {
      // Hide form Credit
      TweenMax.to(this.$refs.add_panel_credit, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })
    },
    undoFilm: function()
    {
      // Hide form Film
      TweenMax.to(this.$refs.add_panel_film, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })
    },
    saveCredit: function()
    {
      var data = new FormData()
      data.append('role', this.credit.role)
      data.append('name', this.credit.name)

      axios.post('/admin/footer/save_credit', data)
        .then(() => {
          this.undoCredit()
          this.getCredits()
        })
    },
    saveFilm: function()
    {
      var data = new FormData()
      data.append('title', this.film.title)
      data.append('description', this.film.description)

      axios.post('/admin/footer/save_filmography', data)
        .then(() => {
          this.undoFilm()
          this.getFilmography()
        })
    },
  },
  mounted()
  {
    this.$on('filmography-updated', () => {
      this.getFilmography()
    })
    this.$on('credit-updated', () => {
      this.getCredits()
    })
  },
  components: {
    ElementSingle
  }
}
</script>
<style lang="scss" scoped>
  @import '~styles/shared';

  #panelCredits,
  #panelFilmography,
  #add_panel_film,
  #add_panel_credit {
    display: none;
    opacity: 0;
  }

  .box-body {
    display: flex;
    flex-direction: column;

    .box-tools {
      padding-bottom: $spacer;
    }
  }

</style>
