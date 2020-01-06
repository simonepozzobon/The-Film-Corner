<template>
  <tbody id="caption-single">
    <tr>
      <td>{{ caption.title }}</td>
      <td>{{ this.type }}</td>
      <td>
        <img
          :src="caption.media.img"
          class="img-fluid"
          width="57"
        />
      </td>
      <td ref="description">
      </td>
    </tr>
  </tbody>
</template>
<script>
export default {
  name: 'CaptionSingle',
  props: {
    caption: {
      default: function() {},
      type: Object
    }
  },
  computed: {
    type: function()
    {
      if (this.caption.mediable_type == 'App\\Video') {
        return 'Video'
      } else if (this.caption.mediable_type == 'App\\Audio') {
        return 'Audio'
      } else if (this.caption.mediable_type == 'App\\Media') {
        return 'Image'
      }
    }
  },
  mounted()
  {
    this.$refs.description.innerHTML = this.caption.description
  }
}
</script>
<style lang="scss" scoped>
</style>
