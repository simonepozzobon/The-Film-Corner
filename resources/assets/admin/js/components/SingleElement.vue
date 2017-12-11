<template>
  <tbody id="single-element">
    <tr>
      <td>{{ element.id }}</td>
      <td>{{ element.title }}</td>
      <td>
        <img
          :src="element.img"
          class="img-fluid"
          width="57"
        />
      </td>
      <td>{{ element.path }}</td>
    </tr>
    <tr id="edit_panel" ref="edit_panel">

    </tr>
  </tbody>
</template>
<script>
import {TweenMax, Power4} from 'gsap'

export default {
  name: 'SingleElement',
  props: {
    element: {
      default: function() {},
      type: Object
    }
  },
  data: () => ({
    status: false
  }),
  methods: {
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
      TweenMax.to(this.$refs.edit_panel, .4, {
        opacity: 1,
        display: 'table-row'
      })
    },
    closePanel: function()
    {

    }
  }
}
</script>
<style lang="scss" scoped>
</style>
