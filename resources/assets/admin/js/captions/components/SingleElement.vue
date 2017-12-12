<template>
  <tbody id="single-element">
    <tr @click="selectThis">
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
  </tbody>
</template>
<script>
import {EventBus} from '_js/EventBus'

export default {
  name: 'SingleElement',
  props: {
    element: {
      default: function() {},
      type: Object
    }
  },
  methods: {
    selectThis: function()
    {
      EventBus.$emit('admin-captions-row-selected', this.element)
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
