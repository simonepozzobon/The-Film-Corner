<template>
  <div id="translate-panel">
    <div class="box yellow">
      <div class="box-header">
        Select What To Translate
      </div>
      <div class="box-body">
        <div class="form-group">
          <select class="form-control" v-model="category">
            <option v-for="cat in categories" :key="cat.key" :value="cat.value">{{cat.title}}</option>
          </select>
        </div>
      </div>
      <div class="box-btns">
        <button class="btn btn-yellow" @click="changePanel">Translate</button>
      </div>
    </div>
    <list color="green" :title="title" :items="items" :options="options" :languages="languages"/>
  </div>
</template>
<script>
import axios from 'axios'

import List from './List.vue'

export default {
  name: 'TranslatePanel',
  data: () => ({
    categories: [
      {
        title: 'Apps',
        value: 'apps',
        options: [
          { title: 'title', type: 'input' },
          { title: 'description', type: 'textarea' },
        ]
      },
      {
        title: 'Glossary',
        value: 'app_keywords',
        options: [
          { title: 'name', type: 'input', },
          { title: 'description', type: 'textarea' }
        ],
      },
      {
        title: 'Studios',
        value: 'app_sections',
        options: [
          { title: 'name', type: 'input'},
          { title: 'description', type: 'textarea'}
        ],
      },
      {
        title: 'Didactical Path',
        value: 'app_categories',
        options: [
          { title: 'name', type: 'input'},
          { title: 'description', type: 'textarea'}
        ],
      }
    ],
    languages: '',
    category: 'apps',
    items: [],
    options: [],
    options_obj: '',
    title: '',
  }),
  watch: {
    options: function()
    {
      this.options_obj = this.options
    }
  },
  created() {
    this.get_languages()
  },
  mounted() {
    this.changePanel()

    this.$parent.$on('translation-update', () => {
      this.changePanel()
    })
  },
  methods: {
    get_languages()
    {
      var vue = this
      axios.get('/admin/translate/languages')
        .then(response => {
          vue.languages = response.data
        })
    },

    changePanel()
    {
      var vue = this

      var data = new FormData()
      data.append('type', this.category)

      axios.post('/admin/translate/get-elements', data)
        .then(response => {
          var foundIndex = vue.categories.findIndex(x => x.value == vue.category)
          vue.options = vue.categories[foundIndex].options
          vue.title = vue.categories[foundIndex].title
          vue.items = response.data
        })
    }
  },
  components: {
    List
  }
}
</script>
<style lang="scss" scoped>
</style>
