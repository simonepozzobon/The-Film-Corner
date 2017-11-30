<template>
  <tbody>
    <tr id="list-el" ref="row">
      <td ref="items" v-for="(option, key, index) in options" :key="option.key" @click="edit" :data-property="option.title">{{get_property(option.title)}}</td>
      <td>
        <span v-if="language.short != 'en'" @click="translationPanel(this.event, language)" v-for="language in item.translated" :key="language.key" class="badge badge-red mb">{{language.short}}</span>
        <span v-else class="badge badge-red mb" @click="editDefault(this.event, language)">{{language.short}}</span>
      </td>
    </tr>
    <tr>
      <td id="tools" ref="tools" colspan="42">
        <div class="close">
          <button @click="hide_tools" class="btn btn-secondary"><i class="fa fa-times" /></button>
        </div>
        <div class="form-group">
          <label for="">Language:</label>
          <select class="form-control" v-model="language_form">
            <option v-for="language in languages" :key="language.key" :value="language.id">{{language.short}}</option>
          </select>
        </div>
        <single-field v-for="option in options_obj" :key="option.key" :label="option.title" :type="option.type" :value="option.value"/>
        <div class="d-flex justify-content-center">
          <a href="#" :class="'btn btn-'+color" @click="save"><i class="fa fa-floppy-o" /> Save</a>
        </div>
      </td>
    </tr>
    <tr id="translation" ref="translation" @click="translation_tools" @mouseover="show_translation_alert" @mouseleave="restore_translation">
      <td ref="items" v-for="(option, key, index) in options" :key="option.key">{{get_translation(option.title)}}</td>
      <td>
        <span class="badge badge-red mb">{{language.short}}</span>
      </td>
    </tr>
  </tbody>
</template>
<script>
import {TweenMax, TimelineMax, Power4} from 'gsap'
import _ from 'lodash'
import axios from 'axios'

import SingleField from './SingleField.vue'

export default {
  name: 'ListEl',
  props: {
    'item': {
      default: '',
      type: Object
    },
    'options': {
      default: '',
      type: Array
    },
    'languages': {
      default: '',
      type: [Array, String]
    },
    'color': {
      default: '',
      type: String
    }
  },
  data: () => ({
    toolbar: {
      status: false,
      translation: false,
      cache: ''
    },
    language: '',
    language_form: '',
    options_obj: '',
    translation: '',
  }),
  computed: {
    opt_lenght: function ()
    {
      return this.options.length
    },
  },
  watch: {
    options: function()
    {
      this.options_obj = this.options
    }
  },
  mounted() {
    this.options_obj = this.options
    this.$on('input-updated', input => {
      this.updateObjs(input)
    })
  },
  methods: {
    get_property(val)
    {
      var property = _.pick(this.item, val)
      return Object.values(property)[0]
    },

    get_translation(val)
    {
      var property = _.pick(this.translation, val)
      return Object.values(property)[0]
    },

    updateObjs(input)
    {
      var foundIndex = this.options_obj.findIndex(x => x.title == input.option)
      this.options_obj[foundIndex].value = input.value
    },

    edit()
    {
      if (!this.toolbar.status) {
        this.show_tools()
      } else {
        this.hide_tools()
      }

      if (this.toolbar.translation)
      {
        this.hideTranslation()
      }
    },

    hide_tools()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.row, .4, {
        background: 'none',
        easing: Power4.easeInOut,
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.tools, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t2)
      master.add(t1, .4)
      master.play()
      this.toolbar.status = false
      this.language_form = ''
      _.each(this.options_obj, option => {
        option.value = ''
      })
    },

    show_tools()
    {
      this.toolbar.status = true

      var t1 = new TimelineMax()
      t1.to(this.$refs.row, .4, {
        background: 'rgba(255, 255, 255, 0.4)',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.tools, .4, {
        opacity: 1,
        display: 'table-cell',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2, .4)
      master.play()
    },

    save()
    {
      var vue = this
      if (this.language_form == '' || vue.item.id == '' || vue.item.model == '' || vue.options_obj == '') {
        alert('Please complete all the informations')
      } else {

        var data = new FormData()
        data.append('language', this.language_form)
        data.append('translable_id', this.item.id)
        data.append('translable_type', this.item.model)
        data.append('translations', JSON.stringify(this.options_obj))

        axios.post('/admin/translate/save', data)
          .then(() => {
            vue.hide_tools()
            vue.$root.$emit('translation-update')
          })
      }


    },

    translationPanel(e, language)
    {
      if (!this.toolbar.translation) {
        this.language = language
        this.toolbar.cache = e.target
        this.showTranslation()
      } else {
        this.hideTranslation()
      }

      if (this.toolbar.status) {
        this.hide_tools()
      }
    },

    editDefault(e, language)
    {
      if (this.toolbar.status) {
        this.hide_tools()
      }

      var vue = this
      this.language = language
      this.toolbar.cache = e.target
      vue.language_form = vue.language.id
      _.each(vue.options_obj, option => {
        var value = vue.get_property(option.title)
        option.value = value
      })
      vue.edit()
    },

    showTranslation()
    {
      var vue = this
      var data = new FormData()
      data.append('id', this.item.id)
      data.append('original_model', this.item.original_model)
      data.append('language', this.language.short)

      var t1 = new TimelineMax()
      t1.to(vue.$refs.translation, .4, {
        opacity: 1,
        display: 'table-row'
      })

      var t2 = new TimelineMax()
      t2.to(this.toolbar.cache, .4, {
        background: 'rgb(170, 170, 170)'
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2)

      axios.post('/admin/translate/get-translation', data)
        .then(response => {
          vue.translation = response.data
          master.play()
          vue.toolbar.translation = true
        })


    },

    hideTranslation()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.translation, .4, {
        opacity: 0,
        display: 'none'
      })

      var t2 = new TimelineMax()
      t2.to(this.toolbar.cache, .4, {
        background: 'rgb(255, 135, 143)'
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2)
      master.play()

      this.toolbar.cache = ''
      this.toolbar.translation = false
      this.language = ''
    },

    translation_tools()
    {
      var vue = this
      this.language_form = this.language.id
      _.each(this.options_obj, option => {
        var value = vue.get_translation(option.title)
        option.value = value
      })
      this.edit()
    },

    show_translation_alert(e)
    {

    },

    restore_translation(e)
    {

    },

  },
  components: {
    SingleField
  }
}
</script>
<style lang="scss" scoped>

  #tools, #translation {
    display: none;
    opacity: 0;
  }

</style>
