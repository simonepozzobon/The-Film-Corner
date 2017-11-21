<template>
  <div id="translate-panel">
    <list title="Apps" color="green" :items="appsParsed" :options="options" :languages="languages"></list>
  </div>
</template>
<script>
import axios from 'axios'

import List from './List.vue'

export default {
  name: "translate-panel",
  props: ['apps'],
  data: () => ({
      options: [
          {title: 'title'},
          {title: 'slug'},
          {title: 'description'},
      ],
      languages: '',
  }),
  computed: {
      appsParsed: function()
      {
          return JSON.parse(this.apps);
      }
  },
  created() {
    //do something after creating vue instance
    this.get_languages();
  },
  methods: {
    get_languages()
    {
      var vue = this;
      axios.get('/admin/translate/languages')
      .then(response => {
        vue.languages = response.data;
      });
    }
  },
  components: {
      List
  }
}
</script>
<style lang="scss" scoped>
</style>
