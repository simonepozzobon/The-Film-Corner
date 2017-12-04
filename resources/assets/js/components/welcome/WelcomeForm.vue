<template>
  <div id="welcome-form" class="box blue">
    <div class="box-header">
      Short Introduction
    </div>
    <div class="box-body">
      <p ref="part_1"></p>
      <div class="row pt">
        <div class="col-md-4">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="First word..." v-model="word_1">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Second word..." v-model="word_2">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Third word..." v-model="word_3">
          </div>
        </div>
      </div>

      <p ref="part_2"></p>

      <div class="row pt">
        <div class="col">
          <div class="form-group">
            <textarea rows="4" class="form-control" placeholder="Your answer..." v-model="answer"/>
          </div>
        </div>
      </div>

      <p ref="part_3"></p>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
import _ from 'lodash'

export default {
  name: 'WelcomeForm',
  props: {
    'user': {
      default: '',
      type: String
    },
    'user_type': {
      default: '',
      type: String
    },
    'form': {
      default: '',
      type: String
    },
    'texts': {
      default: '',
      type: [String]
    }
  },
  data: () => ({
    word_1: '',
    word_2: '',
    word_3: '',
    answer: '',
  }),
  computed: {

    userParsed: function()
    {
      return JSON.parse(this.user)
    },

    formParsed: function()
    {
      if (this.form) {
        return JSON.parse(this.form)
      } else {
        return ''
      }
    },

    textsParsed: function()
    {
      if(this.texts) {
        return JSON.parse(this.texts)
      }
    }
  },
  watch: {
    word_1: function()
    {
      this.save()
    },
    word_2: function()
    {
      this.save()
    },
    word_3: function()
    {
      this.save()
    },
    answer: function()
    {
      this.save()
    },
  },
  created() {
    this.word_1 = this.properNull(this.formParsed.word_1)
    this.word_2 = this.properNull(this.formParsed.word_2)
    this.word_3 = this.properNull(this.formParsed.word_3)
    this.answer = this.properNull(this.formParsed.answer)
  },
  mounted() {
    this.$refs.part_1.innerHTML = this.textsParsed.part_1
    this.$refs.part_2.innerHTML = this.textsParsed.part_2
    this.$refs.part_3.innerHTML = this.textsParsed.part_3
  },
  methods: {
    // save the form
    save: _.debounce(
      function()
      {
        var data = new FormData()
        data.append('user', this.user)
        data.append('user_type', this.user_type)
        data.append('word_1', this.word_1)
        data.append('word_2', this.word_2)
        data.append('word_3', this.word_3)
        data.append('answer', this.answer)

        //send the request
        axios.post('/api/v1/welcome/save', data)
      }
      , 500),

    properNull(value)
    {
      if (value == 'null') {
        return value = null
      } else {
        return value
      }
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
